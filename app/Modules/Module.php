<?php namespace App\Modules;

use Illuminate\Support\ServiceProvider;
use File;
use Lang;

class Module extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Register enabled modules
     *
     * @return void
     */
    public function registerModules()
    {
        $modules = $this->getModules('enabled', 'array');

        if ($modules) {
            foreach ($modules as $key => $module) {

                // Merge configs
                $configs = File::files($module['path'] . '/config');
                foreach ($configs as $config) {
                    if (basename($config) == 'config.php') {
                        $this->mergeConfigFrom($config, $module['name']);
                    } else {
                        $path = pathinfo($config);
                        $this->mergeConfigFrom($config, $module['name'] . '.' . $path['filename']);
                    }
                }

                // Add routes
                if (is_file($module['path'] . '/routes.php')) {
                    include_once $module['path'] . '/routes.php';
                }

                // Add views with namespace
                if (is_dir($module['path'] . '/views')) {
                    view()->addNamespace($module['name'], $module['path'] . '/views');
                }

                // Add translations with namespace
                if (is_dir($module['path'] . '/lang')) {
                    Lang::addNamespace($module['name'], $module['path'] . '/lang');
                }

                // Register main provider per module {MODULE_NAME}ServiceProvider
                $providerClass = ucfirst($module['name']) . 'ServiceProvider';
                if (is_file($module['path'] . '/Providers/' . $providerClass . '.php')) {
                    $this->app->register('App\\Modules\\' . ucfirst($module['name']) . '\\Providers\\' . $providerClass);
                }
            }
        }
    }

    /**
     * Get modules (enabled, disabled, all)
     *
     * @param string $state (enabled|disabled|all)
     * @param string $return (name|path|array)
     * @return array $modules
     */
    public function getModules($state = 'enabled', $return = 'name', $key = 'numeric')
    {
        $modules = array();
        foreach (File::files(app_path('Modules/*')) as $file) {
            if (basename($file) == 'module.json') {
                $moduleArray = json_decoder($file);

                switch ($state) {
                    case 'enabled':
                        if ($moduleArray['enabled'])
                            $modules[$moduleArray['name']] = $this->getModulesReturnType($moduleArray, $return, $file);
                        break;

                    case 'disabled':
                        if (!$moduleArray['enabled'])
                            $modules[$moduleArray['name']] = $this->getModulesReturnType($moduleArray, $return, $file);
                        break;

                    default:
                        $modules[$moduleArray['name']] = $this->getModulesReturnType($moduleArray, $return, $file);
                }
            }
        }

        uasort($modules, function ($a, $b) {
            return $a['order'] - $b['order'];
        });
        return $modules;
    }

    protected function getModulesReturnType($moduleArray, $return, $file)
    {
        $modules = array();
        switch ($return) {
            case 'name':
                return $moduleArray['name'];
                break;

            case 'path':
                return dirname($file);
                break;

            case 'array':
                $moduleArray['path'] = dirname($file);
                return $moduleArray;
                break;

        }
        return $modules;
    }

    /**
     * Run the seeder if it exists
     *
     * @param string $module
     * @return void
     */
    public function seed($module)
    {
        $modules = modules();
        $class = $modules[$module]['class'];
        $class = 'App\Modules\\' . $class . '\Database\Seeds\\' . $class . 'TableSeeder';

        if (class_exists($class)) {
            $seeder = new $class;
            $seeder->run();
        }
    }

}