<?php

return [
     /***********************************************************************************************************************
      * DOS Protection
      ***********************************************************************************************************************/
     "gemstone_limiter" => [
         "condition" => false, // default // ip_based_limit
         "max_token" => 100, // max token fill in bucket
         "interval" => 60, // "in second"

         // ? additional for DDOS to block service when pass the second threshold
         // ? to disable it leave black array, and it will use regular limiter
         // ? if already used and need to disable it, please clear the loaded black listed IP on Gemstone_log
        // "block_ip" => [],
         "block_ip" => [200, __DIR__."/../../../writeable/Gemstone_log/black_list.php"],
     ], // implemented and underdeveloped


     /***********************************************************************************************************************
      * Secure Data Protection (CORS)
      ***********************************************************************************************************************/
     "securePost" => [
         'condition' => true,
         'cors' => [
             'allowOrigin' => "http://localhost",
             'allowMethods' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
             'allowHeaders' => ['Content-Type', 'Authorization', 'Origin', 'X-Requested-With,', 'X-CSRF-Token'],
             'maxAge' => 86400,
             'allowCredentials' => true,
         ],
     ],

    /***********************************************************************************************************************
     * Secure CSRF-Protector
     ***********************************************************************************************************************/
    "gemstone_csrf" => [
        'condition' => true,
        'key' => "dummykey"
    ],
];
