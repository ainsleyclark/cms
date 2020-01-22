<?php

namespace App\Theme;

use Illuminate\Support\Facades\DB;
use App\Theme\Exceptions\ThemeNotFoundException;
use App\Theme\Exceptions\ThemeConfigNotFoundException;

class Theme
{

    /**
     * Ask Kirk
     * - When to use $this->theme as opposed to passing it via a parameter
     * - How to stop bubbling of error throws
     */


    /**
     * @var
     */
    protected $theme;

    /**
     * @var mixed
     */
    protected $themePath;

    /**
     * @var
     */
    protected $themeConfig;

    /**
     * @var
     */
    protected $viewPath;

    /**
     * Theme constructor.
     * @throws ThemeNotFoundException
     */
    public function __construct()
    {
        $this->theme = $this->get();

        //$this->themePath = $this->getPath();

    }

    /**
     * Get current theme from options table.
     *
     * @return mixed
     * @throws ThemeNotFoundException
     */
    public function get()
    {
        $theme = DB::table('options')
            ->where('option_name',  'active_theme')
            ->value('option_value');

        if (!$theme) {
            throw new ThemeNotFoundException($this->theme);
        }

        return $theme;
    }

    /**
     * Set the current theme.
     *
     * @param $theme
     */
    public function set($theme)
    {


    }

    /**
     * Get the current themes full path.
     *
     * @param $theme
     * @return string
     * @throws ThemeNotFoundException
     */
    public function getPath($theme)
    {
        $path = dirname(base_path()) . '/themes/' . $theme;

        if (!is_dir($path)) {
            throw new ThemeNotFoundException($theme);
        }

        return $path;
    }

    /**
     * Get the themes configuration file.
     *
     * @param bool $theme
     * @return mixed
     * @throws ThemeConfigNotFoundException
     * @throws ThemeNotFoundException
     */
    public function getConfig($theme = false)
    {
        $path = $theme ? $this->getPath($theme) . '/config.json' : $this->getPath($this->theme) . '/config.json';
        $config = json_decode(file_get_contents($path));

        if (!file_exists($path)) {
            throw new ThemeConfigNotFoundException($path);
        }

        return $config;
    }

    /**
     * Get all of the themes configuration
     *
     * @return array
     * @throws ThemeConfigNotFoundException
     * @throws ThemeNotFoundException
     */
    public function getAllConfig()
    {
        $themes = array_diff(scandir(themes_path()), array('.', '..'));
        $themesConfig = [];

        foreach ($themes as $theme) {;
            $themesConfig[$theme] = $this->getConfig($theme)->theme;
            $themesConfig[$theme]->thumbnail = $this->getThumb($theme);
        }

        return $themesConfig;
    }

    /**
     *
     */
    private function loadTheme($theme)
    {
        $config = $this->getConfig($theme);

        //Update options table with active theme
        DB::table('options')->where('option_value',  'active_theme')->update([
            'option_value' => $theme
        ]);


    }

    /**
     * Get the themes thumbnail.
     *
     * @param $theme
     * @return mixed
     * @throws ThemeNotFoundException
     */
    public function getThumb($theme)
    {
        $path = $this->getPath($theme) . '/thumbnail.*';
        $files = glob($path);

        if (count($files) > 0) {
            foreach ($files as $file) {
                 return pathinfo($file);
            }
        }

        return false;
    }

}
