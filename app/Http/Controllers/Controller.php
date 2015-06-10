<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;

abstract class Controller extends BaseController
{

    use DispatchesCommands, ValidatesRequests;

    protected $redirectRoute;

    /**
     * Create the response for when a request fails validation.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  array $errors
     * @return \Illuminate\Http\Response
     */
    protected function buildFailedValidationResponse(Request $request, array $errors)
    {
        if ($request->ajax() || $request->wantsJson()) {
//            return new JsonResponse($errors, 422);
        }

        msg($errors, 'danger');
        return redirect()->to($this->getRedirectUrl())
            ->withInput($request->input());
//            ->withErrors($errors, $this->errorBag());
    }

    /**
     * Format the validation errors to be returned.
     *
     * @param  \Illuminate\Validation\Validator $validator
     * @return array
     */
    protected function formatValidationErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }

    /**
     * Get the URL we should redirect to.
     *
     * @return string
     */
    protected function getRedirectUrl()
    {
        if ($this->redirectRoute) return route($this->redirectRoute);

        return app('Illuminate\Routing\UrlGenerator')->previous();
    }

    /**
     * Set the redirect route.
     *
     * @param string $redirectRoute
     * @return string
     */
    public function setRedirectRoute($redirectRoute)
    {
        $this->redirectRoute = $redirectRoute;
    }


}
