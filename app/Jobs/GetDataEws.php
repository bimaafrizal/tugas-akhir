<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\Promise;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;

class GetDataEws
{
    use Dispatchable;
    protected $result;
    protected $ews;
    protected $promise;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($ews, Promise $promise)
    {
        $this->ews = $ews;
        $this->promise = $promise;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $dataEws = $this->ews;
        $client = new Client();
        $dataTemp = [];
        foreach ($dataEws as $ews) {
            $response = $client->request('GET', $ews->api_url);
            $data = json_decode($response->getBody()->getContents());
            // $detailData = $data->feeds[0];
            $dataTemp[$ews->id] = $data->feeds[0];
        }
        // $response = Http::pool(function (Pool $pool) use ($dataEws) {
        //     foreach ($dataEws as $url) {
        //         $pool->get($url->api_url);
        //     }
        // });

        // foreach ($response as $ar) {
        //     $json = $ar->json();
        //     array_push($dataTemp, $json['feeds'][0]);
        // }

        $this->promise->resolve($dataTemp);
    }

    public function getResult()
    {
        return $this->promise->wait();
    }
}