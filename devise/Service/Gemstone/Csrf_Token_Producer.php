<?php
namespace Xel\Devise\Service\Gemstone;
use Xel\Async\Gemstone\Csrf_Shield;
require __DIR__."/../../../vendor/autoload.php";

if (!function_exists('csrf_token')){
    function csrf_token(): string
    {
        $csrf_maker = require __DIR__."/Gemstone.php";
        $gemstone = new Csrf_Shield();
        return $gemstone->generateCSRFToken($csrf_maker['gemstone_csrf']['key']);
    }


}
