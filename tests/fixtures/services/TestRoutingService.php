<?php

namespace tests\fixtures\services;

use Nerd\Framework\Http\Request\RequestContract;
use Nerd\Framework\Routing\RouterContract;

class TestRoutingService implements RouterContract
{
    public function handle(RequestContract $request)
    {
        if ($request->getPath() == '/') {
            return new TestResponse("/");
        }

        if ($request->getPath() == 'error') {
            throw new \Exception("Exception thrown inside controller");
        }

        return 'hello';
    }
}
