<?php

Route::group(['prefix' => ADMIN], function () {

    Route::get('/', ['as' => 'admin', 'uses' => 'App\Modules\Admin\Controllers\AdminController@dashboard']);

    Route::get('api/change-status', ['as' => 'api.admin.change.status', 'uses' => 'App\Modules\Admin\Controllers\AdminController@changeStatus']);

    Route::get('api/change-language/{lang}/{back?}', ['as' => 'api.admin.change.language', 'uses' => 'App\Modules\Admin\Controllers\AdminController@adminLanguage']);

    Route::post('api/sort-rows', ['as' => 'api.admin.sort.rows', 'uses' => 'App\Modules\Admin\Controllers\AdminController@sortRows']);

    Route::post('api/get-model', ['as' => 'api.admin.get.model', 'uses' => 'App\Modules\Admin\Controllers\AdminController@getModel']);

    Route::get('api/get-image/{path}/{config}/{key?}', ['as' => 'api.admin.get.image', 'uses' => 'App\Modules\Admin\Controllers\AdminController@getImage']);

    Route::get('api/image-destroy/{id}/{withImages?}/{force?}', ['as' => 'api.admin.image.destroy', 'uses' => 'App\Modules\Admin\Controllers\AdminController@imageDestroy']);

    Route::post("api/image/crop", ['as' => 'api.admin.image.crop', "uses" => 'App\Modules\Admin\Controllers\AdminController@imageCrop']);

    Route::get('api/add-element', ['as' => 'api.admin.add.element', 'uses' => 'App\Modules\Admin\Controllers\AdminController@addElement']);

    Route::get('api/model-content/destroy/{id?}', ['as' => 'api.admin.model-content.destroy', 'uses' => 'App\Modules\Admin\Controllers\AdminController@modelContentDestroy']);

    Route::post('api/set-session', ['as' => 'api.admin.set.session', 'uses' => 'App\Modules\Admin\Controllers\AdminController@setSession']);
});

Route::get('admin/login', ['as' => 'admin.get.login', 'uses' => 'App\Modules\Admin\Controllers\AuthController@getLogin']);

Route::post('admin/login', ['as' => 'admin.post.login', 'uses' => 'App\Modules\Admin\Controllers\AuthController@postLogin']);

Route::get('admin/logout', ['as' => 'admin.logout', 'uses' => 'App\Modules\Admin\Controllers\AuthController@getLogout']);





