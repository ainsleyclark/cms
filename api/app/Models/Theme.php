<?php

namespace App\Models;

use App\Contracts\ThemeContract;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\ViewFinderInterface;

class Theme implements ThemeContract
{


    protected $themePath;
    protected $finder;
    protected $themes;
    protected $app;

    public function __construct($app, ViewFinderInterface $finder)
    {
        $this->app = $app;
        $this->finder = $finder;
    }

    public function test() {
        return 'test';
    }


    /**
     * Get the themes configuration file.
     *
     * @param $theme
     * @return mixed
     * @throws FileNotFoundException
     */
    public function getThemeConfig($theme = false)
    {
        $configPath = $theme ? themes_path() . $theme . '/config.json' : theme_path() . '/config.json';

        if (file_exists($configPath)) {
            return json_decode(file_get_contents($configPath));
        } else {
            throw new FileNotFoundException('The config.json file was not found in the theme\'s directory. Path: ' . $configPath);
        }
    }

}
