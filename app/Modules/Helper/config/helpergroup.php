<?php

$moduleUpper = get_dirname(__FILE__, 2);
$moduleLower = strtolower($moduleUpper);

return [

    'module' => [
        'assetsDirModule' => 'assets/' . $moduleLower,
        'mainModuleLower' => $moduleLower,
        'mainModuleUpper' => $moduleUpper,
        'moduleLower' => 'helpergroup',
        'moduleUpper' => 'HelperGroup',
        'moduleTitle' => 'Helper Group',
        'modelName' => 'App\Modules\\' . $moduleUpper . '\Models\HelperGroup',
    ],

];