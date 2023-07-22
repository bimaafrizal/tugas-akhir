<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Earthquake;
use App\Models\Ews;
use App\Models\Flood;
use App\Models\KategoryArticle;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();
        $earthquakeThisYear = Earthquake::whereDate('created_at', '>=', Carbon::now()->startOfYear())->whereDate('created_at', '<=', Carbon::now()->endOfYear())->orderBy('id', 'desc')->get();
        $floodThisYear = Flood::where('level', 1)->orWhere('level', 2)->orWhere('level', 3)->whereDate('created_at', '>=', Carbon::now()->startOfYear())->whereDate('created_at', '<=', Carbon::now()->endOfYear())->orderBy('id', 'desc')->get();
        $total = count($earthquakeThisYear) + count($floodThisYear);
        $countEarthquake = count($earthquakeThisYear);
        $countFlood =  count($floodThisYear);
        $ews = Ews::all();
        $no = 1;

        $bulan = array(
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        );

        $currentMonth = date('n');
        $listMonths = [];
        for ($i = 1; $i <= $currentMonth; $i++) {
            $listMonths[] = $bulan[$i];
        }

        $month = $request->month;
        if ($request->month < 10) {
            $month = '0' . $request->month;
        }

        if ($request->month != null) {
            $earthquakeThisYear = Earthquake::whereDate('created_at', '>=', Carbon::now()->startOfYear())->whereDate('created_at', '<=', Carbon::now()->endOfYear())->whereRaw('SUBSTRING(created_at, 6, 2) = ?', [$month])->get();
            $floodThisYear = Flood::whereDate('created_at', '>=', Carbon::now()->startOfYear())->whereDate('created_at', '<=', Carbon::now()->endOfYear())->whereRaw('SUBSTRING(created_at, 6, 2) = ?', [$month])->where('level', 1)->orWhere('level', 2)->orWhere('level', 3)->get();
        }

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
            return view('pages.dashboard2.index-user', compact('user', 'cuaca', 'time', 'cuacas', 'earthquakeThisYear', 'ews', 'floodThisYear', 'no', 'countEarthquake', 'countFlood', 'listMonths'));
        } else {
            $countUser = User::where('role_id', 1)->count();
            $countAdmin = User::where('role_id', 2)->count();
            $countSuperAdmin = User::where('role_id', 3)->count();
            $countEws = Ews::count();
            $countArticle = Article::count();
            $countKetegoryArticle = KategoryArticle::count();

            return view('pages.dashboard2.index', compact('earthquakeThisYear', 'ews', 'floodThisYear', 'no', 'countEarthquake', 'countFlood', 'listMonths', 'countUser', 'countAdmin', 'countSuperAdmin', 'countEws', 'countKetegoryArticle', 'countArticle'));
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