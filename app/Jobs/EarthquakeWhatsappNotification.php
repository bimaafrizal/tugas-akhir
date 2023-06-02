<?php

namespace App\Jobs;

use App\Models\Template;
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
        $longitude = $earthquakeData['longitude'];
        $latitude = $earthquakeData['latitude'];
        $depth = $earthquakeData['depth'];
        $strength = $earthquakeData['strength'];

        $body = Template::where('id', 2)->first();
        $body = $body->body;

        foreach ($users as $user) {
            $distance = $user['distance'];
            eval("\$body = \"$body\";");
            
            $this->sendWhatsapp($user['phone_number'], $body);
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