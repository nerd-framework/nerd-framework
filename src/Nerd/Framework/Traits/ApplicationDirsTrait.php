<?php

namespace Nerd\Framework\Traits;

trait ApplicationDirsTrait
{
    private $baseDir;

    protected function setBaseDir($baseDir)
    {
        $this->baseDir = $baseDir;
    }

    public function getBaseDir()
    {
        return $this->baseDir;
    }

    public function getConfigDir()
    {
        return $this->getBaseDir() . DIRECTORY_SEPARATOR . 'config';
    }

    public function getApplicationDir()
    {
        return $this->getBaseDir() . DIRECTORY_SEPARATOR . 'app';
    }

    public function getResourcesDir()
    {
        return $this->getBaseDir() . DIRECTORY_SEPARATOR . 'resources';
    }

    public function getStorageDir()
    {
        return $this->getBaseDir() . DIRECTORY_SEPARATOR . 'storage';
    }
}
