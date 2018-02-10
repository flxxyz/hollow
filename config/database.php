<?php

return [
    'defalut' => 'mysql',
    'mysql'   => [
        'host'     => '127.0.0.1',
        'port'     => 3306,
        'database' => 'love',
        'username' => 'love',
        'password' => 'love_passwd',
        'charset'  => 'utf8mb4',
        'perfix'   => 'love_',
        'options'  => [
            /**
             * @link http://php.net/manual/zh/pdo.error-handling.php
             */
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ],
    ],
    'redis'   => [
        'host'     => '127.0.0.1',
        'port'     => 6379,
        'pass'     => null,
        'database' => 0,
    ],
];