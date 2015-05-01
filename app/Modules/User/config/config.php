<?php

$moduleUpper = get_dirname(__FILE__, 2);
$moduleLower = strtolower($moduleUpper);

return array(

    'module' => array(
        'assetsDirModule' => 'assets/' . $moduleLower,
        'moduleLower' => $moduleLower,
        'moduleUpper' => $moduleUpper,
        'modelName' => 'App\Modules\\' . $moduleUpper . '\Models\\' . $moduleUpper,
    ),

);