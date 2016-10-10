<?php

namespace tests\fixtures\services;

use Nerd\Framework\Services\ServiceContract;

class FooService implements ServiceContract
{
    public function foo()
    {
        return "bar";
    }
}
