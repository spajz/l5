<?php namespace App\Modules\Front\Controllers;

use App;
use App\Modules\Work\Models\Work;
use DB;

class HomeController extends FrontController
{
    public function __construct()
    {
        $this->setConfig(__FILE__);
    }

    public function index()
    {
        $pages['whoWeAre'] = $this->getPageByConfigKey('whoWeAre');
        $pages['ourClients'] = $this->getPageByConfigKey('ourClients');
        $works = Work::where('status', 1)
            ->orderBy(DB::raw('RAND()'))
            ->limit(2)
            ->get();
        return view_theme("{$this->moduleLower}::home", compact('pages', 'works'));
//        return view("{$this->moduleLower}::under_construction");
    }

    public function contact()
    {
        $pages['whereWeAre'] = $this->getPageByConfigKey('whereWeAre');

        return view("{$this->moduleLower}::contact", compact('pages'));
    }

}