<?php

namespace Nerd\Framework\Providers;

use Nerd\Framework\Routing\Router;
use Nerd\Framework\Routing\RouterContract;

class RoutingServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->getApplication()->singleton(RouterContract::class, Router::class);
    }
}
