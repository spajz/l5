<?php namespace App\Modules\Front\Controllers;

use App;

class HomeController extends FrontController
{
    public function __construct()
    {
        $this->setConfig(__FILE__);
    }

    public function index()
    {
        echo csrf_token();
        return view_theme("{$this->moduleLower}::home");
    }

}