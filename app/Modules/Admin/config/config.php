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

    'baseUrl' => 'admin',

    'module' => array(
        'layout' => $moduleLower . '::layouts.master',
        'assetsDirAdmin' => 'assets/' . $moduleLower,
        'moduleLower' => $moduleLower,
        'moduleUpper' => $moduleUpper,
    ),

);