<?php

namespace tests;

use Nerd\Framework\Application;
use Nerd\Framework\Services\ConfigService;
use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase
{
    /**
     * @var Application
     */
    private $app;

    public function setUp()
    {
        $testFrameworkBaseDir = implode(DIRECTORY_SEPARATOR, [__DIR__, 'fixtures', 'testfw']);
        $this->app = new Application($testFrameworkBaseDir);
    }

    public function testInstance()
    {
        $this->assertInstanceOf(Application::class, $this->app);
    }

    public function testCoreServices()
    {
        /**
         * @var ConfigService $configService
         */
        $configService = $this->app->get(ConfigService::class);

        $this->assertEquals('test', $configService->getSetting('app.env'));
    }
}
