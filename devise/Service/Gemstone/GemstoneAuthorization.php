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
    /************************************************************************************************************
     * Authorization check
     ************************************************************************************************************/
     public static function check(Request $request, Response $responses, Container $container): bool
     {
         if (!isset($request->cookie['X-ACCESS-TOKEN']) && !isset($request->cookie['X-REFRESH-TOKEN'])){
             return false;
         }elseif(isset($request->cookie['X-ACCESS-TOKEN']) === false && isset($request->cookie['X-REFRESH-TOKEN']) === true){
             $data = $request->cookie['X-REFRESH-TOKEN'];
             try {
                 $data = JWT::decode($data, new Key($_ENV["GEMSTONE_REFRESH_KEY"], $_ENV["GEMSTONE_ALGO"]));
                 try {
 
                     // ? check first
                     if (self::userCheck($data, $container) === false){
                         return false;
                     }
                     // ? crete new access token 
                     $newAccessToken = JWT::encode((array)$data, $_ENV["GEMSTONE_SECRET"], $_ENV["GEMSTONE_ALGO"]);
 
                     // ? create new access token 
                     self::middlewareGenerateAccessToken($responses, $newAccessToken);
 
                     return true;
                 } catch (Exception $e) {
                     echo $e->getMessage();
                     return false;
                 }
             } catch (Exception $e) {
                 echo $e->getMessage();
                 return false;
             }
         }elseif(isset($request->cookie['X-ACCESS-TOKEN']) === true && isset($request->cookie['X-REFRESH-TOKEN']) === true){
             $data = $request->cookie['X-ACCESS-TOKEN'];
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
                 return false;
             }
         }else{
            self::deleteSession($responses);
             // ? unset access token 
             return false;                
        }
     } 


    /************************************************************************************************************
     * Authentication check
     ************************************************************************************************************/ 
     public static function attempt(array|stdClass $data, Container $container): bool
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
            } catch (Exception) {
                return false;
            }

        } catch (Exception) {
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
        $result = $query->select([$keys[0], $keys[1]])->from('users')->where('email', '=', $data['email'])->get() ?? [];

        if(count($result) > 0){
            if (password_verify($data['password'], $result[0]['password'])){
                return true;
            } else {
                // User check failed
                return false;
            }
        }else{
            return false;
        }
    }


    private static function deleteSession(Response $responses):void{
        // ? unset access token 
        $responses->setCookie(
            name : "X-ACCESS-TOKEN",
            value : '',
            expires : time() - 3600,
            path : '/',
            domain :'',
            secure : false,
            httponly : true,
            samesite : '',
            priority : ''
        );

        // ? unset refresh token 
        $responses->setCookie(
            name : "X-REFRESH-TOKEN",
            value : '',
            expires : time() - 3600,
            path : '/',
            domain :'',
            secure : false,
            httponly : true,
            samesite : '',
            priority : ''
        );  
    }


    public static function logout(Responses $responses):void{
        // ? unset access token 
        $responses->setCookie(
            name : "X-ACCESS-TOKEN",
            value : '',
            expire : time() - 3600,
            path : '/',
            domain :'',
            secure : false,
            httponly : true,
            sameSite : '',
            priority : ''
        );

        // ? unset refresh token 
        $responses->setCookie(
            name : "X-REFRESH-TOKEN",
            value : '',
            expire : time() - 3600,
            path : '/',
            domain :'',
            secure : false,
            httponly : true,
            sameSite : '',
            priority : ''
        );  
    }

    /************************************************************************************************************
     * Token Management
     ************************************************************************************************************/

    /************************************************************************************************************
     * Utility
    ************************************************************************************************************/
    private static function middlewareGenerateAccessToken(Response $responses, mixed $value):void{
        // ? create new access token 
        $responses->setCookie(
           name : "X-ACCESS-TOKEN",
           value : $value,
           expires : time() + $_ENV["GEMSTONE_COOKIE_ACCESS_EXPIRED"],
           path : '/',
           domain :'',
           secure :   $_ENV["GEMSTONE_COOKIE_SECURE"],
           httponly : $_ENV["GEMSTONE_COOKIE_ONLY"],
           samesite : $_ENV["GEMSTONE_COOKIE_SAMESITE"],
           priority : ''
       );

   }

    private static function generateAccessToken(Responses $responses, mixed $value):void{
         // ? create new access token 
         $responses->setCookie(
            name : "X-ACCESS-TOKEN",
            value : $value,
            expire : time() + $_ENV["GEMSTONE_COOKIE_ACCESS_EXPIRED"],
            path : '/',
            domain :'',
            secure :   $_ENV["GEMSTONE_COOKIE_SECURE"],
            httponly : $_ENV["GEMSTONE_COOKIE_ONLY"],
            sameSite : $_ENV["GEMSTONE_COOKIE_SAMESITE"],
            priority : ''
        );

    }

    private static function generateRefreshToken(Responses $responses,  mixed $value):void{
        // ? create new access token 
        $responses->setCookie(
            name : "X-REFRESH-TOKEN",
            value : $value,
            expire : time() + $_ENV["GEMSTONE_COOKIE_ACCESS_EXPIRED"],
            path : '/',
            domain :'',
            secure :   $_ENV["GEMSTONE_COOKIE_SECURE"],
            httponly : $_ENV["GEMSTONE_COOKIE_ONLY"],
            sameSite : $_ENV["GEMSTONE_COOKIE_SAMESITE"],
            priority : ''
        );
    }
    

    public static function giveAuthorization(Responses $responses,stdClass $payload): array
    {
        $data = get_object_vars($payload);
        $data['expired'] = time() + $_ENV['GEMSTONE_COOKIE_ACCESS_EXPIRED'];

        // ? encode the value
        $access = JWT::encode($data, $_ENV["GEMSTONE_SECRET"], $_ENV["GEMSTONE_ALGO"]);
        $refresh = JWT::encode($data, $_ENV["GEMSTONE_REFRESH_KEY"], $_ENV["GEMSTONE_ALGO"]);

        // ? set access token 
        self::generateAccessToken($responses, $access);

        // ? set refresh token 
        self::generateRefreshToken($responses, $refresh);
       
        return [
            'Token' => $access,
            'Expired' => $data['expired']
        ];
    }

    public static function getData(Request $request): false|stdClass
    {
        $data = $request->header['Authorization'];
        try {
            return JWT::decode($data, new Key($_ENV["GEMSTONE_SECRET"], $_ENV["GEMSTONE_ALGO"]));
        }catch (Exception){
            return false;
        }
    }
}
