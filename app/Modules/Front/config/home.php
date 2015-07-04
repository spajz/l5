<?php

$moduleUpper = get_dirname(__FILE__, 2);
$moduleLower = strtolower($moduleUpper);

return [

    'under-maintenance' => false,

    'module' => [
        'layout' => $moduleLower . '::layouts.master',
        'assetsDirModule' => 'assets/' . $moduleLower,
        'moduleLower' => $moduleLower,
        'moduleUpper' => $moduleUpper,
        'theme' => env('THEME', null),
    ],

];