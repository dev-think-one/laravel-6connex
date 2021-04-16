<?php

namespace LaravelSixConnex\Tests;

use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            \LaravelSixConnex\ServiceProvider::class,
        ];
    }

    public function defineEnvironment($app)
    {
        $app['config']->set('sixconnex.options.production', false);
        $app['config']->set('sixconnex.api_username', 'some_api_username');
        $app['config']->set('sixconnex.api_password', 'some_api_password');
    }
}
