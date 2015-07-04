<?php namespace App\Modules\Client\Controllers;

use App\Modules\Front\Controllers\FrontController;
use App\Modules\Client\Models\Client as Model;
use DB;

class ClientController extends FrontController
{
    public function __construct()
    {
        parent::__construct();

        $this->setConfig(__FILE__);
    }

    public function index()
    {
        $clients = Model::where('status', 1)->orderBy(DB::raw('RAND()'))->get();
        return view("{$this->moduleLower}::front.index", compact('clients'));
    }
}