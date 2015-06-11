<?php namespace App\Modules\Person\Controllers\Admin;

use App\Library\ImageApi;
use App\Modules\Admin\Controllers\AdminController;
use App\Modules\Person\Models\Person as Model;

use Datatables;
use DatatablesFront;
use Former;
use Input;
use Illuminate\Http\Request as HttpRequest;
use App\Models\ModelContent;
use App\Models\ModelContentValue;

class PersonController extends AdminController
{
    protected $dtColumns = [
        ['name' => 'id', 'className' => 'w40'],
        ['name' => 'first_name', 'columnFilter' => 'text'],
        ['name' => 'last_name', 'columnFilter' => 'text'],
        ['name' => 'job_title'],
        ['name' => 'created_at'],
        ['name' => 'order', 'className' => 'w40'],
        ['name' => 'lang', 'className' => 'w40', 'columnFilter' => 'select', 'tfClass' => 'filter-count'],
        ['name' => 'trans_id', 'className' => 'w40', 'title' => 'Parent'],
        ['name' => 'translate', 'className' => 'w120 text-center', 'actionColumn' => true],
        ['name' => 'status', 'className' => 'w40 text-center'],
        ['name' => 'actions', 'className' => 'w120 text-center', 'actionColumn' => true],
    ];

    protected $dtChangeStatus = false;

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
        $query = $model::select('*');
//        $model = $model::select('persons.*', 'images.image')
//            ->where('lang', 'sr');
//            ->leftJoin('images', 'authors.id','=','articles.author_id');

//            ->leftJoin('images', function ($join) use ($model) {
//                $join->on('images.model_id', '=', 'persons.id')
//                    ->where('images.model_type', '=', $model);
//            });

        return Datatables::of($query)
            ->addColumn('status', function ($data) use ($dtFront, $model) {
                return $dtFront->renderStatusButtons($data, $model);
            })
            ->addColumn('translate', function ($data) use ($dtFront, $model) {
                return $dtFront->renderTransButtons($data);
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
    public function create($trans_id = null, $lang = null)
    {
        $model = $this->modelName;
        $transButtons = '';

        $lang = $this->adminLanguage($lang);

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

        // Add validation from model to former
        $validationRules = $model::rulesMergeStore();

        $formButtons = $this->formButtons($this->formButtons);
        return view("{$this->moduleLower}::admin.create", compact('formButtons', 'trans_id', 'lang', 'transButtons', 'validationRules'));
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

        $thisObj = $this;
        Former::populate($item);
        $formButtons = $this->formButtons($this->formButtons);
        $transButtons = $this->renderTransButtons($item);
        $statusButton = function ($item) use ($thisObj) {
            return $thisObj->renderStatusButtons($item);
        };

        // Add validation from model to former
        $validationRules = $model::rulesMergeUpdate();

        return view("{$this->moduleLower}::admin.edit", compact('item', 'formButtons', 'transButtons', 'statusButton', 'validationRules'));
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
//        $imageApi->setBaseName('novi fajl');

        if (!$imageApi->process()) {
            msg($imageApi->getErrorsAll(), 'danger');
            return redirect()->back();
        }

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

    public function content($lang = null)
    {
        $lang = $this->adminLanguage($lang);

        $languages = config('admin.languages');

        $buttonSize = 'btn-xs';

        $elements = [
            '' => '* Add element',
            'textarea' => 'Text area',
            'rte' => 'Rich text editor',
            'text' => 'Text',
            'text2' => 'Text 2',
            'image' => 'Image',
        ];

        asort($elements);

        $contents = ModelContent::where('model_type', $this->modelName)
            ->where('lang', $lang)
            ->orderBy('order')
            ->get();

        return view("{$this->moduleLower}::admin.content", compact('lang', 'elements', 'languages', 'buttonSize', 'contents'));
    }

    public function contentStore($lang = null)
    {
//        dd(Input::all());
        $fillableContent = new ModelContent;
        $fillableContentValues = new ModelContentValue;
        $fillableContent = $fillableContent->getFillable();
        $fillableContentValues = $fillableContentValues->getFillable();

        $fillableContentNew = array_map(function ($item) {
            return $item . '_new';
        }, $fillableContent);
        $fillableContentValuesNew = array_map(function ($item) {
            return $item . '_new';
        }, $fillableContentValues);

        $ids = Input::get('id');
        $idsNew = Input::get('id_new');

        $attributesContent = [
            'model_type' => Input::get('model_type'),
            'lang' => Input::get('lang')
        ];

        // Loop through existing ids and update
        if ($ids && $fillableContent) {

            foreach ($ids as $k => $id) {

                $attributesValues = [];

                $modelContent = ModelContent::find($k);

                if ($modelContent) {

                    foreach ($fillableContent as $column) {

                        if (!is_null(Input::get($column . '.' . $k, null))) {
                            $attributesContent[$column] = Input::get($column . '.' . $k);
                        }
                    }

                    foreach ($fillableContentValues as $column) {

                        if (!is_null(Input::get($column . '.' . $k, null))) {
                            $attributesValues[$column] = Input::get($column . '.' . $k);
                        }
                    }

                    // Value create or update
                    $value_id = Input::get('value_id' . '.' . $k);
                    if (is_numeric($value_id)) {
                        $modelContentValue = ModelContentValue::find($value_id);
                    } else {
                        $modelContentValue = new ModelContentValue;
                    }

                    $modelContent->fill($attributesContent);
                    $modelContent->save();
                    $modelContentValue->fill($attributesValues);
                    if ($modelContentValue->value != '') {
                        $modelContent->values()->save($modelContentValue);
                    }
                }
            }
        }

        // Create new items
        if ($idsNew && $fillableContent) {
            foreach ($idsNew as $k => $null) {

                $suffix = '_new';

                $attributesValues = [];

                $modelContent = new ModelContent;

                foreach ($fillableContent as $column) {

                    if (!is_null(Input::get($column . $suffix . '.' . $k, null))) {
                        $attributesContent[$column] = Input::get($column . $suffix . '.' . $k);
                    }
                }


                if (!is_null(Input::get('value' . $suffix, null))) {

                    foreach (Input::get('value' . $suffix, null) as $k1 => $array) {

                        foreach ($array as $k2 => $value) {

                            foreach ($fillableContentValues as $column) {

                                $attributesValuesTmp[$column] = Input::get($column . $suffix . '.' . $k1 . '.' . $k2);
                            }
                        }

                       // $attributesValues[] = new ModelContentValue($attributesValuesTmp);
                    }

                }


//                $modelContentValue = new ModelContentValue($attributesValues);

                $modelContent->fill($attributesContent);
               $modelContent->save();

                //$modelContent->values()->saveMany($attributesValues);

//                if ($modelContentValue->value != '') {
//                    $modelContent->values()->save($modelContentValue);
//                }
            }
        }
        return redirect()->back();
    }

}