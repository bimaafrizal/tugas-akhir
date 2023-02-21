<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoryArticleController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Livewire\KategoryArticle as LivewireKategoryArticle;
use App\Http\Livewire\KategoryArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::controller(LandingPageController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('blog', 'blog');
    Route::get('blog-single', 'blogSingle');
});

Route::controller(AuthController::class)->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', 'login')->name('login');
        Route::post('/login', 'auth');
        Route::get('/register', 'register')->name('register');
        Route::post('/register', 'sendRegister');
        Route::get('/forgot-password', 'forgotPassword');
    });
    Route::post('/logout', 'logout');
    Route::get('email/verify', 'verificationEmail')->middleware(['auth'])->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', 'verifiyEmail')->middleware(['auth', 'signed'])->name('verification.verify');
    Route::post('email/verification-notification', 'reSendEmail')->middleware(['auth', 'throttle:6,1'])->name('verification.send');
    Route::get('otp/verify', 'sendOtp')->middleware(['auth'])->name('verification.otp');
    Route::post('otp/verify', 'verifyOtp')->middleware(['auth', 'throttle:6,1'])->name('otp.verify');
});

Route::post('email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Route::middleware(['auth', 'verified', 'otp'])->group(function () {
    Route::get('dashboard', function () {
        return view('pages.dashboard.index');
    });

    Route::controller(KategoryArticleController::class)->group(function () {
        Route::get('/kategory-article', 'index')->name('kategory-article');
        Route::get('/kategory-article/{id}/edit', 'edit')->name('kategory-edit');
    });
});