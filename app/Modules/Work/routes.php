<?php

extract(config(strtolower(get_dirname(__FILE__)) . '.module', array()));

// Admin
$namespaceAdmin = 'App\Modules\\' . $moduleUpper . '\Controllers\Admin\\';

Route::group(array("prefix" => ADMIN), function () use ($moduleUpper, $moduleLower, $namespaceAdmin) {

    Route::get($moduleLower, array("as" => "admin.{$moduleLower}.index", "uses" => $namespaceAdmin . "{$moduleUpper}Controller@index"));

    Route::get("{$moduleLower}/create/{id?}/{lang?}", array("as" => "admin.{$moduleLower}.create", "uses" => $namespaceAdmin . "{$moduleUpper}Controller@create"));

    Route::get("{$moduleLower}/{id}/trans/{lang?}", array("as" => "admin.{$moduleLower}.create2", "uses" => $namespaceAdmin . "{$moduleUpper}Controller@createTrans"));

    Route::get("{$moduleLower}/order", array("as" => "admin.{$moduleLower}.order", "uses" => $namespaceAdmin . "{$moduleUpper}Controller@order"));

    Route::get("{$moduleLower}/{id}/edit", array("as" => "admin.{$moduleLower}.edit", "uses" => $namespaceAdmin . "{$moduleUpper}Controller@edit"));

    Route::get("{$moduleLower}/{id}/destroy", array("as" => "admin.{$moduleLower}.destroy", "uses" => $namespaceAdmin . "{$moduleUpper}Controller@destroy"));

    Route::post($moduleLower, array("as" => "admin.{$moduleLower}.store", "uses" => $namespaceAdmin . "{$moduleUpper}Controller@store"));

    Route::put("{$moduleLower}/{id}", array("as" => "admin.{$moduleLower}.update", "uses" => $namespaceAdmin . "{$moduleUpper}Controller@update"));

    Route::get("api/{$moduleLower}/dt", array("as" => "api.{$moduleLower}.dt", "uses" => $namespaceAdmin . "{$moduleUpper}Controller@getDatatable"));

    Route::get("{$moduleLower}/content/{lang?}", array("as" => "admin.{$moduleLower}.content", "uses" => $namespaceAdmin . "{$moduleUpper}Controller@content"));

    Route::post("{$moduleLower}/content/{lang?}", array("as" => "admin.{$moduleLower}.content.store", "uses" => $namespaceAdmin . "{$moduleUpper}Controller@contentStore"));

    Route::put("{$moduleLower}/item/content/update/{id}", array("as" => "admin.{$moduleLower}.item.content.update", "uses" => $namespaceAdmin . "{$moduleUpper}Controller@updateItemContent"));
    Route::put("{$moduleLower}/item/content/update2/{id}", array("as" => "admin.{$moduleLower}.item.content.update2", "uses" => $namespaceAdmin . "{$moduleUpper}Controller@updateItemContent2"));

    Route::get("api/{$moduleLower}/add-element", ['as' => "api.{$moduleLower}.add.element", 'uses' => $namespaceAdmin . "{$moduleUpper}Controller@addElement"]);

//    Route::get("{$moduleLower}/image/{id}/destroy", array("as" => "admin.{$moduleLower}.image.destroy", "uses" => $moduleUpper . '\Admin\Controllers\\' . "{$moduleUpper}Controller@destroyImage"));
//    Route::get("api/{$moduleLower}/image/download/{id}", array("as" => "api.{$moduleLower}.image.download", "uses" => $moduleUpper . '\Admin\Controllers\\' . "{$moduleUpper}Controller@imageDownload"));

});

// Front
$namespaceAdmin = 'App\Modules\\' . $moduleUpper . '\Controllers\\';

Route::group(['prefix' => LaravelLocalization::setLocale()], function () use ($moduleLower, $namespaceAdmin, $moduleUpper) {

    Route::get($moduleLower . '/{slug?}', array("as" => "{$moduleLower}.index", "uses" => $namespaceAdmin . "{$moduleUpper}Controller@index"));

});

