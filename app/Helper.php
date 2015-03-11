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
    static public function getModules($state = 'enabled', $return = 'name')
    {
        $modules = array();
        foreach (File::allFiles(app_path('Http/Controllers')) as $file) {
            if ($file->getFilename() == 'module.json') {
                $moduleArray = json_decoder($file->getRealPath());

                switch ($state) {
                    case 'enabled':
                      //static::getModulesReturnType();
                        break;

                    case 'disabled':

                        break;

                    default:
                        if ($return == 'name') {
                            $modules[$moduleJson['order']] = $moduleJson['name'];
                        } else {
                            $modules[$moduleJson['order']] = $file->getPath();
                        }
                }
            }
        }

        ksort($modules);
        return $modules;
    }

    static function getModulesReturnType($moduleArray, $return, $file)
    {
        $modules = array();
        switch($return){
            case 'name':
                $modules[$moduleArray['order']] = $moduleArray['name'];
                break;

            case 'path':
                $modules[$moduleArray['order']] = $file->getPath();
                break;

            case 'array':
                $modules[$moduleArray['order']] = $moduleArray;
                break;

            case 'json':
                $modules[$moduleArray['order']] = $moduleArray['name'];
                break;

        }
        ksort($modules);
        return $modules;
    }
}