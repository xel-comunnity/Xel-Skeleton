<?php

namespace Xel\Setup\Bootstrap;
use DI\ContainerBuilder;
use DI\DependencyException;
use DI\NotFoundException;
use Dotenv\Dotenv;
use Exception;
use Xel\Async\Http\Application_v3;
use Xel\Container\Dock;
use Xel\Container\XelContainer;
use function Xel\Async\Router\Attribute\Generate\{loaderClass};
use function Xel\Setup\Dock\DockEntry;

date_default_timezone_set('Asia/Jakarta');
final readonly class App
{
    /**
     * @throws DependencyException
     * @throws NotFoundException
     * @throws Exception
     */
    public function init(): void
    {
        /**
         * Init Container
         */
        $container = new ContainerBuilder();
        // ? container builder
        $xelContainer = new XelContainer($container);
        // ? Load container and launch
        $dock = new Dock($xelContainer, DockEntry());
        // ? launch
        $dependency = $dock->launch();

        /**
         * @var array<int|string, mixed $serverConfig>
         */
        $serverConfig = $dependency->get('server');

        /**
         * DOTENV init
         */
        $dotenv = Dotenv::createImmutable(__DIR__."/../../");
        $dotenv->safeLoad();


        /**
         * Router class collection and path
         */
        $class = $dependency->get('ServiceDock');
        $cache = $dependency->get('RouterCachePath');
        $loaderClass = loaderClass($class, $cache, $_ENV['BUILD']);

        /**
         * Launch Instance
         */
        $app = new Application_v3(
            $serverConfig,
            $loaderClass,
            $dependency->get('dbConfig'),
            $dependency
        );

        $app
            ->gemstoneLimiter()
            ->router()
            ->init();
    }

}