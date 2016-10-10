<?php

namespace tests\fixtures;

use Nerd\Framework\Http\OutputContract;
use Nerd\Framework\Http\RequestContract;
use Nerd\Framework\Http\ResponseContract;

class TestResponse implements ResponseContract
{
    private $prepared = false;

    private $rendered = false;

    private $request;

    /**
     * TestResponse constructor.
     * @param $request
     */
    public function __construct(RequestContract $request)
    {
        $this->request = $request;
    }

    /**
     * Prepare HTTP Response to send to client
     *
     * @param RequestContract $request
     * @return mixed
     */
    public function prepare(RequestContract $request)
    {
        $this->prepared = true;
    }

    /**
     * Send HTTP Response to client
     *
     * @param OutputContract $output
     * @return mixed
     */
    public function render(OutputContract $output)
    {
        $this->rendered = true;
    }

    /**
     * @return boolean
     */
    public function isPrepared()
    {
        return $this->prepared;
    }

    /**
     * @return boolean
     */
    public function isRendered()
    {
        return $this->rendered;
    }

    /**
     * @return RequestContract
     */
    public function getRequest()
    {
        return $this->request;
    }
}
