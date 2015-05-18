<?php namespace App\Modules\Person\Controllers;

use App\Modules\Front\Controllers\FrontController;
use App\Modules\Person\Models\Person as Model;

class PersonController extends FrontController
{
    public function __construct()
    {
        $this->setConfig(__FILE__);
    }

    public function index()
    {
        dd(Model::all());
        echo 'person index';
        exit;
    }
}