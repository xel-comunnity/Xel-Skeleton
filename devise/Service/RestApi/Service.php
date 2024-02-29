<?php

namespace Xel\Devise\Service\RestApi;
use DI\DependencyException;
use DI\NotFoundException;
use Psr\Http\Message\ResponseInterface;
use Xel\Async\Router\Attribute\GET;

class Service extends AbstractService
{
    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    #[GET("/")]
    public function index(): ResponseInterface
    {
        return $this->serverResponse->plain("Hello Xel", 200);
    }
}