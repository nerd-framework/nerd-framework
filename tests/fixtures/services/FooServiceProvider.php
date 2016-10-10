<?php

namespace tests\fixtures\services;

use Nerd\Framework\Providers\ServiceProvider;

class FooServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->getApplication()->singleton("foo", FooService::class);
    }

    public static function provides()
    {
        return ["foo"];
    }
}
