<?php

namespace Xel\Devise\Service\Gemstone\auth;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use stdClass;
use Swoole\Http\Request;
use Swoole\Http\Response;

readonly class GemAuthValidator
{
    public function __construct(private Request $request, private Response $response)
    {}

    /**
     * @throws Exception
     */
    public function validateCookie():bool
    {
        $request = $this->request;
        if (!isset($request->cookie['X-ACCESS-TOKEN']) && !isset($request->cookie['X-REFRESH-TOKEN'])){
            return false;
        }elseif(isset($request->cookie['X-ACCESS-TOKEN']) === false && isset($request->cookie['X-REFRESH-TOKEN']) === true){
            $token = $request->cookie['X-REFRESH-TOKEN'];
            try {
                // decode jwt and identify
                $isIdentifiedUser = JWT::decode($token, new Key($_ENV["GEMSTONE_REFRESH_KEY"], $_ENV["GEMSTONE_ALGO"]));
                try {
                   // ? check first
                   if(!is_object($isIdentifiedUser)){
                       return  false;
                   }
                   // ? create new access token
                   $this->regenerate_access_token($isIdentifiedUser);

                   return true;
                } catch (Exception) {
                    return false;
                }

            } catch (Exception) {
                return false;
            }
        }elseif(isset($request->cookie['X-ACCESS-TOKEN']) === true && isset($request->cookie['X-REFRESH-TOKEN']) === true){
            $data = $request->cookie['X-ACCESS-TOKEN'];
            try {
                $isIdentifiedUser = JWT::decode($data, new Key($_ENV["GEMSTONE_SECRET"], $_ENV["GEMSTONE_ALGO"]));

                // ? check first
                if(!is_object($isIdentifiedUser)){
                    return  false;
                }

                return true;

            } catch (Exception) {
              return false;
            }
        }
        return 0;
    }

    public function validateNonJWT()
    {}


    /********************************************************************************************************
     * hook utility for validate user
     ********************************************************************************************************/
    private function regenerate_access_token(stdClass $param): void
    {
        $payload = (array) $param;
        // create new access token
        $token =  JWT::encode($payload, $_ENV["GEMSTONE_SECRET"], $_ENV["GEMSTONE_ALGO"]);

        // ? create new access token
        $this->response->setCookie(
            name : "X-ACCESS-TOKEN",
            value : $token,
            expires : time() + $_ENV["GEMSTONE_COOKIE_ACCESS_EXPIRED"],
            secure :   $_ENV["GEMSTONE_COOKIE_SECURE"],
            httponly : $_ENV["GEMSTONE_COOKIE_ONLY"],
            sameSite : $_ENV["GEMSTONE_COOKIE_SAMESITE"],
        );
    }
}