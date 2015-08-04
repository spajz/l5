<?php

Route::get('front2', array('as' => 'front', 'uses' => 'App\Modules\Front\Controllers\HomeController@index'));

Route::group(['prefix' => LaravelLocalization::setLocale()], function()
{
    Route::get('/', array('as' => 'home', 'uses' => 'App\Modules\Front\Controllers\HomeController@index'));
    Route::post('api/color/save', array('as' => 'api.color.save', 'uses' => 'App\Modules\Front\Controllers\ApiController@colorSave'));

    Route::get('contact', array('as' => 'contact', 'uses' => 'App\Modules\Front\Controllers\HomeController@contact'));
});







