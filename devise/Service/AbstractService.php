<?php

namespace Xel\Devise\Service;

use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Psr\Http\Message\ServerRequestInterface;
use Xel\Async\Http\Response;
use Xel\DB\QueryBuilder\QueryDML;
use Xel\Devise\BaseData\QueryHelper\ORM;
use Xel\Devise\Service\RestApi\Gemstone\DataProcessor;

abstract class AbstractService
{
    use DataProcessor, ORM;
    protected ServerRequestInterface $serverRequest;
    protected Response $serverResponse;
    protected Container $container;
    public function setRequest(ServerRequestInterface $serverRequest): void
    {
       $this->serverRequest = $serverRequest;
    }

    public function setResponse(Response $serverResponse): void
    {
        $this->serverResponse = $serverResponse;
    }

    public function setContainer(Container $container): void
    {
        $this->container = $container;
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function getQueryBuilder(): QueryDML
    {
        /**@var QueryDML $queryBuilder*/
        $queryBuilder = $this->container->get('xgen');
        return $queryBuilder;
    }
    
}