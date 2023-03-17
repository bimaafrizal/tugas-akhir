<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EarthquakeController;
use App\Http\Controllers\EwsController;
use App\Http\Controllers\FloodController;
use App\Http\Controllers\KategoryArticleController;
use App\Http\Controllers\LandingPageController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

Route::middleware(['auth', 'verified', 'otp'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index']);
    Route::get('send-location', [DashboardController::class, 'sendLocation'])->name('send-location');

    Route::controller(KategoryArticleController::class)->group(function () {
        Route::get('/kategory-article', 'index')->name('kategory-article');
        Route::get('/kategory-article/{id}/edit', 'edit')->name('kategory-edit');
    });

    Route::controller(ArticleController::class)->group(function () {
        Route::post('image-upload', 'imageUpload')->name('images-upload');
        Route::get('/check-slug', 'checkSlug')->name('check-slug');
        Route::prefix('article')->group(function () {
            Route::get('/{slug}/edit', 'edit')->name('article.edit');
            Route::post('/{slug}', 'update')->name('article.update');
            Route::post('/edit-status/{slug}', 'editStatus')->name('article.edit-status');
        });
    });
    Route::resource('/article', ArticleController::class)->only('index', 'create', 'store');

    Route::resource('/ews', EwsController::class)->only('index', 'create', 'store', 'show');
    Route::controller(EwsController::class)->prefix('ews')->group(function () {
        Route::post('edit-status/{id}', 'editStatus')->name('ews.edit-status');
        Route::get('/{id}/edit', 'edit')->name('ews.edit');
        Route::post('/{id}', 'update')->name('ews.update');
        Route::post('/get-data', 'getDetailData')->name('ews.get-data');
    });

    Route::controller(EarthquakeController::class)->prefix('gempa')->group(function () {
        Route::get('/', 'index')->name('earthquake.index');
    });
});

Route::get('test-ews', [FloodController::class, 'store']);
Route::get('test-gempa', [EarthquakeController::class, 'store']);
