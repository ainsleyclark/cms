<?php

/**
 * Get the root path
 *
 * @return string
 */
if (!function_exists('root_path')) {

    function root_path() {
        return dirname(base_path());
    }
}

/**
 * Get the theme path
 *
 * @return string
 */
if (!function_exists('theme_path')) {

    function theme_path() {
        $activeTheme = DB::table('options')->where('option_name', 'active_theme')->value('option_value');
        return dirname(base_path()) . '/themes/' . $activeTheme;
    }
}

/**
 * Get the admin path
 *
 * @return string
 */
if (!function_exists('admin_path')) {

    function admin_path() {
        return dirname(base_path()) . '/admin';
    }
}