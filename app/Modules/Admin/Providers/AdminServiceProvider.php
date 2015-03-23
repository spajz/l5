<?php namespace App\Modules\Admin\Providers;

use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
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
            $modulesPath = modules_path($name . '/');
            if (is_file($modulesPath . "/views/admin/menu.blade.php")) {
                $menus .= view($name . '::admin.menu', array('module' => $module));
            }
        }

        if ($menus) {
            view()->composer('admin::_partials.sidebar', function ($view) use ($menus) {
                $view->with('menu', $menus);
            });
        }
    }
}