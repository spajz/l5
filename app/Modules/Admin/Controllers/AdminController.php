<?php namespace App\Modules\Admin\Controllers;

use App\Http\Requests;
use App\Http\Controllers\BaseController;
use View;
use Input;
use DatatablesFront;
use Redirect;

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
        $this->setConfig(__FILE__);
        $this->language = config('admin.language');
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
        $moduleConfig = config($module . '.module');
        if ($moduleConfig) {
            foreach ($moduleConfig as $key => $value) {
                $this->$key = $value;
                View::share($key, $value);
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
        return View::make('admin::datatables.but_status', array('data' => $data, 'model' => $model));
    }

    public function changeStatus()
    {
        if (!Input::get('model')) return false;

        if (!Input::get('id')) return false;

        $model = urldecode2(Input::get('model'));

        $item = $model::find(Input::get('id'));

        if ($item->status != 1) $item->status = 1;
        else $item->status = 0;

        $item->save();

        return $this->dtStatusButton($item);
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

        if (strpos($column, ',')) {
            $column = explode(',', $column);
        }
        if (!$column) $column = '*';
        $column = 'first_name';
        $items = $model::select($column)
            ->orderBy($column)
            ->get();


        switch ($type) {
            case 'list':
                $out = $items->lists($column, $key);
                break;

            case 'option':
                if ($items) {
                    foreach ($items as $item) {
                        $out .= '<option value="' . addslashes($item->$column) . '">' . $item->$column . '</option>';
                    }
                }
                break;

            default:
                $out = $items;
        }

        return $out;

    }

}