<?php

namespace Nerd;

use Nerd\Framework\Application;

function app()
{
    return Application::getInstance();
}

function resource($name)
{
    return app()->get($name);
}

function config($key, $default = null)
{
    return null;
}
