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
        return view("{$this->moduleLower}::home");
    }

    public function contact()
    {
        return view("{$this->moduleLower}::contact");
    }

}