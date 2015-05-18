<?php

$moduleUpper = get_dirname(__FILE__, 2);
$moduleLower = strtolower($moduleUpper);

return array(

    'under-maintenance' => false,

    'module' => array(
        'layout' => $moduleLower . '::layouts.master',
        'assetsDirModule' => 'assets/' . $moduleLower,
        'moduleLower' => $moduleLower,
        'moduleUpper' => $moduleUpper,
        'theme' => env('THEME', null),
    ),

);