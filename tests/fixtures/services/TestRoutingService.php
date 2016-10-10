<?php

namespace tests\fixtures\services;

use Nerd\Framework\Http\RequestContract;
use Nerd\Framework\Routing\RouterContract;

class TestRoutingService implements RouterContract
{
    public function handle(RequestContract $request)
    {
        if ($request->getPath() == '/') {
            return new TestResponse("/");
        }

        return 'hello';
    }
}
