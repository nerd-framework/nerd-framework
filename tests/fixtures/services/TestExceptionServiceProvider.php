<?php

namespace tests\fixtures\services;

use Nerd\Framework\Http\Services\ExceptionServiceContract;
use Nerd\Framework\ServiceProvider;

class TestExceptionServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {
        $this->getApp()->singleton('app.exception-handler', TestExceptionService::class);
    }

    public function provides()
    {
        return ['app.exception-handler'];
    }
}
