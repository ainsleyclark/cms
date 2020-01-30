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
        $activeTheme = DB::table('settings')->where('name', 'theme_active')->value('value');
        return dirname(base_path()) . '/themes/' . $activeTheme;
    }
}

/**
 * Get themes root path
 *
 * @return string
 */
if (!function_exists('themes_path')) {

    function themes_path() {
        return dirname(base_path()) . '/themes/';
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