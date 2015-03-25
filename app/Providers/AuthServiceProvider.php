<?php namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Auth\AuthServiceProvider as ServiceProvider;
use App\Library\Guard;

class AuthServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['auth']->extend('eloquent', function ($app)
        {
            $model = $app['config']['auth.model'];

            $provider = new EloquentUserProvider($app['hash'], $model);

            return new Guard($provider, $this->app['session.store']);
        });
    }
}
