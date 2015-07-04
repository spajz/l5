<?php namespace App\Library;

use Config;

class DatatablesFront
{

    protected $template;
    protected $javascript;
    protected $actionButtons;
    protected $statusButtons;
    protected $transButtons;
    protected $url;
    protected $id;
    protected $class;
    protected $options = [];
    protected $callbacks = [];
    protected $columns = [];
    protected $searchColumns = [];
    protected $columnFilters = [];
    protected $modelName;
    protected $thClass = [];
    protected $tfClass = [];
    protected $buttonSize = 'btn-xs';

    public function __construct()
    {
        $this->setId();
        $this->template = Config::get('datatables.views.template');
        $this->javascript = Config::get('datatables.views.javascript');
        $this->actionButtons = Config::get('datatables.views.actionButtons');
        $this->statusButtons = Config::get('datatables.views.statusButtons');
        $this->transButtons = Config::get('datatables.views.transButtons');
    }

    public function setTemplate($template)
    {
        $this->template = $template;
        return $this;
    }

    public function setJavascript($javascript)
    {
        $this->javascript = $javascript;
        return $this;
    }

    public function setActionButtons($buttons)
    {
        $this->actionButtons = $buttons;
        return $this;
    }

    public function setStatusButtons($buttons)
    {
        $this->statusButtons = $buttons;
        return $this;
    }

    public function setUrl($url)
    {
        $this->options['ajax'] = $url;
        $this->options['serverSide'] = true;
        return $this;
    }

    public function setId($id = null)
    {
        $this->id = empty($id) ? str_random(8) : $id;
        return $this;
    }

    public function setClass($class)
    {
        $this->class = $class;
        return $this;
    }

    public function setModelName($modelName)
    {
        $this->modelName = $modelName;
        return $this;
    }

    public function setThClass($key, $value = null)
    {
        if (is_array($key)) {
            $this->thClass = array_merge($this->thClass, $key);
        } else {
            $this->thClass[$key] = $value;
        }
        return $this;
    }

    public function setTfClass($key, $value = null)
    {
        if (is_array($key)) {
            $this->tfClass = array_merge($this->tfClass, $key);
        } else {
            $this->tfClass[$key] = $value;
        }
        return $this;
    }

    public function setButtonSize($size)
    {
        $this->buttonSize = $size;
        return $this;
    }

    public function addColumns($columns)
    {
        foreach ($columns as &$column) {
            if (isset($column['actionColumn'])) {
                $column['orderable'] = false;
                $column['searchable'] = false;
                unset($column['actionColumn']);
            }

            if (isset($column['thClass'])) {
                $this->setThClass($column['name'], $column['thClass']);
                unset($column['thClass']);
            }

            if (isset($column['tfClass'])) {
                $this->setTfClass($column['name'], $column['tfClass']);
                unset($column['tfClass']);
            }

            if (!isset($column['data'])) $column['data'] = $column['name'];
            if (!isset($column['title'])) {
                $column['title'] = ucfirst_replace($column['data']);
            }

            if (isset($column['columnFilter'])) {
                $this->setColumnFilters($column['name'], $column['columnFilter']);
            }
        }
        $this->columns = $columns;
        return $this;
    }

    public function setColumnFilters($column, $type = 'text')
    {
        $this->columnFilters[$column] = $type;
    }

    public function searchColumns()
    {
        $this->searchColumns = func_get_args();
        return $this;
    }

    private function prepareColumns()
    {
        //'orderable' => false, 'searchable' => false,
        if (!empty($this->searchColumns)) {
            foreach ($this->columns as &$column) {
                if (in_array($column['data'], $this->searchColumns)) {
                    $column['searchable'] = true;
                } else {
                    $column['searchable'] = false;
                }
            }
        }
    }

//    public function addColumn()
//    {
//        foreach (func_get_args() as $title) {
//            if (is_array($title)) {
//                foreach ($title as $mapping => $arrayTitle) {
//                    $this->columns[] = $arrayTitle;
//                    $this->aliasColumns[] = $mapping;
//                    if (is_string($mapping)) {
//                        $this->createdMapping = false;
//                    }
//                }
//            } else {
//                $this->columns[] = $title;
//                $this->aliasColumns[] = count($this->aliasColumns) + 1;
//            }
//        }
//        return $this;
//    }

    public function setOptions()
    {
        if (func_num_args() == 2) {
            $this->options[func_get_arg(0)] = func_get_arg(1);
        } else if (func_num_args() == 1 && is_array(func_get_arg(0))) {
            foreach (func_get_arg(0) as $key => $option) {
                $this->options[$key] = $option;
            }
        } else
            throw new Exception('Invalid number of options provided for the method "setOptions"');
        return $this;
    }

    public function setCallbacks()
    {
        if (func_num_args() == 2) {
            $this->callbacks[func_get_arg(0)] = func_get_arg(1);
        } else if (func_num_args() == 1 && is_array(func_get_arg(0))) {
            foreach (func_get_arg(0) as $key => $value) {
                $this->callbacks[$key] = $value;
            }
        } else
            throw new Exception('Invalid number of callbacks provided for the method "setCallbacks"');

        return $this;
    }

    public function render()
    {
        $this->prepareColumns();
        $this->options['columns'] = $this->columns;
        $options = array_merge(Config::get('datatables.default.options'), $this->options);
        $callbacks = array_merge(Config::get('datatables.default.callbacks'), $this->callbacks);

        $out['dtTable'] = view($this->template, array(
            'id' => $this->id,
            'class' => $this->class,
            'columns' => $this->columns,
            'thClass' => $this->thClass,
            'tfClass' => $this->tfClass,
        ));

        $out['dtJavascript'] = view($this->javascript, array(
            'id' => $this->id,
            'options' => $options,
            'callbacks' => $callbacks,
            'columnFilters' => $this->columnFilters,
            'modelName' => $this->modelName,
        ));

        return $out;
    }

    public function renderActionButtons($data)
    {
        return view($this->actionButtons, array('data' => $data, 'buttonSize' => $this->buttonSize))->render();
    }

    public function renderTransButtons($item)
    {
        $languages = Config::get('admin.languages');

        $transRelated = $item->transRelated();

        $buttonSize = $this->buttonSize;

        return view($this->transButtons, compact('item', 'languages', 'transRelated', 'buttonSize'))->render();
    }

    public function renderStatusButtons($data, $model = null, $column = 'status')
    {
        return view($this->statusButtons,
            ['data' => $data, 'model' => $model, 'buttonSize' => $this->buttonSize, 'column' => $column])
            ->render();
    }

}