<?php

namespace Xel\Devise;

use DI\Container;
use Swoole\Http\Request;
use Xel\Async\CentralManager\CentralManagerRunner;
use Xel\Async\Gemstone\Csrf_Shield;
use Xel\Devise\Service\Gemstone\DataProcessor;
use Xel\Devise\Service\Gemstone\FileProcessor;

abstract class AbstractService
{
    use DataProcessor, FileProcessor;
    public Request $serverRequest;
    public Container $container;
    public CentralManagerRunner $return;

    protected function xelCsrfManager():Csrf_Shield{
        /**@var Csrf_Shield $csrfManager */
        $csrfManager = $this->container->get('csrfShield');
        return $csrfManager;
    }
}