<?php

namespace App\Jobs;

use App\Models\FloodNotification;
use GuzzleHttp\Promise\Promise;
use Illuminate\Foundation\Bus\Dispatchable;

class InsertNotification
{
    use Dispatchable;
    protected $datas;
    protected $promise;
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
        $insertData = FloodNotification::insert($datas);
        $dataId = [];
        if ($insertData) {
            foreach ($datas as $data) {
                $notif = FloodNotification::where([
                    ['user_id', '=', $data->user_id],
                    ['flood_id', '=', $data->flood_id]
                ])->orderBy('id', 'desc')->first();
                array_push($dataId, [
                    'flood_notification_id' => $notif->id,
                    'user_id' => $notif->user_id
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
