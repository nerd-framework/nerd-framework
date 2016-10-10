<?php

namespace tests;

use Nerd\Framework\Application;
use PHPUnit\Framework\TestCase;
use tests\fixtures\services\FooService;
use tests\fixtures\services\FooServiceProvider;
use tests\fixtures\services\IncorrectServiceProvider;

class ServiceProvidersTest extends TestCase
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

    public function testServiceProviderRegistration()
    {
        // At start we assert, that service foo doesn't exist
        $this->assertFalse($this->app->has('foo'));
        // Then will register foo service provider class
        $this->app->registerServiceProvider(FooServiceProvider::class);
        // At next we see, that service foo exists
        $this->assertTrue($this->app->has('foo'));

        // Let's play with that service
        $fooService = $this->app->get('foo');
        $this->assertInstanceOf(FooService::class, $fooService);
        $this->assertEquals('bar', $fooService->foo());
    }

    /**
     * @expectedException \Nerd\Framework\Exceptions\ApplicationException
     */
    public function testIncorrectServiceProviderClass()
    {
        $this->app->registerServiceProvider(IncorrectServiceProvider::class);
    }
}
