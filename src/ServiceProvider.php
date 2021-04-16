<?php

namespace LaravelSixConnex;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/sixconnex.php' => config_path('sixconnex.php'),
            ], 'config');


            $this->commands([
            ]);
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/sixconnex.php', 'sixconnex');

        $this->app->bind(SixConnexApi::class, function ($app) {
            return new SixConnexApi(
                config('sixconnex.client_domain'),
                config('sixconnex.api_username'),
                config('sixconnex.api_password'),
                config('sixconnex.options'),
            );
        });
    }
}
