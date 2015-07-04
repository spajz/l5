<?php namespace App\Modules\Work\Controllers;

use App\Modules\Front\Controllers\FrontController;
use App\Modules\Work\Models\Work as Model;
use DB;
use App;

class WorkController extends FrontController
{
    public function __construct()
    {
        parent::__construct();

        $this->setConfig(__FILE__);
    }

    public function index($slug = null)
    {
        $lang = App::getLocale();
        if (!is_null($slug)) {
            $work = Model::where('slug', $slug)
                ->where('lang', $lang)
                ->first();

            if ($work) {
                return view("{$this->moduleLower}::front.single", compact('work'));
            }
        } else {
            $works = Model::where('status', 1)
                ->where('lang', $lang)
                ->orderBy(DB::raw('RAND()'))
                ->get();
            return view("{$this->moduleLower}::front.index", compact('works'));
        }

    }
}