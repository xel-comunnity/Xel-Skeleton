<?php
    
namespace Xel\Devise\Service\RestApi;
use DI\DependencyException;
use DI\NotFoundException;
use Exception;
use Xel\Async\Http\Responses;
use Xel\Async\Router\Attribute\GET;
use Xel\Async\Router\Attribute\POST;
use Xel\Devise\AbstractService;
use Xel\Devise\Service\Gemstone\GemstoneAuthorization;
use Xel\Devise\Service\Middleware\AuthMiddleware;

class Authentication extends AbstractService
{
    /**
     * @throws DependencyException
     * @throws NotFoundException
     * @throws Exception
     */
    #[POST("/login")]
    public function login(): void
    {
        $sanitize = $this->sanitizeData();

        $this->return
            ->workSpace(function (Responses $responses) use ($sanitize){
                if (GemstoneAuthorization::attempt($sanitize, $responses,$this->container)){
                    $payload = GemstoneAuthorization::encode(responses: $responses,payload: $sanitize, expired: 3600);
                    $responses->json($payload, false, 201);

                }
                $responses->json('not valid user', false, 401);
            });
    }

    #[GET("/async")]
    public function test(){
        $this->return
            ->doProcess(function(){
                echo "hello";
            })
            ->afterExecute('test')
            ->dispatch();
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    #[GET("/protected", [AuthMiddleware::class])]
    public function protectedSource(): void
    {
        $this->return
            ->workSpace(function (Responses $responses){
                $responses->json('valid user', false, 200);
            });
    }


}
