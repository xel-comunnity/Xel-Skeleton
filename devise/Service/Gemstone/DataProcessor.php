<?php

namespace Xel\Devise\Service\Gemstone;
use Exception;

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
    private function parseAndSanitize(string $content, string $contentType)
    {
        if ($contentType === "application/x-www-form-urlencoded") {
            parse_str($content, $data);
        } else {
            $data = json_decode($content, true);
            if (!is_array($data)) {
                return false;
            }
        }

        array_walk_recursive($data, function (&$value) {
            //$value = preg_replace('/[^a-zA-Z0-9\s]/', '', htmlspecialchars(filter_var($value, FILTER_SANITIZE_STRING), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            $value = htmlspecialchars(filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS), ENT_QUOTES | ENT_HTML5, 'UTF-8');

        });

        return $data;
    }

}