<?php

namespace Xel\Devise\Service\Middleware;
use DI\Container;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Xel\Async\Contract\MiddlewareInterfaces;
use Xel\Async\Contract\RequestHandlerInterfaces;
use Xel\Devise\Service\Gemstone\GemstoneAuthorization;

readonly class AuthMiddleware implements MiddlewareInterfaces
{
    public function __construct(private Container $container)
    {}

    public function process(Request $request, RequestHandlerInterfaces $handler, Response $response): void
    {
        if (GemstoneAuthorization::check($request,$response, $this->container) === false){
            $response->setStatusCode(401);
            $response->end();
        }
        $handler->handle($request);
    }
}