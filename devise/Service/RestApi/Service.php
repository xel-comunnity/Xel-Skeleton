<?php

namespace Xel\Devise\Service\RestApi;
use DI\DependencyException;
use DI\NotFoundException;
use Exception;
use Xel\Async\Http\Responses;
use Xel\Async\Router\Attribute\GET;
use Xel\DB\QueryBuilder\QueryDML;
use Xel\Devise\AbstractService;


class Service extends AbstractService
{
    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    #[GET("/")]
    public function index():void
    {
        $this->return->workSpace(function (Responses $response){
            $response->json(['hello world'], false, 200);
        });
    }

     /**
     * @throws DependencyException
     * @throws NotFoundException
     * @throws Exception
     */
    #[GET("/users")]
    public function json(): void
    {
        $this->return
            ->workSpace(function (Responses $response, QueryDML $queryDML){
                $data = $queryDML->select(['id','name','email'])->from('users')->get();
                $response->json($data,false,200);
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

   

    /**
     * @throws DependencyException
     * @throws NotFoundException
     * @throws Exception
     */
    #[GET("/xss/{name}")]
    public function logger($name): void
    {
        $data = $this->sanitizeUrlParam($name);
        $this->return
            ->workSpace(function (Responses $response) use ($data){
                    $response->json(["sanitized result" => $data], false, 200);
            });
    }
}
