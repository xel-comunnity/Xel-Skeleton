<?php

namespace Xel\Devise\Service\RestApi;
use DI\DependencyException;
use DI\NotFoundException;
use Exception;
use Xel\Async\Http\Responses;
use Xel\Async\Router\Attribute\GET;
use Xel\Devise\AbstractService;

class Service extends AbstractService
{
    /**
     * @throws Exception
     */
    #[GET("/")]
    public function index():void
    {
        $this->return->workSpace(function (Responses $response){
            $response->Display('landing.php');
        });
    }


    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    #[GET("/auth")]
    public function landing(): void
    {
        $this->return
        ->workSpace(function (Responses $response){
            $response->Display('auth/auth.php');
        });  
    }
}
