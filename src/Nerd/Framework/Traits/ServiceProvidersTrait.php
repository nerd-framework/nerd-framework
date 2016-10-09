<?php

namespace Nerd\Framework\Traits;

trait ServiceProvidersTrait
{
    private $serviceProvidersClasses = [];

    private $providedServicesMap = [];

    protected function registerServiceProviderClass($providerClass)
    {
        $providedServices = $providerClass::provides();
        $this->serviceProvidersClasses[$providerClass] = false;
        array_walk($providedServices, function ($service) use ($providerClass) {
            $this->providedServicesMap[$service] = $providerClass;
        });
    }

    protected function bootService($service)
    {
        $providerClass = $this->providedServicesMap[$service];

        if ($this->serviceProvidersClasses[$providerClass] === false) {
            $providerInstance = new $providerClass($this);
            $providerInstance->register();
            $this->serviceProvidersClasses[$providerClass] = true;
        }
    }
}
