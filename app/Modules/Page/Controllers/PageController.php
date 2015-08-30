<?php namespace App\Modules\Page\Controllers;

use App\Modules\Front\Controllers\FrontController;
use App\Modules\Page\Models\Page as Model;
use DB;
use App;

class PageController extends FrontController
{
    public function __construct()
    {
        parent::__construct();

        $this->setConfig(__FILE__);
    }

    public function index2($slug = null)
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

    public function index($id = null)
    {
        if (!is_null($id)) {
            $page = Model::find($id);

            if ($page) {
                return view($this->getStaticView($id, "{$this->moduleLower}::front.single"), compact('page'));
            }
        } else {
            $pages = Model::where('status', 1)
                ->get();
            return view("{$this->moduleLower}::front.index", compact('pages'));
        }
    }

    public function getStaticView($id, $view = null)
    {
        if (view()->exists("{$this->moduleLower}::front.static.{$id}")) {
            return "{$this->moduleLower}::front.static.{$id}";
        }
        return $view;
    }

    protected function includeView()
    {
        $skipSubType = ['video'];
        $moduleLower = $this->moduleLower;
        return function ($item) use ($moduleLower, $skipSubType) {
            if ($item->sub_type && !in_array($item->type, $skipSubType)) {
                $base = explode('_', $item->sub_type);
                return $moduleLower . '::front._partials.' . $item->type . '_' . $base[0];
            }
            return $moduleLower . '::front._partials.' . $item->type;
        };
    }

    protected function columnMixer()
    {
        return function ($item) {

            $class = 'col-xs-12 col-ms-12 col-sm-% col-md-% col-lg-% col-xl-%';
            $classPullPush = 'col-xs-12 col-ms-12 col-sm-%1 col-sm-%3-%2 col-md-%1 col-md-%3-%2 col-lg-%1 col-lg-%3-%2 col-xl-%1 col-xl-%3-%2';

            switch ($item->sub_type) {
                case 'column_1':
                    $out = str_replace('%', '4', $class);
                    break;

                case 'column_2':
                    $out = str_replace('%', '8', $class);
                    break;

                case 'column_1_pull':
                    $out = str_replace(['%1', '%2', '%3'], ['4', '8', 'pull'], $classPullPush);
                    break;

                case 'column_2_pull':
                    $out = str_replace(['%1', '%2', '%3'], ['8', '4', 'pull'], $classPullPush);
                    break;

                case 'column_1_push':
                    $out = str_replace(['%1', '%2', '%3'], ['4', '8', 'push'], $classPullPush);
                    break;

                case 'column_2_push':
                    $out = str_replace(['%1', '%2', '%3'], ['8', '4', 'push'], $classPullPush);
                    break;

                case 'center':
                    $out = str_replace('%', '4', $class);
                    break;

                case 'full':
                    $out = str_replace('%', '12', $class);
                    break;

                default:
                    $out = 'col-xs-12';
                    break;

            }

            return $out;
        };
    }
}