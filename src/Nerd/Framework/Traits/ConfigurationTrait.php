<?php

namespace Nerd\Framework\Traits;

use const Nerd\Config\Formats\PHP;

use function Nerd\Config\getConfig;
use function Nerd\Config\getValue;

trait ConfigurationTrait
{
    /**
     * @var array
     */
    private $config = [];


    /**
     * @return string
     */
    abstract public function getConfigDir();

    /**
     * @return void
     */
    protected function loadConfig()
    {
        $configDir = $this->getConfigDir();

        $this->config = getConfig($configDir, PHP);
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function config($key, $default = null)
    {
        return getValue($this->config, $key, $default);
    }

    /**
     * @param array $config
     */
    public function mergeConfig(array $config)
    {
        $this->config = array_merge_recursive($this->config, $config);
    }
}
