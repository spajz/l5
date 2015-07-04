<?php

Route::get('front2', array('as' => 'front', 'uses' => 'App\Modules\Front\Controllers\HomeController@index'));

Route::group(['prefix' => LaravelLocalization::setLocale()], function()
{
    Route::get('/', array('as' => 'home', 'uses' => 'App\Modules\Front\Controllers\HomeController@index'));

    Route::get('contact', array('as' => 'contact', 'uses' => 'App\Modules\Front\Controllers\HomeController@contact'));
});







