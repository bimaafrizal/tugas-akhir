<?php

namespace App\Http\Controllers;

use App\Models\Flood;
use App\Http\Requests\StoreFloodRequest;
use App\Http\Requests\UpdateFloodRequest;
use App\Jobs\CheckLastData;
use App\Jobs\EmailSendNotification;
use App\Jobs\GetDataEws;
use App\Jobs\InsertFlood;
use App\Jobs\InsertFloodNotification;
use App\Jobs\TestingCheckLastData;
use App\Jobs\TestingEmailSendNotification;
use App\Jobs\TestingGetDataEws;
use App\Jobs\TestingInsertFlood;
use App\Jobs\TestingInsertFloodNotification;
use App\Jobs\TestingWhatsappSendNotification;
use App\Jobs\WhatsappSendNotification;
use App\Models\Disaster;
use App\Models\Ews;
use App\Models\FloodNotification;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\Coroutine;
use GuzzleHttp\Promise\Promise;
use GuzzleHttp\Promise\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use SendinBlue\Client\Configuration;
// use SendinBlue\Client\Api\SMTPApi;
use SendinBlue\Client\Api\TransactionalEmailsApi;
use SendinBlue\Client\Model\SendWhatsappMessage;

class FloodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFloodRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //get data and check last data
        $ews = EWS::where('status', '1')->get();
        $promise1 =  new Promise();
        $getDataEws = new TestingGetDataEws($ews, $promise1);
        $promise2 =  new Promise();
        $getLastdata = new TestingCheckLastData($promise2);
        dispatch($getDataEws);
        dispatch($getLastdata);
        $promises[] = $promise1;
        $promises[] = $promise2;
        $results = Utils::all($promises)->wait();
        $dataEWS = $getDataEws->getResult();
        $lastDataEws = $getLastdata->getResult();

        $arrIdEwsLast = [];
        foreach ($lastDataEws as $data) {
            if ($data != null) {
                array_push($arrIdEwsLast, $data->ews_id);
            }
        }

        $results2 = [];
        //check if any new data 
        foreach ($lastDataEws as $last) {
            if ($last != null) {
                if ($dataEWS[$last->ews_id]->created_at != date("Y-m-d\TH:i:s\Z", strtotime($last->created_at))) {
                    $results2[$last->ews_id] = $dataEWS[$last->ews_id];
                }
            }
        }

        //if there is nothing last data
        foreach ($dataEWS as $key => $value) {
            if (in_array($key, $arrIdEwsLast) == false) {
                $results2[$key] = $dataEWS[$key];
            }
        }

        //convert to level
        $convertLevel = [];
        foreach ($results2 as $key => $data) {
            $arrTemp = [];
            if (property_exists($data, 'field2') == false) {
                $arrTemp['ews_id'] = $key;
                if ($data->field1 <= 1024) {
                    $arrTemp['level'] = 0;
                } else if ($data->field1 > 1024 && $data->field1 <= 2048) {
                    $arrTemp['level'] = 1;
                } else if ($data->field1 > 2048 && $data->field1 <= 3072) {
                    $arrTemp['level'] = 2;
                } else if ($data->field3 > 3072) {
                    $arrTemp['level'] = 3;
                }
                $arrTemp['created_at'] = $data->created_at;
                array_push($convertLevel, $arrTemp);
            } else {
                $arrTemp['ews_id'] = $key;
                if ($data->field1 == 1) {
                    $arrTemp['level'] = 0;
                } else if ($data->field1 == 0) {
                    $arrTemp['level'] = 1;
                } else if ($data->field2 == 0) {
                    $arrTemp['level'] = 2;
                } else if ($data->field3 == 0) {
                    $arrTemp['level'] = 3;
                }
                $arrTemp['created_at'] = $data->created_at;
                array_push($convertLevel, $arrTemp);
            }
        }

        //insert to flood table
        $promise3 =  new Promise();
        $insertFlood = new TestingInsertFlood($convertLevel, $promise3);
        dispatch($insertFlood);
        $floodData = $insertFlood->getResult();

        $result3 = [];
        $result3 = $convertLevel; //delete in production

        //check if any new level
        // foreach ($convertLevel as $value) {
        //     if (in_array($value['ews_id'], $arrIdEwsLast)) {
        //         $lastData =  Flood::where('ews_id', $value['ews_id'])->first();
        //         if ($lastData->level != $value['level']) {
        //             array_push($result3, $value);
        //         }
        //     } else if ($value->lavel != 0) {
        //         array_push($result3, $value);
        //     }
        // }

        //get users where longitude & latitude not null
        $users = User::join('setting_disasters', 'users.id', '=', 'setting_disasters.user_id')->where(
            [
                ['users.status', '=', 1],
                ['users.role_id', '=', 1],
                ['setting_disasters.disaster_id', '=', 1],
                ['setting_disasters.status', '=', '1'],
            ],
        )->whereNotNull('users.longitude')->whereNotNull('users.latitude')->get();


        //get longitude latitude of ews
        $dataEWS = [];
        foreach ($result3 as $data) {
            $ews = Ews::where('id', $data['ews_id'])->first();
            array_push($dataEWS, [
                'ews_id' => $ews->id,
                'ews_name' => $ews->name,
                'long' => $ews->longitude,
                'lat' => $ews->latitude,
                'level' => $data['level']
            ]);
        }

        $checkDistance = [];
        $disaster = Disaster::where('id', 1)->first();

        //check distance
        //return data for send notification to email & whatsapp
        for ($i = 0; $i < count($dataEWS); $i++) {
            for ($j = 0; $j < count($users); $j++) {
                $distance = $this->calculateDistance($users[$j]->latitude, $users[$j]->longitude, $dataEWS[$i]['lat'], $dataEWS[$i]['long']);
                //under if on production
                array_push($checkDistance, [
                    'ews_id' => $dataEWS[$i]['ews_id'],
                    'ews_name' => $dataEWS[$i]['ews_name'],
                    'level' => $dataEWS[$i]['level'],
                    'distance' => $distance,
                    'user_id' => $users[$j]->id,
                    'email_user' => $users[$j]->email,
                    'phone_user' => $users[$j]->phone_num
                ]);
                if ($distance <= $disaster->distance) {
                }
            }
        }

        //return data for insert to notification table
        $dataNotif = [];
        for ($i = 0; $i < count($checkDistance); $i++) {
            for ($j = 0; $j < count($floodData); $j++) {
                if ($checkDistance[$i]['ews_id'] == $floodData[$j]['ews_id']) {
                    array_push($dataNotif, [
                        'flood_id' => $floodData[$j]['flood_id'],
                        'user_id' => $checkDistance[$i]['user_id'],
                        'distance' => $checkDistance[$i]['distance'],
                        'created_at' => Carbon::now()
                    ]);
                }
            }
        }

        $promise4 = new Promise();
        $sendEmail = new TestingEmailSendNotification($checkDistance, $promise4);
        $promise5 = new Promise();
        $sendWhatsapp = new TestingWhatsappSendNotification($checkDistance, $promise5);

        TestingInsertFloodNotification::dispatch($dataNotif);

        dispatch($sendEmail);
        dispatch($sendWhatsapp);


        dd($dataNotif);
    }

    function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $R = 6371; // Radius of the Earth in kilometers
        $lat1Rad = deg2rad($lat1);
        $lon1Rad = deg2rad($lon1);
        $lat2Rad = deg2rad($lat2);
        $lon2Rad = deg2rad($lon2);

        $distance = $R * acos(sin($lat1Rad) * sin($lat2Rad) + cos($lat1Rad) * cos($lat2Rad) * cos($lon2Rad - $lon1Rad));

        return $distance;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Flood  $flood
     * @return \Illuminate\Http\Response
     */
    public function show(Flood $flood)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Flood  $flood
     * @return \Illuminate\Http\Response
     */
    public function edit(Flood $flood)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFloodRequest  $request
     * @param  \App\Models\Flood  $flood
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFloodRequest $request, Flood $flood)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Flood  $flood
     * @return \Illuminate\Http\Response
     */
    public function destroy(Flood $flood)
    {
        //
    }

    public function getDetailData(Request $request)
    {
        // $decryptId = decrypt($request->id);
        try {
            $decrypted = Crypt::decrypt($request->id);
        } catch (DecryptException $e) {
            echo $e;
        }
        $floods = Flood::where('ews_id', $decrypted)->orderBy('id', 'desc')->take(30)->get();
        $labels = $floods->pluck('created_at');
        // $labels = substr($label, strpos($label, 'T') + 1, -1);
        $data = $floods->pluck('level');

        return response()->json(compact('labels', 'data'));
    }

    public function downloadData($id, Request $request)
    {
        try {
            $decrypted = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            echo $e;
        }

        $nextDay = date('Y-m-d', strtotime($request->tanggal_akhir . '+1 day'));
        $nextDay2 = date('Y-m-d', strtotime($request->tanggal_mulai . '+1 day'));

        if ($request->tanggal_mulai == null || $request->tanggal_akhir == null) {
            $data = Flood::with('ews')->where('ews_id', $decrypted)->get();
            if ($decrypted == 0) {
                $data = Flood::with('ews')->get();
            }
        } else {
            $data = Flood::with('ews')->where('ews_id', $decrypted)->where('created_at', '>=', $request->tanggal_mulai)->where('created_at', '<=', $nextDay)->get();
            if ($decrypted == 0) {
                $data = Flood::with('ews')->where('created_at', '>=', $request->tanggal_mulai)->where('created_at', '<=', $nextDay)->get();
            }
            if ($request->tanggal_mulai > $request->tanggal_akhir) {
                $data = Flood::with('ews')->where('ews_id', $decrypted)->where('created_at', '>=', $request->tanggal_akhir)->where('created_at', '<=', $nextDay2)->get();
                if ($decrypted == 0) {
                    $data = Flood::with('ews')->where('created_at', '>=', $request->tanggal_akhir)->where('created_at', '<=', $nextDay2)->get();
                }
            }
        }

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama EWS');
        $sheet->setCellValue('C1', 'Lokasi');
        $sheet->setCellValue('D1', 'Level');
        $sheet->setCellValue('E1', 'Created At');

        $row = 2;
        $number = 1;

        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, $number);
            $sheet->setCellValue('B' . $row, $item->ews->name);
            $sheet->setCellValue('C' . $row, $item->ews->regency->name . ',' . $item->ews->province->name);
            $sheet->setCellValue('D' . $row, $item->level);
            $sheet->setCellValue('E' . $row, $item->created_at);
            $row++;
            $number++;
        }

        $writer = new Xlsx($spreadsheet);

        $fileName = 'data-ews' . Carbon::now() . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$fileName\"");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}