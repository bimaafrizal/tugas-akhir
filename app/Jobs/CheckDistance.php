<?php

namespace App\Jobs;

use App\Models\User;
use GuzzleHttp\Promise\Promise;
use Illuminate\Foundation\Bus\Dispatchable;

class CheckDistance
{
    use Dispatchable;
    protected $lat;
    protected $long;
    protected $apiLat;
    protected $apiLong;
    protected $api;
    protected $result;
    protected $promise;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($arr, Promise $promise)
    {
        // $this->lat = $lat;
        // $this->long = $long;
        // $this->apiLat = $apiLat;
        // $this->apiLong = $apiLong;
        $this->api = $arr;
        $this->promise = $promise;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = User::Where(
            [
                ['status', '=', 1],
                ['role_id', '=', 1],
            ],
        )->whereNotNull('longitude')->whereNotNull('latitude')->get();

        foreach ($users as $user) {
            
        }
    }

    public function getDistance($userLat, $userLong, $apiLat, $apiLong)
    {
        $earth_radius = 6371; //in km

        $dLat = deg2rad($apiLat - $userLat);
        $dLon = deg2rad($apiLong - $userLong);

        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($userLat)) * cos(deg2rad($apiLong)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * asin(sqrt($a));

        $distance = $earth_radius * $c;

        $this->result =  round($distance);
    }

    public function getResult()
    {
        return $this->result;
    }
}