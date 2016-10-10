<?php

namespace tests;

use Nerd\Framework\Application;
use Nerd\Framework\Http\ResponseContract;
use PHPUnit\Framework\TestCase;
use tests\fixtures\TestRequest;
use tests\fixtures\TestResponse;

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

        /**
         * @var TestResponse $response
         */
        $response = $this->app->handle($request);

        $this->assertInstanceOf(ResponseContract::class, $response);

        $this->assertFalse($response->isPrepared());

        $this->assertFalse($response->isRendered());
    }
}
