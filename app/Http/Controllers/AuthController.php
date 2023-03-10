<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
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
        return view('pages.auth.forgot-password');
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

        return view('pages.auth.reset-password')->with(['token' => $token, 'email' => $email]);
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
        return view('pages.auth.verify-email');
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
        $otp = $this->createOtp();
        $user = Auth::user();
        $this->sendEmailOtp($user->email, 'OTP Verification', $otp);

        return view('pages.auth.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();

        //check otp expired or not
        if (Carbon::now()->gt(Carbon::parse($user->otp_expires_at))) {
            return back()->with('error', 'The OTP code has expired. Please request a new OTP code.');
        }

        //check otp correct or not
        if (Hash::check($request->otp, $user->otp)) {
            //save phone num verification
            $user->phone_num_verified_at = Carbon::now();
            $user->save();
            return redirect('/dashboard');
        }

        return back()->with('error', 'The OTP code is incorrect.');
    }

    public function sendEmailOtp($receiver, $subject, $otp)
    {
        if ($this->isOnline()) {
            $email = [
                'recepient' => $receiver,
                'fromEmail' => 'admin@awasbencana.com',
                'fromName' => 'Awas Bencana',
                'subject' => $subject,
                'otp' => $otp
            ];

            Mail::send('pages.auth.otp_verification', $email, function ($message) use ($email) {
                $message->from($email['fromEmail'], $email['fromName']);
                $message->to($email['recepient']);
                $message->subject($email['subject']);
            });
        }
    }

    public function isOnline($site = "https://www.youtube.com/")
    {
        if (@fopen($site, "r")) {
            return true;
        } else {
            return false;
        }
    }
}
