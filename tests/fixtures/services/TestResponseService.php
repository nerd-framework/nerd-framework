<?php

namespace tests\fixtures\services;

use Nerd\Framework\Http\ResponseContract;
use Nerd\Framework\Http\ResponseServiceContract;
use tests\fixtures\services\TestResponse;

class TestResponseService implements ResponseServiceContract
{
    /**
     * Add converter to ResponseService
     *
     * @param string $type
     * @param callable $converter
     * @return mixed
     */
    public function on($type, callable $converter)
    {
        //
    }

    /**
     * Handle convert response to ResponseContract
     *
     * @param mixed $response
     * @return ResponseContract
     */
    public function convert($response)
    {
        if (is_string($response)) {
            return new TestResponse($response);
        }

        return $response;
    }
}
