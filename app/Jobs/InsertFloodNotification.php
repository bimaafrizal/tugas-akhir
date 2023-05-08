<?php

namespace App\Jobs;

use App\Models\FloodNotification;
use GuzzleHttp\Promise\Promise;
use Illuminate\Foundation\Bus\Dispatchable;

class InsertFloodNotification
{
    use Dispatchable;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $datas;

    public function __construct($arr)
    {
        $this->datas = $arr;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = $this->datas;
        FloodNotification::insert($data);
    }
}
