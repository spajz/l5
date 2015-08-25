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
        'column_1' => 'Column 1/3',
        'column_2' => 'Column 2/3',
        'column_1_pull' => 'Column 1/3 pull',
        'column_2_pull' => 'Column 2/3 pull',
        'column_1_push' => 'Column 1/3 push',
        'column_2_push' => 'Column 2/3 push',
        'full' => 'Full',
        'center' => 'Center',
    ],

];