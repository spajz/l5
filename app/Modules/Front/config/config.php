<?php

$moduleUpper = get_dirname(__FILE__, 2);
$moduleLower = strtolower($moduleUpper);

return array(

    'under-maintenance' => false,

    'language' => 'sr',

    'languages' => [
        'sr',
        'en',
        'de',
    ],

    'module' => array(
        'layout' => $moduleLower . '::layouts.master',
        'assetsDirFront' => 'assets/' . $moduleLower,
        'moduleLower' => $moduleLower,
        'moduleUpper' => $moduleUpper,
        'buildPath' => '/modules/' . $moduleLower,
        'theme' => env('THEME', null),
    ),

);