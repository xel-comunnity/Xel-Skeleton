<?php

namespace Xel\Devise\Service\RestApi;
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
        $this->return
        ->workSpace(function (Responses $response){
            $response->Display('landing.php');
        });  
        

    }

    #[GET("/auth")]
    public function landing(){
        $this->return
        ->workSpace(function (Responses $response){
            $response->Display('auth/auth.php');
        });  
    }
}
