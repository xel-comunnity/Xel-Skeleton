<?php
namespace Xel\Devise\Service\Middleware;
use DI\Container;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Xel\Async\Contract\MiddlewareInterfaces;
use Xel\Async\Contract\RequestHandlerInterfaces;

class CorsMiddleware implements MiddlewareInterfaces
{
    public function __construct(private Container $container)
    {}
    public function process(Request $request, RequestHandlerInterfaces $handler, Response $response): void
    {
        $origin = $request->header['origin'] ?? '*'; // Allow any origin (less secure)
        $response->header('Access-Control-Allow-Origin', $origin);
        $response->header('Access-Control-Allow-Credentials', 'true');
        $response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, Origin, X-GEMSTONE-AUTH');
        $response->header('Access-Control-Max-Age', 86400);

        if ($request->getMethod() == 'OPTIONS') {
            $response->status(200);
            $response->end();
            return;
        }

        $handler->handle($request);
    }
}
