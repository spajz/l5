<?php namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\BaseController;
use App\Library\ImageApi;
use Input;
use DatatablesFront;
use Notification;
use Redirect;
use DB;
use App\Models\Content;
use Session;
use Route;

use League\Fractal;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use App\Library\Transformer;

class AdminController extends BaseController
{
    protected $layout;
    protected $assetsDirAdmin;
    protected $assetsDirModule;
    protected $moduleLower;
    protected $moduleUpper;
    protected $moduleTitle;
    protected $config;
    protected $language;

    public function __construct()
    {
        if (app()->environment() == 'production') {
            app()->bind('path.public', function () {
                return base_path() . '/public_html';
            });
        }

        $this->middleware('auth.admin');

        $this->setConfig(__FILE__);
        $this->language = config('admin.language');

        $this->defaultSession();
    }

    public function dashboard()
    {
        return view("admin::dashboard");
    }

    protected function setConfig($module, $path = true)
    {
        if ($path) {
            if (get_dirname($module, 1) == 'Admin') {
                $module = strtolower(get_dirname($module, 3));
            } else {
                $module = strtolower(get_dirname($module, 2));
            }
        }

        $this->config = config($module);
        view()->share('config', $this->config);
        $moduleConfig = config($module . '.module');
        if ($moduleConfig) {
            foreach ($moduleConfig as $key => $value) {
                $this->$key = $value;
                view()->share($key, $value);
            }
        }
    }

    protected function defaultSession()
    {
        if (!Session::get('settings.language')) {
            Session::put('settings.language', $this->language);
        }
        app()->setLocale(Session::get('settings.language'));

        if (!Session::get('settings.tab')) {
            Session::put('settings.tab', '#basic');
        }

        if (strpos(Route::currentRouteName(), 'create') !== false) {
            Session::put('settings.tab', '#basic');
        }
    }

    /**
     * Datatables methods
     *
     * @return array $out
     */
    public function dtSelectColumns()
    {
        $out = array();
        foreach ($this->dtColumns as $column) {
            if (!isset($column['actionColumn'])) $out[] = $column['name'];
        }
        return $out;
    }

    public function changeStatus()
    {
        if (!Input::get('model') || !Input::get('id')) return false;

        $column = 'status';
        if (Input::get('column')) $column = Input::get('column');

        $model = urldecode2(Input::get('model'));

        $item = $model::find(Input::get('id'));

        if ($item->{$column} != 1) $item->{$column} = 1;
        else $item->{$column} = 0;

        $item->save();

        return $this->renderStatusButtons($item, $column);
    }

    public function renderStatusButtons($item, $column = null)
    {
        $dtFront = new DatatablesFront;
        return $dtFront->renderStatusButtons($item, null, $column);
    }

    public function sortRows()
    {
        $model = Input::get('model');
        $data = Input::get('data');

        $items = $model::whereIn('id', $data)->get();

        if (count($items)) {
            $dataFlip = array_flip($data);
            foreach ($items as $item) {
                $item->order = $dataFlip[$item->id];
                $item->save();
            }
        }
    }

    protected function redirect($item, $input = null)
    {

        if (is_null($input)) {
            $input = Input::all();
        }
        $action = $input['save'];

        switch (true) {
            case isset($action['edit']):
                $route = Redirect::route("admin.{$this->moduleLower}.edit", $item->id);
                break;

            case isset($action['exit']):
                $route = Redirect::route("admin.{$this->moduleLower}.index");
                break;

            case isset($action['new']):
                $route = Redirect::route("admin.{$this->moduleLower}.create");
                break;

            default:
                $route = Redirect::route("admin.{$this->moduleLower}.index");

        }
        return $route;
    }

    protected function formButtons($type = null, $item = null, $extra = null)
    {
        if ($type == 'edit') {
            $filter = isset($this->formButtonsEdit) ? $this->formButtonsEdit : $this->formButtons;
        } elseif ($type == 'create') {
            $filter = isset($this->formButtonsCreate) ? $this->formButtonsCreate : $this->formButtons;
        } else {
            $filter = $this->formButtons;
        }

        // Default buttons and order
        $formButtons = [
            'back',
            'save',
            'save_new',
            'save_exit',
            'approve',
            'reject',
            'destroy',
            'destroy_translation',
        ];

        if (isset($filter['only'])) {
            $formButtons = array_intersect($formButtons, $filter['only']);
        } elseif (isset($filter['except'])) {
            $formButtons = array_diff($formButtons, $filter['except']);
        }

        return view('admin::_partials.form_buttons_template', compact('formButtons', 'extra', 'item'));
    }

    public function renderTransButtons($item)
    {
        $dtFront = new DatatablesFront;
        return $dtFront->renderTransButtons($item);
    }

    public function renderTranslateButtons($item)
    {
        $dtFront = new DatatablesFront;
        return $dtFront->renderTranslateButtons($item);
    }

    public function getModel($model = null, $key = null, $column = null, $type = null, $extra = null)
    {
        $out = '';
        $model = is_null($model) ? Input::get('model') : $model;
        $key = is_null($key) ? Input::get('key') : $key;
        $column = is_null($column) ? Input::get('column') : $column;
        $type = is_null($type) ? Input::get('type') : $type;
        $extra = is_null($extra) ? Input::get('extra') : $extra;

        if (strpos($column, ',')) {
            $column = explode(',', $column);
        }
        if (!$column) $column = '*';

        $items = $model::select([$column, DB::raw('count(*) as total')])
            ->orderBy($column);

        if (!count($items)) return $out;

        switch ($type) {
            case 'list':
                $out = $items->get()->lists($column, $key)->all();
                break;

            case 'option':
                $items = $items->groupBy($column)->get();
                if ($items) {
                    foreach ($items as $item) {
                        if (isset($extra['filterCount']) && $extra['filterCount']) {
                            $out .= '<option value="' . addslashes($item->$column) . '">' . $item->$column . ' [' . $item->total . ']</option>';
                        } else {
                            $out .= '<option value="' . addslashes($item->$column) . '">' . $item->$column . '</option>';
                        }
                    }
                }
                break;

            case 'option-list':
                $items = $items->groupBy($column)->get();
                if ($items) {
                    foreach ($items as $item) {
                        $out .= '<option>' . $item->$column . '</option>';
                    }
                }
                break;

            case 'autocomplete-json':
                $query = Input::get('query');
                $items = $items->where($column, 'LIKE', '%' . $query . '%')->groupBy($column)->lists($column)->all();
                if ($items) {
                    return json_encode(['suggestions' => $items]);
                } else {
                    return json_encode(['suggestions' => []]);
                }
                break;

            default:
                $out = $items->get();
        }
        return $out;
    }

    public function imageDestroy($id, $withImages = true, $force = false)
    {
        $imageApi = new ImageApi;
        if ($imageApi->destroy($id, $withImages, $force)) {
            msg('The image successfully deleted.');
        }

        return redirect()->back();
    }

    /**
     * Crop image
     *
     * @param \App\Library\ImageApi $imageApi
     * @return array $out
     */
    public function imageCrop(ImageApi $imageApi)
    {
        if ($imageApi->imageCrop()) {
            msg('The image successfully cropped.');
        } else {
            msg('An error occurred. Please try again.', 'danger');
        }
    }

    /**
     * Add element to model content
     *
     * @param string @element
     * @return \Illuminate\View\View
     */
    public function addElement()
    {
        $element = Input::get('element');

        return view("admin::_partials.content.template", ['type' => $element]);
    }

    public function modelContentDestroy($id = null)
    {
        $success = false;
        if (is_numeric($id)) {
            $model = Content::find($id);
            if ($model) {
                $success = true;
                $model->delete();
                $model->reorder([
                    'model_type' => $model->model_type,
                    'model_id' => $model->model_id,
                ]);
            }
        }

        if (is_ajax()) {
            if ($success) {
                ob_start();
                echo Notification::successInstant('The item successfully deleted.');
                $output = ob_get_contents();
                ob_end_clean();
                $return = [
                    'type' => 'success',
                    'msg' => $output
                ];
            } else {
                ob_start();
                echo Notification::dangerInstant('An error occurred. The item does not exist or has been deleted.');
                $output = ob_get_contents();
                ob_end_clean();
                $return = [
                    'type' => 'danger',
                    'msg' => $output
                ];
            }

            return response()->json($return);
        }

        return redirect()->back();
    }

    public function adminLanguage($lang = null, $back = null)
    {
        $languages = config('admin.languages');
        if (isset($languages[$lang])) {
            session(['settings.language' => $lang]);
            app()->setLocale($lang);
        }

        if ($back) return redirect()->back();

        return session('settings.language');
    }

    public function setSession()
    {
        if (Input::get('session')) {
            Session::put(Input::get('session'));
        }
    }

    /*
     *  Get tree
    [{
        "id":1,"text":"Root node","children":[
            {"id":2,"text":"Child node 1"},
            {"id":3,"text":"Child node 2"}
        ]
    }]
    */
    public function getTree()
    {
//        dd(Input::all());
        $model = urldecode2(Input::get('model'));
//        $items = $model::select('*')->get();
//        $tree = $model::defaultOrder()->get()->toTree();

//        $tree = $model::all()->toHierarchy()->toArray();

//        defaultOrder()->get();

        $tree =  $model::defaultOrder()->get()->toTree()->toArray();


        return response()->json($tree);

        if (count($items)) {
            foreach ($items as $item) {

            }
        }
    }

    public function setTree()
    {
        $model = urldecode2(Input::get('model'));
        $transform = $model::transform();
        $json = json_decode(Input::get('data'), true);

        $transformer = new Transformer;
        $transformer->setTransformer($transform);
        $transformer->setCollectionIgnoreKeys(['li_attr', 'a_attr', 'state']);
        $transformed = $transformer->transformArray($json);


        $model::updateTreeRoots($transformed);
        $model::rebuildTree($transformed);

        $tree =  $model::all()->toTree()->toArray();

        return response()->json($tree);

    }

}