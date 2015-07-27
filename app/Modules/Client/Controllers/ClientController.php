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
        view()->share('bodyClass', 'page-' . $this->moduleLower);
    }

    public function index()
    {
        $hoverEffects = [
            'from_top_and_bottom',
            'from_left_and_right',
            'top_to_bottom',
            'bottom_to_top',
        ];
        $clients = Model::where('status', 1)->orderBy('order')->get();
        return view("{$this->moduleLower}::front.index", compact('clients', 'hoverEffects'));
    }
}