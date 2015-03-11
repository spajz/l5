<?php namespace App\Providers;

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
        //
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

    protected function menu()
    {
        foreach (File::allFiles(resources_path('admin')) as $file) {
            if ($file->getFilename() == 'module.json') {
                if (json_decoder($file->getRealPath(), 'enabled')) {
                    require $file->getPath() . '/routes.php';
                }
            }
        }
    }

}
