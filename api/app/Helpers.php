<?php

namespace App;

class Helpers
{

    /**
     * Get the root path
     *
     * @return string
     */
    public static function rootPath()
    {

        return dirname(base_path());

    }

    /**
     * Get theme path
     *
     * @return string
     */
    public static function themePath()
    {

        return dirname(base_path()) . '/themes';

    }

    /**
     * Get admin path
     *
     * @return string
     */
    public static function adminPath()
    {

        return dirname(base_path()) . '/admin';

    }
}
