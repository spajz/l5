<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Route;

abstract class Request extends FormRequest
{

//    abstract protected function separateValidation();

    public function rules()
    {
        return $this->rulesType();
    }

    public function rulesAll()
    {
        return array();
    }

    public function rulesUpdate()
    {
        return array();
    }

    public function rulesStore()
    {
        return array();
    }

    protected function rulesType()
    {
        $name = Route::currentRouteName();
        $name = explode('.', $name);

        $rules = $this->rulesAll();

        if (in_array('update', $name)) {
            return array_merge($rules, $this->rulesUpdate());
        }

        return array_merge($rules, $this->rulesStore());
    }
}
