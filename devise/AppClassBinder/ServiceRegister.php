<?php

namespace Xel\Devise\Service\AppClassBinder;
use Xel\Devise\BaseData\Projects;
use Xel\Devise\BaseData\Users;
use Xel\Devise\Service\Console\CreateConsole;
use Xel\Devise\Service\Console\CreateMigration;
use Xel\Devise\Service\Console\MiddlewareGenerator;
use Xel\Devise\Service\Console\MigrationDrop;
use Xel\Devise\Service\Console\MigrationMigrate;
use Xel\Devise\Service\Console\MigrationMigrateFresh;
use Xel\Devise\Service\Console\MigrationRollback;
use Xel\Devise\Service\Console\MigrationSeeder;
use Xel\Devise\Service\Console\ProductionCommand;
use Xel\Devise\Service\Console\RestAPIGenerator;
use Xel\Devise\Service\Console\RouterDelete;
use Xel\Devise\Service\Console\RouterGenerator;
use Xel\Devise\Service\Console\RouterList;
use Xel\Devise\Service\Console\RouterRegenerate;
use Xel\Devise\Service\Console\ServerCommand;
use Xel\Devise\Service\Console\TokenGeneratorConsole;
use Xel\Devise\Service\RestApi\Auth\Authentication;
use Xel\Devise\Service\RestApi\Crud;
use Xel\Devise\Service\RestApi\CsrfSample;
use Xel\Devise\Service\RestApi\csrfTokenMaker\CsrfTokenMaker;
use Xel\Devise\Service\RestApi\Service;
use Xel\Devise\Service\RestApi\Transfer;

function serviceRegister(): array
{
    return [
        Service::class,
        Authentication::class,
        CsrfTokenMaker::class,
        Crud::class,
        CsrfSample::class,
        Transfer::class
    ];
}

function serviceModelRegister(): array
{
    return [
        "projects" => Projects::class,
        "users" => Users::class
    ];
}

function serviceMiddlewareGlobals(): array
{
    return [];
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
        CreateMigration::class,
        TokenGeneratorConsole::class,
        MigrationSeeder::class
    ];
}