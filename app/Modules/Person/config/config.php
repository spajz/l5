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
        'quality' => 85,
        'allowed_types' => 'jpeg,gif,png',
        'max' => '2000', // max size in kilobytes (0 for no limit)
        'sizes' => array(
            'original' => array(
                'folder' => 'original/', // relative path from main image folder with trailing slash
                'actions' => array(),
            ),
            'large' => array(
                'quality' => 95,
                'folder' => 'large/', // relative path from main image folder with trailing slash
                'actions' => array(
                    'resize' => array(800, 800, function ($image) {
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