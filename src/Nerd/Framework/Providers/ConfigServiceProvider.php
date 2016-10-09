<?php

namespace Nerd\Framework\Providers;

use Nerd\Framework\Services\ConfigService;

class ConfigServiceProvider extends ServiceProvider
{
    public function register()
    {
        $configDir = $this->getApplication()->getConfigDir();
        $service = new ConfigService($configDir);
        $this->getApplication()->bind(ConfigService::class, $service);
    }

    public static function provides()
    {
        return [
            ConfigService::class
        ];
    }
}
