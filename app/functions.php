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

if (!function_exists('modules_path')) {

    function modules_path($path = '')
    {
        $path = $path ? 'Modules/' . $path : 'Modules';
        return app_path($path);
    }
}

if (!function_exists('modules')) {

    function modules($status = 'enabled')
    {
        $module = app('module');
        $modules = $module->getModules($status, 'array');
        return $modules;
    }
}

if (!function_exists('module')) {

    function module($status = 'enabled')
    {
        $module = app('module');
        $modules = $module->getModules($status, 'array');
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
        Notification::$type($text, view('notifications.default')->render());
    }
}

if (!function_exists('msg_modal')) {
    function msg_modal($text, $type = 'success')
    {
        Notification::$type($text, view('notifications.modal')->render());
    }
}

if (!function_exists('cure')) {
    function cure($asset)
    {
        if (config('app.debug')) $prefix = '';
        else $prefix = 'build/';

        return asset($prefix . $asset);
    }
}

if (!function_exists('get_property_class')) {
    function get_property_class($obj, $property, $key = 0)
    {
        if (isset($obj->$property[$key])) return get_class($obj->$property[$key]);

        return false;
    }
}

if (!function_exists('get_dirname')) {
    function get_dirname($path, $level = 1, $basename = true)
    {
        for ($x = 1; $x <= $level; $x++) {
            $path = dirname($path);
        }
        return $basename ? basename($path) : $path;
    }
}

if (!function_exists('ee')) {
    function ee()
    {
        array_map(function ($x) {
            (new Illuminate\Support\Debug\Dumper)->dump($x);
        }, func_get_args());

    }
}

if (!function_exists('pp')) {
    function pp($obj)
    {
        print_r($obj);
        exit;
    }
}

if (!function_exists('ucfirst_replace')) {
    function ucfirst_replace($str, $search = '_', $replace = ' ')
    {
        return ucfirst(str_replace($search, $replace, $str));
    }
}

if (!function_exists('_s')) {
    function _s($str, $char ='`')
    {
       return $char . $str . $char;
    }
}



