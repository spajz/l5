<?php namespace App\Modules\Work\Controllers\Admin;

use App\Library\ImageApi;
use App\Modules\Admin\Controllers\AdminController;
use App\Modules\Work\Models\Work as Model;
use App\Modules\Work\Models\WorkTranslation as ModelTranslation;

use Datatables;
use DatatablesFront;
use Former;
use Input;
use Illuminate\Http\Request as HttpRequest;
use App\Models\Content;
use App\Models\ContentValue;

class WorkController extends AdminController
{
    protected $dtColumns = [
        ['name' => 'id', 'className' => 'w40', 'prefix' => 'works'],
        ['name' => 'title', 'columnFilter' => 'text'],
        ['name' => 'sub_title', 'columnFilter' => 'text'],
        ['name' => 'order', 'className' => 'w40'],
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
        $this->viewBase = "{$this->moduleLower}::admin";
    }

    public function getDatatable(DatatablesFront $dtFront)
    {
        $model = $this->modelName;
        $config = $this->config;

        if (isset($this->dtChangeStatus) && !$this->dtChangeStatus) {
            view()->share('changeStatusDisabled', true);
        }

        $columns = $dtFront->createSelectArray($this->dtColumns, ['actions', 'translate']);

        $query = $model::translated()->select($columns);

        return Datatables::of($query)
            ->addColumn('translate', function ($data) use ($dtFront, $model) {
                return $dtFront->renderTranslateButtons($data);
            })
            ->addColumn('featured', function ($data) use ($dtFront, $model) {
                return $dtFront->renderStatusButtons($data, $model, 'featured');
            })
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

        return view("{$this->viewBase}.index", $vars);
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
        $lang = $this->adminLanguage();

        // Add form buttons
        $formButtons = $this->formButtons(__FUNCTION__);

        // Add validation from model to former
        $validationRules = $model::rulesMergeStore();

        return view("{$this->viewBase}.create",
            compact(
                'lang',
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

        $elements = [
            '' => '* Add element',
            'textarea' => 'Text area',
            'rte' => 'Rich text editor',
            'text' => 'Text',
            'text_duo' => 'Text duo',
            'example' => 'Example',
            'gallery' => 'Gallery',
            'video_duo' => 'Video duo',
            'video' => 'Video',
        ];
        asort($elements);

        $contents = $item->contentable;

        return view("{$this->viewBase}.edit",
            compact(
                'item',
                'formButtons',
                'translateButtons',
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

    public function destroyTranslation($id)
    {
        $item = ModelTranslation::find($id);

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

        $fillableContent = new Content;
        $fillableContentValues = new ContentValue;
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

                $modelContent = Content::find($k);

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

                            $modelContentValue = ContentValue::find($k1);

                            if ($modelContentValue) {

                                $attributesValuesTmp = [];

                                foreach ($fillableContentValues as $column) {

                                    // Do not update some columns
                                    if (in_array($column, ['content_id', 'order'])) continue;

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

                $modelContent = new Content;

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
                            $attributesValues[] = new ContentValue($attributesValuesTmp);
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

    public function updateItemContent2($id)
    {
        $model = $this->modelName;
        $item = $model::find($id);

        if (!$item) {
            msg('The requested item does not exist or has been deleted.', 'danger');
            return redirect()->back();
        }

        $suffix = '_new';
        $prefix = 'val_';

        $fillableContent = new Content;
        $fillableContentValues = new ContentValue;
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

                $modelContent = Content::find($k);

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

                            $modelContentValue = ContentValue::find($k1);

                            if ($modelContentValue) {

                                $attributesValuesTmp = [];

                                foreach ($fillableContentValues as $column) {

                                    // Do not update some columns
                                    if (in_array($column, ['content_id', 'order'])) continue;

                                    $input = $prefix . $column . '.' . $k;

                                    $attributesValuesTmp[$column] = Input::get($input . '.' . $k1);
                                }

                                if ($attributesValuesTmp) {
                                    $modelContentValue->fill($attributesValuesTmp);
                                    $modelContentValue->save();
                                }
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

                $modelContent = new Content;

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

                        if ($attributesValuesTmp) {
                            $attributesValues[] = new ContentValue($attributesValuesTmp);
                        }
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

        return $this->redirect($item, null, $this->moduleLower . '.content');
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
                'Title' => $item->title,
                'Sub title' => $item->sub_title,
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

        $contents = Content::where('model_type', $this->modelName)
            ->where('lang', $lang)
            ->where('model_id', 0)
            ->orderBy('order')
            ->get();

        $thisObj = $this;

        $statusButton = function ($item) use ($thisObj) {
            return $thisObj->renderStatusButtons($item);
        };

        view()->share('statusButton', $statusButton);

        return view("{$this->viewBase}.content", compact('lang', 'elements', 'languages', 'buttonSize', 'contents'));
    }

    public function contentStore($lang = null)
    {

        $suffix = '_new';
        $prefix = 'val_';

        $fillableContent = new Content;
        $fillableContentValues = new ContentValue;
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

                $modelContent = Content::find($k);

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

                            $modelContentValue = ContentValue::find($k1);

                            if ($modelContentValue) {

                                $attributesValuesTmp = [];

                                foreach ($fillableContentValues as $column) {

                                    // Do not update some columns
                                    if (in_array($column, ['content_id', 'order'])) continue;

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

                $modelContent = new Content;

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
                            $attributesValues[] = new ContentValue($attributesValuesTmp);
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
        if (config("{$this->moduleLower}.content.element.{$type}.image")) {
            return "{$this->moduleLower}.content.element.{$type}.image";
        }
        return "{$this->moduleLower}.image";
    }

    public function addElement()
    {
        $element = Input::get('element');

        $uploadFileFields = [
            'video_left' => ['mp4', 'wma', 'ogg'],
            'video_right' => ['mp4', 'ogg', 'wma'],
        ];

        $uploadFileFields = array_content_values_sort($uploadFileFields);
        view()->share('uploadFileFields', $uploadFileFields);


        $formButtons = $this->formButtons($this->formButtons);
        view()->share('formButtons', $formButtons);

        return view("admin::_partials.content.template", ['type' => $element]);
    }

    public function contentEdit($id, $lang = null)
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
        $this->formButtonsEdit = array('only' => array('back', 'save'));
        $formButtons = $this->formButtons('edit', $item);
        $translateButtons = $this->renderTranslateButtons($item);
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
            'text_duo' => 'Text duo',
            'example' => 'Example',
            'gallery' => 'Gallery',
            'video_duo' => 'Video duo',
            'video' => 'Video',
        ];
        asort($elements);

        $contents = $item->contentable;

        return view("{$this->viewBase}.content_edit",
            compact(
                'item',
                'formButtons',
                'translateButtons',
                'statusButton',
                'validationRules',
                'elements',
                'contents',
                'lang'
            ));
    }

}