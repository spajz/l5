<?php

extract(config(strtolower(get_dirname(__FILE__)) . '.module', array()));

// Front
$namespaceAdmin = 'App\Modules\\' . $moduleUpper . '\Controllers\\';

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect']
    ],
    function () use ($moduleLower, $namespaceAdmin, $moduleUpper) {
        Route::get($moduleLower, array("as" => "{$moduleLower}.index", "uses" => $namespaceAdmin . "{$moduleUpper}Controller@index"));
    }
);

// Admin
$namespaceAdmin = 'App\Modules\\' . $moduleUpper . '\Controllers\Admin\\';

Route::group(array("prefix" => 'admin'), function () use ($moduleUpper, $moduleLower, $namespaceAdmin) {

    Route::get($moduleLower, array("as" => "admin.{$moduleLower}.index", "uses" => $namespaceAdmin . "{$moduleUpper}Controller@index"));

    Route::get("{$moduleLower}/create", array("as" => "admin.{$moduleLower}.create", "uses" => $namespaceAdmin . "{$moduleUpper}Controller@create"));

    Route::get("{$moduleLower}/order", array("as" => "admin.{$moduleLower}.order", "uses" => $namespaceAdmin . "{$moduleUpper}Controller@order"));

    Route::get("{$moduleLower}/{id}/edit", array("as" => "admin.{$moduleLower}.edit", "uses" => $namespaceAdmin . "{$moduleUpper}Controller@edit"));

    Route::get("{$moduleLower}/{id}/destroy", array("as" => "admin.{$moduleLower}.destroy", "uses" => $namespaceAdmin . "{$moduleUpper}Controller@destroy"));

    Route::post($moduleLower, array("as" => "admin.{$moduleLower}.store", "uses" => $namespaceAdmin . "{$moduleUpper}Controller@store"));

    Route::put("{$moduleLower}/{id}", array("as" => "admin.{$moduleLower}.update", "uses" => $namespaceAdmin . "{$moduleUpper}Controller@update"));

    Route::get("api/{$moduleLower}/dt", array("as" => "api.{$moduleLower}.dt", "uses" => $namespaceAdmin . "{$moduleUpper}Controller@getDatatable"));

    // Submodule ClientGroup
    if (config("{$moduleLower}.clientgroup")) {

        extract(config("{$moduleLower}.clientgroup.module", array()));

        Route::get($moduleLower, array("as" => "admin.{$moduleLower}.index", "uses" => $namespaceAdmin . "{$moduleUpper}Controller@index"));

        Route::get("{$moduleLower}/create", array("as" => "admin.{$moduleLower}.create", "uses" => $namespaceAdmin . "{$moduleUpper}Controller@create"));

        Route::get("{$moduleLower}/order", array("as" => "admin.{$moduleLower}.order", "uses" => $namespaceAdmin . "{$moduleUpper}Controller@order"));

        Route::get("{$moduleLower}/{id}/edit", array("as" => "admin.{$moduleLower}.edit", "uses" => $namespaceAdmin . "{$moduleUpper}Controller@edit"));

        Route::get("{$moduleLower}/{id}/destroy", array("as" => "admin.{$moduleLower}.destroy", "uses" => $namespaceAdmin . "{$moduleUpper}Controller@destroy"));

        Route::post($moduleLower, array("as" => "admin.{$moduleLower}.store", "uses" => $namespaceAdmin . "{$moduleUpper}Controller@store"));

        Route::put("{$moduleLower}/{id}", array("as" => "admin.{$moduleLower}.update", "uses" => $namespaceAdmin . "{$moduleUpper}Controller@update"));

        Route::get("api/{$moduleLower}/dt", array("as" => "api.{$moduleLower}.dt", "uses" => $namespaceAdmin . "{$moduleUpper}Controller@getDatatable"));
    }

});