<?php

namespace Core\System\Providers;

use Illuminate\Support\ServiceProvider;

class ConsoleProvider extends ServiceProvider
{
    /**
     * The array of command paths
     *
     * @var
     */
    protected $commands = [
        'Core\Theme\Console\MakeTheme',
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);
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
