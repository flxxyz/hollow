<?php

return [
    'defalut' => 'mysql',
    'mysql'   => [
        'host'     => '127.0.0.1',  // 数据库地址
        'port'     => 3306,  // 数据库端口
        'database' => 'love',  // 数据库库名
        'username' => 'love',  // 数据库用户名
        'password' => 'love_passwd',  // 数据库密码
        'charset'  => 'utf8mb4',  // 数据库字符集
        'perfix'   => 'love_',  // 数据库前缀
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