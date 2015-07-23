<?php

$moduleUpper = get_dirname(__FILE__, 2);
$moduleLower = strtolower($moduleUpper);

return [

    'module' => [
        'assetsDirModule' => 'assets/' . $moduleLower,
        'moduleLower' => $moduleLower,
        'moduleUpper' => $moduleUpper,
        'modelName' => 'App\Modules\\' . $moduleUpper . '\Models\\' . $moduleUpper,
    ],

    'image' => [
        'path' => public_path() . '/media/images/', // main path with trailing slash
        'baseUrl' => url('media/images') . '/',
        'required' => false, // true or false
        'multiple' => false,
        'order' => false, // allow reordering
        'crop' => false, // allow cropping
        'baseName' => $moduleLower . '_[:id]', // [:id]
        'filenameFormat' => '', // default: [:base_name]_[:uniqid]
        'quality' => 85,
        'allowedTypes' => 'jpeg,gif,png',
        'max' => '4000', // max size in kilobytes (0 for no limit)
        'mainSize' => 'original', //  required
        'sizes' => [
            'original' => [
                'folder' => 'original/', // relative path from main image folder with trailing slash
                'actions' => [],
            ],
            'large' => [
                'quality' => 95,
                'folder' => 'large/', // relative path from main image folder with trailing slash
                'actions' => [
                    'resize' => [800, 800, function ($image) {
                        $image->aspectRatio();
                        $image->upsize();
                    }],
                ],
            ],
            'medium' => [
                'folder' => 'medium/', // relative path from main image folder with trailing slash
                'actions' => [
                    'resize' => [250, null, function ($image) {
                        $image->aspectRatio();
                        $image->upsize();
                    }],
                ],
            ],
            'thumb' => [
                'folder' => 'thumb/',
                'actions' => [
                    'fit' => [140, 110, function ($image) {
                        $image->aspectRatio();
                        $image->upsize();
                    }],
                ],
            ],
        ],
    ],
];