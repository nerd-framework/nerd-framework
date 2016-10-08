<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 08.10.16
 * Time: 23:04
 */

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
}
