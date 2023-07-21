<?php

namespace App\Console\Commands;

use App\Jobs\CheckLastData;
use App\Jobs\EmailSendNotification;
use App\Jobs\GetDataEws;
use App\Jobs\InsertFlood;
use App\Jobs\InsertFloodNotification;
use App\Jobs\WhatsappSendNotification;
use App\Models\Disaster;
use Illuminate\Console\Command;
use App\Models\Flood;
use App\Models\Ews;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\Promise;
use GuzzleHttp\Promise\Utils;

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
    protected $description = 'Get data aws every 15 minutes';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //get data and check last data
        $ews = EWS::where('status', '1')->get();
        $promise1 =  new Promise();
        $getDataEws = new GetDataEws($ews, $promise1);
        $promise2 =  new Promise();
        $getLastdata = new CheckLastData($promise2);
        dispatch($getDataEws);
        dispatch($getLastdata);
        $promises[] = $promise1;
        $promises[] = $promise2;
        $results = Utils::all($promises)->wait();
        $dataEWS = $getDataEws->getResult();
        $lastDataEws = $getLastdata->getResult();

        $arrIdEwsLast = [];
        foreach ($lastDataEws as $data) {
            if ($data != null) {
                array_push($arrIdEwsLast, $data->id);
            }
        }

        $results2 = [];
        //check if any new data 
        foreach ($lastDataEws as $last) {
            if ($last != null) {
                if ($dataEWS[$last->ews_id]['data']->created_at != date("Y-m-d\TH:i:s\Z", strtotime($last->created_at))) {
                    $results2[$last->ews_id] = $dataEWS[$last->ews_id];
                }
            }
        }

        //if there is nothing last data
        foreach ($dataEWS as $key => $value) {
            if (in_array($key, $arrIdEwsLast) == false) {
                $results2[$key] = $dataEWS[$key];
            }
        }

        //convert to level
        $convertLevel = [];
        foreach ($results2 as $key => $data) {
            $arrTemp = [];
            if ($data['ews']->standard_id == 1) {
                if (property_exists($data['data'], 'field1') == true && property_exists($data['data'], 'field2') == false && property_exists($data['data'], 'field3') == false) {
                    $arrTemp['ews_id'] = $key;
                    if ($data['data']->field1 <= 1024) {
                        $arrTemp['level'] = 0;
                    } else if ($data['data']->field1 > 1024 && $data['data']->field1 <= 2048) {
                        $arrTemp['level'] = 1;
                    } else if ($data['data']->field1 > 2048 && $data['data']->field1 <= 3072) {
                        $arrTemp['level'] = 2;
                    } else if ($data['data']->field1 > 3072) {
                        $arrTemp['level'] = 3;
                    }
                    $arrTemp['created_at'] = $data['data']->created_at;
                    $arrTemp['resume'] = serialize($data['data']);
                    array_push($convertLevel, $arrTemp);
                } else if (property_exists($data['data'], 'field1') == true && property_exists($data['data'], 'field2') == true && property_exists($data['data'], 'field3') == true && property_exists($data['data'], 'field4') == false && property_exists($data['data'], 'field5') == false && property_exists($data['data'], 'field6') == false) {
                    $arrTemp['ews_id'] = $key;
                    if ($data['data']->field1 == 1) {
                        $arrTemp['level'] = 0;
                    } else if ($data['data']->field1 == 0 && $data['data']->field2 == 1 && $data['data']->field3 == 1) {
                        $arrTemp['level'] = 1;
                    } else if ($data['data']->field2 == 0 && $data['data']->field2 == 0 && $data['data']->field3 == 1) {
                        $arrTemp['level'] = 2;
                    } else if ($data['data']->field3 == 0 && $data['data']->field2 == 0 && $data['data']->field3 == 0) {
                        $arrTemp['level'] = 3;
                    }
                    $arrTemp['created_at'] = $data['data']->created_at;
                    $arrTemp['resume'] = serialize($data['data']);
                    array_push($convertLevel, $arrTemp);
                } else if (property_exists($data['data'], 'field1') == true && property_exists($data['data'], 'field2') == true && property_exists($data['data'], 'field3') == true && property_exists($data['data'], 'field4') == true && property_exists($data['data'], 'field5') == true && property_exists($data['data'], 'field6') == true) {
                    $arrTemp['ews_id'] = $key;
                    $arrTemp['created_at'] = $data['data']->created_at;
                    if ($data['data']->field6 == 0) {
                        $arrTemp['level'] = 0;
                    } else if ($data['data']->field6 >= 1 && $data['data']->field6 <= 3) {
                        $arrTemp['level'] = 1;
                    } else if ($data['data']->field6 >= 4 && $data['data']->field6 <= 6) {
                        $arrTemp['level'] = 2;
                    } else {
                        $arrTemp['level'] = 3;
                    }
                    $arrTemp['resume'] = serialize($data['data']);
                    array_push($convertLevel, $arrTemp);
                }
            } else if ($data['ews']->standard_id == 2) {
                $arrTemp['ews_id'] = $key;
                if ($data['data']->field1 == 0) {
                    $arrTemp['level'] = 0;
                } else if ($data['data']->field1 == 1) {
                    $arrTemp['level'] = 1;
                } else if ($data['data']->field1 == 2) {
                    $arrTemp['level'] = 2;
                } else if ($data['data']->field1 == 3) {
                    $arrTemp['level'] = 3;
                }
                $arrTemp['created_at'] = $data['data']->created_at;
                $arrTemp['resume'] = serialize($data['data']);
                array_push($convertLevel, $arrTemp);
            }
        }

        //insert to flood table
        $promise3 =  new Promise();
        $insertFlood = new InsertFlood($convertLevel, $promise3);
        dispatch($insertFlood);
        $floodData = $insertFlood->getResult();

        $result3 = [];

        //check if any new level
        foreach ($convertLevel as $value) {
            if (in_array($value['ews_id'], $arrIdEwsLast)) {
                $lastData =  Flood::where('ews_id', $value['ews_id'])->first();
                if ($lastData->level != $value['level']) {
                    array_push($result3, $value);
                }
            } else if ($value['level'] != 0) {
                array_push($result3, $value);
            }
        }

        //get users where longitude & latitude not null
        $users = User::join('setting_disasters', 'users.id', '=', 'setting_disasters.user_id')->where(
            [
                ['users.status', '=', 1],
                ['users.role_id', '=', 1],
                ['setting_disasters.disaster_id', '=', 1],
                ['setting_disasters.status', '=', '1'],
            ],
        )->whereNotNull('users.longitude')->whereNotNull('users.latitude')->get();


        //get longitude latitude of ews
        $dataEWS = [];
        foreach ($result3 as $data) {
            $ews = Ews::where('id', $data['ews_id'])->first();
            array_push($dataEWS, [
                'ews_id' => $ews->id,
                'ews_name' => $ews->name,
                'long' => $ews->longitude,
                'lat' => $ews->latitude,
                'level' => $data['level']
            ]);
        }

        $checkDistance = [];
        $disaster = Disaster::where('id', 1)->first();

        //check distance
        //return data for send notification to email & whatsapp
        for ($i = 0; $i < count($dataEWS); $i++) {
            for ($j = 0; $j < count($users); $j++) {
                $distance = $this->calculateDistance($users[$j]->latitude, $users[$j]->longitude, $dataEWS[$i]['lat'], $dataEWS[$i]['long']);
                //under if on production
                if ($distance <= $disaster->distance) {
                    array_push($checkDistance, [
                        'ews_id' => $dataEWS[$i]['ews_id'],
                        'ews_name' => $dataEWS[$i]['ews_name'],
                        'level' => $dataEWS[$i]['level'],
                        'distance' => $distance,
                        'user_id' => $users[$j]->id,
                        'user_latitude' => $users[$j]->latitude,
                        'user_longitude' => $users[$j]->longitude,
                        'email_user' => $users[$j]->email,
                        'phone_user' => $users[$j]->phone_num
                    ]);
                }
            }
        }

        //return data for insert to notification table
        $dataNotif = [];
        for ($i = 0; $i < count($checkDistance); $i++) {
            for ($j = 0; $j < count($floodData); $j++) {
                if ($checkDistance[$i]['ews_id'] == $floodData[$j]['ews_id']) {
                    array_push($dataNotif, [
                        'flood_id' => $floodData[$j]['flood_id'],
                        'user_id' => $checkDistance[$i]['user_id'],
                        'distance' => $checkDistance[$i]['distance'],
                        'user_latitude' => $checkDistance[$i]['user_latitude'],
                        'user_longitude' => $checkDistance[$i]['user_longitude'],
                        'created_at' => Carbon::now()
                    ]);
                }
            }
        }

        $promise4 = new Promise();
        $sendEmail = new EmailSendNotification($checkDistance, $promise4);
        $promise5 = new Promise();
        $sendWhatsapp = new WhatsappSendNotification($checkDistance, $promise5);

        InsertFloodNotification::dispatch($dataNotif);

        dispatch($sendEmail);
        dispatch($sendWhatsapp);

        $this->info('Berhasil menambahkan data');
    }

    function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $R = 6371; // Radius of the Earth in kilometers
        $lat1Rad = deg2rad($lat1);
        $lon1Rad = deg2rad($lon1);
        $lat2Rad = deg2rad($lat2);
        $lon2Rad = deg2rad($lon2);

        $distance = $R * acos(sin($lat1Rad) * sin($lat2Rad) + cos($lat1Rad) * cos($lat2Rad) * cos($lon2Rad - $lon1Rad));

        $distance = round($distance, 2);
        return $distance;
    }
}
