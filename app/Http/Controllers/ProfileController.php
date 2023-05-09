<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public $auth;
    public function __construct(AuthController $controler)
    {
        $this->auth = $controler;
    }

    public function index()
    {
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();

        return view('pages.dashboard2.profile.index', compact('user'));
    }

    public function editData(Request $request)
    {
        $user = $request->user();
        $validateData = $request->validate([
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|email:dns|unique:users,email,' . $user->id,
            'phone_num' => 'required|min:9|max:13|unique:users,phone_num,' . $user->id,
        ]);

        if ($user->email != $request->email) {
            $validateData['email_verified_at'] = null;
        }
        if ($user->phone_num != $request->phone_num) {
            $validateData['phone_num_verified_at'] = null;
        }
        $user->update($validateData);

        if ($user->email != $request->email) {
            //send email verification
            $user->sendEmailVerificationNotification();
            //redirect new page
            return redirect('/email/verify')->with('success', 'Confirm your email');
        }

        if ($user->phone_num != $request->phone_num) {
            $this->auth->sendOtp();
        }

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