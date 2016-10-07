<?php

namespace Nerd\Framework;

use Nerd\Framework\Container\Container;
use Nerd\Framework\Http\ExceptionServiceContract;
use Nerd\Framework\Http\RequestContract;
use Nerd\Framework\Http\ResponseContract;
use Nerd\Framework\Http\ResponseServiceContract;
use Nerd\Framework\Routing\Router;
use Nerd\Framework\Routing\RouterContract;

class Application extends Container implements ApplicationContract
{
    public function __construct()
    {
        $this->initCoreServices();
    }

    private function initCoreServices()
    {
        $this->bind(RouterContract::class, new Router());
    }

    /**
     * @param RequestContract $request
     * @return ResponseContract
     */
    public function handle(RequestContract $request)
    {
        try {
            $router = $this->get(RouterContract::class);
            $response = $router->handle($request);

            return $this->normalizeResponse($response);
        } catch (\Exception $exception) {
            return $this->handleException($exception);
        }
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
        $converter = $this->get(ResponseServiceContract::class);

        return $converter->convert($response);
    }

    /**
     * @param \Exception $exception
     * @return ResponseContract
     */
    private function handleException(\Exception $exception)
    {
        $handler = $this->get(ExceptionServiceContract::class);

        return $handler->handle($exception);
    }
}
