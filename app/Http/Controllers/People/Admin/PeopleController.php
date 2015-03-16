<?php namespace App\Http\Controllers\People\Admin;

use App\Http\Requests;
use App\Http\Controllers\Admin\AdminController;
use Datatables;
use DatatablesFront;
use App\Models\Page;

class PeopleController extends AdminController
{

    protected $dtColumns = array(
        array('data' => 'title'),
        array('data' => 'slug', 'title' => 'Ovo je slug'),
        array('data' => 'created_at'),
    );

    public function __construct()
    {
        parent::__construct();

        $this->setConfig('people');
    }

    public function getDatatable()
    {
        $pages = Page::select(array('title', 'slug', 'created_at'));

        return Datatables::of($pages)->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $dt = new DatatablesFront();
        $dt->addColumns($this->dtColumns);
        $dt->setUrl(route('api.people.dt'));
        $dt->setId('dt-' . $this->moduleLower);

        $vars = $dt->render();

        return view($this->viewPathModule . '.admin.index', $vars);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

        $vars['table'] = Datatable::table()
            ->addColumn('ID', 'Image', 'Full Name', 'Email', 'Friend Email', 'Age', 'Likes', 'FB ID', 'Status', 'Actions')
            ->setUrl(route("api.{$this->moduleLower}.dt"))
            ->setOptions('order', array(0, "desc"))
            ->setId('table_' . $this->moduleLower)
            ->noScript()
            ->setCallbacks(
                'aoColumnDefs', '[
                        {sClass:"center w40", aTargets:[0]},
                        {sClass:"center w40", aTargets:[5]},
                        {sClass:"center w40", aTargets:[6]},
                        {sClass:"center", aTargets:[7]},
                        {sClass:"center w40", aTargets:[8]},
                        {sClass:"center w170", aTargets:[9], bSortable: false }
                    ]'
            );

        return view($this->viewPathModule . '.admin.create');
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
