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

    'elementView' => [
        'image_16_9' => 'image',
        'image_4_3' => 'image',
        'gallery_16_9' => 'image',
        'gallery_4_3' => 'image',
    ],

    'element' => [
        'video' => [
            'video' => call_function('asort', ['mp4', 'webm', 'ogg']),
        ],
        'gallery' => [
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
                        'folder' => 'original/', // relative path from main image folder with trailing slash
                        'actions' => [],
                    ],
                    'large' => [
                        'folder' => 'large/', // relative path from main image folder with trailing slash
                        'actions' => [
                            'resize' => [1280, 720, function ($image) {
                                $image->aspectRatio();
                                $image->upsize();
                            }],
                        ],
                    ],
                    'medium' => [
                        'folder' => 'medium/', // relative path from main image folder with trailing slash
                        'actions' => [
                            'resize' => [988, 556, function ($image) {
                                $image->aspectRatio();
                                $image->upsize();
                            }],
                        ],
                    ],
                    'thumb' => [
                        'folder' => 'thumb/',
                        'actions' => [
                            'resize' => [160, 90, function ($image) {
                                $image->aspectRatio();
                                $image->upsize();
                            }],
                        ],
                    ],
                ],
            ],
        ],
        'image_4_3' => [
            'image' => [
                'path' => public_path('media/images') . '/', // main path with trailing slash
                'baseUrl' => url('media/images') . '/',
                'required' => false, // true or false
                'multiple' => true,
                'order' => true, // allow reordering
                'crop' => true, // allow cropping
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
                        'folder' => 'original/', // relative path from main image folder with trailing slash
                        'actions' => [],
                    ],
                    'large' => [
                        'folder' => 'large/', // relative path from main image folder with trailing slash
                        'actions' => [
                            'resize' => [1280, 720, function ($image) {
                                $image->aspectRatio();
                                $image->upsize();
                            }],
                        ],
                    ],
                    'medium' => [
                        'folder' => 'medium/', // relative path from main image folder with trailing slash
                        'actions' => [
                            'resize' => [800, 600, function ($image) {
                                $image->aspectRatio();
                                $image->upsize();
                            }],
                        ],
                    ],
                    'thumb' => [
                        'folder' => 'thumb/',
                        'actions' => [
                            'resize' => [160, 120, function ($image) {
                                $image->aspectRatio();
                                $image->upsize();
                            }],
                        ],
                    ],
                ],
            ],
        ],
        'image_16_9' => function(){
            return config("work.content.element.image_4_3");
        },
        'gallery_4_3' => function(){
            return config("work.content.element.image_4_3");
        },
        'gallery_16_9' => function(){
            return config("work.content.element.image_4_3");
        },
    ],

];