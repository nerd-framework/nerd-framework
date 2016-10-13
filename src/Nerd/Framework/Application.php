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
        $this->setEnv($environment);

        $this->bind(Application::class, $this);

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
        if (!parent::has($id) && $this->isServiceProvided($id)) {
            $this->requireService($id);
        }
        return parent::get($id);
    }

    /**
     * @param string $id
     * @return bool
     */
    public function has($id)
    {
        return parent::has($id) || $this->isServiceProvided($id);
    }

    /**
     * Load Service Providers from Config File
     */
    public function loadServiceProviders()
    {
        $providerClasses = $this->config("core.serviceProviders", []);

        array_walk($providerClasses, function ($class) {
            $this->registerServiceProvider($class);
        });
    }
}
