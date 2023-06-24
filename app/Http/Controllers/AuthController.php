<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    //standar auth
    public function login()
    {
        return view('pages.auth.new-login');
    }
    public function auth(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (Auth::attempt($credentials)) {
            if ($user->status == 0) {
                return back()->with('loginError', 'Hubungi super admin untuk mengaktifkan akun');
            }
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->with('loginError', 'Login failed');
    }
    public function register()
    {
        return view('pages.auth.new-register');
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

        $user = User::create($validateData);
        Auth::login($user);
        $user->sendEmailVerificationNotification();
        return redirect('/email/verify')->with('success', 'Registration sucessfull! Please confrim your email');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->intended('/login');
    }

    //forgot password
    public function forgotPassword()
    {
        $email = null;
        // dd(Auth::user() );
        if (Auth::user()) {
            $email = Auth::user()->email;
        }

        return view('pages.auth.new-forgot-password', compact('email'));
    }
    public function sendResetEmail(Request $request)
    {
        $request->validate(['email' => 'required']);
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->with(['error' => __($status)]);
    }
    public function showResetForm(Request $request, $token)
    {
        $email = $request->input('email');

        if (is_null($token)) {
            return redirect()->route('password.request')->with(['error' => 'Invalid password reset token']);
        }

        return view('pages.auth.new-reset-password')->with(['token' => $token, 'email' => $email]);
    }
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:5|max:255',
        ]);

        $credentials = $request->only(
            'email',
            'password',
            'password_confirmation',
            'token'
        );
        $response = Password::reset($credentials, function ($user, $password) {
            $user->forceFill([
                'password' => bcrypt($password)
            ])->save();
        });

        if ($response == Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', 'Your password has been reset!');
        } else {
            return back()->withErrors(['error' => [trans($response)]]);
        }
    }


    //email verification
    public function verificationEmail()
    {
        return view('pages.auth.new-verify-email');
    }
    public function verifiyEmail(Request $request)
    {
        $request->user()->markEmailAsVerified();
        return redirect(route('verification.otp'));
    }
    public function reSendEmail(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    }

    //otp for phone verification
    public function createOtp()
    {
        //generate otp
        $otp = rand(1000, 9999);

        //save to database
        $user = User::where('id', Auth::user()->id)->first();
        $user->otp = Hash::make($otp);
        $user->otp_expires_at = Carbon::now()->addMinutes(5);
        $user->save();

        return $otp;
    }

    public function sendOtp()
    {
        $user = Auth::user();
        if ($user->phone_num_verified_at != null) {
            return redirect('/dashboard');
        }

        if ($user->otp_expires_at == null) {
            $otp = $this->createOtp();
            $message = "OTP Verification, gunakan OTP " . $otp . " untuk memverifikasi akun aknda. Perhatikan! Jangan memberitahukan OTP ini ke pihak siapa pun.";
            $this->sendWhatsapp($user->phone_num, $message);
        }

        $dataUser = User::where('id', $user->id)->first();
        $expired = $dataUser->otp_expires_at;

        return view('pages.auth.new-verify-otp', compact('expired'));
    }

    public function resendOtp()
    {
        $user = Auth::user();
        $otp = $this->createOtp();

        $message = "OTP Verification, gunakan OTP " . $otp . " untuk memverifikasi akun anda. Perhatikan! Jangan memberitahukan OTP ini ke pihak siapa pun.";
        $this->sendWhatsapp($user->phone_num, $message);

        return redirect()->back()->with('success', 'Berhasil mengirim kode otp');
    }

    public function verifyOtp(Request $request)
    {
        $otp = $request->digit1 . $request->digit2 . $request->digit3 . $request->digit4;
        $user = User::where('id', Auth::user()->id)->first();

        //check otp expired or not
        if (Carbon::now()->gt(Carbon::parse($user->otp_expires_at))) {
            return back()->with('error', 'The OTP code has expired. Please request a new OTP code.');
        }

        //check otp correct or not
        if (Hash::check($otp, $user->otp)) {
            //save phone num verification
            $user->phone_num_verified_at = Carbon::now();
            $user->save();
            return redirect('/dashboard');
        }

        return back()->with('error', 'The OTP code is incorrect.');
    }


    public function sendWhatsapp($user, $message)
    {
        $token = config('services.FONNTE_TOKEN');

        $client = new Client();
        $response = $client->request('POST', 'https://api.fonnte.com/send', [
            'headers' => [
                'Accept' => 'aplication/json',
                'Authorization' => $token
            ],
            'json' => [
                'target' => $user,
                'message' => $message,
                'countryCode' => '62', //optional
            ]
        ]);
        $data = json_decode($response->getBody()->getContents());
        return $data;
    }
}