<?php

use Monolog\Level;
use Monolog\Logger;
use Xel\Logger\LoggerSchedule;

return [
    "mode" => "single", // change to stack to separate the logger,
    "single_logging_generation" => LoggerSchedule::Daily->apply(),
    "path" => __DIR__."/../../writeable/log/xel.log",
    "collections" => [
        "my_logger" => [
            "channel" => new Logger("my_logger"),
            "path" => __DIR__."/../..my_logger.log",
            "logging_generation"=> LoggerSchedule::Daily->apply(),
            "level" => Level::Debug,
        ],

        "security" => [
            "channel" => new Logger("security"),
            "path" => __DIR__.'/security.log',
            "logging_generation"=> LoggerSchedule::Daily->apply(),
            "level" => Level::Error,
        ],
    ],
];