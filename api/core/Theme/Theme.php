<?php

namespace Core\Theme;

use JSON;
use Core\Resource\Resource;
use Core\Settings\Settings;
use Illuminate\Support\Facades\DB;
use Core\Theme\Exceptions\ThemeConfigException;
use Core\Theme\Exceptions\ThemeNotFoundException;;

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
     * Settings model.
     *
     * @var
     */
    protected $settings;

    /**
     * Resources model used for setting theme.
     *
     * @var
     */
    protected $resource;

    /**
     * Theme constructor.
     *
     * @throws ThemeConfigException
     * @throws ThemeNotFoundException
     */
    public function __construct()
    {
        $this->settings = new Settings();

        $this->resource = new Resource();

        $this->theme = $this->get();

        $this->themePath = $this->getPath();

        $this->themeConfig = $this->getConfig();

        $this->check();

        $this->viewPath = $this->getViewPaths();

//        if (!$this->check()) {
//            $this->set();
//        }
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
        $theme = $this->settings->getValueByName('theme_active');

        if (!$theme) {
            throw new ThemeNotFoundException($this->theme);
        }

        return $theme;
    }

    /**
     * Set the current theme.
     *
     * @return bool|void
     * @throws ThemeConfigException
     * @throws ThemeNotFoundException
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
     * Checks if the current theme configuration file is
     * the same as the one stored in the database.
     *
     * @return bool
     */
    private function check()
    {
        $existingThemeConfig = unserialize($this->settings->getValueByName('theme_config'));

        if ($existingThemeConfig != $this->themeConfig || !isset($existingThemeConfig)) {
            return false;
        }

        return true;
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
        $config = JSON::validate($path, $theme);

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
     * Sets the theme, updates theme configuration file as well as
     * inserting and updating the categories and resources
     * table.
     *
     * @param $theme
     * @return mixed
     * @throws ThemeConfigException
     * @throws ThemeNotFoundException
     */
    private function setTheme($theme)
    {
        $config = $this->getConfig($theme);

        //Update settings table with new theme and configuration.
        $this->settings->store('theme_active', $theme);
        $this->settings->store('theme_config', serialize($config));

        //Insert into resources table
        if (isset($config->resources)) {
            foreach ($this->themeConfig->resources as $resourceName => $resource) {

                try {
                    $data = [
                        'name' => $resourceName,
                        'friendly_name' => $resource->name,
                        'singular_name' => $resource->singular_name,
                        'slug' => $resource->slug,
                        //'resource_categories' => $data['categories'],
                        'theme' => $this->theme,
                        'icon' => $resource->options->icon,
                        'menu_position' => $resource->options->menu_position,
                        'single_template' => $resource->templates->single_template,
                        'index_template' => $resource->templates->index_template,
                    ];

                    if ($this->resource->getByName($resourceName, $this->theme)) {
                        $this->resource->store($data, $resourceName);
                    } else {
                        $this->resource->store($data);
                    }

                } catch (ThemeConfigException $e) {
                    throw new ThemeConfigException($e->getMessage(), $theme);
                }

            }
        }

        //Insert into categories table
        if (isset($this->themeConfig->categories)) {
            foreach ($this->themeConfig->categories as $categoryName => $category) {

                try {
                    dump('to do ');

                    // INSERT INTO CATEGORIES TABLE not content, user will do that
                    // make a category model etc
                } catch (ThemeConfigException $e) {
                    throw $e;
                }

            }
        }

        return $theme;
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