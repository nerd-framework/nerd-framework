<?php

namespace tests\fixtures\services;

use Nerd\Framework\ServiceProvider;

class TestRoutingServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('app.router', TestRoutingService::class);
    }

    public function provides()
    {
        return ['app.router'];
    }

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
