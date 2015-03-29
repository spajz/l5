<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Validator;

abstract class Request extends FormRequest
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

    public function response(array $errors)
    {
        if ($this->ajax() || $this->wantsJson()) {
            return new JsonResponse($errors, 422);
        }

        msg($errors, 'danger');
        return $this->redirector->to($this->getRedirectUrl())
            ->withInput($this->except($this->dontFlash));
//            ->withErrors($errors, $this->errorBag);
    }

    public function setRedirectRoute($redirectRoute)
    {
        $this->redirectRoute = $redirectRoute;
    }

    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }
}
