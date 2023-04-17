<?php

namespace App\Jobs;

use App\Models\Flood;
use GuzzleHttp\Promise\Promise;
use Illuminate\Foundation\Bus\Dispatchable;

class InsertFlood
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
        // foreach ($this->datas as $key => $data) {
        //     $arrTemp = [];
        //     if (property_exists($data, 'field2') == false) {
        //         $arrTemp['ews_id'] = $key;
        //         if ($data->field1 <= 1024) {
        //             $arrTemp['level'] = 0;
        //         } else if ($data->field1 > 1024 && $data->field1 <= 2048) {
        //             $arrTemp['level'] = 1;
        //         } else if ($data->field1 > 2048 && $data->field1 <= 3072) {
        //             $arrTemp['level'] = 2;
        //         } else if ($data->field3 > 3072) {
        //             $arrTemp['level'] = 3;
        //         }
        //         $arrTemp['created_at'] = $data->created_at;
        //         array_push($this->result, $arrTemp);
        //     } else {
        //         $arrTemp['ews_id'] = $key;
        //         if ($data->field1 == 1) {
        //             $arrTemp['level'] = 0;
        //         } else if ($data->field1 == 0) {
        //             $arrTemp['level'] = 1;
        //         } else if ($data->field2 == 0) {
        //             $arrTemp['level'] = 2;
        //         } else if ($data->field3 == 0) {
        //             $arrTemp['level'] = 3;
        //         }
        //         $arrTemp['created_at'] = $data->created_at;
        //         array_push($this->result, $arrTemp);
        //     }
        // }
        $insertData = Flood::insert($this->datas);
        $this->promise->resolve($insertData);
    }

    // public function getResult()
    // {
    //     return $this->promise->wait();
    // }
}