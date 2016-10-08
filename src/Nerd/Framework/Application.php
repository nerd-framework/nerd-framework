<?php

namespace Nerd\Framework;

use Nerd\Framework\Container\Container;
use Nerd\Framework\Http\ExceptionServiceContract;
use Nerd\Framework\Http\RequestContract;
use Nerd\Framework\Http\ResponseContract;
use Nerd\Framework\Http\ResponseServiceContract;
use Nerd\Framework\Providers\ConfigServiceProvider;
use Nerd\Framework\Providers\RoutingServiceProvider;
use Nerd\Framework\Routing\RouterContract;
use Nerd\Framework\Services\ServiceProviderContract;

class Application extends Container implements ApplicationContract
{
    use Traits\ApplicationDirsTrait;

    private $coreServiceProviders = [
        ConfigServiceProvider::class,
        RoutingServiceProvider::class
    ];

    private $bootedServiceProviders = [];

    public function __construct($baseDir)
    {
        $this->setBaseDir($baseDir);
        $this->bootServiceProviders();
    }

    private function bootServiceProviders()
    {
        array_walk($this->coreServiceProviders, [$this, 'bootServiceProvider']);
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

    protected function bootServiceProvider($serviceProvider)
    {
        // Skip service provider if it already booted
        if (array_key_exists($serviceProvider, $this->bootedServiceProviders)) {
            return;
        }

        /**
         * @var ServiceProviderContract $instance
         */
        $instance = new $serviceProvider($this);
        $instance->register();

        // Mark current service provider as booted
        $this->bootedServiceProviders[$serviceProvider] = true;
    }
}
