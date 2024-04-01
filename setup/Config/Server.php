<?php
return [
    'api_server' => [
        'host' => 'http://localhost',
        'port' => 9501,
        'mode' => 2,
        'options' => [
            'worker_num' => 35,
//            'daemonize' => 1,
//            'http_gzip_level' => 9,

            /**Enable it when use mode 2*/
            'dispatch_mode' => 1,

            /**Optional Config*/

            'open_tcp_nodelay'      => true,
            'reload_async'          => true,
            'max_wait_time'         => 60,
            'enable_reuse_port'     => true,
            'enable_coroutine'      => true,
            'http_compression'      => true,
            'enable_static_handler' => false,
            'buffer_output_size'    => swoole_cpu_num() * 1024 * 1024,
        ],
    ],

];

