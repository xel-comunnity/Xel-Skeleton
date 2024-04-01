<?php

namespace Xel\Devise\Service\RestApi;
use DI\DependencyException;
use DI\NotFoundException;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Xel\Async\Router\Attribute\DELETE;
use Xel\Async\Router\Attribute\GET;
use Xel\Async\Router\Attribute\POST;
use Xel\Async\Router\Attribute\PUT;
use Xel\Devise\BaseData\Users;
use Xel\Devise\Service\AbstractService;
class Service extends AbstractService
{
    /**
     * @throws DependencyException
     * @throws NotFoundException
     * @throws Exception
     */
    #[GET("/")]
    public function index(): ResponseInterface
    {
        $result = $this->getQueryBuilder()
            ->select()
            ->from('projects')
            ->get();

        return $this->serverResponse->json($result, 200);
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     * @throws Exception
     */
    #[POST("/create")]
    public function insert(): ResponseInterface
    {
        try {
             // ? Model sanitize special char to prevent xss
             $data = $this
                 ->sanitizeData($this->serverRequest);

            // ? GET Data
            $this->getQueryBuilder()->insert('projects',[
                "name" => $data->name
            ])->run();


        }catch (Exception $e){
            return $this->serverResponse->json(["error" => $e->getMessage(), "errorCode" => $e->getCode()], 422);
        }
        return $this->serverResponse->json(["message" => "data success inserted", "status" => true], 201);
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     * @throws Exception
     */
    #[GET("/userById/{id}")]
    public function readById(int $id): ResponseInterface
    {
        $users = $this
            ->getQueryBuilder()
            ->select()
            ->from('project')->where('id', '=', $id)
            ->get();

        return $this->serverResponse->json($users, 200);
    }

    /**
     * @param int $id
     * @return ResponseInterface
     * @throws DependencyException
     * @throws NotFoundException
     */
    #[PUT('/update/{id}')]
    public function renew(int $id): ResponseInterface
    {
        parse_str($this->serverRequest->getBody()->getContents(), $data);

        try {
            // ? GET Data
            $this->getQueryBuilder()
                ->update
                (
                    'users',
                    [
                        'fullname' => $data['fullname'],
                        'email' => $data['email'],
                        'password' => $data['password'],
                        'date_of_birth' => $data['date_of_birth'],
                        'gender' => $data['gender'],
                        'contact' => $data['contact'],
                        'religion' => $data['religion'],
                    ]
                )->where('id', '=', $id)
                ->run();
        }catch (Exception $e){
            return $this->serverResponse->json(["error" => $e->getMessage(), "errorCode" => $e->getCode()], 422);
        }
        return $this->serverResponse->json(["message" => "success updated"], 200);
    }

    /**
     * @param int $id
     * @return ResponseInterface
     * @throws DependencyException
     * @throws NotFoundException
     */
    #[DELETE("/delete/{id}")]
    public function remove(int $id): ResponseInterface
    {
        try {
            // ? GET Data
            $this->getQueryBuilder()
                ->delete('users')
                ->where('id', '=',  $id)
                ->run();
        }catch (Exception $e){
            return $this->serverResponse->json(["error" => $e->getMessage(), "errorCode" => $e->getCode()], 422);
        }
        return $this->serverResponse->json(["message" => "success updated"], 200);
    }
}