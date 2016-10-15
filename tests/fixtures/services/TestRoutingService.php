<?php

namespace tests\fixtures\services;

use Nerd\Framework\Http\Request\RequestContract;
use Nerd\Framework\Routing\RouterContract;

class TestRoutingService implements RouterContract
{
    public function handle(RequestContract $request)
    {
        if ($request->getPath() == '/') {
            return new TestResponse("/");
        }

        if ($request->getPath() == 'error') {
            throw new \Exception("Exception thrown inside controller");
        }

        return 'hello';
    }

    /**
     * Add route for GET method into routes list.
     *
     * @param string $route
     * @param callable $action
     * @param mixed $data
     * @return RouterContract
     */
    public function get($route, $action, $data = null)
    {
        return $this;
    }

    /**
     * Add route for POST method into routes list.
     *
     * @param string $route
     * @param callable $action
     * @param mixed $data
     * @return RouterContract
     */
    public function post($route, $action, $data = null)
    {
        return $this;
    }

    /**
     * Add route for PUT method into routes list.
     *
     * @param string $route
     * @param callable $action
     * @param mixed $data
     * @return RouterContract
     */
    public function put($route, $action, $data = null)
    {
        return $this;
    }

    /**
     * Add route for DELETE method into routes list.
     *
     * @param string $route
     * @param callable $action
     * @param mixed $data
     * @return RouterContract
     */
    public function delete($route, $action, $data = null)
    {
        return $this;
    }

    /**
     * @param string $route
     * @param callable $action
     * @param null $data
     * @return RouterContract
     */
    public function any($route, $action, $data = null)
    {
        return $this;
    }

    /**
     * Add middleware to router.
     *
     * @param $route
     * @param $middleware
     * @return RouterContract
     */
    public function middleware($route, $middleware)
    {
        return $this;
    }

    /**
     * Add route into routes list.
     *
     * @param string|array $methods
     * @param string $regexp
     * @param callable $action
     * @param mixed $data
     * @return RouterContract
     */
    public function add($methods, $regexp, $action, $data = null)
    {
        return $this;
    }
}
