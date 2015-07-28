<?php namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\BaseController;
use Cache;
use Image;

class RapidController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function getImage($url, $config, $key = 0)
    {
        $image = Image::make(urldecode2($url));
        $config = urldecode2($config);
        $config = $config . '.image.dynamic.' . $key;
        $actions = config($config . '.actions', []);
        $quality = config($config . '.quality', 75);
        $responseAs = config($config . '.responseAs', 'jpg');
        // Apply actions
        foreach ($actions as $action => $param) {
            call_user_func_array(array($image, $action), $param);
        }

        // Cache image output
        if (Cache::has(md5($url))) {
            return Cache::get(md5($url));
        }

        $output = $image->response($responseAs, $quality);
        Cache::put(md5($url), $output, 120);
        return $output;
    }

}