<?php

namespace Core\System\Providers;

use Illuminate\Support\Facades\Config;
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
        /**
         * Register helper files.
         */
        $corePath = dirname(__DIR__, 2);
        $helperFiles = [
            $corePath . '/System/helpers.php'
        ];
        foreach ($helperFiles as $filename){
            require_once($filename);
        }

        /**
         * Register custom configuration files.
         */
        $configPath = root_path() . '/config/';
        $configFiles = [
            'media' => $configPath . 'media.php'
        ];
        foreach ($configFiles as $name => $configFile) {
            $this->mergeConfigFrom(
                $configFile, $name
            );
        }

        /**
         * Change public path
         */
        $this->app->bind('path.public', function() {
            return root_path() . '/public';
        });
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
