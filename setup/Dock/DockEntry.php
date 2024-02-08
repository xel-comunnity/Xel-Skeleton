<?php

namespace Xel\Setup\Dock;
use HttpSoft\Message\ResponseFactory;
use HttpSoft\Message\ServerRequestFactory;
use HttpSoft\Message\StreamFactory;
use HttpSoft\Message\UploadedFileFactory;
use Xel\Async\Http\Response;
use Xel\Devise\Service\RestApi\Service;
use function DI\create;
use function Xel\Container\dependency\containerEntry;

function DockEntry(): array
{
    $config = require __DIR__ . "/../Config/Config.php";

    return containerEntry(
        [
            /**
             * Server config
             */
            "server" => $config,

            /**
             * Router Config
             */
            "RouterCache" => false,
            "RouterCachePath" => __DIR__."/../../writeable/routerCache",

            /**
             * Http Protocol Container
             */

            "ServerFactory" =>  create(ServerRequestFactory::class),
            "StreamFactory" =>  create(StreamFactory::class),
            "UploadFactory" =>  create(UploadedFileFactory::class),
            "ResponseFactory" =>  create(ResponseFactory::class),
            "ResponseInterface" =>  create(Response::class),

            /**
             * Service Container
             */
            "ServiceDock" => [
                Service::class
            ]

        ]
    );
}