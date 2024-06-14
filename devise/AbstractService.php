<?php

namespace Xel\Devise;

use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Swoole\Http\Request;
use Xel\Async\CentralManager\CentralManagerRunner;
use Xel\Async\Gemstone\Csrf_Shield;
use Xel\DB\QueryBuilder\QueryDML;
use Xel\Devise\Service\Gemstone\auth\GemAuthorization;
use Xel\Devise\Service\Gemstone\DataProcessor;
use Xel\Devise\Service\Gemstone\FileProcessor;
use Xel\Logger\LoggerService;

abstract class AbstractService
{
    use DataProcessor, FileProcessor;
    public Request $serverRequest;
    public Container $container;
    public CentralManagerRunner $return;

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    protected function xelCsrfManager():Csrf_Shield{
        /**@var Csrf_Shield $csrfManager */
        $csrfManager = $this->container->get('csrfShield');
        return $csrfManager;
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    protected function log(): LoggerService
    {
        /**
         * @var LoggerService $log
         */
        $log = $this->container->get('log');
        return $log;
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    protected function xgen(): QueryDML
    {
        /**
         * @var QueryDML $log
         */
        $log = $this->container->get('xgen');
        return $log;
    }


    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    protected function auth(): GemAuthorization
    {
        return new GemAuthorization(['email', 'password'], $this->xgen());
    }
}