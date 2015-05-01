<?php

$moduleUpper = get_dirname(__FILE__, 2);
$moduleLower = strtolower($moduleUpper);

return array(

    'module' => array(
        'layout' => $moduleLower . '::layouts.auth',
        'assetsDirAdmin' => 'assets/' . $moduleLower,
        'moduleLower' => $moduleLower,
        'moduleUpper' => $moduleUpper,
    ),

);