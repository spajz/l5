<?php namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\BaseController;
use App\Library\ImageApi;
use Illuminate\Support\Facades\Request;
use Input;
use DatatablesFront;
use Notification;
use Redirect;
use DB;
use App\Models\ModelContent;
use Session;

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
        $this->middleware('auth.admin');

        $this->setConfig(__FILE__);
        $this->language = config('admin.language');

        if (!Session::get('settings.language')) {
            Session::put('settings.language', $this->language);
        }
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

    public function dtButtons($data, $model = null)
    {
        return view()->make('admin::datatables.but_status', array('data' => $data, 'model' => $model));
    }

    public function changeStatus()
    {
        if (!Input::get('model') || !Input::get('id')) return false;

        $model = urldecode2(Input::get('model'));

        $item = $model::find(Input::get('id'));

        if ($item->status != 1) $item->status = 1;
        else $item->status = 0;

        $item->save();

        $dtFront = new DatatablesFront;

        return $this->renderStatusButtons($item);
    }

    public function renderStatusButtons($item)
    {
        $dtFront = new DatatablesFront;
        return $dtFront->renderStatusButtons($item);
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

    protected function formButtons($filter = array(), $extra = '')
    {
        // Default buttons and order
        $formButtons = [
            'back',
            'save',
            'save_new',
            'save_exit',
            'approve',
            'reject',
        ];

        if (isset($filter['only'])) {
            $formButtons = array_intersect($formButtons, $filter['only']);
        } elseif (isset($filter['except'])) {
            $formButtons = array_diff($formButtons, $filter['except']);
        }

        return view('admin::_partials.form_buttons_template', compact('formButtons', 'extra'));
    }

    public function renderTransButtons($item)
    {
        $dtFront = new DatatablesFront;
        return $dtFront->renderTransButtons($item);
    }

    public function getModel()
    {
        $out = '';
        $model = Input::get('model');
        $key = Input::get('column');
        $column = Input::get('column');
        $type = Input::get('type');
        $extra = Input::get('extra');

        if (strpos($column, ',')) {
            $column = explode(',', $column);
        }
        if (!$column) $column = '*';

        $items = $model::select([$column, DB::raw('count(*) as total')])
            ->orderBy($column);

        if (!count($items)) return $out;

        switch ($type) {
            case 'list':
                $out = $items->get()->lists($column, $key);
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

            default:
                $out = $items->get();
        }
        return $out;
    }

    public function imageDestroy($id, ImageApi $imageApi)
    {
        if ($imageApi->destroy($id)) {
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

        return view("admin::_partials.model_content." . $element);
    }

    public function modelContentDestroy($id = null)
    {
        $success = false;
        if (is_numeric($id)) {
            $model = ModelContent::find($id);
            if ($model) {
                $success = true;
                $model->delete();
            }
        }

        if (is_ajax()) {
            if ($success) {
                ob_start(); //Start output buffer
                echo Notification::successInstant('The item successfully deleted.');
                $output = ob_get_contents(); //Grab output
                ob_end_clean(); //Discard output buffer
                $return = [
                    'type' => 'success',
//                    'msg' => 'The item successfully deleted.'
                    'msg' => $output
                ];
            } else {
                $return = [
                    'type' => 'danger',
                    'msg' => 'An error occurred. The item does not exist or has been deleted.'
                ];
            }

            return response()->json($return);
        }

        return redirect()->back();
    }

    public function adminLanguage($lang)
    {
        $languages = config('admin.languages');
        if (isset($languages[$lang])) {
            session(['settings.language' => $lang]);
        }

        return session('settings.language');
    }

}