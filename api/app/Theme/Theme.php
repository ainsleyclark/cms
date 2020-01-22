<?php

namespace App\Theme;

use Illuminate\Support\Facades\DB;
use App\Theme\Exceptions\ThemeNotFoundException;
use App\Theme\Exceptions\ThemeConfigNotFoundException;

class Theme
{

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

        $this->themePath = $this->getPath();

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
     *
     */
    public function getAll()
    {
        $themes = array_diff(scandir(themes_path()), array('.', '..'));
        $themesConfig = [];

        foreach ($themes as $theme) {
            array_push($themesConfig, $this->getConfig($theme));
        }

        return $themesConfig;
    }

    /**
     * Get the current themes full path.
     *
     * @param $theme
     * @return string
     * @throws ThemeNotFoundException
     */
    public function getPath()
    {
        $path = dirname(base_path()) . '/themes/' . $this->theme;

        if (!is_dir($path)) {
            throw new ThemeNotFoundException($this->theme);
        }

        return $path;
    }

    /**
     * Get the themes configuration file.
     *
     * @return mixed
     * @throws ThemeConfigNotFoundException
     * @throws ThemeNotFoundException
     */
    public function getConfig($theme = false)
    {
        $path = $theme ? $this->getPath($this->theme) . '/config.json' : $this->getPath($theme) . '/config.json';

        if (!file_exists($path)) {
            throw new ThemeConfigNotFoundException($path);
        }

        return json_decode(file_get_contents($path));
    }

    /**
     *
     */
    public function loadTheme($theme)
    {
        //Update options table with active theme
        DB::table('options')->where('option_value',  'active_theme')->update([
            'option_value' => $theme
        ]);
    }

}
