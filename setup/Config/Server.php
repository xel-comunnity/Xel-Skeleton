<?php
return [
    'api_server' => [
        'host' => 'http://localhost',
        'port' => 9501,
        'mode' => 1,
        'options' => [
            "enable_static_handler" => true,
            "document_root" => dirname(__DIR__, 2),
            'worker_num' => swoole_cpu_num(),
//            'task_worker_num'=>16,
            'task_enable_coroutine' => true, // optional to turn on task coroutine support
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
            'buffer_output_size'    => swoole_cpu_num() * 1024 * 1024,
        ],
    ],
];

