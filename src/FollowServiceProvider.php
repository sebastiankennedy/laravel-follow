<?php

namespace SebastianKennedy\LaravelFollower;

use Illuminate\Support\ServiceProvider;

class FollowServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([dirname(__DIR__) . '/config/like.php' => config_path('like.php')], 'config');
        $this->publishes([dirname(__DIR__) . '/migrations/' => database_path('migrations')], 'migrations');

        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(dirname(__DIR__) . '/migrations/');
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(dirname(__DIR__) . '/config/follow.php', 'follower');
    }
}