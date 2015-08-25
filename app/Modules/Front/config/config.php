<?php

$moduleUpper = get_dirname(__FILE__, 2);
$moduleLower = strtolower($moduleUpper);
$theme = env('THEME', null);
$theme = $theme == 'default' ? null : $theme;

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
        'buildPath' => $theme ? 'assets/' . $moduleLower . '/_themes/' . $theme : 'assets/' . $moduleLower,
        'assetsDirTheme' => 'assets/' . $moduleLower . '/_themes/' . $theme,
        'theme' => $theme,
    ],

];