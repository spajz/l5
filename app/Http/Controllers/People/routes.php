<?php

//Route::get('people', 'People\Admin\PeopleController@index');

extract(config('people.module', array()));

Route::group(array("prefix" => ADMIN), function () use ($moduleUpper, $moduleLower) {

    Route::get($moduleLower, array("as" => "admin.{$moduleLower}.index", "uses" => $moduleUpper . '\Admin\\' . "{$moduleUpper}Controller@index"));

    Route::get("{$moduleLower}/create", array("as" => "admin.{$moduleLower}.create", "uses" => $moduleUpper . '\Admin\\' . "{$moduleUpper}Controller@create"));

    Route::get("api/{$moduleLower}/dt", array("as" => "api.{$moduleLower}.dt", "uses" => $moduleUpper . '\Admin\\' . "{$moduleUpper}Controller@getDatatable"));

//
//
//
//    Route::get("{$moduleLower}/{id}/edit", array("as" => "admin.{$moduleLower}.edit", "uses" => $moduleUpper . '\Admin\Controllers\\' . "{$moduleUpper}Controller@edit"));
//
//    Route::get("{$moduleLower}/{id}/destroy", array("as" => "admin.{$moduleLower}.destroy", "uses" => $moduleUpper . '\Admin\Controllers\\' . "{$moduleUpper}Controller@destroy"));
//
//
//
//    Route::post($moduleLower, array("as" => "admin.{$moduleLower}.store", "uses" => $moduleUpper . '\Admin\Controllers\\' . "{$moduleUpper}Controller@store"));
//
//    Route::put("{$moduleLower}/{id}", array("as" => "admin.{$moduleLower}.update", "uses" => $moduleUpper . '\Admin\Controllers\\' . "{$moduleUpper}Controller@update"));
//
//    Route::get("{$moduleLower}/image/{id}/destroy", array("as" => "admin.{$moduleLower}.image.destroy", "uses" => $moduleUpper . '\Admin\Controllers\\' . "{$moduleUpper}Controller@destroyImage"));
//
//
//
//    Route::get("api/{$moduleLower}/image/download/{id}", array("as" => "api.{$moduleLower}.image.download", "uses" => $moduleUpper . '\Admin\Controllers\\' . "{$moduleUpper}Controller@imageDownload"));

});
