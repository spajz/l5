<?php namespace App\Library;

use Config;

class DatatablesFront
{

//->addColumn('ID', 'Image', 'Full Name', 'Email', 'Friend Email', 'Age', 'Likes', 'FB ID', 'Status', 'Actions')
//->setUrl(route("api.{$this->moduleLower}.dt"))
//            ->setOptions('order', array(0, "desc"))
//    ->setId('table_' . $this->moduleLower)
//    ->noScript()
//    ->setCallbacks(

    protected $template = 'admin.views.datatable.template';
    protected $javascript = 'admin.views.datatable.javascript';
    protected $url;
    protected $id;
    protected $class;
    protected $options = array();
    protected $callbacks = array();
    protected $columns = array();

    public function __construct()
    {
        $this->setId();
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

    public function addColumns($columns)
    {
        foreach ($columns as &$column) {
            if (!isset($column['title'])) {
                $column['title'] = ucfirst(str_replace('_', ' ', $column['data']));
            }
        }
        $this->columns = $columns;
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
        $this->options['columns'] = $this->columns;
        $options = array_merge(Config::get('datatables.default.options'), $this->options);
        $callbacks = array_merge(Config::get('datatables.default.callbacks'), $this->callbacks);

        $out['dtTable'] = view($this->template, array(
            'id' => $this->id,
            'class' => $this->class,
            'columns' => $this->columns,
        ));

        $out['dtJavascript'] = view($this->javascript, array(
            'id' => $this->id,
            'options' => $options,
            'callbacks' => $callbacks,
        ));

        return $out;
    }

}