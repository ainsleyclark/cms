<?php

namespace Core\System\Providers;

use Illuminate\Support\ServiceProvider;

class CoreCMSServiceProvider extends ServiceProvider
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
        /**
         * Register Custom Migration Paths
         */
        $this->loadMigrationsFrom([
            dirname(__DIR__, 2) . '/Database/migrations'
        ]);

        /**
         * Register Custom Factories Paths
         */
        $this->loadFactoriesFrom([
            dirname(__DIR__, 2) . '/Database/factories'
        ]);

        $this->publishes([
            dirname(__DIR__, 2) . '/Config/media.php' => config_path('media.php'),
        ]);

    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        return $this->laravel->databasePath().'/seeds/'.$name.'.php';
    }
}
