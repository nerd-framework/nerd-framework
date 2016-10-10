<?php

namespace tests\fixtures\services;

use Nerd\Framework\Http\ResponseServiceContract;
use Nerd\Framework\Providers\ServiceProvider;
use tests\fixtures\services\TestResponseService;

class TestResponseServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->getApplication()->singleton(ResponseServiceContract::class, TestResponseService::class);
    }

    public static function provides()
    {
        return [ResponseServiceContract::class];
    }
}