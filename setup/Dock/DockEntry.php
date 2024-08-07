<?php

namespace Xel\Setup\Dock;
use Monolog\Handler\FirePHPHandler;
use Nyholm\Psr7\Factory\Psr17Factory;
use Xel\Async\Router\RouterRunner;
use Xel\Devise\AbstractService;
use Xel\Devise\Job\test;
use Xel\Logger\LoggerService;
use function DI\{create, get};
use function Xel\Container\dependency\containerEntry;
use function Xel\Devise\Service\AppClassBinder\serviceMiddlewareGlobals;
use function Xel\Devise\Service\AppClassBinder\serviceModelRegister;
use function Xel\Devise\Service\AppClassBinder\serviceRegister;

function DockEntry(): array
{
    $config = require __DIR__ . "/../Config/Server.php";
    $logging = require __DIR__."/../Config/Logging.php";
    $dbConfig = require __DIR__."/../Config/DBConfig.php";
    $gemstone = require __DIR__."/../../devise/Service/Gemstone/Gemstone.php";
    return containerEntry(
        [
            /**
             * Server config
             */
            "server" => $config,

            /**
             * Db Config
             */
            "dbConfig" => $dbConfig,

            /**
             * Logging
             */
            "Logging" => $logging,
            "FirePHPHandler" => create(FirePHPHandler::class),
            "log" =>  create(LoggerService::class)->constructor($logging, get('FirePHPHandler')),

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

            /**
             * Job Dispatcher
             */
            'test' => test::class,

            /***
             * Gemstone
             */
            'gemstone' => $gemstone,

            /**
             * BaseData
             */
            'basedata' => serviceModelRegister(),

            /**
             * Display Path
             */
            'display_path' => __DIR__."/../../devise/Display/",
        ]
    );
}