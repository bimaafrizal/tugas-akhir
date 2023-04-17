<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DisasterController;
use App\Http\Controllers\EarthquakeController;
use App\Http\Controllers\EwsController;
use App\Http\Controllers\FloodController;
use App\Http\Controllers\KategoryArticleController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ManajemenUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingLandingPage;
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
    });

    Route::controller(FloodController::class)->group(function () {
        Route::get('/get-data', 'getDetailData')->name('ews.get-data');
        Route::get('/download-data/{id}', 'downloadData')->name('ews.download-data');
    });

    Route::controller(EarthquakeController::class)->prefix('gempa')->group(function () {
        Route::get('/', 'index')->name('earthquake.index');
        Route::get('/download-data', 'downloadData')->name('earthquake.download');
    });

    Route::controller(ProfileController::class)->prefix('profile')->group(function () {
        Route::get('/', 'index')->name('profile.index');
        Route::post('/edit-data', 'editData')->name('profile.edit-data');
        Route::post('/change-password', 'changePassword')->name('profile.change-password');
    });

    Route::resource('manajemen-user', ManajemenUserController::class)->only('index', 'create', 'store');
    Route::controller(ManajemenUserController::class)->prefix('manajemen-user')->group(function () {
        Route::post('edit-status/{id}', 'editStatus')->name('manajemen-user.edit-status');
        Route::get('/{id}/edit', 'edit')->name('manajemen-user.edit');
        Route::post('/{id}', 'update')->name('manajemen-user.update');
        Route::get('/download-data/{id}', 'downloadData')->name('manajemen-user.download');
    });

    Route::controller(DisasterController::class)->prefix('bencana')->group(function () {
        Route::get('/', 'index')->name('disaster.index');
        Route::get('/{id}/edit', 'edit')->name('disaster.edit');
        Route::post('/{id}', 'update')->name('disaster.update');
    });

    Route::controller(SettingLandingPage::class)->prefix('/landing-pages')->group(function () {
        Route::get('/', 'index')->name('landing-page.index');
        Route::post('/home-edit', 'homeEdit')->name('landing-page.home-edit');
        Route::post('/about-edit', 'aboutEdit')->name('landing-page.about-edit');
        Route::post('/footer-edit', 'footerEdit')->name('landing-page.footer-edit');

        //fitur
        Route::get('create-fitur', 'createFitur')->name('landing-page.create-fitur');
        Route::post('store-fitur', 'storeFitur')->name('landing-page.store-fitur');
        Route::get('{id}/edit-fitur', 'editFitur')->name('landing-page.edit-fitur');
        Route::post('update-fitur/{id}', 'updateFitur')->name('landing-page.update-fitur');
        Route::post('delete-fitur/{id}', 'deleteFitur')->name('landing-page.delete-fitur');

        //collaborations
        Route::get('create-instansi', 'createInstansi')->name('landing-page.create-instansi');
        Route::post('store-instansi', 'storeInstansi')->name('landing-page.store-instansi');
        Route::get('{id}/edit-instansi', 'editInstansi')->name('landing-page.edit-instansi');
        Route::post('update-instansi/{id}', 'updateInstansi')->name('landing-page.update-instansi');
        Route::post('delete-instansi/{id}', 'deleteInstansi')->name('landing-page.delete-instansi');
    });
});

Route::get('test-ews', [FloodController::class, 'store']);
