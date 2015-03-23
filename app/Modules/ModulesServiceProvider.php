<?php namespace App\Modules;

use Illuminate\Support\ServiceProvider;

class ModulesServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Admin base url
        define("ADMIN", config('modules.adminBaseUrl'));

        $module = $this->app['module'];

        $module->registerModules();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('module', function ($app) {
            return new Module($app);
        });
    }
}