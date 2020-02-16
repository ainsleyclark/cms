<?php

if (!function_exists('root_path')) {
    /**
     * Get the root path
     *
     * @return string
     */
    function root_path() {
        return dirname(base_path());
    }
}

if (!function_exists('theme_path')) {
    /**
     * Get the theme path
     *
     * @return string
     */
    function theme_path() {
        $activeTheme = DB::table('settings')->where('name', 'theme_active')->value('value');
        return root_path() . '/themes/' . $activeTheme;
    }
}

if (!function_exists('themes_path')) {
    /**
     * Get themes root path
     *
     * @return string
     */
    function themes_path() {
        return root_path() . '/themes/';
    }
}

if (!function_exists('admin_path')) {
    /**
     * Get the admin path
     *
     * @return string
     */
    function admin_path() {
        return root_path() . '/admin';
    }
}

if (!function_exists('public_path')) {
    /**
     * Get the admin path
     *
     * @return string
     */
    function admin_path() {
        return root_path() . '/public';
    }
}