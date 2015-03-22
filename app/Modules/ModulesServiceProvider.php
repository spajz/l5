<?php namespace App\Modules;

use Illuminate\Support\ServiceProvider;
use App\Helper2;
use File;

class ModulesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Admin base url
        define("ADMIN", "admin");

        $modules = Helper2::getModules('enabled', 'array');

        define("MODULES", json_encode($modules ?: array()));

        if ($modules) {
            foreach ($modules as $key => $module) {

                // Add configs
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

                // Add views
                if (is_dir($module['path'] . '/views')) {
                    view()->addNamespace($module['name'], $module['path'] . '/views');
                }

                // Add lang
                if (is_dir($module['path'] . '/lang')) {
                    lang()->addNamespace($module['name'], $module['path'] . '/lang');
                }

                // Register providers
                $providerClass = ucfirst($module['name']) . 'ServiceProvider';
                if (is_file($module['path'] . '/Providers/' . $providerClass . '.php')) {
                    $this->app->register('App\\Modules\\' . ucfirst($module['name']) . '\\Providers\\' . $providerClass);
                }
            }
        }

        $this->menu();
    }

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
     * Build admin menu from view files
     *
     * @return void
     */
    protected function menu()
    {
        $menus = '';
        foreach (modules() as $module) {
            $name = $module['name'];
            $modulesPath = modules_path($name . '');
            if (File::exists($modulesPath . "/views/admin/menu.blade.php")) {
                $menus .= view($name . '::admin.menu', array('module' => $module));
            }
        }

        if ($menus) {
            view()->composer('admin::._partials.sidebar', function ($view) use ($menus) {
                $view->with('menu', $menus);
            });
        }
    }
}