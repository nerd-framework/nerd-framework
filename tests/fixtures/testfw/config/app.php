<?php

return [
    'foo' => 'bar',

    "service-providers" => [
        \tests\fixtures\services\TestRoutingServiceProvider::class,
        \tests\fixtures\services\TestResponseServiceProvider::class,
        \tests\fixtures\services\TestExceptionServiceProvider::class
    ],
];
