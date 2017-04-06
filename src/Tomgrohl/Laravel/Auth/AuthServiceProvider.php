<?php

namespace Tomgrohl\Laravel\Auth;

use Illuminate\Config\Repository;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Tomgrohl\Laravel\Auth\Commands\Hash;

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

            return new InMemoryUserProvider(
                $app->make('hash'),
                $config->get('auth.memory.users', []),
                $config->get('auth.memory.model', 'Illuminate\Auth\GenericUser')
            );
        });

        $this->app->bind('Tomgrohl\Laravel\Auth\Commands\Hash', function(Application $app) {
            return new Hash($app->make('hash'));
        });

        $this->commands([
            'Tomgrohl\Laravel\Auth\Commands\Hash'
        ]);
    }
}
