<?php

namespace App\Jobs;

use App\Models\Template;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\Promise;
use Illuminate\Foundation\Bus\Dispatchable;

class TestingWeatherWhatsappNotification
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
        $body = Template::where('id', 3)->first();
        $body = $body->body;
        $datas = $this->data;
        foreach ($datas as $data) {
            $cuaca = $data['cuaca']->weather[0]->description;
            $temp = $data['cuaca']->main->temp;
            $feels_like = $data['cuaca']->main->feels_like;
            $dt_txt = $data['cuaca']->dt_txt;

            eval("\$body = \"$body\";");

            $this->sendWhatsapp($data['user']->phone_num, $body);
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