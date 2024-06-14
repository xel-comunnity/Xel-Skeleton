<?php
    
namespace Xel\Devise\Service\RestApi\Auth;
use DI\DependencyException;
use DI\NotFoundException;
use Exception;
use Xel\Async\Http\Responses;
use Xel\Async\Router\Attribute\GET;
use Xel\Async\Router\Attribute\POST;
use Xel\DB\QueryBuilder\QueryDML;
use Xel\Devise\AbstractService;
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
            ->workSpace(function (Responses $responses, QueryDML $queryDML) use ($sanitize){
                // check the user is valid user
                $token = $this->auth()->JwtAuth(["email" => $sanitize->email, "password" => $sanitize->password]);

                // if return token u can store to cookie for jwt
                if (is_array($token)){
                    $this->auth()->storeToCookie($responses, $token);
                    $responses->json('success authenticated', false, 201);
                }

                // if not request invalid
                $responses->json('email or password not valid', false, 401);
            });
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     * @throws Exception
     */

    #[GET("/logout", [AuthMiddleware::class])]
    public function logout():void{
        $this->return
        ->workSpace(function (Responses $responses){
            $this->auth()->flushAuth($responses);
            $responses->Display('auth/auth.php');
        });
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
