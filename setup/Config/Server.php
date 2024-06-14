<?php
return [
    'api_server' => [
        'host' => 'http://localhost',
        'port' => 9501,
        'mode' => 1,
        'options' => [
            /**
             * Log
             */
            'log_level' => SWOOLE_LOG_ERROR,


            /**
             * server setup path and static handler
             */
            "enable_static_handler" => true,
            "document_root" => dirname(__DIR__, 2),


            'enable_delay_receive' => true,
            'open_tcp_nodelay'      => true,
            'reload_async'          => true,
            'max_wait_time'         => 60,
            'enable_reuse_port'     => true,
            'enable_coroutine'      => true,
            'http_compression'      => true,
            'buffer_output_size'    => swoole_cpu_num() * 1024 * 1024,


            //            'dispatch_mode' => 1,
            //            'daemonize' => 1,
            //            'http_gzip_level' => 9,


            /**
             * Setup worker mode for utilize cpu and task,
             */
//            'worker_num' => 1,
//            'task_worker_num'=>16,
            'task_enable_coroutine' => true,




            /**
             * secure concurrent limit per ip connection
             */
            'max_connection'       => 100,
            // 'send_yield'           => true,
            // 'send_timeout'         => 1.5,
        ],
    ],
];

