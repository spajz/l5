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
        'path' => public_path('media/images') . '/', // main path with trailing slash
        'baseUrl' => url('media/images') . '/',
        'required' => false, // true or false
        'multiple' => false,
        'order' => false, // allow reordering
        'crop' => true, // allow cropping
        'baseName' => $moduleLower . '_[:id]', // [:id]
        'filenameFormat' => '', // default: [:base_name]_[:uniqid]
        'quality' => 85,
        'allowedTypes' => 'jpeg,gif,png',
        'max' => '4000', // max size in kilobytes (0 for no limit)
        'mainSize' => 'original', //  required
        'saveAs' => '', // force extension
        'background' => '', // background color (transaprent to color background) - optional
        'sizes' => [
            'original' => [
                'folder' => 'original/', // relative path from main image folder with trailing slash
                'actions' => [],
            ],
            'large' => [
                'saveAs' => 'jpg',
                'background' => '#ffffff',
                'quality' => 95,
                'folder' => 'large/', // relative path from main image folder with trailing slash
                'actions' => [
                    'resize' => [800, 800, function ($image) {
                        $image->aspectRatio();
                        $image->upsize();
                    }],
                ],
            ],
            'thumb' => [
                'saveAs' => 'jpg',
                'background' => '#ffffff',
                'quality' => 95,
                'folder' => 'thumb/',
                'actions' => [
                    'resize' => [150, 150, function ($image) {
                        $image->aspectRatio();
                        $image->upsize();
                    }],
                    'resizeCanvas' => [150, 150, 'center', false, 'rgba(0, 0, 0, 0)'],
                ],
            ],
        ],
    ],
    'type' => [
        'none' => 'None',
        'default' => 'Default',
        'image' => 'Image',
    ],
];