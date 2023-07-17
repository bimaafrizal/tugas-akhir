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
            'longitude' => substr($detailData->Coordinates, strpos($detailData->Coordinates, ',') + 1),
            'latitude' => substr($detailData->Coordinates, '0', strpos($detailData->Coordinates, ',')),
            'strength' => $detailData->Magnitude,
            'depth' => $detailData->Kedalaman,
            'tanggal' => $detailData->Tanggal,
            'jam' => $detailData->Jam,
            'createdAt' => $detailData->DateTime,
            'potensi' => $detailData->Potensi
        ];

        //get nama lokasi
        $response2 = $client->request('GET', 'https://api.opencagedata.com/geocode/v1/json?q=' . $earthquakeData['latitude'] . ',' . $earthquakeData['longitude'] . '&key=' . config('services.OPENCAGEDATA_API') . '&language=id&pretty=1');
        $data2 = json_decode($response2->getBody()->getContents());
        $earthquakeData['location'] = $data2->results[0]->formatted;

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
                'inserted_at' => Carbon::now(),
                'location' => $earthquakeData['location']
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
                    'inserted_at' => Carbon::now(),
                    'location' => $earthquakeData['location']
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
            //under if on production
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
            $this->info('Berhasil menambahkan data gempa');
        }
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
}
