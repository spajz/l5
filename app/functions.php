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

if (!function_exists('urlencode2')) {
    function urlencode2($str)
    {
        return urlencode(urlencode($str));
    }
}

if (!function_exists('urldecode2')) {
    function urldecode2($str)
    {
        return urldecode(urldecode($str));
    }
}

if (!function_exists('hex2rgb')) {
    function hex2rgb($hex)
    {
        $hex = str_replace("#", "", $hex);

        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        $rgb = array($r, $g, $b);
        //return implode(",", $rgb); // returns the rgb values separated by commas
        return $rgb; // returns an array with the rgb values
    }
}

if (!function_exists('number_list')) {
    function number_list($start, $end, $leading_zeros = null, $step = 1)
    {
        $out = array();
        $range = range($start, $end, $step);
        if (is_numeric($leading_zeros)) {
            foreach ($range as $num) {
                $tmp = sprintf("%0{$leading_zeros}d", $num);
                $out[$tmp] = $tmp;
            }
        } else {
            foreach ($range as $num) {
                $out[$num] = $num;
            }
        }
        return $out;
    }
}

if (!function_exists('msg')) {
    function msg($text, $type = 'success')
    {
        Notification::$type($text, view('views.notifications.default')->render());
    }
}

if (!function_exists('msg_modal')) {
    function msg_modal($text, $type = 'success', $title = null)
    {
        Notification::$type($text, view('views.notifications.modal')->render());
    }
}

if (!function_exists('cure')) {
    function cure($asset)
    {
        if (Config::get('app.debug')) $prefix = '';
        else $prefix = 'build/';

        return asset($prefix . $asset);
    }
}

