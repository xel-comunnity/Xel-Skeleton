<?php
    
namespace Xel\Devise\Service\RestApi;
use Xel\Devise\AbstractService;
use Xel\Async\Http\Responses;
use Xel\Async\Router\Attribute\POST;

class Transfer extends AbstractService
{   
    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    #[POST("/transfer/protected")]
    public function index(): void
    {
        $this->return
        ->workSpace(function (Responses $response){
           $data = $this->getRequestFromMultipart(['amount' => 'string', 'recipient' => 'string']);
           
           $response->json(["flag" => true, "message" => "transaction success", "data" => $data], false, 200);
        });
    }  

     /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    #[POST("/transfer/vulnerable")]
    public function vulnerable(): void
    {
        $this->return
        ->workSpace(function (Responses $response){
            $data = $this->getRequestFromMultipart(['amount' => 'string', 'recipient' => 'string']);
           
            $response->json(["flag" => true, "message" => "transaction success", "data" => $data], false, 200);        });  
    }  
}
