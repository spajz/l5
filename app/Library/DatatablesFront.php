<?php namespace App\Library;

//use yajra\Datatables\Datatables as BaseDatatables;

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
    protected $options;
    protected $callbacks;

    public static function init()
    {
        return new static;
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
        echo $url;
        $this->url = $url;

    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setClass($class)
    {
        $this->class = $class;
    }

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
}