<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 08.10.16
 * Time: 23:08
 */

namespace Nerd\Framework\Services;

use const Nerd\Config\Formats\PHP;

use function Nerd\Config\getConfig;
use function Nerd\Config\getValue;

class ConfigService implements ServiceContract
{
    private $config;

    public function __construct($configDir)
    {
        $this->config = getConfig($configDir, PHP);
    }

    public function getSetting($key, $default = null)
    {
        return getValue($this->config, $key, $default);
    }
}
