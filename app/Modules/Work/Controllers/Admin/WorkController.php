<?php namespace App\Modules\Work\Controllers\Admin;

use App\Library\ImageApi;
use App\Modules\Admin\Controllers\AdminController;
use App\Modules\Work\Models\Work as Model;

use Datatables;
use DatatablesFront;
use Former;
use Input;
use Illuminate\Http\Request as HttpRequest;
use App\Models\ModelContent;
use App\Models\ModelContentValue;

class WorkController extends AdminController
{
    protected $dtColumns = [
        ['name' => 'id', 'className' => 'w40'],
        ['name' => 'title', 'columnFilter' => 'text'],
        ['name' => 'sub_title', 'columnFilter' => 'text'],
        ['name' => 'created_at'],
        ['name' => 'order', 'className' => 'w40'],
        ['name' => 'lang', 'className' => 'w40', 'columnFilter' => 'select', 'tfClass' => 'filter-count'],
        ['name' => 'trans_id', 'className' => 'w40', 'title' => 'Parent'],
        ['name' => 'translate', 'className' => 'w120 text-center', 'actionColumn' => true],
        ['name' => 'featured', 'className' => 'w40 text-center'],
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
        $query = $model::select('*');

        return Datatables::of($query)
            ->addColumn('featured', function ($data) use ($dtFront, $model) {
                return $dtFront->renderStatusButtons($data, $model, 'featured');
            })
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

        // Create first article only in default language
        $defaultLang = config('admin.language');
        if (is_null($trans_id) && $lang != $defaultLang) {
            msg('The first article must be in the main language.', 'info');
            $this->adminLanguage($defaultLang);
            return redirect()->route("admin.{$this->moduleLower}.create");
        }

        if (is_numeric($trans_id)) {

            $trans = $model::hasTrans($trans_id, $lang)->first();
            if ($trans) {
                msg('This item already exists in the requested language.', 'info');
                return $this->redirect($trans, ['save' => ['edit' => 'Save']]);
            }

            $item = $model::find($trans_id);
            if (!$item) {
                msg('The item which you want to translate does not exist or has been deleted.', 'danger');
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
            msg('The item successfully created.');
            return $this->redirect($item);
        }

        msg('The item has not been created.', 'danger');
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

        $lang = $this->adminLanguage($lang);

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
                'transButtons',
                'statusButton',
                'validationRules',
                'elements',
                'contents',
                'lang'
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

    public function updateItemContent($id)
    {
        $model = $this->modelName;
        $item = $model::find($id);

        if (!$item) {
            msg('The requested item does not exist or has been deleted.', 'danger');
            return redirect()->back();
        }

        $suffix = '_new';
        $prefix = 'val_';

        $fillableContent = new ModelContent;
        $fillableContentValues = new ModelContentValue;
        $fillableContent = $fillableContent->getFillable();
        $fillableContentValues = $fillableContentValues->getFillable();

        $ids = Input::get('id');
        $idsNew = Input::get('id_new');

        $attributesContent = [
            'model_type' => Input::get('model_type'),
            'lang' => Input::get('lang')
        ];

        // Loop through existing ids and update
        if ($ids && $fillableContent) {

            foreach ($ids as $k => $contentId) {

                $modelContent = ModelContent::find($k);

                if ($modelContent) {

                    $attributesContent = [];

                    foreach ($fillableContent as $column) {

                        if (is_array(Input::get($column . '.' . $k, null))) {
                            $attributesContent[$column] = json_encode(Input::get($column . '.' . $k));
                        } elseif (!is_null(Input::get($column . '.' . $k, null))) {
                            $attributesContent[$column] = Input::get($column . '.' . $k);
                        }
                    }

                    // Update content
                    $modelContent->fill($attributesContent);
                    $modelContent->save();

                    // New images
                    if (Input::file($k . '_files_new')) {
                        $imageApi = new ImageApi;
                        $imageApi->setConfig($this->contentImageConfig(isset($attributesContent['type']) ? $attributesContent['type'] : ''));
                        $imageApi->setInputFields('files_new', $k . '_files_new');
                        $imageApi->setInputFields('alt_new', $k . '_alt_new');
                        $imageApi->setModelId($modelContent->id);
                        $imageApi->setModelType(get_class($modelContent));
                        $imageApi->setBaseName("{$this->moduleLower}_{$attributesContent['type']}");
                        $imageApi->setStatus(1);

                        if (!$imageApi->process()) {
                            msg($imageApi->getErrorsAll(), 'danger');
                        }
                    }

                    // Update content values. Check id fields
                    $array = Input::get($prefix . 'id' . '.' . $k, null);

                    if (!is_null($array)) {

                        foreach ($array as $k1 => $value) {

                            $modelContentValue = ModelContentValue::find($k1);

                            if ($modelContentValue) {

                                $attributesValuesTmp = [];

                                foreach ($fillableContentValues as $column) {

                                    // Do not update some columns
                                    if (in_array($column, ['model_content_id', 'order'])) continue;

                                    $input = $prefix . $column . '.' . $k;

                                    $attributesValuesTmp[$column] = Input::get($input . '.' . $k1);
                                }

                                if ($attributesValuesTmp)
                                    $modelContentValue->update($attributesValuesTmp);
                            }
                        }
                    }
                }
            }
        }

        if ($idsNew && $fillableContent) {

            foreach ($idsNew as $k => $null) {

                $attributesValues = [];
                $attributesContent = [];

                $modelContent = new ModelContent;

                $modelContent->model_id = $id;
                $modelContent->model_type = get_class($item);

                foreach ($fillableContent as $column) {

                    if (is_array(Input::get($column . $suffix . '.' . $k, null))) {
                        $attributesContent[$column] = json_encode(Input::get($column . $suffix . '.' . $k));
                    } elseif (!is_null(Input::get($column . $suffix . '.' . $k, null))) {
                        $attributesContent[$column] = Input::get($column . $suffix . '.' . $k);
                    }
                }

                $array = Input::get($prefix . 'value' . $suffix . '.' . $k, null);

                if (!is_null($array)) {

                    $attributesValuesTmp = [];

                    foreach ($array as $k1 => $value) {

                        foreach ($fillableContentValues as $column) {

                            $input = $prefix . $column . $suffix . '.' . $k . '.' . $k1;
                            if (!is_null(Input::get($input, null))) {
                                $attributesValuesTmp[$column] = Input::get($input);
                            }
                        }

                        if ($attributesValuesTmp)
                            $attributesValues[] = new ModelContentValue($attributesValuesTmp);
                    }
                }

                $modelContent->fill($attributesContent);
                $modelContent->save();

                if ($attributesValues)
                    $modelContent->values()->saveMany($attributesValues);

                // Save images
                if (Input::file($k . '_files_new')) {
                    $imageApi = new ImageApi;
                    $imageApi->setConfig($this->contentImageConfig(isset($attributesContent['type']) ? $attributesContent['type'] : ''));
                    $imageApi->setInputFields('files_new', $k . '_files_new');
                    $imageApi->setInputFields('alt_new', $k . '_alt_new');
                    $imageApi->setModelId($modelContent->id);
                    $imageApi->setModelType(get_class($modelContent));
                    $imageApi->setBaseName("{$this->moduleLower}_{$attributesContent['type']}_{$modelContent->id}");
                    $imageApi->setStatus(1);

                    if (!$imageApi->process()) {
                        msg($imageApi->getErrorsAll(), 'danger');
                    }
                }
            }
        }

        // Update alt
        if (Input::get('alt_update')) {
            $imageApi = new ImageApi;
            $imageApi->dbUpdate();
        }

        msg('The item successfully updated.');

        return $this->redirect($item);
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
            'example' => 'Example',
            'gallery' => 'Gallery',
            'video_duo' => 'Video duo',
            'video' => 'Video',
        ];

        asort($elements);

        $contents = ModelContent::where('model_type', $this->modelName)
            ->where('lang', $lang)
            ->where('model_id', 0)
            ->orderBy('order')
            ->get();

        $thisObj = $this;

        $statusButton = function ($item) use ($thisObj) {
            return $thisObj->renderStatusButtons($item);
        };

        view()->share('statusButton', $statusButton);

        return view("{$this->moduleLower}::admin.content", compact('lang', 'elements', 'languages', 'buttonSize', 'contents'));
    }

    public function contentStore($lang = null)
    {

        $suffix = '_new';
        $prefix = 'val_';

        $fillableContent = new ModelContent;
        $fillableContentValues = new ModelContentValue;
        $fillableContent = $fillableContent->getFillable();
        $fillableContentValues = $fillableContentValues->getFillable();

        $ids = Input::get('id');
        $idsNew = Input::get('id_new');

        $attributesContent = [
            'model_type' => Input::get('model_type'),
            'lang' => Input::get('lang')
        ];

        // Loop through existing ids and update
        if ($ids && $fillableContent) {

            foreach ($ids as $k => $id) {

                $modelContent = ModelContent::find($k);

                if ($modelContent) {

                    foreach ($fillableContent as $column) {

                        if (!is_null(Input::get($column . '.' . $k, null))) {
                            $attributesContent[$column] = Input::get($column . '.' . $k);
                        }
                    }

                    // Update content
                    $modelContent->fill($attributesContent);
                    $modelContent->save();

                    // Save images
                    $imageApi = new ImageApi;
                    $imageApi->setConfig($this->contentImageConfig());
                    $imageApi->setInputFields('files_new', $k . '_files_new');
                    $imageApi->setInputFields('alt_new', $k . '_alt_new');
                    $imageApi->setModelId($modelContent->id);
                    $imageApi->setModelType(get_class($modelContent));
                    $imageApi->setBaseName("{$this->moduleLower}_{$attributesContent['type']}");

                    if (!$imageApi->process()) {
                        msg($imageApi->getErrorsAll(), 'danger');
                    }

                    // Update content values. Check id fields
                    $array = Input::get($prefix . 'id' . '.' . $k, null);

                    if (!is_null($array)) {

                        foreach ($array as $k1 => $value) {

                            $modelContentValue = ModelContentValue::find($k1);

                            if ($modelContentValue) {

                                $attributesValuesTmp = [];

                                foreach ($fillableContentValues as $column) {

                                    // Do not update some columns
                                    if (in_array($column, ['model_content_id', 'order'])) continue;

                                    $input = $prefix . $column . '.' . $k;

                                    $attributesValuesTmp[$column] = Input::get($input . '.' . $k1);
                                }

                                if ($attributesValuesTmp)
                                    $modelContentValue->update($attributesValuesTmp);
                            }
                        }
                    }
                }
            }
        }

        // Create new items
        if ($idsNew && $fillableContent) {

            foreach ($idsNew as $k => $null) {

                $attributesValues = [];

                $modelContent = new ModelContent;

                foreach ($fillableContent as $column) {

                    if (!is_null(Input::get($column . $suffix . '.' . $k, null))) {
                        $attributesContent[$column] = Input::get($column . $suffix . '.' . $k);
                    }
                }

                $array = Input::get($prefix . 'value' . $suffix . '.' . $k, null);

                if (!is_null($array)) {

                    $attributesValuesTmp = [];

                    foreach ($array as $k1 => $value) {

                        foreach ($fillableContentValues as $column) {

                            $input = $prefix . $column . $suffix . '.' . $k . '.' . $k1;
                            if (!is_null(Input::get($input, null))) {
                                $attributesValuesTmp[$column] = Input::get($input);
                            }
                        }

                        if ($attributesValuesTmp)
                            $attributesValues[] = new ModelContentValue($attributesValuesTmp);
                    }
                }

                $modelContent->fill($attributesContent);
                $modelContent->save();

                if ($attributesValues)
                    $modelContent->values()->saveMany($attributesValues);

                // Save images
                if (Input::file($k . '_files_new')) {
                    $imageApi = new ImageApi;
                    $imageApi->setConfig($this->contentImageConfig());
                    $imageApi->setInputFields('files_new', $k . '_files_new');
                    $imageApi->setInputFields('alt_new', $k . '_alt_new');
                    $imageApi->setModelId($modelContent->id);
                    $imageApi->setModelType(get_class($modelContent));
                    $imageApi->setBaseName("{$this->moduleLower}_{$attributesContent['type']}");

                    if (!$imageApi->process()) {
                        msg($imageApi->getErrorsAll(), 'danger');
                    }
                }
            }
        }

        return redirect()->back();
    }

    public function contentImageConfig($type = 'image')
    {
        if (config("{$this->moduleLower}.model_content.element.{$type}.image")) {
            return "{$this->moduleLower}.model_content.element.{$type}.image";
        }
        return "{$this->moduleLower}.image";
    }

    public function addElement()
    {
        $element = Input::get('element');

        $formButtons = $this->formButtons($this->formButtons);
        view()->share('formButtons', $formButtons);

        return view("admin::_partials.model_content.template", ['type' => $element]);
    }

}