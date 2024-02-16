<?php

namespace Xel\Devise\Service\RestApi;

use Psr\Http\Message\ResponseInterface;
use Xel\Async\Router\Attribute\GET;

class Service extends AbstractService
{
    #[GET("/")]
    public function index(): ResponseInterface
    {
//        $this->serverRequest->getMethod();
        return $this->serverResponse->plain("Hello Xel", 200);
    }

}