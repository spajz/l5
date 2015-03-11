<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\BaseController;
use App\Models\Page as Page;

use Illuminate\Http\Request;
use View;
use App\Helper;

class AdminController extends BaseController
{

    protected $layout = 'admin.views.layouts.master';
    protected $assetsDir = 'assets/admin';
    protected $viewPath = 'admin.views';

    public function __construct()
    {
        View::share('assetsDir', $this->assetsDir);
        View::share('viewPath', $this->viewPath);
        View::share('layout', $this->layout);
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

        $ff = Helper::getModules('enabled', 'path');
        dd($ff);
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
