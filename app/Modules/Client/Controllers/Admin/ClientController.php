<?php namespace App\Modules\Client\Controllers\Admin;

use App\Library\ImageApi;
use App\Modules\Admin\Controllers\AdminController;
use App\Modules\Client\Models\Client as Model;

use Datatables;
use DatatablesFront;
use Former;
use Input;
use Illuminate\Http\Request as HttpRequest;
use App\Models\ModelContent;
use App\Models\ModelContentValue;

class ClientController extends AdminController
{
    protected $dtColumns = [
        ['name' => 'id', 'className' => 'w40'],
        ['name' => 'title', 'columnFilter' => 'text'],
        ['name' => 'industry', 'columnFilter' => 'text'],
        ['name' => 'order', 'className' => 'w40'],
        ['name' => 'status', 'className' => 'w40 text-center'],
        ['name' => 'actions', 'className' => 'w120 text-center', 'actionColumn' => true],
    ];

    protected $dtChangeStatus = true;

    protected $formButtons = array('except' => array('approve', 'reject', 'destroy'));
    protected $formButtonsEdit = array('except' => array('approve', 'reject'));

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

        foreach ($this->dtColumns as $columnItem) {
            $columns[$columnItem['name']] = $columnItem['name'];
            $columns = array_except($columns, ['actions']);
        }

        $model = $this->modelName;
        $query = $model::select($columns);

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
     * @param int $trans_id
     * @param string $lang
     * @return Response
     */
    public function create()
    {
        $model = $this->modelName;

        $formButtons = $this->formButtons(isset($this->formButtonsCreate) ? $this->formButtonsCreate : $this->formButtons);

        // Add validation from model to former
        $validationRules = $model::rulesMergeStore();

        return view("{$this->moduleLower}::admin.create",
            compact(
                'formButtons',
                'validationRules'
            ));
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
            msg('The item successfully created.');
            return $this->redirect($item);
        }

        msg('The item has not been created.', 'danger');
        return redirect()->back();
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

        $thisObj = $this;
        Former::populate($item);
        $formButtons = $this->formButtons('edit', $item, null);
        $statusButton = function ($item) use ($thisObj) {
            return $thisObj->renderStatusButtons($item);
        };

        // Add validation from model to former
        $validationRules = $model::rulesMergeUpdate();

        $elements = [
            '' => '* Add element',
            'textarea' => 'Text area',
            'rte' => 'Rich text editor',
            'text' => 'Text',
            'example' => 'Example',
            'gallery' => 'Gallery',
            'video_duo' => 'Video duo',
            'video' => 'Video',
        ];

        asort($elements);

        $contents = $item->contentable;

        return view("{$this->moduleLower}::admin.edit",
            compact(
                'item',
                'formButtons',
                'statusButton',
                'validationRules',
                'elements',
                'contents'
            ));
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

        $imageApi = new ImageApi;
        $imageApi->setConfig("{$this->moduleLower}.image");
        $imageApi->setModelId($id);
        $imageApi->setModelType(get_class($item));
        $imageApi->setBaseName("{$this->moduleLower}_{$item->id}");

        if (!$imageApi->process()) {
            msg($imageApi->getErrorsAll(), 'danger');
            return redirect()->back();
        }

        if ($item->update(Input::all())) {
            msg('The item successfully updated.');
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
        $model = $this->modelName;
        $item = $model::find($id);

        if (!$item) {
            msg('The requested item does not exist or has been deleted.', 'danger');
            return redirect()->back();
        }

        $item->delete();
        msg('The item successfully deleted.');
        return redirect()->back();

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

}