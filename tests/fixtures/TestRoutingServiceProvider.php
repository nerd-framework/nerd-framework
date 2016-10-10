<?php

namespace tests\fixtures;

use Nerd\Framework\Providers\ServiceProvider;
use Nerd\Framework\Routing\RouterContract;

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
