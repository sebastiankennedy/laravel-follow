<?php

/*
 * This file is part of the sebastian-kennedy/laravel-follow.
 *
 * (c) SebastianKennedy <sebastiankennedy@foxmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace SebastianKennedy\LaravelFollower;

use Illuminate\Support\ServiceProvider;

class FollowServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([dirname(__DIR__).'/config/follow.php' => config_path('follow.php')], 'config');
        $this->publishes([dirname(__DIR__).'/migrations/' => database_path('migrations')], 'migrations');

        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(dirname(__DIR__).'/migrations/');
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(dirname(__DIR__).'/config/follow.php', 'follow');
    }
}
