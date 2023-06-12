<?php

namespace App\Jobs;

use App\Models\Ews;
use App\Models\Flood;
use GuzzleHttp\Promise\Promise;
use Illuminate\Foundation\Bus\Dispatchable;

class TestingCheckLastData
{
    use Dispatchable;
    protected $result;
    protected $promise;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Promise $promise)
    {
        $this->promise = $promise;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $dataTerakhir = [];
        $ews = Ews::all();
        foreach ($ews as $item) {
            array_push($dataTerakhir, Flood::where('ews_id', $item->id)->orderBy('created_at', 'desc')->first());
        }

        $this->promise->resolve($dataTerakhir);
    }

    public function getResult()
    {
        return $this->promise->wait();
    }
}