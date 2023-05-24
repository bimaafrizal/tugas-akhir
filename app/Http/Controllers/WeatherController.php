<?php

namespace App\Http\Controllers;

use App\Jobs\WeatherEmailNotification;
use App\Jobs\WeatherWhatsappNotification;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\Promise;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    public function sendNotif()
    {
        $users = User::Where(
            [
                ['status', '=', 1],
                ['role_id', '=', 1],
            ],
        )->whereNotNull('longitude')->whereNotNull('latitude')->get();

        $client = new Client();
        $usersWeatherData = [];
        foreach ($users as $user) {
            $response = $client->request('GET', 'api.openweathermap.org/data/2.5/forecast?lat=' . $user->latitude . '1&lon=' . $user->longitude . '&appid=' . config('services.OPEN_WEATHER_API_KEY'));
            $data = json_decode($response->getBody()->getContents());
            $nextDayData = $data->list[6];
            array_push($usersWeatherData, [
                'cuaca' => $nextDayData,
                'user' => $user
            ]);
        }

        $promise1 = new Promise();
        $sendEmail = new WeatherEmailNotification($usersWeatherData, $promise1);
        $promise2 = new Promise();
        $sendWhatsapp = new WeatherWhatsappNotification($usersWeatherData, $promise2);
        dispatch($sendEmail);
        dispatch($sendWhatsapp);

        dd($usersWeatherData);
    }
}
