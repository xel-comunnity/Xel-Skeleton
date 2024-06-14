<?php

use Monolog\Level;
use Xel\Logger\LoggerSchedule;

return [
    "mode" => "single", // change to stacked to separate the logger,
    "single_logging_generation" => [
        'level' => Level::Debug, // Log level for the single logger
        'format' => LoggerSchedule::Daily->apply(), // Log file name format
    ],
    "path" => __DIR__."/../../writeable/log/xel.log",
    "collections" => [
        "my_logger" => [
            "path" => __DIR__."/../../writeable/log/my_logger.log",
            "logging_generation" => [
                'level' => Level::Debug, // Log level for the single logger
                'format' => LoggerSchedule::Daily->apply(), // Log file name format
            ],

        ],
        "security" => [
            "path" => __DIR__."/../../writeable/log/security/security.log",
            "logging_generation" => [
                'level' => Level::Error, // Log level for the single logger
                'format' => LoggerSchedule::Monthly->apply(), // Log file name format
            ],
        ],

        "system" => [
            "path" =>__DIR__."/../../writeable/log/system/system.log",
            "logging_generation" => [
                'level' => Level::Critical, // Log level for the single logger
                'format' => LoggerSchedule::Monthly->apply(), // Log file name format
            ],
        ],
    ],
];