<?php

namespace Xel\Devise\Service\RestApi;

use Psr\Http\Message\ServerRequestInterface;
use Xel\Async\Http\Response;

abstract class AbstractService
{
    protected ServerRequestInterface $serverRequest;
    protected Response $serverResponse;

    public function setRequest(ServerRequestInterface $serverRequest): void
    {
       $this->serverRequest = $serverRequest;
    }

    public function setResponse(Response $serverResponse): void
    {
        $this->serverResponse = $serverResponse;
    }
}