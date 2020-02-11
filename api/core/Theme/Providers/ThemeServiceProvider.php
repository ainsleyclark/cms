<?php

namespace Core\Theme\Providers;

use Core\Theme\Theme;
use Core\Theme\ThemeViewFinder;
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
        $this->app->singleton('theme', function($app) {
            return $app->make(Theme::class);
        });

        $this->app->bind('view.finder', function ($app) {
            return new ThemeViewFinder($app['files'], $app['config']['view.paths'], null);
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
