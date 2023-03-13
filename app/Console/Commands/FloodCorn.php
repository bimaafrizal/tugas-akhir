<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Flood;
use App\Models\Ews;
use GuzzleHttp\Client;

class FloodCorn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flood:corn';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get data aws every one minutes';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $ews = Ews::all();
        $client = new Client();
        $array = [];

        foreach ($ews as $item) {
            $response = $client->request('GET', $item->api_url);
            $data = json_decode($response->getBody()->getContents());
            $detailData = $data->feeds[0];
            $arrayTemp = [];
            $flood = Flood::where('ews_id', $item->id)->orderBy('created_at', 'desc')->first();
            if ($flood == null) {
                if (property_exists($detailData, 'field2') == false) {
                    $arrayTemp['ews_id'] = $item->id;
                    if ($detailData->field1 <= 1024) {
                        $arrayTemp['level'] = 0;
                    } else if ($detailData->field1 > 1024 && $detailData->field1 <= 2048) {
                        $arrayTemp['level'] = 1;
                    } else if ($detailData->field1 > 2048 && $detailData->field1 <= 3072) {
                        $arrayTemp['level'] = 2;
                    } else if ($detailData->field3 > 3072) {
                        $arrayTemp['level'] = 3;
                    }
                    $arrayTemp['created_at'] = $detailData->created_at;
                    array_push($array, $arrayTemp);
                } else {
                    $arrayTemp['ews_id'] = $item->id;
                    if ($detailData->field1 == 1) {
                        $arrayTemp['level'] = 0;
                    } else if ($detailData->field1 == 0) {
                        $arrayTemp['level'] = 1;
                    } else if ($detailData->field2 == 0) {
                        $arrayTemp['level'] = 2;
                    } else if ($detailData->field3 == 0) {
                        $arrayTemp['level'] = 3;
                    }
                    $arrayTemp['created_at'] = $detailData->created_at;
                    array_push($array, $arrayTemp);
                }
            } else {
                if (property_exists($detailData, 'field2') == false) {
                    if ($detailData->created_at != date("Y-m-d\TH:i:s\Z", strtotime($flood->created_at))) {
                        $arrayTemp['ews_id'] = $item->id;
                        if ($detailData->field1 <= 1024) {
                            $arrayTemp['level'] = 0;
                        } else if ($detailData->field1 > 1024 && $detailData->field1 <= 2048) {
                            $arrayTemp['level'] = 1;
                        } else if ($detailData->field1 > 2048 && $detailData->field1 <= 3072) {
                            $arrayTemp['level'] = 2;
                        } else if ($detailData->field3 > 3072) {
                            $arrayTemp['level'] = 3;
                        }
                        $arrayTemp['created_at'] = $detailData->created_at;
                        array_push($array, $arrayTemp);
                    }
                    // dd('Data sudah ada');
                    // $this->info('Data sudah ada');
                } else {
                    if ($detailData->created_at != date("Y-m-d\TH:i:s\Z", strtotime($flood->created_at))) {
                        $arrayTemp['ews_id'] = $item->id;
                        if ($detailData->field1 == 1) {
                            $arrayTemp['level'] = 0;
                        } else if ($detailData->field1 == 0) {
                            $arrayTemp['level'] = 1;
                        } else if ($detailData->field2 == 0) {
                            $arrayTemp['level'] = 2;
                        } else if ($detailData->field3 == 0) {
                            $arrayTemp['level'] = 3;
                        }
                        $arrayTemp['created_at'] = $detailData->created_at;
                        array_push($array, $arrayTemp);
                    }
                    // dd('Data sudah ada');
                    // $this->info('Data sudah ada');
                }
            }
        }
        Flood::insert($array);
        $this->info('Berhasil menambahkan data');
        // $this->info('Gagal menambahkan data');
    }
}