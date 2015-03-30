<?php namespace App\Modules\Person\Controllers\Admin;

use App\Modules\Admin\Controllers\AdminController;
use App\Modules\Person\Models\Person as Model;

use Datatables;
use DatatablesFront;
use Former;
use Input;
use Illuminate\Http\Request as HttpRequest;

class PersonController extends AdminController
{

    protected $dtColumns = [
        ['name' => 'id', 'className' => 'w40'],
        ['name' => 'first_name', 'columnFilter' => 'text'],
        ['name' => 'last_name', 'columnFilter' => 'text'],
        ['name' => 'job_title'],
        ['name' => 'created_at'],
        ['name' => 'order', 'className' => 'w40'],
        ['name' => 'status', 'className' => 'w40 center'],
        ['name' => 'lang', 'className' => 'w40', 'columnFilter' => 'select'],
        ['name' => 'trans_id', 'className' => 'w40', 'title' => 'Parent'],
        ['name' => 'translate', 'className' => 'w120 center', 'actionColumn' => true],
        ['name' => 'actions', 'className' => 'w120 center', 'actionColumn' => true],
    ];

    protected $formButtons = array('except' => array('approve', 'reject'));

    public function __construct()
    {
        parent::__construct();

        $this->setConfig(__FILE__);
    }

    public function getDatatable(DatatablesFront $dtFront)
    {
        $model = $this->modelName;
        $model = $model::select('*');
//            ->where('lang', 'sr');
        $modelNameSpace = get_class($model);

        return Datatables::of($model)
            ->addColumn('status', function ($data) use ($dtFront, $modelNameSpace) {
                return $dtFront->renderStatusButtons($data, $modelNameSpace);
            })
            ->addColumn('translate', function ($data) use ($dtFront, $modelNameSpace) {
                return $dtFront->renderTransButtons($data);
            })
            ->addColumn('actions', function ($data) use ($dtFront, $modelNameSpace) {
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
    public function create($trans_id = null, $lang = null)
    {
        $model = $this->modelName;
        $transButtons = '';

        if (is_null($lang)) $lang = $this->language;
        if (is_numeric($trans_id)) {

            $trans = $model::hasTrans($trans_id, $lang)->first();
            if ($trans) {
                msg('This item already exists in the requested language.', 'info');
                return $this->redirect($trans, ['save' => ['edit' => 'Save']]);
            }

            $item = $model::find($trans_id);
            if (!$item) {
                msg('Item which you want to translate does not exist or has been deleted.', 'danger');
                return redirect()->route("admin.{$this->moduleLower}.index");
            }
            Former::populate($item);
            $transButtons = $this->renderTransButtons($item);
        }

        $formButtons = $this->formButtons($this->formButtons);
        return view("{$this->moduleLower}::admin.create", compact('formButtons', 'trans_id', 'lang', 'transButtons'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Modules\Person\Models\Person $model
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
    public function edit($id, $lang = null)
    {
        $model = $this->modelName;
        $item = $model::find($id);

        if (!$item) {
            msg('The requested item does not exist or has been deleted.', 'danger');
            return redirect()->route("admin.{$this->moduleLower}.index");
        }

        Former::populate($item);
        $formButtons = $this->formButtons($this->formButtons);
        $transButtons = $this->renderTransButtons($item);

        return view("{$this->moduleLower}::admin.edit", compact('item', 'formButtons', 'transButtons'));
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

    /**
     * Reorder items.
     *
     * @return Response
     */
    public function order()
    {
        $model = $this->modelName;
        $items = $model::all();
        return view("{$this->moduleLower}::admin.order", compact('model', 'items'));
    }

    protected function createTransChild($id)
    {

    }

}
