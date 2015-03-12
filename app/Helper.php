<?php namespace App;

use File;

class Helper
{
    /*
     * Get modules (enabled, disabled, all)
     *
     * @param string $state
     * @param string $return
     * @return array $modules
     */
    static public function getModules($state = 'enabled', $return = 'name', $module = null)
    {
        $modules = array();
        foreach (File::allFiles(app_path('Http/Controllers')) as $file) {
            if ($file->getFilename() == 'module.json') {
                $moduleArray = json_decoder($file->getRealPath());

                switch ($state) {
                    case 'enabled':
                        if ($moduleArray['enabled'])
                            $modules[$moduleArray['order']] = static::getModulesReturnType($moduleArray, $return, $file);
                        break;

                    case 'disabled':
                        if (!$moduleArray['enabled'])
                            $modules[$moduleArray['order']] = static::getModulesReturnType($moduleArray, $return, $file);
                        break;

                    default:
                        $modules[$moduleArray['order']] = static::getModulesReturnType($moduleArray, $return, $file);
                }
            }
        }

        ksort($modules);
        return $modules;
    }

    static function getModulesReturnType($moduleArray, $return, $file)
    {
        $modules = array();
        switch ($return) {
            case 'name':
                return $moduleArray['name'];
                break;

            case 'path':
                return $file->getPath();
                break;

            case 'array':
                $moduleArray['path'] = $file->getPath();
                return $moduleArray;
                break;

        }
        ksort($modules);
        return $modules;
    }
}