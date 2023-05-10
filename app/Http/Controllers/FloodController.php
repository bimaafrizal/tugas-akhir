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
use SendinBlue\Client\Configuration;
// use SendinBlue\Client\Api\SMTPApi;
use SendinBlue\Client\Api\TransactionalEmailsApi;

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
        $getDataEws = new GetDataEws($ews, $promise1);
        $promise2 =  new Promise();
        $getLastdata = new CheckLastData($promise2);
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
        $insertFlood = new InsertFlood($convertLevel, $promise3);
        dispatch($insertFlood);
        $floodData = $insertFlood->getResult();
        // dd( $insertFlood->getResult());

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
        $users = User::Where(
            [
                ['status', '=', 1],
                ['role_id', '=', 1],
            ],
        )->whereNotNull('longitude')->whereNotNull('latitude')->get();

        //get longitude latitude of ews
        $dataEWS = [];
        foreach ($result3 as $data) {
            array_push($dataEWS, [
                'ews' => Ews::where(
                    'id',
                    $data['ews_id'],
                )->first(),
                'level' => $data['level']
            ]);
        }

        $client = new Client();
        $longLat = [];
        //get long lat
        foreach ($dataEWS as $ews) {
            $responseLongLat = $client->request('GET', $ews['ews']->api_url);
            $data = json_decode($responseLongLat->getBody()->getContents());

            array_push($longLat, [
                'long' => $data->channel->longitude,
                'lat' => $data->channel->latitude,
                'level' => $ews['level'],
                'ews_id' => $ews['ews']->id
            ]);
        }

        $checkDistance = [];

        $disaster = Disaster::where('id', 1)->first();

        //check distance
        //return data for send notification to email & whatsapp
        for ($i = 0; $i < count($longLat); $i++) {
            for ($j = 0; $j < count($users); $j++) {
                $distance = $this->calculateDistance($users[$j]->latitude, $users[$j]->longitude, $longLat[$i]['lat'], $longLat[$i]['long']);
                //under if on production
                array_push($checkDistance, [
                    'ews_id' => $longLat[$i]['ews_id'],
                    'level' => $longLat[$i]['level'],
                    'distance' => $distance,
                    'disaster_id' => 1,
                    'user_id' => $users[$j]->id,
                    'email_user' => $users[$j]->email
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
                        'user_id' => $checkDistance[$i]['user_id']
                    ]);
                }
            }
        }

        $promise4 = new Promise();
        $sendEmail = new EmailSendNotification($checkDistance, $promise4);

        InsertFloodNotification::dispatch($dataNotif);
        dispatch($sendEmail);


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

    public function downloadData($id)
    {
        try {
            $decrypted = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            echo $e;
        }
        $data = Flood::with('ews')->where('ews_id', $decrypted)->get();
        if ($decrypted == 0) {
            $data = Flood::with('ews')->get();
        }

        //create a csv file with fatched data
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=data-ews" . Carbon::now() . '.csv',
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');
            fputcsv($file, array('Nama EWS', 'Lokasi', 'Level', 'Created At'));
            foreach ($data as $row) {
                fputcsv($file, array($row->ews->name, $row->ews->location, $row->level, $row->created_at));
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
