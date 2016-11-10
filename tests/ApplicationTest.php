<?php

namespace tests;

use Nerd\Framework\Application;
use Nerd\Framework\Http\Request\Request;
use Nerd\Framework\Http\Response\ResponseContract;
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
    }

    public function testConfigInterpolation()
    {
        $this->assertEquals('bar', $this->app->config('app.interpolate'));
        $this->assertEquals('value + ps + alternative value', $this->app->config('app.other'));
    }

    public function testRouting()
    {
        $request = Request::create("/");

        $response = $this->app->handle($request);

        $this->assertInstanceOf(ResponseContract::class, $response);
        $this->assertEquals("/", $response->unpack());
    }

    public function testResponseConverting()
    {
        $request = Request::create("foo");

        $response = $this->app->handle($request);

        $this->assertInstanceOf(ResponseContract::class, $response);
        $this->assertEquals("hello", $response->unpack());
    }

    public function testExceptionHandling()
    {
        $request = Request::create("error");

        $response = $this->app->handle($request);

        $this->assertInstanceOf(ResponseContract::class, $response);

        $content = $response->unpack();

        $this->assertInstanceOf(\Exception::class, $content);
    }

    public function testConfigDirectories()
    {
        $baseDir = function ($dir) {
            return $this->baseDir . DIRECTORY_SEPARATOR . $dir;
        };

        $this->assertEquals($baseDir('app'), $this->app->getApplicationDir());
        $this->assertEquals($baseDir('config'), $this->app->getConfigDir());
        $this->assertEquals($baseDir('env'), $this->app->getEnvDir());
        $this->assertEquals($baseDir('resources'), $this->app->getResourcesDir());
    }
}
