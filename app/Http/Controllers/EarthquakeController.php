<?php

namespace App\Http\Controllers;

use App\Models\Earthquake;
use App\Http\Requests\StoreEarthquakeRequest;
use App\Http\Requests\UpdateEarthquakeRequest;
use App\Jobs\CheckDistanceUserEarthquake;
use App\Jobs\EarthquakeEmailNotification;
use App\Jobs\EarthquakeWhatsappNotification;
use App\Jobs\InsertEarthquake;
use App\Jobs\InsertEarthquakeNotification;
use App\Jobs\TestingCheckDistanceUserEarthquake;
use App\Jobs\TestingEarthquakeEmailNotification;
use App\Jobs\TestingEarthquakeWhatsappNotification;
use App\Jobs\TestingInsertEarthquakeNotification;
use App\Models\Disaster;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\Promise;
use GuzzleHttp\Promise\Utils;
use Illuminate\Support\Facades\Response;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class EarthquakeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gempa = Earthquake::orderBy('id', 'desc')->first();
        $gempas = Earthquake::orderBy('id', 'desc')->take(30)->get();
        return view('pages.dashboard2.earthquake.index', compact('gempa', 'gempas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEarthquakeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $coba = $this->calculateDistance(-7.5556917, 110.8605321, 0.63, 114.99);
        // $coba = round($coba, 2);
        // dd($coba);
        //get data
        $client = new Client();
        $response = $client->request('GET', 'https://data.bmkg.go.id/DataMKG/TEWS/autogempa.json');
        $data = json_decode($response->getBody()->getContents());
        $detailData = $data->Infogempa->gempa;
        $insert = false;

        $earthquakeData = [
            'longitude' => substr($detailData->Coordinates, strpos($detailData->Coordinates, ',') + 1),
            'latitude' => substr($detailData->Coordinates, '0', strpos($detailData->Coordinates, ',')),
            'strength' => $detailData->Magnitude,
            'depth' => $detailData->Kedalaman,
            'tanggal' => $detailData->Tanggal,
            'jam' => $detailData->Jam,
            'createdAt' => $detailData->DateTime,
            'potensi' => $detailData->Potensi
        ];

        //get last data
        $earthquake = Earthquake::orderBy('id', 'desc')->first();
        if ($earthquake  == null) {
            $insert = Earthquake::insert([
                'longitude' => $earthquakeData['longitude'],
                'latitude' => $earthquakeData['latitude'],
                'strength' => $earthquakeData['strength'],
                'depth' => $earthquakeData['depth'],
                'date' => $earthquakeData['tanggal'],
                'time' => $earthquakeData['jam'],
                'created_at' => $earthquakeData['createdAt'],
                'potency' => $earthquakeData['potensi'],
                'inserted_at' => Carbon::now()
            ]);
        } else {
            if ($earthquake->longitude != $earthquakeData['longitude'] || $earthquake->latitude != $earthquakeData['latitude'] || $earthquake->date != $earthquakeData['tanggal'] || $earthquake->time  != $earthquakeData['jam']) {
                $insert = Earthquake::insert([
                    'longitude' => $earthquakeData['longitude'],
                    'latitude' => $earthquakeData['latitude'],
                    'strength' => $earthquakeData['strength'],
                    'depth' => $earthquakeData['depth'],
                    'date' => $earthquakeData['tanggal'],
                    'time' => $earthquakeData['jam'],
                    'created_at' => $earthquakeData['createdAt'],
                    'potency' => $earthquakeData['potensi'],
                    'inserted_at' => Carbon::now()
                ]);
            }
        }

        $idEarthquake = 0;
        //check strength and depth data
        $disaster = Disaster::where('id', 2)->first();
        $lengthOfString = strlen($earthquakeData['depth']);
        $convertDepth = (int) substr($earthquakeData['depth'], '0', $lengthOfString - strpos($earthquakeData['depth'], 'km'));

        if ($insert) {
            if ($earthquakeData['strength'] >= $disaster->strength && $convertDepth >= $disaster->depth) {
                //get id
                $earthquake = Earthquake::where([
                    ['longitude', '=', $earthquakeData['longitude']],
                    ['latitude', '=', $earthquakeData['latitude']],
                    ['strength', '=', $earthquakeData['strength']],
                    ['depth', '=', $earthquakeData['depth']],
                    ['time', '=', $earthquakeData['jam']],
                    ['created_at', '=', $earthquakeData['createdAt']],
                    ['potency', '=', $earthquakeData['potensi']]
                ])->first();
                $idEarthquake = $earthquake->id;
            }
        }

        //check distance
        $distanceOfUser = [];
        $users = User::join('setting_disasters', 'users.id', '=', 'setting_disasters.user_id')->where(
            [
                ['users.status', '=', 1],
                ['users.role_id', '=', 1],
                ['setting_disasters.disaster_id', '=', 2],
                ['setting_disasters.status', '=', '1'],
            ],
        )->whereNotNull('users.longitude')->whereNotNull('users.latitude')->get();

        $disaster = Disaster::where('id', 2)->first();

        foreach ($users as $user) {
            $distance = $this->calculateDistance($user->latitude, $user->longitude, $earthquake['latitude'], $earthquake['longitude']);
            if ($distance <=  $disaster->distance) {
                array_push($distanceOfUser, [
                    'distance' => $distance,
                    'user_id' => $user->user_id,
                    'user_latitude' => $user->latitude,
                    'user_longitude' => $user->longitude,
                    'email_user' => $user->email,
                    'phone_number' => $user->phone_num
                ]);
            }
        }

        $dataNotif = [];
        if ($idEarthquake != 0) {
            foreach ($distanceOfUser as $distance) {
                array_push($dataNotif, [
                    'user_id' => $distance['user_id'],
                    'earthquake_id' => $idEarthquake,
                    'distance' => $distance['distance'],
                    'user_latitude' => $distance['user_latitude'],
                    'user_longitude' => $distance['user_longitude'],
                    'created_at' => Carbon::now()
                ]);
            }
            //insert to notification tabele
            $insertNotification = new InsertEarthquakeNotification($dataNotif);
            //send notification
            $promise3 = new Promise();
            $sendEmail = new EarthquakeEmailNotification($distanceOfUser, $earthquakeData, $promise3);
            $promise4 = new Promise();
            $sendWa = new EarthquakeWhatsappNotification($distanceOfUser, $earthquakeData, $promise4);
            dispatch($sendEmail);
            dispatch($sendWa);
            dispatch($insertNotification);
        }

        dd($dataNotif);
    }

    function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        // Convert degrees to radians
        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        // Earth radius in kilometers
        $radius = 6371;

        // Haversine formula
        $deltaLat = $lat2 - $lat1;
        $deltaLon = $lon2 - $lon1;
        $a = sin($deltaLat / 2) * sin($deltaLat / 2) + cos($lat1) * cos($lat2) * sin($deltaLon / 2) * sin($deltaLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = round($radius * $c, 2);

        return $distance;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Earthquake  $earthquake
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $idDecrypt = decrypt($id);
        $gempa = Earthquake::where('id', $idDecrypt)->first();
        return view('pages.dashboard2.earthquake.detail', compact('gempa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Earthquake  $earthquake
     * @return \Illuminate\Http\Response
     */
    public function edit(Earthquake $earthquake)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEarthquakeRequest  $request
     * @param  \App\Models\Earthquake  $earthquake
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEarthquakeRequest $request, Earthquake $earthquake)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Earthquake  $earthquake
     * @return \Illuminate\Http\Response
     */
    public function destroy(Earthquake $earthquake)
    {
        //
    }

    public function downloadData(Request $request)
    {
        $nextDay = date('Y-m-d', strtotime($request->tanggal_akhir . '+1 day'));
        $nextDay2 = date('Y-m-d', strtotime($request->tanggal_mulai . '+1 day'));

        if ($request->tanggal_mulai == null || $request->tanggal_akhir == null) {
            $data = Earthquake::orderBy('id', 'desc')->get();
        } else {
            $data = Earthquake::where('created_at', '>=', $request->tanggal_mulai)->where('created_at', '<=', $nextDay)->orderBy('id', 'desc')->get();
            if ($request->tanggal_mulai > $request->tanggal_akhir) {
                $data = Earthquake::where('created_at', '>=', $request->tanggal_akhir)->where('created_at', '<=', $nextDay2)->orderBy('id', 'desc')->get();
            }
        }

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Koordinat');
        $sheet->setCellValue('C1', 'Kekuatan');
        $sheet->setCellValue('D1', 'Kedalaman');
        $sheet->setCellValue('E1', 'Created At');
        $sheet->setCellValue('F1', 'Potensi');

        $row = 2;
        $number = 1;

        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, $number);
            $sheet->setCellValue('B' . $row, $item->latitude . ',' . $item->longitude);
            $sheet->setCellValue('C' . $row, $item->strength);
            $sheet->setCellValue('D' . $row, $item->depth);
            $sheet->setCellValue('E' . $row, $item->created_at);
            $sheet->setCellValue('F' . $row, $item->potency);
            $row++;
            $number++;
        }

        $writer = new Xlsx($spreadsheet);

        $fileName = 'data-gempa' . Carbon::now() . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$fileName\"");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
