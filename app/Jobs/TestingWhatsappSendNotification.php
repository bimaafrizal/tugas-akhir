<?php

namespace App\Jobs;

use App\Models\Template;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\Promise;
use Illuminate\Foundation\Bus\Dispatchable;

class TestingWhatsappSendNotification
{
    use Dispatchable;
    protected $datas;
    protected $promise;
    protected $result = [];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($arr, Promise $promise)
    {
        $this->datas = $arr;
        $this->promise = $promise;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $datas = $this->datas;
        $body = Template::where('id', 1)->first();
        $body = $body->body;

        foreach ($datas as $data) {
            $level = "normal";
            if ($data['level'] ==  1) {
                $level = "Siaga";
            } else if ($data['level'] ==  2) {
                $level = "Waspada";
            } else if ($data['level'] ==  3) {
                $level = "Awas";
            }
            $distance = $data['distance'];
            $ews_name = $data['ews_name'];

            eval("\$body = \"$body\";");

            $this->sendWhatsapp($data['phone_user'], $body);
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