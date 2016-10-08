<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 08.10.16
 * Time: 23:05
 */

namespace Nerd\Framework\Providers;

use Nerd\Framework\Application;
use Nerd\Framework\Services\ServiceProviderContract;

abstract class ServiceProvider implements ServiceProviderContract
{
    private $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * @return Application
     */
    protected function getApplication()
    {
        return $this->application;
    }
}
