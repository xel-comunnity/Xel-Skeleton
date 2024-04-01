<?php

namespace Xel\Setup\Bootstrap;
use DI\Container;
use DI\ContainerBuilder;
use DI\DependencyException;
use DI\NotFoundException;
use Dotenv\Dotenv;
use Exception;
use Xel\Async\Http\Applications;
use Xel\Container\Dock;
use Xel\Container\XelContainer;
use Xel\Logger\ApplicationLogger;
use function Xel\Async\Router\Attribute\Generate\{loaderClass};
use function Xel\Setup\Dock\DockEntry;

final readonly class App
{
    private Container $containerBuilder;

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
        $this->containerBuilder = $dock->launch();

        /**
         * @var array<int|string, mixed $serverConfig>
         */
        $serverConfig = $this->containerInstance()->get('server');

        /**
         * DOTENV init
         */
        $dotenv = Dotenv::createImmutable(__DIR__."/../../");
        $dotenv->safeLoad();

        /**
         * Logger init
         */
        $this->loggerInit();

        $app = new Applications(
            $serverConfig,
            $this->routerConfig(),
            $this->containerInstance()->get('dbConfig'),
            $this->containerInstance()
        );
        $app->initialize();
    }

    private function containerInstance(): Container
    {
        return $this->containerBuilder;
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    private function routerConfig(): ?array
    {
        /**
         * Router class collection and path
         */
        $class = $this->containerInstance()->get('ServiceDock');
        $cache = $this->containerInstance()->get('RouterCachePath');

        /**
         * Load clas and Generate route cache
         */

        return  loaderClass($class, $cache, $_ENV['BUILD']);
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    private function loggerInit(): void
    {
        /**
         * Logger Init
         */
        $loggerConfig = $this->containerInstance()->get('Logging');
        $FireHandler =  $this->containerInstance()->get('FirePHPHandler');

        ApplicationLogger::init($loggerConfig, $FireHandler);
    }

}