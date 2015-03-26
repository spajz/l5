<?php namespace App\Modules\User\Controllers\Admin;

use App\Modules\Admin\Controllers\AdminController;
use Datatables;
use DatatablesFront;
use Former;
use Input;
use App\modules\User\Models\Group;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Auth;

class UserController extends AdminController
{

    protected $dtColumns = array(
        array('data' => 'id', 'className' => 'w40'),
        array('data' => 'name'),
        array('data' => 'email'),
        array('data' => 'created_at'),
        array('data' => 'status', 'className' => 'w40 center'),
        array('name' => 'actions', 'className' => 'w120 center', 'orderable' => false),
    );

    protected $formButtons = array('except' => array('approve', 'reject'));

    public function __construct(Guard $auth, Registrar $registrar)
    {
        parent::__construct();

        $this->auth = $auth;
        $this->registrar = $registrar;

//        $this->middleware('guest', ['except' => 'getLogout']);

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
        $groups = Group::orderBy('name')->get()->lists('name');
        $formButtons = $this->formButtons($this->formButtons);
        return view("{$this->moduleLower}::admin.create", compact('groups', 'formButtons'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $validator = $this->registrar->validatorAdmin(Input::all());

        if ($validator->fails()) {
            msg($validator->messages()->all(), 'danger');
            return redirect()->back()->withInput();
        }

        if ($item = $this->registrar->create(Input::all())) {
            msg('Item successfully created.');
            return $this->redirect($item);
        }

        msg('Item has not been created.', 'danger');

        return redirect()->back();
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
        $groups = Group::orderBy('name')->get()->lists('name');
        $formButtons = $this->formButtons($this->formButtons);

        return view("{$this->moduleLower}::admin.edit", compact('item', 'groups', 'formButtons'));
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

        if (!$item) {
            msg('The requested item does not exist or has been deleted.', 'danger');
            return redirect()->back();
        }

        $validator = $this->registrar->validatorAdminUpdate(Input::all());

        if ($validator->fails()) {
            msg($validator->messages()->all(), 'danger');
            return redirect()->back()->withInput();
        }

        if ($this->registrar->update(Input::all())) {
            msg('Item successfully updated.');
            return $this->redirect($item);
        }

        msg('Nothing changed.', 'info');

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
