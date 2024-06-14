<?php

namespace Xel\Devise\Service\Gemstone\auth;
use Exception;
use Firebase\JWT\JWT;
use PDOException;
use Xel\Async\Http\Responses;
use Xel\DB\QueryBuilder\QueryDML;

readonly class GemAuthorization
{
    public function __construct(private array $validationParam, private QueryDML $queryDML)
    {}

    /**
     * @throws Exception
     */
    public function JwtAuth(array $param): bool|array
    {
        // ? fetch auth data
        try {
            $authDataFetch = $this->queryDML->select()->from('users')->where($this->validationParam[0], '=', $param[$this->validationParam[0]])->get();
            if (count($authDataFetch) > 0){
               $check = password_verify($param[$this->validationParam[1]], $authDataFetch[0][$this->validationParam[1]]);

               if ($check === false){
                   return false;
               }

               // add expired time
               $param['expired'] =   time() + $_ENV['GEMSTONE_COOKIE_ACCESS_EXPIRED'];
               $access = JWT::encode($param, $_ENV["GEMSTONE_SECRET"], $_ENV["GEMSTONE_ALGO"]);
               $refresh = JWT::encode($param, $_ENV["GEMSTONE_REFRESH_KEY"], $_ENV["GEMSTONE_ALGO"]);

               $this->queryDML->resetState();
               return [
                   "access_token" => $access,
                   "refresh_token" => $refresh
               ];

            }
        }catch (PDOException $exception){
            throw  new Exception($exception->getMessage());
        }

        return 0;
    }

    /**
     * @throws Exception
     */
    public function storeToCookie(Responses $responses, array $token):void
    {
        try {
            // ? create new access token
            $responses->setCookie(
                name : "X-ACCESS-TOKEN",
                value : $token['access_token'],
                expire : time() + $_ENV["GEMSTONE_COOKIE_ACCESS_EXPIRED"],
                secure :   $_ENV["GEMSTONE_COOKIE_SECURE"],
                httponly : $_ENV["GEMSTONE_COOKIE_ONLY"],
                sameSite : $_ENV["GEMSTONE_COOKIE_SAMESITE"],
            );

            // ? store refresh  token to cookie
            $responses->setCookie(
                name : "X-REFRESH-TOKEN",
                value : $token['refresh_token'],
                expire : time() + $_ENV["GEMSTONE_COOKIE_ACCESS_EXPIRED"],
                secure :   $_ENV["GEMSTONE_COOKIE_SECURE"],
                httponly : $_ENV["GEMSTONE_COOKIE_ONLY"],
                sameSite : $_ENV["GEMSTONE_COOKIE_SAMESITE"],
            );
        }catch (Exception $e){
            throw new Exception($e->getMessage());
        }

    }

    /**
     * @throws Exception
     */
    public function flushAuth(Responses $responses): void
    {
        try {
            // ? unset access token
            $responses->setCookie(
                name : "X-ACCESS-TOKEN",
                expire : time() - 3600,
            );

            // ? unset refresh token
            $responses->setCookie(
                name : "X-REFRESH-TOKEN",
                expire : time() - 3600,
            );
        }catch (Exception $e){
            throw new Exception($e->getMessage());
        }

    }
}