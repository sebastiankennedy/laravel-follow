<?php

namespace SebastianKennedy\LaravelFollow\Tests;

use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase;
use SebastianKennedy\LaravelFollow\FollowServiceProvider;

abstract class LaravelFollowTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [FollowServiceProvider::class];
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadMigrationsFrom(dirname(__DIR__).'/migrations');

        Event::fake();
        config(['auth.providers.users.model' => User::class]);
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set(
            'database.connections.testing',
            [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
            ]
        );
    }
}