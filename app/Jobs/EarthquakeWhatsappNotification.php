<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\Promise;
use Illuminate\Foundation\Bus\Dispatchable;

class EarthquakeWhatsappNotification
{
    use Dispatchable;
    protected $users;
    protected $earthquake;
    protected $promise;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($users, $earthquake, Promise $promise)
    {
        $this->users = $users;
        $this->earthquake = $earthquake;
        $this->promise = $promise;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = $this->users;
        $earthquakeData = $this->earthquake;
        
        foreach ($users as $user) {
            $message = "Gempa pada koordinat " . $earthquakeData['longitude'] . "," . $earthquakeData['latitude'] . " pada kedalaman " . $earthquakeData['depth'] .  " kekuatan sebesar " . $earthquakeData['strength'] . " SR. Jarak anda dengan lokasi gempa adalah " . $user['distance'] . " km.";
            $this->sendWhatsapp($user['phone_number'], $message);
        }
    }

    public function sendWhatsapp($user, $message)
    {
        $token = config('services.FONNTE_TOKEN');

        $client = new Client();
        $response = $client->request('POST', 'https://api.fonnte.com/send', [
            'headers' => [
                'Accept' => 'aplication/json',
                'Authorization' => $token
            ],
            'json' => [
                'target' => $user,
                'message' => $message,
                'countryCode' => '62', //optional
            ]
        ]);
        $data = json_decode($response->getBody()->getContents());
        return $data;
    }
}