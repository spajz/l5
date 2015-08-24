<?php

$moduleUpper = get_dirname(__FILE__, 2);
$moduleLower = strtolower($moduleUpper);

return [

    'under-maintenance' => false,

    'language' => 'sr',

    'languages' => [
        'sr' => 'Srpski',
        'en' => 'English',
    ],

    'baseUrl' => 'admin',

    'module' => [
        'layout' => $moduleLower . '::layouts.master',
        'assetsDirAdmin' => 'assets/' . $moduleLower,
        'moduleLower' => $moduleLower,
        'moduleUpper' => $moduleUpper,
        'buildPath' => '/assets/' . $moduleLower,
    ],

    'contentPosition' => [
        'left_1' => 'Left 1/3',
        'left_2' => 'Left 2/3',
        'right_1' => 'Right 1/3',
        'right_2' => 'Right 2/3',
        'left_1_pull' => 'Left 1/3 pull',
        'left_2_pull' => 'Left 2/3 pull',
        'right_1_push' => 'Right 1/3 push',
        'right_2_push' => 'Right 2/3 push',
        'full' => 'Full',
        'center' => 'Center',
    ],

];