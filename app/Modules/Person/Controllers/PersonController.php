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
        $model = Model::find(1);
        dd($model->job_title);
    }
}