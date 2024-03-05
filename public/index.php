<?php

use DI\DependencyException;
use DI\NotFoundException;
use Dotenv\Dotenv;
use Xel\Setup\Bootstrap\App;
require __DIR__."/../vendor/autoload.php";

$app = new App();
try {
    $app->init();
} catch (DependencyException|NotFoundException|Exception $e) {
    echo "error : ".$e->getMessage();
}



