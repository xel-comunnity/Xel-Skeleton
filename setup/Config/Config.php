<?php

return [
    'api_server' => [
        'host' => 'http://localhost',
        'port' => 9501,
        'mode' => 1,
        'options' => [
            'worker_num' => 3,
            'enable_coroutine' => true,
//            'http_compression' => true,
//            'http_gzip_level' => 9,
//            'dispatch_mode' => 1,
//            'reload_async' => true,
        ],
    ],

];
