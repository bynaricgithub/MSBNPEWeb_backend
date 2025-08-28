<?php

namespace App\Providers;

use App\Services\Auth\Authentication;
use App\Services\Masters\Master;
use Illuminate\Console\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class AuthProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(Authentication::class, function (Application $app) {
            return new Authentication(fn () => $app['request']);
        });

        $this->app->singleton(Master::class, function (Application $app) {
            return new Master(fn () => $app['request']);
        });

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
