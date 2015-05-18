<?php namespace App\Modules\Front\Controllers;

use App\Http\Controllers\BaseController;

class FrontController extends BaseController
{
    protected $layout;
    protected $assetsDirFront;
    protected $assetsDirModule;
    protected $moduleLower;
    protected $moduleUpper;
    protected $moduleTitle;
    protected $config;
    protected $language;
    protected $theme;

    public function __construct()
    {
        $this->setConfig(__FILE__);
        $this->language = config('front.language');
    }

    protected function setConfig($module, $path = true)
    {
        if ($path) {
            if (get_dirname($module, 1) == 'Front') {
                $module = strtolower(get_dirname($module, 3));
            } else {
                $module = strtolower(get_dirname($module, 2));
            }
        }

        $this->config = config($module);
        view()->share('config', $this->config);
        $moduleConfig = config($module . '.module');
        if ($moduleConfig) {
            foreach ($moduleConfig as $key => $value) {
                $this->$key = $value;
                view()->share($key, $value);
            }
        }

        $this->layout = theme('front::layouts.master');
        view()->share('layout', $this->layout);
    }

    public function index()
    {
        return view_theme("{$this->moduleLower}::home");
    }


}