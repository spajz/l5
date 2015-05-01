<?php namespace App\Modules\Front\Controllers;

use App\Http\Requests;
use App\Http\Controllers\BaseController;


class FrontController extends BaseController
{
    public function index()
    {
        echo 'front controller';
        exit;
    }

}