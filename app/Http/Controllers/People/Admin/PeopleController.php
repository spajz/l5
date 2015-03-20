<?php namespace App\Http\Controllers\People\Admin;

use App\Http\Requests;
use App\Http\Controllers\Admin\AdminController;
use Datatables;
use DatatablesFront;
use App\Models\Page;
use Former;
use Input;
use View;
use Notification;


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

    public function __construct()
    {
        parent::__construct();

        $this->setConfig('people');
    }

    public function getDatatable()
    {
        $model = $this->modelName;
        $model = $model::select($this->dtSelectColumns());
        $modelNameSpace = get_class($model);
        $buttons = DatatablesFront::init();

        return Datatables::of($model)
            ->addColumn('status', function ($data) use ($buttons, $modelNameSpace) {
                return $buttons->renderStatusButtons($data, $modelNameSpace);
            })
            ->addColumn('actions', function ($data) use ($buttons, $modelNameSpace) {
                return $buttons->renderActionButtons($data);
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
        $dt = DatatablesFront::init()
//            ->searchColumns('slug', 'status')
            ->addColumns($this->dtColumns)
            ->setUrl(route('api.people.dt'))
            ->setId('dt-' . $this->moduleLower);

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
        $model = $this->modelName;
        $item = $model::find($id);

        if (!$item) {
            msg('The requested item does not exist or has been deleted.', 'danger');
            return redirect()->route("admin.{$this->moduleLower}.index");
        }

        Former::populate($item);

        return view($this->viewPathModule . '.admin.edit', compact('item'));
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
            return redirect()->route("admin.{$this->moduleLower}.index");
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
