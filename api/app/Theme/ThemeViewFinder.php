<?php

namespace App\Theme;

use Illuminate\Filesystem\Filesystem;
use Illuminate\View\FileViewFinder;


class ThemeViewFinder extends FileViewFinder
{


    public function __construct(Filesystem $files, array $paths, array $extensions = null)
    {

        parent::__construct($files, $paths, $extensions);

        $this->paths = ['/home/vagrant/web/GitHubProjects/cms/hello'];
        $this->flush();

        //dd($this);
    }



    //$this->app->bind('view.finder', function ($app) {
//    $paths = $app['config']['view.paths'];
//
//    $test = dirname(base_path()) . '/themes';
//    $themes = scandir($test);
//    unset($themes[0]);
//    unset($themes[1]);
//
//    foreach ($themes as &$theme)
//    {
//        $themeLocation = $test . '/' . $theme . '/views';
//        array_push($paths, $themeLocation);
//    }
//
//    return new FileViewFinder($app['files'], $paths);
//});
}