<?php

namespace App\Jobs;

use App\Models\Disaster;
use App\Models\User;
use GuzzleHttp\Promise\Promise;
use Illuminate\Foundation\Bus\Dispatchable;

class CheckDistanceUserEarthquake
{
    use Dispatchable;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $lat;
    protected $long;
    protected $promise;
    public function __construct($lat, $long, Promise $promise)
    {
        $this->lat = $lat;
        $this->long = $long;
        $this->promise = $promise;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $earthquakeLat = $this->lat;
        $earthquakeLong = $this->long;
        $arrayUser = [];
        $users = User::Where(
            [
                ['status', '=', 1],
                ['role_id', '=', 1],
            ],
        )->whereNotNull('longitude')->whereNotNull('latitude')->get();

        $disaster = Disaster::where('id', 2)->first();

        foreach ($users as $user) {
            $distance = $this->calculateDistance($user->lat, $user->long, $earthquakeLat, $earthquakeLong);
            //under if on production
            array_push($arrayUser, [
                'jarak' => $distance,
                'user_id' => $user->id,
                'email_user' => $user->email,
                'phone_number' => $user->phone_num
            ]);
            if ($distance <=  $disaster->distance) {
            }
        }


        $this->promise->resolve($arrayUser);
    }

    public function getResult()
    {
        return $this->promise->wait();
    }

    function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $R = 6371; // Radius of the Earth in kilometers
        $lat1Rad = deg2rad($lat1);
        $lon1Rad = deg2rad($lon1);
        $lat2Rad = deg2rad($lat2);
        $lon2Rad = deg2rad($lon2);

        $distance = $R * acos(sin($lat1Rad) * sin($lat2Rad) + cos($lat1Rad) * cos($lat2Rad) * cos($lon2Rad - $lon1Rad));

        return $distance;
    }
}