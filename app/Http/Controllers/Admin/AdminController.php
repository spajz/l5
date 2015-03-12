<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\BaseController;
use App\Models\Page as Page;

use Illuminate\Http\Request;
use View;
use App\Helper;
use Config;

class AdminController extends BaseController
{
    protected $layout;
    protected $assetsDir;
    protected $viewPath;
    protected $moduleLower;
    protected $moduleUpper;
    protected $config;

    public function __construct()
    {
        $this->setConfig();
    }

    protected function setConfig($module = 'admin')
    {
        $this->config = config($module . '.config');
        $moduleConfig = config('admin.module');
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
//        $items = Page::all();
//        $page = Page::create(
//            array(
//                'title' => 'Daj novi naslov',
//            )
//        );
//
//        $page->save();

//        $value = Config::get('admin::config');
//        $value2 = Config::get('front::config.image.path');
//        echo $value2; exit;


        return view($this->viewPath . '.start');

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

}
