<?php

Route::group(array('prefix' => ADMIN), function () {

    Route::get('/', array('as' => 'admin', 'uses' => 'Admin\AdminController@index'));

    Route::get('change-status', array('as' => 'admin.change.status', 'uses' => 'Admin\AdminController@changeStatus'));

    Route::post('sort-rows', array('as' => 'admin.sort.rows', 'uses' => 'Admin\AdminController@sortRows'));

});

Route::get('admin/login', array('as' => 'admin.login', 'uses' => 'Admin\AdminController@login'));

Route::post('admin/login', array('before' => 'csrf', 'as' => 'admin.login', 'uses' => 'Admin\AdminController@login'));

Route::get('admin/logout', array('as' => 'admin.logout', 'uses' => 'Admin\AdminController@logout'));

