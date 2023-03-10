<?php

namespace App\Http\Controllers;

use App\Models\User;
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
            if ($user->longitude != null && $user->latitude != null) {
                $client = new Client();
                $response = $client->request('GET', 'http://api.openweathermap.org/data/2.5/weather?lat=' . $user->latitude . '&lon=' . $user->longitude . '&appid=' . config('services.OPEN_WEATHER_API_KEY'));
                $cuaca = json_decode($response->getBody()->getContents());
                // dd($cuaca);
            }
            return view('pages.dashboard.index-customer', compact('user', 'cuaca'));
        } else {
            return view('pages.dashboard.index');
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