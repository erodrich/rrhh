<?php

namespace App\Providers;

use App\System\Repositories\ArticleRepositoryImpl;
use App\System\Repositories\DocumentRepositoryImpl;
use App\System\Repositories\OccasionRepositoryImpl;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        if ($this->app->environment() == 'production') {
            URL::forceScheme('https');
        }
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
        $this->app->bind('App\System\Repositories\DocumentRepositoryInterface', function () {
            return new DocumentRepositoryImpl;
        });

    }
}
