<?php

namespace Xel\Devise\Service\RestApi;

use DI\Container;
use Psr\Http\Message\ServerRequestInterface;
use Xel\Async\Http\Response;

abstract class AbstractService
{
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
}