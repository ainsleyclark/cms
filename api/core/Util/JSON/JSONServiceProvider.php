<?php

namespace Core\Util\JSON;

use Illuminate\Support\ServiceProvider;

class JSONServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('json', function() {
            return new JSON();
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
