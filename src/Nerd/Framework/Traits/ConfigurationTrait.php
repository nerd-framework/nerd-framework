<?php

namespace Nerd\Framework\Traits;

use const Nerd\Config\Formats\JSON;

use function Nerd\Config\getConfig;
use function Nerd\Config\getValue;

trait ConfigurationTrait
{
    /**
     * @var array
     */
    private $env = [];

    /**
     * @var array
     */
    private $config = [];


    /**
     * @return string
     */
    abstract public function getConfigDir();

    /**
     * @return string
     */
    abstract public function getEnvDir();

    /**
     * @return string
     */
    abstract public function getEnv();

    /**
     * @return void
     */
    protected function loadConfig()
    {
        $configDir = $this->getConfigDir();
        $this->config = getConfig($configDir, JSON);
    }

    /**
     * @return void
     */
    protected function loadEnv()
    {
        $envDir = $this->getEnvDir();
        $env = $this->getEnv();
        $envFile = $envDir . DIRECTORY_SEPARATOR . $env . '.json';
        if (file_exists($envFile)) {
            $content = file_get_contents($envFile);
            $this->env = json_decode($content, true);
        }
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function config($key, $default = null)
    {
        $value = getValue($this->config, $key, $default);

        return $this->interpolate($value, $default);
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function env($key, $default = null)
    {
        return getValue(array_merge($_ENV, $this->env), $key, $default);
    }

    /**
     * @param string $value
     * @param mixed $default
     * @return mixed
     */
    protected function interpolate($value, $default = null)
    {
        if (is_string($value) && preg_match('~^\${(.+)}$~', $value, $match)) {
            return $this->env($match[1], $default);
        }

        return $value;
    }
}