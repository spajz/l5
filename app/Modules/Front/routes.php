<?php

Route::get('front2', array('as' => 'front', 'uses' => 'App\Modules\Front\Controllers\HomeController@index'));

Route::group(['prefix' => LaravelLocalization::setLocale()], function()
{
    Route::get('front', array('as' => 'front', 'uses' => 'App\Modules\Front\Controllers\HomeController@index'));
});







