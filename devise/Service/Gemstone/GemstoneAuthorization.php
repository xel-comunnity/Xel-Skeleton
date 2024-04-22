<?php

namespace Xel\Devise\Service\Gemstone;


use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use stdClass;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Xel\Async\Http\Responses;
use Xel\DB\QueryBuilder\QueryDML;

class GemstoneAuthorization
{
    public static function check(Request $request, Response $responses, Container $container): bool
    {
        if (!isset($request->cookie['X-Requested-With'])){
            return false;
        }else{
            $data = $request->cookie['X-Requested-With'];
            try {

                $data = JWT::decode($data, new Key($_ENV["GEMSTONE_SECRET"], $_ENV["GEMSTONE_ALGO"]));
                try {
                    if (self::userCheck($data, $container) === false){
                        return false;
                    }
                    return true;
                } catch (Exception $e) {
                    echo $e->getMessage();

                    return false;
                }
            } catch (Exception $e) {
                echo $e->getMessage();
                return false;
            }
        }
    }

    public static function attempt(array|stdClass $data, Responses $responses, Container $container): bool
    {
        try {
            /**
             * @var QueryDML $query
             */
            $query = $container->get('xgen');
            $result = $query->select()->from('users')->where('email','=', $data->email)->get();
            if (count($result) > 0){
                return password_verify($data->password, $result[0]['password']);
            }

            try {
                if (self::userCheck($data, $container) === false){
                    return false;
                }
                return true;
            } catch (Exception $e) {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     * @throws Exception
     */
    private static function userCheck(stdClass $user, Container $container): bool
    {
        $data = get_object_vars($user);
        $keys = array_keys($data);

        /**
         * @var QueryDML $query
         */
        $query = $container->get('xgen');
        $result = $query->select([$keys[0], $keys[1]])->from('users')->where('email', '=', $data['email'])->get();
        if (password_verify($data['password'], $result[0]['password'])){
            return true;
        } else {
            // User check failed
            return false;
        }
    }

    public static function encode(Responses $responses,stdClass $payload, int $expired): array
    {
        $data = get_object_vars($payload);
        $data['expired'] = time() + $expired;
        $token = JWT::encode($data, $_ENV["GEMSTONE_SECRET"], $_ENV["GEMSTONE_ALGO"]);

        $responses->setCookie(
            name : "X-Requested-With",
            value : $token,
            expire :  $data['expired'],
            path : '/',
            domain :'',
            secure : false,
            httponly : true,
            sameSite : 'lax',
            priority : ''
        );
        return [
            'Token' => $token,
            'Expired' => $data['expired']
        ];
    }

    public static function getData(Request $request): false|stdClass
    {
        $data = $request->header['Authorization'];
        try {
            return JWT::decode($data, new Key($_ENV["GEMSTONE_SECRET"], $_ENV["GEMSTONE_ALGO"]));
        }catch (Exception $e){
            return false;
        }
    }
}