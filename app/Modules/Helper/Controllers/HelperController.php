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

        $this->includeFiles($item->id);

        $before = null;
        if (function_exists('_before')) {
            $before = _before($item->id);
        }

        if (!is_null(session()->get('_result'))) {
            $main = session()->get('_result');
        } else {
            $main = $this->getMain($item->id);
        }

        return view()->make("{$this->moduleLower}::front.single", compact(
            'item',
            'before',
            'main'
        ));
    }

    public function process($id)
    {
        $item = Model::where('id', $id)->first();
        if (!$item) return redirect()->route('home');

        $this->includeFiles($item->id);

        $result = null;
        if (function_exists('_result')) {
            $result = _result($id);
        }

        $main = $this->getMain($id, $result);

        return redirect()->route("{$this->moduleLower}.show", $item->slug)->withInput()->with('_result', $main);
    }

    public function getMain($id, $result = null)
    {
        $route = route("{$this->moduleLower}.process", $id);
        return view()->make("{$this->moduleLower}::content.{$id}.main", compact('route', 'result'))->render();
    }

    protected function getRoute($id)
    {
        return route("{$this->moduleLower}.process", $id);
    }

    protected function includeFiles($id)
    {
        $contentPath = $this->contentPath . '/' . $id;
        include_once($contentPath . '/functions.php');
    }

}