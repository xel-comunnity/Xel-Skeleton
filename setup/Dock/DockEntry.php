<?php

namespace Xel\Setup\Dock;
use Monolog\Handler\FirePHPHandler;
use Nyholm\Psr7\Factory\Psr17Factory;
use Xel\Async\Http\Applications;
use Xel\Async\Http\Response;
use Xel\Async\Router\RouterRunner;
use Xel\Devise\Service\RestApi\AbstractService;
use function DI\create;
use function Xel\Container\dependency\containerEntry;
use function Xel\Devise\Service\AppClassBinder\serviceMiddlewareGlobals;
use function Xel\Devise\Service\AppClassBinder\serviceRegister;

function DockEntry(): array
{
    $config = require __DIR__ . "/../Config/Config.php";
    $logging = require __DIR__."/../Config/Logging.php";
    return containerEntry(
        [
            /**
             * Server config
             */
            "Application" => create(Applications::class),
            "server" => $config,

            /**
             * Logging
             */
            "Logging" => $logging,
            "FirePHPHandler" => create(FirePHPHandler::class),

            /**
             * Router Config
             */
            "RouterCache" => false,
            "RouterCachePath" => __DIR__."/../../writeable/routerCache",
            "RouterRunner" => create(RouterRunner::class),

            /**
             * Http Protocol Container
             */

            "ServerFactory" =>  create(Psr17Factory::class),
            "StreamFactory" =>  create(Psr17Factory::class),
            "UploadFactory" =>  create(Psr17Factory::class),
            "ResponseFactory" =>  create(Psr17Factory::class),
            "ResponseInterface" =>  create(Response::class),

            /**
             * Service Container
             */
            "ServiceDock" => serviceRegister(),
            "AbstractService" => AbstractService::class,


            /**
             * Global Middleware
             */
            "GlobalMiddleware" => serviceMiddlewareGlobals(),
        ]
    );
}