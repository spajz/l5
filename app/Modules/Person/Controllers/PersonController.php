<?php namespace App\Modules\Person\Controllers;

use App\Library\ImageApi;
use App\Modules\Front\Controllers\FrontController;
use App\Modules\Person\Models\Person as Model;


class PersonController extends FrontController
{
    public function index()
    {
        echo 'person index';
        exit;
    }
}
