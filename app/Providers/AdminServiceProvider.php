<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helper;
use Config;
use Request;
use File;

class AdminServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if (modules() && is_admin()) {
            $this->menu();
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Admin base url
        define("ADMIN", "admin");

        $modules = Helper::getModules('enabled', 'array');

        define("MODULES", json_encode($modules ?: array()));

        if ($modules) {

            // Add modules config
            foreach ($modules as $key => $module) {
                if (is_file($module['path'] . '/config.php')) {
                    Config::set(strtolower($module['name']) . '::config', include($module['path'] . '/config.php'));
                }
            }

            // Build menu
            if (is_admin()) {
                $this->menu($modules);
            }
        }
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
            $name = strtolower($module['name']);
            $resourcesPath = resources_path($name);
            if (File::exists($resourcesPath . '/views/admin/menu.blade.php')) {
                $menus .= view($name . '.views.admin.menu')->render();

            }
        }

        if ($menus) {
            view()->composer('admin.views._partials.sidebar', function ($view) use ($menus) {
                $view->with('menu', $menus);
            });
        }
    }

}
