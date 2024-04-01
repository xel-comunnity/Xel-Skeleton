<?php
return [
    'driver' => 'mysql',
    'host' => 'localhost',
    'charset' => 'utf8mb4',
    'username' => 'root',
    'password' => 'Todokana1ko!',
    'dbname' => 'absensi',
    'options' =>[
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ],

    'pool' => swoole_cpu_num(),
    'poolMode' => true,

    'migration' => "\\Xel\\Migration",
    'pathMigration' => __DIR__."/../../migration"
];
