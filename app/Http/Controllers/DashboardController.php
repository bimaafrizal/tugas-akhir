<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        if ($user->role_id == 1) {
            $cuaca = null;
            $cuacas = [];
            $time = Carbon::now();
            if ($user->longitude != null && $user->latitude != null) {
                $client = new Client();
                $response = $client->request('GET', 'http://api.openweathermap.org/data/2.5/weather?lat=' . $user->latitude . '&lon=' . $user->longitude . '&units=metric&lang=id' . '&appid=' . config('services.OPEN_WEATHER_API_KEY'));
                $responseCuacaJam = $client->request('GET', 'https://api.openweathermap.org/data/2.5/forecast?lat=' . $user->latitude . '&lon=' . $user->longitude . '&units=metric&appid=' . config('services.OPEN_WEATHER_API_KEY'));
                $cuaca = json_decode($response->getBody()->getContents());
                $cuacaJam = json_decode($responseCuacaJam->getBody()->getContents());

                foreach ($cuacaJam->list as $item) {
                    if (count($cuacas) < 4) {
                        if ($item->dt_txt > $time) {
                            array_push($cuacas, $item);
                        }
                    }
                }
            }
            return view('pages.dashboard2.index-user', compact('user', 'cuaca', 'time', 'cuacas'));
        } else {
            return view('pages.dashboard2.index');
        }
    }

    public function sendLocation(Request $request)
    {
        $idUser = Auth::user()->id;
        $user = User::where('id', $idUser)->first();
        $user->update([
            'longitude' => $request->longitude,
            'latitude' => $request->latitude
        ]);

        echo 'Data berhasil diupdate';
    }
}