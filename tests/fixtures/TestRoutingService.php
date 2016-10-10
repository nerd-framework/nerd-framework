<?php

namespace tests\fixtures;

use Nerd\Framework\Http\RequestContract;
use Nerd\Framework\Routing\RouterContract;

class TestRoutingService implements RouterContract
{
    public function handle(RequestContract $request)
    {
        return new TestResponse($request);
    }
}
