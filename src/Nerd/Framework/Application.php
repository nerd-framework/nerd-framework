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
    use Traits\ConfigurationTrait;
    use Traits\ServiceProviderTrait;

    /**
     * @var string
     */
    private $environment;

    /**
     * @param string $baseDir
     * @param string $environment
     */
    public function __construct($baseDir, $environment)
    {
        $this->setBaseDir($baseDir);
        $this->setEnv($environment);

        $this->loadEnv();
        $this->loadConfig();

        $this->loadServiceProviders();
    }

    /**
     * @param $environment
     * @return void
     */
    private function setEnv($environment)
    {
        $this->environment = $environment;
    }

    /**
     * @return string
     */
    public function getEnv()
    {
        return $this->environment;
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

    /**
     * @param string $id
     * @return object
     */
    public function get($id)
    {
        if (!$this->has($id) && $this->isProvided($id)) {
            $this->requireService($id);
        }
        return parent::get($id);
    }

    public function loadServiceProviders()
    {
        $providerClasses = $this->config("core.serviceProviders", []);

        array_walk($providerClasses, function ($class) {
            $this->registerServiceProvider($class);
        });
    }
}
