<?php

namespace Xel\Devise\Service\Gemstone\request;
use Exception;
use HTMLPurifier;
use HTMLPurifier_Config;

trait DataProcessor
{
    /**
    /**
     * @throws Exception
     */
    public function sanitizeData(): object
    {
        $data = $this->parser();
        if ($data !== false) {
            return $data;
        }
        throw new Exception('Content is not valid');
    }

    public function getRequestFromMultipart($expectedFields = []): array
    {
        // Create HTMLPurifier instance with default configuration
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);

        // Retrieve POST data
        $data = $this->serverRequest->post;

        // Remove the 'id' field if it exists
        if (isset($data['id'])) {
            unset($data["id"]);
        }

        // Sanitize each field in the data array
        $sanitizedData = [];
        foreach ($data as $key => $value) {
            if (!array_key_exists($key, $expectedFields)) {
                // Default to basic sanitization if the field is not in expectedFields
                $sanitizedData[$key] = htmlspecialchars($purifier->purify($value), ENT_QUOTES, 'UTF-8');
                continue;
            }

            switch ($expectedFields[$key]) {
                case 'string':
                    // Use HTMLPurifier to remove any malicious content and encode special characters
                    $sanitizedValue = htmlspecialchars($purifier->purify($value), ENT_QUOTES, 'UTF-8');
                    break;

                case 'email':
                    // Validate and sanitize email address
                    $sanitizedValue = filter_var($value, FILTER_SANITIZE_EMAIL);
                    if (!filter_var($sanitizedValue, FILTER_VALIDATE_EMAIL)) {
                        $sanitizedValue = ''; // Invalid email
                    } else {
                        // Further sanitize using HTMLPurifier
                        $sanitizedValue = htmlspecialchars($purifier->purify($sanitizedValue), ENT_QUOTES, 'UTF-8');
                    }
                    break;

                case 'int':
                    // Sanitize integer value
                    $sanitizedValue = filter_var($value, FILTER_SANITIZE_NUMBER_INT);
                    $sanitizedValue = filter_var($sanitizedValue, FILTER_VALIDATE_INT) !== false ? (int)$sanitizedValue : 0;
                    break;

                default:
                    // Default to HTMLPurifier sanitization
                    $sanitizedValue = htmlspecialchars($purifier->purify($value), ENT_QUOTES, 'UTF-8');
                    break;
            }

            $sanitizedData[$key] = $sanitizedValue;
        }

        return $sanitizedData;
    }


    /**
     * @throws Exception
     */
    private function parser(): false|object
    {
        $contentType = $this->serverRequest->header['content-type'];
        switch ($contentType) {
            case "application/x-www-form-urlencoded":
            case "application/json":
                $data = $this->parseAndSanitize($this->serverRequest->getContent(), $contentType);
                return (object)$data;
            default:
                return false;
        }
    }

    /**
     * @param string $content
     * @param string $contentType
     * @return array|false
     */
    private function parseAndSanitize(string $content, string $contentType): false|array
    {
        // Create HTMLPurifier instance with default configuration
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);

        if ($contentType === "application/x-www-form-urlencoded") {
            parse_str($content, $data);
        } else {
            $data = json_decode($content, true);
            if (!is_array($data)) {
                return false;
            }
        }

        array_walk_recursive($data, function (&$value) use ($purifier) {
            // Use HTMLPurifier to sanitize the value
            $value = $purifier->purify($value);

            // Additional sanitization
            $value = htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        });

        return $data;
//        if ($contentType === "application/x-www-form-urlencoded") {
//            parse_str($content, $data);
//        } else {
//            $data = json_decode($content, true);
//            if (!is_array($data)) {
//                return false;
//            }
//        }
//
//        array_walk_recursive($data, function (&$value) {
//            //$value = preg_replace('/[^a-zA-Z0-9\s]/', '', htmlspecialchars(filter_var($value, FILTER_SANITIZE_STRING), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
//            $value = htmlspecialchars( htmlentities(filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS)), ENT_QUOTES | ENT_HTML5, 'UTF-8');
//
//        });
//
//        return $data;
    }


}