<?php

namespace App\Theme;

use App\Theme\ThemeContract;
use Illuminate\Support\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('view.finder', function ($app) {
            return new \App\Theme\ThemeViewFinder($app['files'], $app['config']['view.paths'], null);
        });
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
