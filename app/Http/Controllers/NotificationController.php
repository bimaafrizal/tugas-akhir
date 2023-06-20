<?php

namespace App\Http\Controllers;

use App\Models\Earthquake;
use App\Models\EarthquakeNotification;
use App\Models\FloodNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $earthquakeNotif = EarthquakeNotification::orderBy('id', 'desc')->get();
        $floodNotif = FloodNotification::orderBy('id', 'desc')->get();

        if ($user->role_id == 1) {
            $earthquakeNotif = EarthquakeNotification::where('user_id', $user->id)->orderBy('id', 'desc')->get();
            $floodNotif = FloodNotification::where('user_id', $user->id)->orderBy('id', 'desc')->get();
        }

        return view('pages.dashboard2.notifikasi.index', compact('earthquakeNotif', 'floodNotif'));
    }

    public function earthquakeDetail($id)
    {
        $decryptId = decrypt($id);
        $data = EarthquakeNotification::where('id', $decryptId)->first();


        return view('pages.dashboard2.notifikasi.earthquake-detail', compact('data'));
    }

    public function floodDetail($id)
    {
        $decryptId = decrypt($id);
        $data = FloodNotification::where('id', $decryptId)->first();

        return view('pages.dashboard2.notifikasi.flood-detail', compact('data'));
    }
}