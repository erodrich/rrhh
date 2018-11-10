<?php

namespace App\Providers;

use App\System\Repositories\ArticleRepositoryImpl;
use App\System\Repositories\OccasionRepositoryImpl;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\System\Repositories\ArticleRepositoryInterface', function () {
            return new ArticleRepositoryImpl;
        });
        $this->app->bind('App\System\Repositories\OccasionRepositoryInterface', function () {
            return new OccasionRepositoryImpl;
        });
    }
}
