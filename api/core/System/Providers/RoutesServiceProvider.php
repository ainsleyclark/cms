<?php

namespace Core\System\Providers;

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
            $path = dirname(__DIR__, 2) . '/routes';
            require $path . '/api.php';
            require $path . '/backend.php';
            require $path . '/frontend.php';
        }
    }
}
