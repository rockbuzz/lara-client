<?php

namespace Rockbuzz\LaraClient;

use Illuminate\Support\ServiceProvider as SupportServiceProvider;
use Rockbuzz\LaraClient\Commands\CreateClient;

class ServiceProvider extends SupportServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        $this->publishes([
            __DIR__ . '/database/migrations/' => database_path('migrations')
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/config/client.php' => config_path('client.php')
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/client.php', 'client');

        $this->commands([
            CreateClient::class
        ]);
    }
}
