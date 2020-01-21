<?php

namespace App\Theme;

use App\Theme\ThemeContract;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\FileViewFinder;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
//        $this->app->singleton( ThemeContract::class, function ($app) {
//            return new Theme();
//        });

        $this->app->bind('view.finder', function ($app) {
            return new \App\Theme\ThemeViewFinder($app['files'], $app['config']['view.paths'], null);
        });

//        $this->app->singleton('view.finder', function ($app) {
//            return new ThemeViewFinder($app['files'], $app['config']['view.paths'], null);
//        });
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
