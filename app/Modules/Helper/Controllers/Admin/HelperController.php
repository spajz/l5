<?php namespace App\Modules\Helper\Controllers\Admin;

use App\Library\ImageApi;
use App\Modules\Admin\Controllers\AdminController;
use App\Modules\Helper\Models\Helper as Model;
use App\Modules\Helper\Models\HelperGroup;

use Datatables;
use DatatablesFront;
use Former;
use Input;
use Illuminate\Http\Request as HttpRequest;
use Html;
use File;

class HelperController extends AdminController
{
    protected $contentPath;
    protected $files = array('form.blade.php', 'functions.php', 'result.blade.php');

    protected $dtColumns = [
        ['name' => 'id', 'className' => 'w40', 'prefix' => 'helpers'],
        ['name' => 'image', 'actionColumn' => true],
        ['name' => 'title', 'columnFilter' => 'text', 'prefix' => 'helpers'],
        ['name' => 'title', 'data' => 'group', 'columnFilter' => 'text', 'title' => 'Group', 'prefix' => 'helper_groups'],
        ['name' => 'type', 'columnFilter' => 'text', 'prefix' => 'helpers'],
        ['name' => 'featured', 'className' => 'w40 text-center', 'prefix' => 'helpers'],
        ['name' => 'status', 'className' => 'w40 text-center', 'prefix' => 'helpers'],
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
        $this->viewPath = app_path('Modules/' . $this->moduleUpper . '/views');
        $this->contentPath = app_path('Modules/' . $this->moduleUpper . '/views/content');
    }

    public function getDatatable(DatatablesFront $dtFront)
    {
        $model = $this->modelName;
        $config = $this->config;

        if (isset($this->dtChangeStatus) && !$this->dtChangeStatus) {
            view()->share('changeStatusDisabled', true);
        }

        $columns = $dtFront->createSelectArray($this->dtColumns, ['actions', 'image']);

        $query = $model::with('images')->join('helper_groups', 'helpers.helper_group_id', '=', 'helper_groups.id')
            ->select($columns);

        return Datatables::of($query)
            ->addColumn('image', function ($data) use ($dtFront, $config) {
                $out = 'N/A';
                $img = isset($data->images[0]) ? $data->images[0] : null;
                if ($img && is_file(array_get($config, 'image.path') . 'thumb/' . image_filename($img, 'thumb'))) {
                    $out = '<a href="' . array_get($config, 'image.baseUrl') . 'large/' . image_filename($img, 'large') . '" class="fancybox" rel="gallery">' .
                        Html::image(array_get($config, 'image.baseUrl') . 'thumb/' . image_filename($img, 'thumb'),
                            '',
                            array(
                                'class' => 'img-responsive col-centered img-thumbnail',
                            )
                        ) .
                        '</a>';
                }
                return $out;
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

        $formButtons = $this->formButtons(__FUNCTION__);

        // Add validation from model to former
        $validationRules = $model::rulesMergeStore();
        $groups = HelperGroup::orderBy('title')->lists('title', 'id')->toArray();

        return view("{$this->viewBase}.create",
            compact(
                'formButtons',
                'validationRules',
                'groups'
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

            $this->copyTemplateFiles(Input::get('type'), $item->id);

            return $this->redirect($item);
        }

        msg('The item has not been created.', 'danger');
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @param  File $filesystem
     * @return Response
     */
    public function edit($id, File $filesystem)
    {
        $model = $this->modelName;
        $item = $model::find($id);

        if (!$item) {
            msg('The requested item does not exist or has been deleted.', 'danger');
            return redirect()->route("admin.{$this->moduleLower}.index");
        }

        $thisObj = $this;
        Former::populate($item);
        $formButtons = $this->formButtons(__FUNCTION__, $item, null);
        $statusButton = function ($item) use ($thisObj) {
            return $thisObj->renderStatusButtons($item);
        };

        // Add validation from model to former
        $validationRules = $model::rulesMergeUpdate();
        $groups = HelperGroup::orderBy('title')->lists('title', 'id')->toArray();

        // Check content
        $files = [];
        $contentFiles = [];
        $deleteFiles = [];
        $contentPath = $this->contentPath . '/' . $id;
        if ($filesystem::isDirectory($contentPath)) {
            $files = $filesystem::files($contentPath);
        }

        foreach ($files as $file) {
            $baseName = basename($file);
            $contentFiles[$baseName] = $filesystem::get($file);
            $deleteFiles[$baseName] = [
                'name' => 'delete_files[]',
                'value' => $baseName,
            ];
        }

        return view("{$this->viewBase}.edit",
            compact(
                'item',
                'formButtons',
                'statusButton',
                'validationRules',
                'groups',
                'contentFiles',
                'deleteFiles'
            ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param \Illuminate\Http\Request $request
     * @param File $filesystem
     * @return Response
     */
    public function update($id, HttpRequest $request, File $filesystem)
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

        // Change type or update
        $contentPath = $this->contentPath . '/' . $id;
        if ($item->type != Input::get('type') || !$filesystem::isDirectory($contentPath)) {
            $this->copyTemplateFiles(Input::get('type'), $id);
        } else {
            // Delete files
            if($deleteFiles = Input::get('delete_files')){
                foreach($deleteFiles as $deleteFile){
                    $filesystem::delete($contentPath . '/' . $deleteFile);
                }
            }

            // Update files
            $files = $this->getFiles($id);
            foreach ($files as $file) {
                if (Input::get(base64_encode($file), false) !== false) {
                    $filesystem::put($contentPath . '/' . $file, Input::get(base64_encode($file)));
                }
            }

            // Add custom file
            if($addCustomFile = Input::get('add_custom_file')){
                if(strpos($addCustomFile, ',')){
                    $customFiles = explode(',', $addCustomFile);
                } else {
                    $customFiles[] = $addCustomFile;
                }
                foreach($customFiles as $customFile){
                    $filesystem::put($contentPath . '/' . $customFile, '');
                }
            }
        }

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
                'Title' => $item->title,
                'Group' => $item->group->title,
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

    protected function copyTemplateFiles($type, $id)
    {
        // Delete old template files
        if (is_numeric($id)) {

            $contentPath = $this->contentPath . '/' . $id;

            // Delete dir for none type
            if ($type == 'none') {
                if (File::isDirectory($contentPath)) {
                    File::deleteDirectory($contentPath);
                }
                return;
            }

            if (!File::isDirectory($contentPath)) {
                File::makeDirectory($contentPath);
            }

            // Delete existing files
            $contentFiles = $this->getFiles($id);
            if ($contentFiles) {
                foreach ($contentFiles as $file) {
                    File::delete($file);
                }
            }

            // Copy template files
            $templateFiles = File::files($this->viewPath . '/type/' . $type);
            if ($templateFiles) {
                foreach ($templateFiles as $file) {
                    $baseName = basename($file);
                    File::copy($file, $contentPath . '/' . $baseName);
                }
            }
        }
    }

    protected function getFiles($id)
    {
        $out = [];
        $contentPath = $this->contentPath . '/' . $id;

        if (!File::isDirectory($contentPath)) return $out;

        return File::files($contentPath);
    }

}