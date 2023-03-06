<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        if ($user->role_id == 1) {
            return view('pages.dashboard.index-customer', compact('user'));
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
        // if ($user->longitude == null && $user->latitude == null) {

        // }
    }
}
