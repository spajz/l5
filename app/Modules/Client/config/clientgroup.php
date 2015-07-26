<?php

$moduleUpper = get_dirname(__FILE__, 2);
$moduleLower = strtolower($moduleUpper);

return [

    'module' => [
        'assetsDirModule' => 'assets/' . $moduleLower,
        'mainModuleLower' => $moduleLower,
        'mainModuleUpper' => $moduleUpper,
        'moduleLower' => 'clientgroup',
        'moduleUpper' => 'ClientGroup',
        'moduleTitle' => 'Client Group',
        'modelName' => 'App\Modules\\' . $moduleUpper . '\Models\ClientGroup',
    ],

];