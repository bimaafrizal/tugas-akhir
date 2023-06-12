<?php

namespace App\Jobs;

use App\Models\Disaster;
use App\Models\Earthquake;
use Carbon\Carbon;
use GuzzleHttp\Promise\Promise;
use Illuminate\Foundation\Bus\Dispatchable;

class TestingInsertEarthquake
{
    use Dispatchable;
    protected $newEarthquake;
    protected $lastEarthquake;
    protected $promise;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($lastEarthquake, $newEarthquake, Promise $promise)
    {
        $this->lastEarthquake = $lastEarthquake;
        $this->newEarthquake = $newEarthquake;
        $this->promise = $promise;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $lastData = $this->lastEarthquake;
        $newData = $this->newEarthquake;
        $insert = false;

        //insert to db
        if ($lastData  == null) {
            $insert = Earthquake::insert([
                'longitude' => $newData['longitude'],
                'latitude' => $newData['latitude'],
                'strength' => $newData['strength'],
                'depth' => $newData['depth'],
                'date' => $newData['tanggal'],
                'time' => $newData['jam'],
                'created_at' => $newData['createdAt'],
                'potency' => $newData['potensi'],
                'inserted_at' => Carbon::now()
            ]);
        } else {
            if ($lastData->longitude != $newData['longitude'] || $lastData->latitude != $newData['latitude'] || $lastData->date != $newData['tanggal'] || $lastData->time  != $newData['jam']) {
                $insert = Earthquake::insert([
                    'longitude' => $newData['longitude'],
                    'latitude' => $newData['latitude'],
                    'strength' => $newData['strength'],
                    'depth' => $newData['depth'],
                    'date' => $newData['tanggal'],
                    'time' => $newData['jam'],
                    'created_at' => $newData['createdAt'],
                    'potency' => $newData['potensi'],
                    'inserted_at' => Carbon::now()
                ]);
            }
        }

        $idEarthquake = 0;
        //check strength and depth data
        $disaster = Disaster::where('id', 2)->first();
        $lengthOfString = strlen($newData['depth']);
        $convertDepth = (int) substr($newData['depth'], '0', $lengthOfString - strpos($newData['depth'], 'km'));

        if ($insert) {
            if ($newData['strength'] >= $disaster->strength && $convertDepth >= $disaster->depth) {
                //get id
                $earthquake = Earthquake::where([
                    ['longitude', '=', $newData['longitude']],
                    ['latitude', '=', $newData['latitude']],
                    ['strength', '=', $newData['strength']],
                    ['depth', '=', $newData['depth']],
                    ['time', '=', $newData['jam']],
                    ['created_at', '=', $newData['createdAt']],
                    ['potency', '=', $newData['potensi']]
                ])->first();
                $idEarthquake = $earthquake->id;
            }
        }

        $this->promise->resolve($idEarthquake);
    }

    public function getResult()
    {
        return $this->promise->wait();
    }
}