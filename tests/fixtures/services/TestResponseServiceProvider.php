<?php

namespace tests\fixtures\services;

use Nerd\Framework\Http\Services\ResponseServiceContract;
use Nerd\Framework\ServiceProvider;

class TestResponseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('app.response-converter', TestResponseService::class);
    }

    public function provides()
    {
        return ['app.response-converter'];
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
