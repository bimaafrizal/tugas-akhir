<?php

namespace App\Providers;

use App\Repositories\KategoryArticle\KategoryArticleRepository;
use App\Repositories\KategoryArticle\KategoryArticleRepositoryImplement;
use App\Services\KategoryArticle\KategoryArticleService;
use App\Services\KategoryArticle\KategoryArticleServiceImplement;
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
        Paginator::useBootstrap();
    }
}
