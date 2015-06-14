<?php

$moduleUpper = get_dirname(__FILE__, 2);
$moduleLower = strtolower($moduleUpper);

return array(

    'module' => array(
        'assetsDirModule' => 'assets/' . $moduleLower,
        'moduleLower' => $moduleLower,
        'moduleUpper' => $moduleUpper,
        'modelName' => 'App\Modules\\' . $moduleUpper . '\Models\\' . $moduleUpper,
    ),

    'image' => array(
        'path' => public_path() . '/media/images/', // main path with trailing slash
        'baseUrl' => url('media/images') . '/',
        'required' => false, // true or false
        'multiple' => true,
        'order' => true, // allow reordering
        'crop' => true, // allow cropping
        'baseName' => $moduleLower, // image base name
        'filenameFormat' => '', // default: [:base_name]_[:uniqid]
        'quality' => 85,
        'allowedTypes' => 'jpeg,gif,png',
        'max' => '4000', // max size in kilobytes (0 for no limit)
        'mainSize' => 'original', //  required
        'sizes' => array(
            'original' => array(
                'folder' => 'original/', // relative path from main image folder with trailing slash
                'actions' => array(),
            ),
            'large' => array(
                'quality' => 95,
                'folder' => 'large/', // relative path from main image folder with trailing slash
                'actions' => array(
                    'resize' => array(630, 580, function ($image) {
                        $image->aspectRatio();
                        $image->upsize();
                    }),
                ),
            ),
            'medium' => array(
                'folder' => 'medium/', // relative path from main image folder with trailing slash
                'actions' => array(
                    'resize' => array(250, null, function ($image) {
                        $image->aspectRatio();
                        $image->upsize();
                    }),
                ),
            ),
            'thumb' => array(
                'folder' => 'thumb/',
                'actions' => array(
                    'fit' => array(140, 110, function ($image) {
                        $image->aspectRatio();
                        $image->upsize();
                    }),
                ),
            ),
        ),
    ),
);