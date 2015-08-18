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


function make_collection($collection){
    if(!$collection instanceof \Illuminate\Support\Collection){
        $collection = collect($collection);
    }

    return $collection->transform(function ($item, $key) {
        if(isset($item['children'])){
            $item['children'] = make_collection($item['children']);
        }
        return $item;
    });
}

function make_fractal($collection){
    if(!$collection instanceof \Illuminate\Support\Collection){
        $collection = collect($collection);
    }

    return $collection->transform(function ($item, $key) {
        if(isset($item['children'])){
            $item['children'] = make_collection($item['children']);
        }
        return $item;
    });
}

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

        $tree = $model::all()->toHierarchy()->toArray();

        return response()->json($tree);

        if (count($items)) {
            foreach ($items as $item) {

            }
        }


    }

    public function ttt($collection){
        $thisObj = $this;
        return $collection->transform(function ($item, $key) use($thisObj) {
            if(isset($item['children'])){
                $item['children'] = $thisObj->ttt(collect($item['children']));
            }
            return $item;
        });
    }

    public function setTree()
    {

        $categories = [
            ['id' => 1, 'title' => 'TV & Home Theather'],
            ['id' => 2, 'title' => 'Tablets & E-Readers'],
            ['id' => 3, 'title' => 'Computers', 'children' => [
                ['id' => 4, 'title' => 'Laptops', 'children' => [
                    ['id' => 5, 'title' => 'PC Laptops'],
                    ['id' => 6, 'title' => 'Macbooks (Air/Pro)']
                ]],
                ['id' => 7, 'title' => 'Desktops', 'children' => [
                    // These will be created
                    ['title' => 'Towers Only'],
                    ['title' => 'Desktop Packages'],
                    ['title' => 'All-in-One Computers'],
                    ['title' => 'Gaming Desktops']
                ]]
                // This one, as it's not present, will be deleted
                // ['id' => 8, 'title' => 'Monitors'],
            ]],
            ['id' => 9, 'title' => 'Cell Phones']
        ];



        $model = urldecode2(Input::get('model'));
        $json = json_decode(Input::get('data'), true);




        $fractal = new Manager();
        $resource = new Collection($json, function($book) {
            return [
                'id'      => (int) $book['id'],
                'title'   => $book['text'],

                'children'   => collect($book['children'])
            ];
        });

        // Turn that into a structured array (handy for XML views or auto-YAML converting)
        $array = $fractal->createData($resource)->toArray();

// Turn all of that into a JSON string
        echo $fractal->createData($resource)->toJson();

        exit;



        $collection = collect($json);


        $books = make_collection($collection);
        $books = \App\Modules\Helper\Models\HelperGroup::all();
/*

        #items: array:1 [
        0 => array:8 [
            "id" => "2"
            "text" => "Group 002"
            "icon" => true
            "li_attr" => array:1 [
                    "id" => "2"
                ]
            "a_attr" => array:2 [
                     "href" => "#"
                     "id" => "2_anchor"
             ]
            "state" => array:4 [
            "loaded" => true
                  "opened" => false
                  "selected" => false
                  "disabled" => false
            ]
            "data" => false
            "children" => Collection {#466
                #items: []
            }
          ]
        ]
*/

        $resource = new Fractal\Resource\Collection($books, function($book) {
            return [
                'id'      => (int) $book['id'],
                'title'   => $book['title'],
                'icon'    => 'FIX',
//                'children'   => $book['children']
            ];
        });

        foreach($resource as $item){
            ee($item);
        };


        dd($resource);


//        $collection->transform(function ($item, $key) {
//            if(isset($item['children'])){
//                $item['children'] = collect($item['children']);
//            }
//            return $item;
//        });


        dd($ttt);
        exit;

        dd($collection);


        remove_key($json, 'data');
        remove_key($json, 'a_attr');
        remove_key($json, 'icon');
        remove_key($json, 'li_attr');
        remove_key($json, 'state');

//       return response()->json($json);
//        dd($json);
        

        $model::buildTree($json);

//        if (is_array($json)) {
//            foreach ($json as $item) {
//                $updateItem = $model::find($item->id);
//                if ($updateItem) {
//                    $updateItem->parent_id = is_numeric($item->parent) ? $item->parent : null;
//                    $updateItem->save();
//                }
//            }
//        }
        return response()->json($categories);
    }



    public function fun($v){

return $v . ' - - ';
    }
}