<?php

namespace App\Http\Controllers;

use App\Models\Disaster;
use App\Models\SettingDisaster;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        $disaster = Disaster::all();
        $settings = SettingDisaster::where('user_id', $id)->where('status', '1')->get();
        $cekChecked = [];
        for ($i = 0; $i < count($disaster); $i++) {
            for ($j = 0; $j < count($settings); $j++) {
                if ($disaster[$i]->id == $settings[$j]->disaster_id) {
                    array_push($cekChecked, $disaster[$i]->id);
                }
            }
        }
        // dd($cekChecked);

        $checkeds = [];
        for ($i = 0; $i < count($disaster); $i++) {
            if (in_array($disaster[$i]->id, $cekChecked)) {
                array_push($checkeds, ['data' => $disaster[$i], 'checked' => true]);
            } else if (!in_array($disaster[$i]->id, $cekChecked)) {
                array_push($checkeds, ['data' => $disaster[$i], 'checked' => false]);
            }
        }

        return view('pages.dashboard2.profile.index', compact('user', 'checkeds', 'settings'));
    }

    public function editData(Request $request)
    {
        $user = $request->user();
        $validateData = $request->validate([
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|email:dns|unique:users,email,' . $user->id,
            'phone_num' => 'required|min:9|max:13|unique:users,phone_num,' . $user->id,
        ]);

        //send email verification
        if ($user->email != $request->email) {
            $request->user()->sendEmailVerificationNotification();
        }
        if ($user->email != $request->email) {
            $validateData['email_verified_at'] = null;
        }
        if ($user->phone_num != $request->phone_num) {
            $validateData['phone_num_verified_at'] = null;
        }
        $user->update($validateData);

        return redirect(route('profile.index'))->with('success', 'Berhasil merubah profile');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'recent_password' => 'required',
            'password' => 'required|confirmed|min:5|max:255'
        ]);
        $user = $request->user();
        if (!(Hash::check($request->recent_password, $user->password))) {
            return back()->withErrors(['recent_password' => 'Your recent password is incorrect.']);
        }
        $password = Hash::make($request->password);
        $user->update(['password' => $password]);
        return redirect()->back()->with('success', 'Password Updated');
    }
}