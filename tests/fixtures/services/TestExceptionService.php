<?php

namespace tests\fixtures\services;

use Nerd\Framework\Http\Services\ExceptionServiceContract;
use Nerd\Framework\Http\Response\ResponseContract;

class TestExceptionService implements ExceptionServiceContract
{

    /**
     * Add new exception handler
     *
     * @param $exceptionClass
     * @param callable $handler
     * @return mixed
     */
    public function on($exceptionClass, callable $handler)
    {
    }

    /**
     * Handle exception using exception handler
     *
     * @param \Exception $exception
     * @return ResponseContract
     */
    public function handle(\Exception $exception)
    {
        return new TestResponse($exception);
    }
}
