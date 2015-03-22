<?php namespace App\Modules\Admin\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helper2;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

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