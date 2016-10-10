<?php

namespace tests;

use Nerd\Framework\Application;
use Nerd\Framework\Routing\RouterContract;
use Nerd\Framework\Services\ConfigService;
use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase
{
    /**
     * @var string
     */
    private $baseDir;

    /**
     * @var string
     */
    private $env = "test";

    /**
     * @var Application
     */
    private $app;

    public function setUp()
    {
        $this->baseDir = implode(DIRECTORY_SEPARATOR, [__DIR__, 'fixtures', 'testfw']);
        $this->app = new Application($this->baseDir, $this->env);
    }

    public function testInstance()
    {
        $this->assertInstanceOf(Application::class, $this->app);
    }

    public function testConfig()
    {
        $this->assertEquals('test', $this->app->config('app.env'));
        $this->assertEquals('bar', $this->app->config('app.interpolate'));
    }

    public function testRouting()
    {
         $routingService = $this->app->get(RouterContract::class);
    }
}
