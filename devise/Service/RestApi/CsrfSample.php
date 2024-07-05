<?php
    
namespace Xel\Devise\Service\RestApi;
use DI\DependencyException;
use DI\NotFoundException;
use Exception;
use Xel\Devise\AbstractService;
use Xel\Async\Http\Responses;
use Xel\Async\Router\Attribute\GET;
use Xel\Devise\BaseData\Users;


class CsrfSample extends AbstractService
{
    /**
     * @throws DependencyException
     * @throws NotFoundException
     * @throws Exception
     */
    #[GET("/csrfsample")]
    public function index(): void
    {
        $this->return->loadBaseData('users')
        ->workSpace(function (Responses $response, Users $users){
            $data = $users->selectAll();
            $response->json($data, false, 200);
        });
    }  
}
