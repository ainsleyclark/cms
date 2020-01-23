<?php

namespace App\Theme;

use App\Resource\Resource;
use Illuminate\Support\Facades\DB;
use App\Theme\Exceptions\ThemeNotFoundException;
use App\Theme\Exceptions\ThemeConfigNotFoundException;

class Theme
{
    /**
     * Themes name.
     *
     * @var
     */
    protected $theme;

    /**
     * Theme absolute path.
     *
     * @var mixed
     */
    protected $themePath;

    /**
     * Theme config from path.
     *
     * @var
     */
    protected $themeConfig;

    /**
     * Views path.
     *
     * @var
     */
    protected $viewPath;

    /**
     * Resources used for setting theme.
     *
     * @var
     */
    protected $resource;

    /**
     * Theme constructor.
     * @throws ThemeNotFoundException
     */
    public function __construct()
    {
        $this->theme = $this->get();

        $this->themePath = $this->getPath();

        $this->themeConfig = $this->getConfig();

        $this->viewPath = $this->getViewPaths();

        $this->resource = new Resource();

        $this->set();
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
     * @return bool
     */
    public function set()
    {
        $theme = $this->setTheme($this->theme);

        if (!$theme) {
            return false;
        }

        return $theme;
    }

    /**
     * Get the current themes full path.
     *
     * @return string
     * @throws ThemeNotFoundException
     */
    public function getPath($theme = false)
    {
        $path = $theme ? dirname(base_path()) . '/themes/' . $theme : dirname(base_path()) . '/themes/' . $this->theme;

        if (!is_dir($path)) {
            throw new ThemeNotFoundException($this->theme);
        }

        return $path;
    }

    /**
     * Get the themes configuration file.
     *
     * @param bool $theme
     * @return mixed
     * @throws ThemeNotFoundException
     */
    public function getConfig($theme = false)
    {
        $path = $theme ? $this->getPath($theme) . '/config.json' : $this->getPath() . '/config.json';
        $config = json_decode(file_get_contents($path));

        if (!file_exists($path)) {
            abort(500, "Theme file not found");
        }

        if (!isset($config)) {
            abort(500, "Error in the file " . $path);
        }

        $this->themeConfig = $config;

        return $config;
    }

    /**
     * Get all of the themes configuration
     *
     * @return array
     * @throws ThemeNotFoundException
     */
    public function getAllConfig()
    {
        $themes = array_diff(scandir(themes_path()), array('.', '..'));
        $themesConfig = [];

        foreach ($themes as $theme) {;
            $themesConfig[$theme] = $this->getConfig($theme)->theme;
            $themesConfig[$theme]->thumbnail = $this->getThumb();
        }

        return $themesConfig;
    }

    /**
     * Get the view path for theme, if set, if not assign default view path.
     *
     * @return array|bool
     * @throws ThemeNotFoundException
     */
    public function getViewPaths()
    {
        $default = $this->themePath . '/views';

        if (!isset($this->themeConfig->options->view_paths)) {
            return $default;
        }

        $directories = $this->themeConfig->options->view_paths;
        $paths = [];

        foreach ($directories as $directory) {
            $path = $this->getPath() . '/' . $directory;

            if (is_dir($path)) {
                array_push($paths, $path);
            }
        }

        if (empty($paths)) {
            return $default;
        }

        return $paths;
    }

    /**
     *
     */
    private function setTheme($theme)
    {
        $config = $this->getConfig($theme);

        //Update options table with active theme
        DB::table('options')->where('option_value',  'active_theme')->update([
            'option_value' => $theme
        ]);

        //Need to insert name, author, description and version somewhere, perhaps a theme table?

        //Insert into resources table
        if (isset($this->themeConfig->resources)) {

            foreach ($this->themeConfig->resources as $resourceName => $resource) {

                $resources = $this->resource->store([
                    'resource_name' => $resourceName,
                    'resource_friendly_name' => $resource->name,
                    //!Come back
                    //'resource_categories' => $data['categories'],
                    'resource_single_template' => $resource->templates->single_template,
                    'resource_index_template' => $resource->templates->index_template,
                    'resource_slug' => $resource->slug
                ]);

                //If resource fucks up throw exception else return true

            }
        }

        //Insert categories






    }

    /**
     * Get the themes thumbnail.
     *
     * @return bool|mixed
     */
    private function getThumb()
    {
        $path = $this->themePath . '/thumbnail.*';
        $files = glob($path);

        if (count($files) > 0) {
            foreach ($files as $file) {
                 return pathinfo($file);
            }
        }

        return false;
    }

}
