<?php

$moduleUpper = get_dirname(__FILE__, 2);
$moduleLower = strtolower($moduleUpper);

return [

    'under-maintenance' => false,

    'language' => 'sr',

    'languages' => [
        'sr' => 'srpski',
        'en' => 'english',
    ],

    'module' => [
        'layout' => $moduleLower . '::layouts.master',
        'assetsDirFront' => 'assets/' . $moduleLower,
        'moduleLower' => $moduleLower,
        'moduleUpper' => $moduleUpper,
        'buildPath' => '/assets/' . $moduleLower,
        'theme' => env('THEME', null),
    ],

];