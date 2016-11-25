<?php

namespace Nerd\Framework;

use Nerd\Framework\Container\Container;
use Nerd\Framework\Http\Services\ExceptionServiceContract;
use Nerd\Framework\Http\Request\RequestContract;
use Nerd\Framework\Http\Response\ResponseContract;
use Nerd\Framework\Http\Services\ResponseServiceContract;
use Nerd\Framework\Routing\RouterContract;

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
        $this->setEnvironment($environment);


        $this->bind('app', $this);
        $this->alias('app', ApplicationContract::class);

        $this->loadConfig();

        $this->loadServiceProviders();
    }

    /**
     * @param $environment
     * @return void
     */
    private function setEnvironment($environment)
    {
        $this->environment = $environment;
    }

    /**
     * @return string
     */
    public function getEnvironment()
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
            $response = $this['app.router']->handle($request);
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
        return $this['app.response-converter']->convert($response);
    }

    /**
     * @param \Exception $exception
     * @return ResponseContract
     * @throws \Exception
     */
    private function handleException(\Exception $exception)
    {
        if (!isset($this['app.exception-handler'])) {
            throw $exception;
        }

        return $this['app.exception-handler']->handle($exception);
    }

    /**
     * @param string $serviceId
     * @return object
     */
    public function get($serviceId)
    {
        if (!parent::has($serviceId) && $this->isServiceProvided($serviceId)) {
            $this->registerService($serviceId);
        }

        return parent::get($serviceId);
    }

    /**
     * @param string $serviceId
     * @return bool
     */
    public function has($serviceId)
    {
        return parent::has($serviceId) || $this->isServiceProvided($serviceId);
    }

    /**
     * Load Service Providers from Config File
     */
    public function loadServiceProviders()
    {
        $serviceProviderClasses = $this->config("app.service-providers", []);

        array_walk($serviceProviderClasses, function ($serviceProviderClass) {
            $this->registerServiceProvider($serviceProviderClass);
        });
    }
}
