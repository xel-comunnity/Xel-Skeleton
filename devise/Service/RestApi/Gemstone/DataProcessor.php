<?php

namespace Xel\Devise\Service\RestApi\Gemstone;

use Exception;
use Psr\Http\Message\ServerRequestInterface;

trait DataProcessor
{
    /**
     * @throws Exception
     */
    public function sanitizeData(ServerRequestInterface $serverRequest)
    {

        $data = $this->parser($serverRequest);
        if($data !== false){
            return $data;
        }
        throw new Exception('Content is not valid');
    }

    /**
     * @throws Exception
     */
    private function parser(ServerRequestInterface $serverRequest): mixed
    {
        $contentType = $serverRequest->getHeaderLine('Content-Type');
        switch ($contentType){
            case "application/x-www-form-urlencoded" :
                parse_str($serverRequest->getBody()->getContents(), $Content);
                $sanitizedData = [];
                foreach ($Content as $key => $value) {
                    $sanitizedData[$key] = htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                }
                return (object)$sanitizedData;
            case "application/json" :
                $data = json_decode($serverRequest->getBody()->getContents(), true);
                if (is_array($data)) {
                    array_walk_recursive($data, function (&$value) {
                        $value = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
                    });
                } elseif (is_scalar($data)) {
                    $data = filter_var($data, FILTER_SANITIZE_SPECIAL_CHARS);
                }
                return (object)$data;
            default :
                return false;
        }
    }
}