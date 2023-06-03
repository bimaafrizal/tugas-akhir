<?php

namespace App\Providers;

use App\Models\LandingPage;
use App\Repositories\KategoryArticle\KategoryArticleRepository;
use App\Repositories\KategoryArticle\KategoryArticleRepositoryImplement;
use App\Services\KategoryArticle\KategoryArticleService;
use App\Services\KategoryArticle\KategoryArticleServiceImplement;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(KategoryArticleRepository::class, KategoryArticleRepositoryImplement::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            $logo = LandingPage::where('id', 1)->first();
            $logo = $logo->logo;
            $view->with('logo', $logo);
        });
        Paginator::useBootstrap();
    }
}