<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('pages.auth.login');
    }

    public function auth(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->with('loginError', 'Login failed');
    }

    public function register()
    {
        return view('pages.auth.register');
    }

    public function sendRegister(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|email:dns|unique:users,email',
            'phone_num' => 'required|min:9|max:13|unique:users,phone_num',
            'password' => 'required|confirmed|min:5|max:255',
        ]);
        $validateData['role_id'] = 1;
        $validateData['status'] = 1;
        $validateData['password'] = Hash::make($validateData['password']);

        // event(new Registered($validateData));
        $user = User::create($validateData);
        Auth::login($user);

        $user->sendEmailVerificationNotification();

        return redirect('/email/verify')->with('success', 'Registration sucessfull! Please confrim your email');
    }

    public function forgotPassword()
    {
        return view('pages.auth.forgot-password');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->intended('/login');
    }

    public function verify()
    {
        return view('pages.auth.verify-email');
    }

    public function verified(Request $request)
    {
        $request->user()->markEmailAsVerified();
        return redirect('/dashboard');
    }

    public function reSendEmail(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    }
}
