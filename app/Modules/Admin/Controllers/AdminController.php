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
    protected $config;

    public function __construct()
    {
        $this->setConfig(__FILE__);
    }

    protected function setConfig($module, $path = true)
    {
        if ($path) {
            $pathInfo = pathinfo($module);
            $pathInfo['filename'];
            $module = explode('_', snake_case($pathInfo['filename']));
            $module = $module[0];
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
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('admin::start');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
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
        return View::make('admin::datatable.but_status', array('data' => $data, 'model' => $model));
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

    protected function redirect($item)
    {
        $save = Input::get('save');
        switch (true) {
            case isset($save['edit']):
                return Redirect::route("admin.{$this->moduleLower}.edit", $item->id);
                break;

            case isset($save['exit']):
                return Redirect::route("admin.{$this->moduleLower}.index");
                break;

            case isset($save['new']):
                return Redirect::route("admin.{$this->moduleLower}.create");
                break;
        }

        return Redirect::route("admin.{$this->moduleLower}.index");
    }

}
