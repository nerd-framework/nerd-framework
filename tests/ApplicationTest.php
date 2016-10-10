<?php

namespace tests;

use Nerd\Framework\Application;
use Nerd\Framework\Http\ResponseContract;
use PHPUnit\Framework\TestCase;
use tests\fixtures\TestRequest;

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
        $request = TestRequest::make("GET", "/");

        $response = $this->app->handle($request);

        $this->assertInstanceOf(ResponseContract::class, $response);
        $this->assertEquals("/", $response->unpack());
    }

    public function testResponseConverting()
    {
        $request = TestRequest::make("GET", "foo");

        $response = $this->app->handle($request);

        $this->assertInstanceOf(ResponseContract::class, $response);
        $this->assertEquals("hello", $response->unpack());
    }

    public function testExceptionHandling()
    {
        $request = TestRequest::make("GET", "error");

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
