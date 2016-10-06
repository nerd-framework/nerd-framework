<?php

namespace Nerd\Framework;

use Nerd\Framework\Container\Container;
use Nerd\Framework\Http\RequestContract;
use Nerd\Framework\Http\ResponseContract;
use Nerd\Framework\Routing\RouterContract;

class Application extends Container implements ApplicationContract
{
    /**
     * @param RequestContract $request
     * @return ResponseContract
     */
    public function handle(RequestContract $request)
    {
        $router = $this->get(RouterContract::class);
        $response = $router->handle($request);

        return $this->normalizeResponse($response);
    }

    /**
     * @param $response
     * @return ResponseContract
     */
    private function normalizeResponse($response)
    {
        if ($response instanceof ResponseContract) {
            return $response;
        }

        return $this->convertResponse($response);
    }

    /**
     * @param $response
     * @return ResponseContract
     */
    private function convertResponse($response)
    {
        throw new \InvalidArgumentException("Response converter is not implemented.");
    }
}
