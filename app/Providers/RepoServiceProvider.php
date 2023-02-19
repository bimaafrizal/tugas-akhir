<?php

namespace App\Providers;

use App\Models\KategoryArticle;
use App\Repositories\KategoryArticle\KategoryArticleRepository;
use App\Repositories\KategoryArticle\KategoryArticleRepositoryImplement;
use Illuminate\Support\ServiceProvider;

class RepoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}