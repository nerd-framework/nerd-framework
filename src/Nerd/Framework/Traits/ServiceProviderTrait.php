<?php

namespace Nerd\Framework\Traits;

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
     */
    public function registerServiceProvider($serviceProviderClass)
    {
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
    public function isProvided($service)
    {
        return array_key_exists($service, $this->servicesProvidedByProviders);
    }
}
