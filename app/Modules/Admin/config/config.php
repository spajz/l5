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

];