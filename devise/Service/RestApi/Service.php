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

    /**
     * @throws DependencyException
     * @throws NotFoundException
     * @throws Exception
     */
    #[GET("/json")]
    public function json(): void
    {
        $this->return
            ->workSpace(function (Responses $response, QueryDML $queryDML){
                $data = $queryDML->select(['id','email'])->from('users')->get();
                var_dump($_ENV['HOST']);
                $response->json($data,false,200);
            });
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     * @throws Exception
     */
    #[GET("/logger")]
    public function logger(): void
    {
        $this->return
            ->workSpace(function (Responses $response){
                    $response->json(["duar meme"], false, 200);
            });
    }
}
