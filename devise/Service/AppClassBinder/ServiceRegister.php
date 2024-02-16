<?php

namespace Xel\Devise\Service\AppClassBinder;
use Xel\Devise\Service\Middleware\CorsMiddleware;
use Xel\Devise\Service\RestApi\Service;

function serviceRegister(): array
{
    return [
        Service::class
    ];
}

function serviceMiddlewareGlobals(): array
{
    return [
        CorsMiddleware::class
    ];
}