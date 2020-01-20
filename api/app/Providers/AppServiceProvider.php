<?php

namespace App\Providers;

use App\Models\Theme;
use App\Contracts\ThemeContract;
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
        $this->app->singleton( ThemeContract::class, function ($app) {
            return new \App\Models\Theme($app, $this->app['view']->getFinder());
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
