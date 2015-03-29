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

    public function __construct()
    {
        $this->setConfig(__FILE__);
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
            if (isset($column['data'])) $out[] = $column['data'];
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

    protected function redirect($item, $array = [])
    {
        $save = Input::get('save');
        $array = (array)$array;

        switch (true) {
            case isset($save['edit']):
                $route = Redirect::route("admin.{$this->moduleLower}.edit", $item->id);
                break;

            case isset($save['exit']):
                $route = Redirect::route("admin.{$this->moduleLower}.index");
                break;

            case isset($save['new']):
                $route = Redirect::route("admin.{$this->moduleLower}.create");
                break;

            default:
                $route = Redirect::route("admin.{$this->moduleLower}.index");

        }

        if ($array) {
            $method = $array[0];
            array_shift($array);
            return $route->{$method}($array ?: []);
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

}
