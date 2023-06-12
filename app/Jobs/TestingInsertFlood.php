<?php

namespace App\Jobs;

use App\Models\Flood;
use GuzzleHttp\Promise\Promise;
use Illuminate\Foundation\Bus\Dispatchable;

class TestingInsertFlood
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
        $insertData = Flood::insert($datas);

        $dataId = [];
        if ($insertData) {
            foreach ($datas as $data) {
                $flood = Flood::where([
                    ['created_at', '=', $data['created_at']],
                    ['ews_id', '=', $data['ews_id']],
                    ['level', '=', $data['level']]
                ])->first();
                array_push($dataId, [
                    'ews_id' => $data['ews_id'],
                    'flood_id' => $flood->id
                ]);
            }
        }
        $this->promise->resolve($dataId);
    }

    public function getResult()
    {
        return $this->promise->wait();
    }
}