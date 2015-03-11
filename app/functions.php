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
        $path = 'resources/' . $path;
        return app('path') . ($path ? '/' . $path : $path);
    }
}


