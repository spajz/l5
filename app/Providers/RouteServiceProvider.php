<?php namespace App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use File;
use App\Helper;

class RouteServiceProvider extends ServiceProvider
{

    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router $router
     * @return void
     */
    public function boot(Router $router)
    {
        parent::boot($router);

        //
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function ($router) {
            require app_path('Http/routes.php');

            $modules = Helper::getModules('enabled', 'path');

            if ($modules) {
                foreach ($modules as $key => $module) {
                    require $module . '/routes.php';
                }
            }

//            foreach (File::allFiles(app_path('Http/Controllers')) as $file) {
//                if ($file->getFilename() == 'module.json') {
//                    if (json_decoder($file->getRealPath(), 'enabled')) {
//                        require $file->getPath() . '/routes.php';
//                    }
//                }
//            }
        });
    }

}