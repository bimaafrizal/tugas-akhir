<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', 'login')->name('login');
        Route::post('login', 'auth');
        Route::get('register', 'register')->name('register');
        Route::post('register', 'sendRegister');
    });
    //forgot password
    Route::get('forgot-password', 'forgotPassword')->name('password.request');
    Route::post('forgot-password', 'sendResetEmail')->name('password.email');
    Route::get('reset-password/{token}', 'showResetForm')->name('password.reset');
    Route::post('reset-password', 'reset')->name('password.update');
    Route::post('/logout', 'logout');

    //phone & email verify
    Route::get('email/verify', 'verificationEmail')->middleware(['auth'])->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', 'verifiyEmail')->middleware(['auth', 'signed'])->name('verification.verify');
    Route::post('email/verification-notification', 'reSendEmail')->middleware(['auth', 'throttle:6,1'])->name('verification.send');
    Route::get('otp/verify', 'sendOtp')->middleware(['auth'])->name('verification.otp');
    Route::post('otp/verify', 'verifyOtp')->middleware(['auth', 'throttle:6,1'])->name('otp.verify');
    Route::get('resend-otp', 'resendOtp')->middleware(['auth'])->name('otp.resend');
});