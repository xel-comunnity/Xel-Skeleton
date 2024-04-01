<?php

namespace Xel\Devise\Service\AppClassBinder;
use Xel\Devise\Service\Console\CreateConsole;
use Xel\Devise\Service\Console\CreateMigration;
use Xel\Devise\Service\Console\MiddlewareGenerator;
use Xel\Devise\Service\Console\MigrationDrop;
use Xel\Devise\Service\Console\MigrationMigrate;
use Xel\Devise\Service\Console\MigrationMigrateFresh;
use Xel\Devise\Service\Console\MigrationRollback;
use Xel\Devise\Service\Console\ProductionCommand;
use Xel\Devise\Service\Console\RestAPIGenerator;
use Xel\Devise\Service\Console\RouterDelete;
use Xel\Devise\Service\Console\RouterGenerator;
use Xel\Devise\Service\Console\RouterList;
use Xel\Devise\Service\Console\RouterRegenerate;
use Xel\Devise\Service\Console\ServerCommand;
use Xel\Devise\Service\Middleware\CorsMiddleware;
use Xel\Devise\Service\RestApi\Service;


function serviceRegister(): array
{
    return [
        Service::class,
    ];
}

function serviceModelRegister(): array
{
    return [

    ];
}

function serviceMiddlewareGlobals(): array
{
    return [
        CorsMiddleware::class
    ];
}

function serviceConsoleRegister():array
{
    return [
        ServerCommand::class,
        ProductionCommand::class,
        CreateConsole::class,
        RestAPIGenerator::class,
        RouterGenerator::class,
        RouterList::class,
        RouterDelete::class,
        RouterRegenerate::class,
        MiddlewareGenerator::class,
        MigrationMigrate::class,
        MigrationMigrateFresh::class,
        MigrationRollback::class,
        MigrationDrop::class,
        CreateMigration::class
    ];
}