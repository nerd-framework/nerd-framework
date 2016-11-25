<?php

namespace Nerd\Framework\Traits;

use Nerd\Framework\Exceptions\ApplicationException;
use Nerd\Framework\ServiceProvider;
use Nerd\Framework\Services\ServiceProviderContract;

trait ServiceProviderTrait
{
    /**
     * @var ServiceProviderContract[]
     */
    private $servicesProvidedByProviders = [];

    /**
     * @param ServiceProviderContract $serviceProviderClass
     * @throws ApplicationException
     */
    public function registerServiceProvider($serviceProviderClass)
    {
        $serviceProvider = $this->invoke($serviceProviderClass);

        if (!$serviceProvider instanceof ServiceProviderContract) {
            throw new ApplicationException(
                "Class \"$serviceProviderClass\" must implement ServiceProviderContract interface."
            );
        }

        $serviceProvider->boot();

        $services = $serviceProvider->provides();

        array_walk($services, function ($serviceId) use ($serviceProvider) {
            $this->servicesProvidedByProviders[$serviceId] = $serviceProvider;
        });
    }

    public function registerService($serviceId)
    {
        $serviceProvider = $this->servicesProvidedByProviders[$serviceId];

        $services = $serviceProvider->provides();

        array_walk($services, function ($serviceId) {
            unset($this->servicesProvidedByProviders[$serviceId]);
        });

        $serviceProvider->register();
    }

    /**
     * @param string $serviceId
     * @return bool
     */
    public function isServiceProvided($serviceId)
    {
        return array_key_exists($serviceId, $this->servicesProvidedByProviders);
    }
}
