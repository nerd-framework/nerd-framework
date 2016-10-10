<?php

namespace tests\fixtures\services;

use Nerd\Framework\Providers\ServiceProvider;
use Nerd\Framework\Routing\RouterContract;
use tests\fixtures\services\TestRoutingService;

class TestRoutingServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->getApplication()->singleton(RouterContract::class, TestRoutingService::class);
    }

    public static function provides()
    {
        return [RouterContract::class];
    }
}
