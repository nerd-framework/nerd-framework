<?php

namespace tests\fixtures\services;

use Nerd\Framework\Http\OutputContract;
use Nerd\Framework\Http\RequestContract;
use Nerd\Framework\Http\ResponseContract;

class TestResponse implements ResponseContract
{
    private $original;

    /**
     * @param $original
     */
    public function __construct($original)
    {
        $this->original = $original;
    }

    /**
     * Prepare HTTP Response to send to client
     *
     * @param RequestContract $request
     * @return mixed
     */
    public function prepare(RequestContract $request)
    {
    }

    /**
     * Send HTTP Response to client
     *
     * @param OutputContract $output
     * @return mixed
     */
    public function render(OutputContract $output)
    {
    }

    /**
     * @return mixed
     */
    public function getOriginal()
    {
        return $this->original;
    }
}
