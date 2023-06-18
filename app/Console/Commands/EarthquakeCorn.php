<?php

namespace App\Console\Commands;

use App\Jobs\CheckDistanceUserEarthquake;
use App\Jobs\EarthquakeEmailNotification;
use App\Jobs\EarthquakeWhatsappNotification;
use App\Jobs\InsertEarthquakeNotification;
use App\Models\Disaster;
use Illuminate\Console\Command;
use App\Models\Earthquake;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\Promise;

class EarthquakeCorn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'earthquake:corn';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get data earthquake from bmkg every one minutes';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //get data
        $client = new Client();
        $response = $client->request('GET', 'https://data.bmkg.go.id/DataMKG/TEWS/autogempa.json');
        $data = json_decode($response->getBody()->getContents());
        $detailData = $data->Infogempa->gempa;
        $insert = false;

        $earthquakeData = [
            'latitude' => substr($detailData->Coordinates, strpos($detailData->Coordinates, ',') + 1),
            'longitude' => substr($detailData->Coordinates, '0', strpos($detailData->Coordinates, ',')),
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
            $distance = $this->calculateDistance($user->lat, $user->long, $earthquake['latitude'], $earthquake['longitude']);
            //under if on production
            if ($distance <=  $disaster->distance) {
                array_push($distanceOfUser, [
                    'distance' => $distance,
                    'user_id' => $user->user_id,
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
            $this->info('Berhasil menambahkan data gempa');
        }
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
}