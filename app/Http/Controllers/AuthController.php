<?php

namespace App\Http\Controllers;

use App\Models\User;
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

        User::create($validateData);
        return redirect('/login')->with('success', 'Registration sucessfull! Please login');
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
}
