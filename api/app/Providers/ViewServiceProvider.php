<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\FileViewFinder;

class ViewServiceProvider extends \Illuminate\View\ViewServiceProvider
{

    /**
     * Register the view finder implementation.
     *
     * @return void
     */
    public function registerViewFinder()
    {
        $this->app->bind('view.finder', function ($app) {
            $paths = $app['config']['view.paths'];

            $test = dirname(base_path()) . '/themes';
            $themes = scandir($test);
            unset($themes[0]);
            unset($themes[1]);

            foreach ($themes as &$theme)
            {
                $themeLocation = $test . '/' . $theme . '/views';
                array_push($paths, $themeLocation);
            }

            return new FileViewFinder($app['files'], $paths);
        });
    }

}
