<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helper;
use Config;
use File;
use App\Library\Datatables;

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
                    $this->mergeConfigFrom($module['path'] . '/config.php', $module['name']);
                }
            }
        }

//        // Extend datatables class
//        $this->app['datatables'] = $this->app->share(function($app)
//        {
//            return new Datatables;
//        });
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
            $resourcesPath = resources_path($name);
            if (File::exists($resourcesPath . '/views/admin/menu.blade.php')) {
                $menus .= view($name . '.views.admin.menu', array('module' => $module));
            }
        }

        if ($menus) {
            view()->composer('admin.views._partials.sidebar', function ($view) use ($menus) {
                $view->with('menu', $menus);
            });
        }
    }

}
