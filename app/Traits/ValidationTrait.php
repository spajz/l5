<?php namespace App\Traits;

use Route;

trait ValidationTrait
{
    public function rules()
    {
        return $this->rulesMerge();
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

    protected function rulesMerge()
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