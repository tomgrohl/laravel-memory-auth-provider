<?php

namespace Tomgrohl\Laravel\Auth;

use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('auth')->extend('memory', function(Application $app) {
            /** @var Repository $config */
            $config = $app->make('config');

            return new InMemoryUserProvider($app->make('hash'), $config->get('auth.memory.users', []));
        });
    }
}
