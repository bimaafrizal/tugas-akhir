<?php

namespace App\Jobs;

use App\Models\EarthquakeNotification;
use Illuminate\Foundation\Bus\Dispatchable;

class InsertEarthquakeNotification
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
        EarthquakeNotification::insert($data);
    }
}
