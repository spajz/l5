<?php

if (!function_exists('json_decoder')) {

    function json_decoder($string, $key = null)
    {
        if (is_file($string)) {
            $json = file_get_contents($string);
        } else {
            $json = $string;
        }
        $json = json_decode($json, true);
        if (!is_null($key)) {
            return array_get($json, $key);
        }
        return $json;
    }
}

if (!function_exists('resources_path')) {

    function resources_path($path = '')
    {
        $path = $path ? 'resources/' . $path : 'resources';
        return base_path($path);
    }
}

if (!function_exists('modules')) {

    function modules()
    {
        $modules = array();
        if (defined('MODULES')) {
            $modules = json_decode(MODULES, true);
        }
        return $modules;
    }
}

if (!function_exists('is_admin')) {

    function is_admin()
    {
        if (Request::is(ADMIN) || Request::is(ADMIN . '/*'))
            return true;

        return false;
    }
}







