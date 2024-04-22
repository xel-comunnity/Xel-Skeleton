<?php
    
namespace Xel\Devise\Service\RestApi;
use DI\DependencyException;
use DI\NotFoundException;
use Xel\Async\Http\Responses;
use Xel\Async\Router\Attribute\GET;
use Xel\Async\Router\Attribute\POST;
use Xel\DB\QueryBuilder\QueryDML;
use Xel\Devise\AbstractService;

class sample extends AbstractService
{   
    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    #[POST("/xss")]
    public function xss(): void
    {
        $sanitized = $this->sanitizeData();
        $this->return->workSpace(function(Responses $responses)use($sanitized){
                var_dump($sanitized);
        });
    }
    
    #[GET("/rate-limit/{id}")]
    public function rateLimit($id): void
    {
        $this->return->workSpace(function(Responses $responses)use($id){
                var_dump($id);
        });
    }  

    #[GET("/query")]
    public function query(): void
    {
        $this->return->workSpace(function(Responses $responses, QueryDML $queryDML){
            $result =  $queryDML->select(['id', 'email'])->from('users')->get();
            $responses->json($result, false, 200);
        });    
    }
    
    #[GET("/query-bunch")]
    public function queryBunch(): void
    {
        $this->return->workSpace(function(Responses $responses, QueryDML $queryDML){
            $result =  $queryDML->select(['id', 'email'])->from('users')->get();
            $responses->json($result, false, 200);
        });    
    } 
    
}
