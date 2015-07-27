<?php namespace App\Modules\Person\Controllers\Admin;

use App\Library\ImageApi;
use App\Modules\Admin\Controllers\AdminController;
use App\Modules\Person\Models\Person as Model;

use Datatables;
use DatatablesFront;
use Former;
use Input;
use Illuminate\Http\Request as HttpRequest;
use Html;

class PersonController extends AdminController
{
    protected $dtColumns = [
        ['name' => 'id', 'className' => 'w40'],
        ['name' => 'image', 'actionColumn' => true],
        ['name' => 'first_name', 'columnFilter' => 'text'],
        ['name' => 'last_name', 'columnFilter' => 'text'],
        ['name' => 'job_title'],
        ['name' => 'order', 'className' => 'w40'],
        ['name' => 'translate', 'className' => 'w120 text-center', 'actionColumn' => true],
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
        $this->viewBase = "{$this->moduleLower}::admin";
    }

    public function getDatatable(DatatablesFront $dtFront)
    {
        $model = $this->modelName;
        $config = $this->config;

        if (isset($this->dtChangeStatus) && !$this->dtChangeStatus) {
            view()->share('changeStatusDisabled', true);
        }

        $columns = $dtFront->createSelectArray($this->dtColumns, ['translate', 'actions', 'image']);

        $query = $model::select($columns);

        return Datatables::of($query)
            ->addColumn('image', function ($data) use ($dtFront, $config) {
                $out = 'N/A';
                $img = isset($data->images[0]) ? $data->images[0] : null;
                if ($img && is_file(array_get($config, 'image.path') . 'thumb/' . image_filename($img, 'thumb'))) {
                    // Dynamic thumb image
                    $imageUrl = array_get($config, 'image.baseUrl') . 'thumb/' . image_filename($img, 'thumb');
                    $out = '<a href="' . array_get($config, 'image.baseUrl') . 'large/' . image_filename($img, 'large') . '" class="fancybox" rel="gallery">' .
                        Html::image(route('api.admin.get.image', [urlencode2($imageUrl), urlencode2($config['module']['moduleLower'])]),
                            '',
                            array(
                                'class' => 'img-responsive col-centered img-thumbnail',
                            )
                        ) .
                        '</a>';
                }
                return $out;
            })
            ->addColumn('status', function ($data) use ($dtFront, $model) {
                return $dtFront->renderStatusButtons($data, $model);
            })
            ->addColumn('translate', function ($data) use ($dtFront, $model) {
                return $dtFront->renderTranslateButtons($data);
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

        return view("{$this->viewBase}.index", $vars);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $model = $this->modelName;
        $lang = $this->adminLanguage();

        // Create first article only in default language
        $defaultLang = config('admin.language');
        if ($lang != $defaultLang) {
            msg('The first article must be in the main language.', 'info');
            $this->adminLanguage($defaultLang);
            return redirect()->route("admin.{$this->moduleLower}.create");
        }

        $formButtons = $this->formButtons(__FUNCTION__);

        // Add validation from model to former
        $validationRules = $model::rulesMergeStore();

        // Add autocomplete lists
        $autocompleteList['job_title'] = $this->getModel($model, 'id', 'job_title', 'option-list');

        return view("{$this->viewBase}.create",
            compact(
                'lang',
                'formButtons',
                'validationRules',
                'autocompleteList'
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
    public function edit($id, $lang = null)
    {
        $model = $this->modelName;
        $item = $model::find($id);

        if (!$item) {
            msg('The requested item does not exist or has been deleted.', 'danger');
            return redirect()->route("admin.{$this->moduleLower}.index");
        }

        if (!is_null($lang)) {
            $this->adminLanguage($lang);
            return redirect()->route("admin.{$this->moduleLower}.edit", $id);
        }
        $lang = $this->adminLanguage();

        $thisObj = $this;
        Former::populate($item);
        $formButtons = $this->formButtons(__FUNCTION__, $item);
        $translateButtons = $this->renderTranslateButtons($item);
        $statusButton = function ($item) use ($thisObj) {
            return $thisObj->renderStatusButtons($item);
        };

        // Add validation from model to former
        $validationRules = $model::rulesMergeUpdate();

        // Add autocomplete lists
        $autocompleteList['job_title'] = $this->getModel(get_class($item), 'id', 'job_title', 'option-list');

        return view("{$this->viewBase}.edit",
            compact(
                'item',
                'lang',
                'formButtons',
                'translateButtons',
                'statusButton',
                'validationRules',
                'contents',
                'autocompleteList'
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
        $imageApi->setStatus(1);

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
        if (Input::get('redirect')) {
            return redirect()->route("admin.{$this->moduleLower}.index");
        }
        return redirect()->back();
    }

    /**
     * Reorder items.
     *
     * @return Response
     */
    public function order()
    {
        $columns = function ($item) {
            return [
                'First name' => $item->first_name,
                'Last name' => $item->last_name,
                'Job title' => $item->job_title,
                'Order' => $item->order
            ];
        };
        $model = $this->modelName;
        $items = $model::orderBy('order')->get();
        $headerTitles = [];
        if (count($items)) {
            $headerTitles = $columns($items[0]);
        }
        return view("{$this->viewBase}.order", compact('model', 'items', 'columns', 'headerTitles'));
    }
}