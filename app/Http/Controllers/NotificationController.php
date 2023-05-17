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
        $earthquakeNotif = EarthquakeNotification::all();
        $floodNotif = FloodNotification::all();

        if ($user->role_id == 1) {
            $earthquakeNotif = EarthquakeNotification::where('user_id', $user->id)->get();
            $floodNotif = FloodNotification::where('user_id', $user->id)->get();
        }

        return view('pages.dashboard2.notifikasi.index', compact('earthquakeNotif', 'floodNotif'));
    }

    public function earthquakeDetail($id)
    {
    }

    public function floodDetail($id)
    {
    }
}