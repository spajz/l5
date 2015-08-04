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

if (!function_exists('module_asset')) {
    function module_asset($module, $asset, $secure = null)
    {
        return asset('assets/' . $module . '/' . $asset, $secure);
    }
}

if (!function_exists('admin_asset')) {
    function admin_asset($asset, $secure = null)
    {
        return asset('assets/admin/' . $asset, $secure);
    }
}

if (!function_exists('module_asset_path')) {
    function module_asset_path($module, $asset)
    {
        return public_path('assets/' . $module . '/' . $asset);
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
        $path = $path ? 'Modules/' . ucfirst($path) : 'Modules';
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
        if (!is_array($text)) $text = (array)$text;
        $text = array_map("nl2br", $text);
        Notification::$type($text, view('notifications.default')->render());
    }
}

if (!function_exists('msg_modal')) {
    function msg_modal($text, $type = 'success')
    {
        Notification::$type($text, view('notifications.modal')->render());
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
    function _s($str, $char = '`')
    {
        return $char . $str . $char;
    }
}

if (!function_exists('array_to_attribute')) {
    function array_to_attribute($attributes)
    {
        $out = '';
        foreach ($attributes as $key => $value) {
            $out .= $key . '="' . $value . '" ';
        }
        return $out;
    }
}

if (!function_exists('link_to_image')) {
    function link_to_image($image, $config, $image_attr = [], $href_attr = [], $sizes = ['thumb', 'large'], $dynamic = null, $secure = null)
    {
        $out = '<a href="' . $config['image']['baseUrl'] . $sizes[1] . '/' . image_filename($image, $sizes[1]) . '" ' . array_to_attribute($href_attr) . '>';
        if ($dynamic) {
            $imageUrl = $config['image']['baseUrl'] . (isset($dynamic[2]) ? $dynamic[2] : $sizes[0]) . '/' . image_filename($image, $sizes[0]);
            $imageUrl = route('api.admin.get.image', [urlencode2($imageUrl), urlencode2($dynamic[0]), isset($dynamic[1]) ? $dynamic[1] : 0]);
        } else {
            $imageUrl = $config['image']['baseUrl'] . $sizes[0] . '/' . image_filename($image, $sizes[0]);
        }

        $out .= Html::image(
            $imageUrl,
            $image->alt,
            $image_attr,
            $secure
        );
        $out .= '</a>';

        return $out;
    }
}

if (!function_exists('image_filename')) {
    function image_filename($image, $extension = 'original')
    {
        return $image->image . '.' . $image->extension($extension);
    }
}

if (!function_exists('image_path')) {
    function image_path($model, $config, $size = 'thumb', $key = 0)
    {
        if (!isset($model->images[$key])) return false;
        $imageObj = $model->images[$key]->image;
        $fullPath = array_get($config, 'image.path') . $size . '/' . image_filename($imageObj, $size);
        if (is_file($fullPath)) {
            return $fullPath;
        }
        return false;
    }
}

if (!function_exists('image_url')) {
    function image_url($model, $config, $size = 'thumb', $key = 0)
    {
        if (!isset($model->images[$key])) return false;
        $imageObj = $model->images[$key];
        $fullPath = array_get($config, 'image.path') . $size . '/' . image_filename($imageObj, $size);
        if (is_file($fullPath)) {
            return array_get($config, 'image.baseUrl') . $size . '/' . image_filename($imageObj, $size);
        }
        return false;
    }
}

if (!function_exists('elixir2')) {
    /**
     * Get the path to a versioned Elixir file.
     *
     * @param  string $file
     * @return string
     */
    function elixir2($file, $build_path = null)
    {
        static $manifest = null;

        if (is_null($manifest)) {
            if ($build_path) {
                $manifest = json_decode(file_get_contents(public_path() . $build_path . '/build/rev-manifest.json'), true);
            } else {
                $manifest = json_decode(file_get_contents(public_path() . '/build/rev-manifest.json'), true);
            }
        }

        if (isset($manifest[$file])) {
            if ($build_path) {
                return $build_path . '/build/' . $manifest[$file];
            } else {
                return '/build/' . $manifest[$file];
            }
        }

        throw new InvalidArgumentException("File {$file} not defined in asset manifest.");
    }

    if (!function_exists('theme')) {
        function theme($view)
        {
            $shared = view()->getShared();
            if (!isset($shared['theme'])) return false;

            $viewPath = view()->getFinder()->find($view);

            if (!$viewPath) return false;

            $path = pathinfo($viewPath);
            $themeFile = $path['dirname'] . '/_themes/' . $shared['theme'] . '/' . $path['basename'];

            if (is_file($themeFile)) {
                $template = explode('::', $view);
                $view = $template[0] . '::' . 'themes.' . $shared['theme'] . '.' . $template[1];
            }

            return $view;
        }
    }

    if (!function_exists('view_theme')) {
        /**
         * Get the evaluated view contents for the given view.
         *
         * @param  string $view
         * @param  array $data
         * @param  array $mergeData
         * @return \Illuminate\View\View
         */
        function view_theme($view = null, $data = array(), $mergeData = array())
        {
            $factory = app('Illuminate\Contracts\View\Factory');

            if (func_num_args() === 0) {
                return $factory;
            }

            return $factory->make(theme($view), $data, $mergeData);
        }
    }

    if (!function_exists('get_object')) {
        function get_object($obj, $property)
        {
            if (is_object($obj)) {
                return $obj->$property;
            }
            return false;
        }
    }

    if (!function_exists('is_ajax')) {
        function is_ajax()
        {
            if (Request::ajax()) return true;

            return false;
        }
    }

    if (!function_exists('elixir3')) {
        /**
         * Get the path to a versioned Elixir file.
         *
         * @param  string $file
         * @return string
         */
        function elixir3($file, $manifest_path = null)
        {
            static $manifest = null;

            if (is_null($manifest)) {
                if ($manifest_path) {
                    $manifest = json_decode(file_get_contents(public_path() . $manifest_path . '/rev-manifest.json'), true);
                } else {
                    $manifest = json_decode(file_get_contents(public_path() . '/rev-manifest.json'), true);
                }
            }

            if (isset($manifest[$file])) {
                return asset($manifest[$file]);
            }

            throw new InvalidArgumentException("File {$file} not defined in asset manifest.");
        }
    }

    if (!function_exists('get_related_item')) {
        function get_related_item($item, $relation, $key = 0, $column = 'id')
        {
            if (isset($item->{$relation}[$key])) {
                return $item->{$relation}[$key]->$column;
            }
            return false;
        }
    }

    if (!function_exists('get_related_item_by_value')) {
        function get_related_item_by_value($item, $relation, $key = 0, $column = 'id')
        {
            if (isset($item->{$relation})) {
                return $item->{$relation}[$key]->$column;
            }
            return false;
        }
    }

    if (!function_exists('sort_array')) {
        function sort_array($array, $sort = 'asort')
        {
            eval($sort . '($array);');
            return $array;
        }
    }

    if (!function_exists('color_brightness')) {
        function color_brightness($hex, $steps)
        {
            $str = str_replace('#', '', $hex);

            $rhex = substr($str, 0, 2);
            $ghex = substr($str, 2, 2);
            $bhex = substr($str, 4, 2);

            $r = hexdec($rhex);
            $g = hexdec($ghex);
            $b = hexdec($bhex);

            $r = dechex(max(0, min(255, $r + $steps)));
            $g = dechex(max(0, min(255, $g + $steps)));
            $b = dechex(max(0, min(255, $b + $steps)));

            $r = str_pad($r, 2, "0", STR_PAD_LEFT);
            $g = str_pad($g, 2, "0", STR_PAD_LEFT);
            $b = str_pad($b, 2, "0", STR_PAD_LEFT);

            $cor = '#' . $r . $g . $b;

            return $cor;
        }
    }

    if (!function_exists('array_content_values_sort')) {
        function array_content_values_sort($array)
        {
            if (is_multi($array)) {
                ksort($array);
                foreach ($array as &$value) {
                    asort($value);
                }
                return $array;
            } else {
                $array = array_flip($array);
                ksort($array);
            }
            return $array;
        }
    }

    if (!function_exists('is_multi')) {
        function is_multi($array)
        {
            return (count($array) != count($array, 1));
        }
    }

}




