<?php namespace App\Modules\User\Controllers\Admin;

use App\Modules\Admin\Controllers\AdminController;
use App\Modules\User\Models\Group;
use App\Modules\User\Models\User as Model;

use Datatables;
use DatatablesFront;
use Former;
use Input;
use Illuminate\Http\Request as HttpRequest;

class UserController extends AdminController
{
    protected $dtColumns = [
        ['name' => 'id', 'className' => 'w40'],
        ['name' => 'name'],
        ['name' => 'email'],
        ['name' => 'created_at'],
        ['name' => 'status', 'className' => 'w40 text-center'],
        ['name' => 'actions', 'className' => 'w120 text-center', 'actionColumn' => true],
    ];

    protected $dtChangeStatus = true;

    protected $formButtons = array('except' => array('approve', 'reject'));

    public function __construct()
    {
        parent::__construct();

        $this->setConfig(__FILE__);
    }

    public function getDatatable(DatatablesFront $dtFront)
    {
        if (isset($this->dtChangeStatus) && !$this->dtChangeStatus) {
            view()->share('changeStatusDisabled', true);
        }

        $model = $this->modelName;
        $query = $model::select($this->dtSelectColumns());

        return Datatables::of($query)
            ->addColumn('status', function ($data) use ($dtFront, $model) {
                return $dtFront->renderStatusButtons($data, $model);
            })
            ->addColumn('actions', function ($data) use ($dtFront, $model) {
                return $dtFront->renderActionButtons($data);
            })
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @param \DatatablesFront $dtFront
     * @return Response
     */
    public function index(DatatablesFront $dtFront)
    {
        $dtFront->addColumns($this->dtColumns)
            ->setUrl(route("api.{$this->moduleLower}.dt"))
            ->setId("dt-{$this->moduleLower}")
            ->setModelName($this->modelName);

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
        $groups = Group::orderBy('name')->get()->lists('name')->all();
        if(!count($groups)){
            msg('Groups are not defined, please define them.', 'danger');
            return redirect()->route("admin.{$this->moduleLower}.index");
        }

        $formButtons = $this->formButtons($this->formButtons);
        return view("{$this->moduleLower}::admin.create", compact('groups', 'formButtons'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Modules\User\Models\User $model
     * @return Response
     */
    public function store(HttpRequest $request, Model $model)
    {
        $this->validate($request, $model->rules());

        if ($item = $model->create(Input::all())) {
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

        $groups = Group::orderBy('name')->get()->lists('name')->all();
        if(!count($groups)){
            msg('Groups are not defined, please define them.', 'danger');
            return redirect()->route("admin.{$this->moduleLower}.index");
        }
        $formButtons = $this->formButtons($this->formButtons);

        return view("{$this->moduleLower}::admin.edit", compact('item', 'groups', 'formButtons'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function update($id, HttpRequest $request)
    {
        $model = $this->modelName;
        $item = $model::find($id);

        if (!$item) {
            msg('The requested item does not exist or has been deleted.', 'danger');
            return redirect()->back();
        }

        $this->validate($request, $item->rules());

        if ($item->update(Input::all())) {
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
