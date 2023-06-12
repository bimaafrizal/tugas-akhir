<?php

namespace App\Console\Commands;

use App\Jobs\WeatherEmailNotification;
use App\Jobs\WeatherWhatsappNotification;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\Promise;
use Illuminate\Console\Command;

class WeatherCorn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Corn Job For Weather Notifitacion';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::join('setting_disasters', 'users.id', '=', 'setting_disasters.user_id')->where(
            [
                ['users.status', '=', 1],
                ['users.role_id', '=', 1],
                ['setting_disasters.disaster_id', '=', 3],
                ['setting_disasters.status', '=', '1'],
            ],
        )->whereNotNull('users.longitude')->whereNotNull('users.latitude')->get();

        $client = new Client();
        $usersWeatherData = [];
        foreach ($users as $user) {
            $response = $client->request('GET', 'api.openweathermap.org/data/2.5/forecast?lat=' . $user->latitude . '&units=metric&lang=id&lon=' . $user->longitude . '&appid=' . config('services.OPEN_WEATHER_API_KEY'));
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
    }
}