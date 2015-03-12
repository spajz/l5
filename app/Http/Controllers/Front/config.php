<?php

return array(

    'module' => array(
        'moduleUpper' => 'KidsDeposit',
        'moduleLower' => 'kidsdeposit',
        'modelName' => 'KidsDeposit\Models\KidsDeposit',
        'moduleTitle' => 'Kids Deposit'
    ),

    'image' => array(
        'path' => public_path() . '/media/images/', // main path with trailing slash
        'baseUrl' => url('media/images') . '/',
        'required' => true, // true or false
        'multiple' => false,
        'quality' => 85,
        'allowed_types' => 'jpeg,gif,png',
        'max' => '3000', // max size in kilobytes (0 for no limit)
        'sizes' => array(
            'original' => array(
                'folder' => 'original/', // relative path from main image folder with trailing slash
                'actions' => array(),
            ),
            'large' => array(
                'folder' => 'large/', // relative path from main image folder with trailing slash
                'actions' => array(
                    'resize' => array(1000, 1000, function ($image) {
                        $image->aspectRatio();
                        $image->upsize();
                    }),
                ),
            ),
            'thumb' => array(
                'folder' => 'thumb/',
                'actions' => array(
                    'resize' => array(100, 100, function ($image) {
                        $image->aspectRatio();
                        $image->upsize();
                    }),
                ),
            ),
        ),
    ),
);