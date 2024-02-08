<?php

namespace Xel\Devise\Service\RestApi;

use Psr\Http\Message\ResponseInterface;
use Xel\Async\Router\Attribute\GET;

class Service extends AbstractService
{
    #[GET("/")]
    public function index(): ResponseInterface
    {
        return $this->serverResponse->plain("Hello Xel", 200);
    }

}