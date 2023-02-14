<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingPageController;
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
    Route::get('/login', 'login');
    Route::post('/login', 'auth');
    Route::post('/logout', 'logout');
    Route::get('/register', 'register');
    Route::post('/register', 'sendRegister');
    Route::get('/forgot-password', 'forgotPassword');
});

Route::get('dashboard', function () {
    return view('pages.dashboard.index');
});