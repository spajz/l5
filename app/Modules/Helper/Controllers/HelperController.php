<?php namespace App\Modules\Helper\Controllers;

use App\Modules\Front\Controllers\FrontController;
use App\Modules\Helper\Models\Helper as Model;
use Input;

class HelperController extends FrontController
{
    protected $contentPath;
    protected $files = array('form.blade.php', 'functions.php', 'result.blade.php');

    public function __construct()
    {
        parent::__construct();

        $this->setConfig(__FILE__);
        view()->share('bodyClass', 'page-' . $this->moduleLower);

        $this->contentPath = app_path('Modules/' . $this->moduleUpper . '/views/content');
        view()->share('contentPath', $this->contentPath);
    }

    public function index()
    {
        $helpers = Model::where('status', 1)->get();
        return view("{$this->moduleLower}::front.index", compact('helpers'));
    }

    public function show($slug)
    {
        $item = Model::where('slug', $slug)->first();

        if (!$item) redirect()->route('home');

        $contentPath = $this->contentPath . '/' . $item->id;

        include_once($contentPath . '/functions.php');

        $route = route("{$this->moduleLower}.process", $item->id);

        $before = null;
        $result = null;
        if (function_exists('_before')) {
            $before = _before();
        }

//        if (!is_null(session()->get('_result'))) {
//            $result = session()->get('_result');
//        }
//
//        $result = session()->get('_result');

        $form = view()->make("{$this->moduleLower}::content.{$item->id}.form", compact('route'));

        return view()->make("{$this->moduleLower}::front.single", compact(
            'item',
            'before',
            'form'
        ));
    }

    public function process($id)
    {

        $item = Model::where('id', $id)->first();
        if (!$item) {
            return redirect()->route('home');
        }

        $contentPath = $this->contentPath . '/' . $item->id;

        include_once($contentPath . '/functions.php');

        $result = null;
        if (function_exists('_result')) {
            $result = _result("{$this->moduleLower}::content.{$id}.result");
        }

        return redirect()->route("{$this->moduleLower}.show", $item->slug)->withInput()->with('_result', $result);

    }

}