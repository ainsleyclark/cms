<?php

namespace Core\Routes\Providers;

use Illuminate\Support\ServiceProvider;

class RoutesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (! $this->app->routesAreCached()) {
            require dirname(__DIR__) . '/api.php';
            require dirname(__DIR__) . '/backend.php';
            require dirname(__DIR__) . '/frontend.php';
        }
    }
}
