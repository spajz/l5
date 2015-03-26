<?php namespace App\Modules\People\Controllers\Admin;

use App\Http\Requests;
use App\Modules\Admin\Controllers\AdminController;
use Datatables;
use DatatablesFront;
use Former;
use Input;
use Redirect;
use App\Modules\People\Models\People;
use Auth;
use Illuminate\Contracts\Auth\Registrar;

class PeopleController extends AdminController
{

    protected $dtColumns = array(
        array('data' => 'id', 'className' => 'w40'),
        array('data' => 'slug', 'title' => 'Ovo je slug'),
        array('data' => 'title'),
        array('data' => 'created_at'),
        array('data' => 'status', 'className' => 'w40 center'),
        array('name' => 'actions', 'className' => 'w120 center', 'orderable' => false),
    );

    public function __construct(Registrar $registrar)
    {
        parent::__construct();
        $this->registrar = $registrar;

        $this->setConfig(__FILE__);
    }

    public function getDatatable()
    {
        $model = $this->modelName;
        $model = $model::select($this->dtSelectColumns());
        $modelNameSpace = get_class($model);
        $dtFront = DatatablesFront::init();

        return Datatables::of($model)
            ->addColumn('status', function ($data) use ($dtFront, $modelNameSpace) {
                return $dtFront->renderStatusButtons($data, $modelNameSpace);
            })
            ->addColumn('actions', function ($data) use ($dtFront, $modelNameSpace) {
                return $dtFront->renderActionButtons($data);
            })
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $dtFront = DatatablesFront::init()
//            ->searchColumns('slug', 'status')
            ->addColumns($this->dtColumns)
            ->setUrl(route("api.{$this->moduleLower}.dt"))
            ->setId("dt-{$this->moduleLower}");

        $vars = $dtFront->render();

        return view("{$this->moduleLower}::admin.index", $vars);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view("{$this->moduleLower}::admin.create");
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

        $this->registrar->create(['email' => 'admin@admin.com', 'password' => 'admin123123123', 'name' => 'djole']);
//        Auth::attempt(['email' => 'admin@admin.com', 'password' => 'admin123123123']);


        $model = $this->modelName;
        $item = $model::find($id);

        if (!$item) {
            msg('The requested item does not exist or has been deleted.', 'danger');
            return Redirect::route("admin.{$this->moduleLower}.index");
        }

        Former::populate($item);
        $people = People::orderBy('order')->get();

        return view("{$this->moduleLower}::admin.edit", compact('item', 'people'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $model = $this->modelName;
        $item = $model::find($id);
        $save = Input::get('save');

        if (!$item) {
            msg('Item does not exist.', 'danger');
            return Redirect::route("admin.{$this->moduleLower}.index");
        }

        if (isset($save['reject'])) {
            msg('Item rejected.');
            $item->status = -1;
            $item->save();
            return $this->redirect($item);
        }

        $item->update(Input::all());

        msg('Item successfully updated.');

        if (isset($save['publish'])) {
            msg('Item successfully published.');
            $item->status = 1;
            return $this->redirect($item);
        }

        return $this->redirect($item);
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