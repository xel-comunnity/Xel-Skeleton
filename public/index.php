<?php

use DI\ContainerBuilder;
use Xel\Async\Http\Applications;
use Xel\Container\XelContainer;
use Xel\Container\Dock;
use function Xel\Async\Router\Attribute\Generate\{loaderClass,loadCachedClass};
use function Xel\Setup\Dock\DockEntry;

require __DIR__."/../vendor/autoload.php";

try {

    /**
     * Register Container
     */
    $DIContainer = new ContainerBuilder();
    $xelContainer = new XelContainer($DIContainer);
    $Dock = new Dock($xelContainer, DockEntry());
    $container = $Dock->launch();
    $Class = $container->get("ServiceDock");

    /**
     * Server config
     */
    $Config = $container->get('server');

    /**
     * Class Cache Loader
     *
     */
    $path = $container->get("RouterCachePath");

    loaderClass($Class, $path);
    $cacheClass = loadCachedClass($path);

    /**
     * Launch Class
     */
    $app = new Applications();
    $app
        ->initialize($Config)
        ->onEvent($cacheClass, $container)
        ->run();

}catch (ReflectionException $e){
    echo "Reflection error : ". $e->getMessage();
}