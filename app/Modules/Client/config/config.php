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

    'industry' => [
        '' => '* N/A',
        'health-and-beauty' => 'Health & Beauty',
        'food-and-drink' => 'Food & Drink',
        'retail' => 'Retail',
        'industry' => 'Industry',
        'financial-services' => 'Financial Services',
        'tobacco' => 'Tobacco',
        'fuel' => 'Fuel',
        'telecommunication' => 'Telecommunication',
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
        'quality' => 100,
        'allowedTypes' => 'jpeg,gif,png',
        'max' => '4000', // max size in kilobytes (0 for no limit)
        'mainSize' => 'original', //  required
        'saveAs' => 'jpg', // force extension
        'background' => '#882211', // background color (png transaprent to jpg) - optional
        'sizes' => [
            'original' => [
                'folder' => 'original/', // relative path from main image folder with trailing slash
                'actions' => [],
            ],
            'large' => [
//                'saveAs' => 'png', // overwrite extension
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
                'background' => '#2589aa',
                'folder' => 'medium/', // relative path from main image folder with trailing slash
                'actions' => [
                    'resize' => [300, 300, function ($image) {
                        $image->aspectRatio();
                        $image->upsize();
                    }],
                    'resizeCanvas' => [300, 300, 'center', false, 'rgba(0, 0, 0, 0)'],
                ],
            ],
            'thumb' => [
//                'saveAs' => 'jpg', // overwrite extension
//                'background' => '#333333', // background color (png transaprent to jpg) - optional
                'quality' => 100,
                'folder' => 'thumb/',
                'actions' => [
                    'resize' => [120, 120, function ($image) {
                        $image->aspectRatio();
                        $image->upsize();
                    }],
//                    'resizeCanvas' => [120, 120, 'center', false, 'rgba(0, 0, 0, 0)'],
                ],
            ],
        ],
    ],
];