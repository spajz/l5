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
        'crop' => false, // allow cropping
        'baseName' => $moduleLower . '_[:id]', // [:id]
        'filenameFormat' => '', // default: [:base_name]_[:uniqid]
        'quality' => 80,
        'allowedTypes' => 'jpeg,gif,png',
        'max' => '4000', // max size in kilobytes (0 for no limit)
        'mainSize' => 'original', //  required
        'saveAs' => '', // force extension
        'background' => '', // background color (transparent to color background) - optional
        'sizes' => [
            'original' => [
                'quality' => 100,
                'folder' => 'original/', // relative path from main image folder with trailing slash
                'actions' => [],
            ],
            'large' => [
                'folder' => 'large/', // relative path from main image folder with trailing slash
                'actions' => [],
            ],
            'medium' => [
                'folder' => 'medium/', // relative path from main image folder with trailing slash
                'actions' => [
                    'resize' => [null, 350, function ($image) {
                        $image->aspectRatio();
                        $image->upsize();
                    }],
                ],
            ],
            'thumb' => [
                'folder' => 'thumb/',
                'actions' => [
                    'resize' => [null, 200, function ($image) {
                        $image->aspectRatio();
                        $image->upsize();
                    }],
                ],
            ],
            'preview' => [
                'quality' => 75,
                'folder' => 'preview/',
                'actions' => [
                    'resize' => [null, 200, function ($image) {
                        $image->aspectRatio();
                        $image->upsize();
                    }],
                    'crop' => [200, 200, 0, 0],
                ],
            ],
        ],
        'dynamic' => [ // Get(resize) image on the fly
            '0' => [
                'responseAs' => 'jpg',
                'quality' => 75,
                'actions' => [
                    'crop' => [200, 200, 0, 0],
                ],
            ]
        ]
    ],
];