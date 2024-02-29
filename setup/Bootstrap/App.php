<?php

namespace Xel\Setup\Bootstrap;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Xel\Async\Http\Applications;
use Xel\Logger\ApplicationLogger;
use function Xel\Async\Router\Attribute\Generate\{loaderClass,loadCachedClass};

final readonly class App
{
    public function __construct
    (
        private Container $containerBuilder
    )
    {}

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function init(): void
    {

        /**
         * @var array<int|string, mixed $serverConfig>
         */
        $serverConfig = $this->containerInstance()->get('server');

        /**
         * Logger init
         */
        $this->loggerInit();

        /**
         * @var Applications $app
         */
        $app = $this->containerInstance()->get('Application');
        $app
            ->initialize($serverConfig)
            ->onEvent($this->routerConfig(), $this->containerInstance())
            ->run();
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
        loaderClass($class, $cache);

        return loadCachedClass($cache);
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