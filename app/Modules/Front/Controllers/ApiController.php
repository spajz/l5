<?php namespace App\Modules\Front\Controllers;

use Input;

class ApiController extends FrontController
{
    public function colorSave()
    {
        $colorsCookie = cookie()->make('colors', json_encode(Input::get('colors')), 120);
        return response()->json(['ok'])->withCookie($colorsCookie);
    }
}