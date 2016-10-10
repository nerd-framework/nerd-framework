<?php

namespace Nerd\Framework\Traits;

use Nerd\Framework\Exceptions\ApplicationException;
use Nerd\Framework\Providers\ServiceProvider;
use Nerd\Framework\Services\ServiceProviderContract;

trait ServiceProviderTrait
{
    /**
     * @var array
     */
    private $serviceProviderClasses = [];

    /**
     * @var array
     */
    private $servicesProvidedByProviders = [];

    /**
     * @param ServiceProviderContract $serviceProviderClass
     * @throws ApplicationException
     */
    public function registerServiceProvider($serviceProviderClass)
    {
        if (!$this->isValidServiceProviderClass($serviceProviderClass)) {
            throw new ApplicationException(
                "Class '$serviceProviderClass' must be instance of ServiceProvider class."
            );
        }

        $providedServices = $serviceProviderClass::provides();

        $index = sizeof($this->serviceProviderClasses);

        $this->serviceProviderClasses[] = $serviceProviderClass;

        array_walk($providedServices, function ($service) use ($index) {
            $this->servicesProvidedByProviders[$service] = $index;
        });
    }

    public function requireService($service)
    {
        $providerIndex = $this->servicesProvidedByProviders[$service];
        $providerClass = $this->serviceProviderClasses[$providerIndex];

        /**
         * @var ServiceProviderContract $providerInstance
         */
        $providerInstance = new $providerClass($this);
        $providerInstance->register();
    }

    /**
     * @param string $service
     * @return bool
     */
    public function isServiceProvided($service)
    {
        return array_key_exists($service, $this->servicesProvidedByProviders);
    }

    private function isValidServiceProviderClass($serviceProviderClass)
    {
        if (!class_exists($serviceProviderClass)) {
            return false;
        }

        $reflection = new \ReflectionClass($serviceProviderClass);

        return $reflection->isSubclassOf(ServiceProvider::class);
    }
}
