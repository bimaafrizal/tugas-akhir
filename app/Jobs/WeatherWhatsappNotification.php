<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\Promise;
use Illuminate\Foundation\Bus\Dispatchable;

class WeatherWhatsappNotification
{
    use Dispatchable;
    protected $data;
    protected $promise;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, Promise $promise)
    {
        $this->data = $data;
        $this->promise = $promise;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $datas = $this->data;
        foreach ($datas as $data) {
            $message = "Cuaca besok di tempat anda adalah " . $data['cuaca']->weather[0]->description . " dengan suhu " . $data['cuaca']->main->temp . "°C terasa seperti " . $data['cuaca']->main->feels_like . "°C. Pada tanggal " . $data['cuaca']->dt_txt;
            $this->sendWhatsapp($data['user']->phone_num, $message);
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
