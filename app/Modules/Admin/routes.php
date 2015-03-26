<?php

Route::group(array('prefix' => ADMIN), function () {

    Route::get('/', array('as' => 'admin', 'uses' => 'App\Modules\Admin\Controllers\AdminController@index'));

    Route::get('api/change-status', array('as' => 'api.admin.change.status', 'uses' => 'App\Modules\Admin\Controllers\AdminController@changeStatus'));

    Route::post('api/sort-rows', array('as' => 'api.admin.sort.rows', 'uses' => 'App\Modules\Admin\Controllers\AdminController@sortRows'));

});

Route::get('admin/login', array('as' => 'admin.login', 'uses' => 'App\Modules\Admin\Controllers\AdminController@login'));

Route::post('admin/login', array('before' => 'csrf', 'as' => 'admin.login', 'uses' => 'App\Modules\Admin\Controllers\AdminController@login'));

Route::get('admin/logout', array('as' => 'admin.logout', 'uses' => 'App\Modules\Admin\Controllers\AdminController@logout'));




