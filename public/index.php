<?php

use DI\ContainerBuilder;
use DI\DependencyException;
use DI\NotFoundException;
use Xel\Container\XelContainer;
use Xel\Container\Dock;
use Xel\Setup\Bootstrap\App;
use function Xel\Setup\Dock\DockEntry;

require __DIR__."/../vendor/autoload.php";

$container = new ContainerBuilder();
// ? container builder
$xelContainer = new XelContainer($container);
// ? Load container and launch
$dock = new Dock($xelContainer, DockEntry());
// ? launch
$injection = $dock->launch();

$app = new App($injection);

try {
    $app->init();
} catch (DependencyException|NotFoundException $e) {
    echo "error : ".$e->getMessage();
}