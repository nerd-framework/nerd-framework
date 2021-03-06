<?php

namespace tests\fixtures\services;

use Nerd\Framework\ServiceProvider;

class FooServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {
        $this->app->singleton("foo", FooService::class);
    }

    public function provides()
    {
        return ["foo"];
    }
}
