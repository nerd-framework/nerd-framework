<?php

namespace tests\fixtures\services;

use Nerd\Framework\Http\ExceptionServiceContract;
use Nerd\Framework\Providers\ServiceProvider;

class TestExceptionServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->getApplication()->singleton(ExceptionServiceContract::class, TestExceptionService::class);
    }

    public static function provides()
    {
        return [ExceptionServiceContract::class];
    }
}
