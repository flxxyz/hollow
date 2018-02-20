<?php

// 是否开启debug模式
define('APP_DEBUG', true, true);

define('DS', DIRECTORY_SEPARATOR, true);
define('SITE_DIR', realpath(__DIR__) . DS, true);
define('APP_DIR', realpath(SITE_DIR . '../app') . DS, true);
define('BASE_DIR', realpath(SITE_DIR . '..') . DS, true);

if(!is_file(APP_DIR . 'install.lock') && isset($_GET['install']) && $_GET['install'] === '') {
    if(isset($_POST['host']) && isset($_POST['port']) && isset($_POST['database']) && isset($_POST['username']) && isset($_POST['password'])) {
        function post($key) {
            if(isset($_POST[$key]) && $_POST[$key] !== '') {
                return true;
            }else {
                return false;
            }
        }

        $host = $port = $database = $username = $password = '';
        if(!post('host')) {
            $host = '请填写正确的数据库地址';
        }
        if(!post('port')) {
            $port = '请填写正确的数据库端口';
        }
        if(!post('database')) {
            $database = '请填写正确的数据库库名';
        }
        if(!post('username')) {
            $username = '请填写正确的数据库用户';
        }
        if(!post('password')) {
            $password = '请填写正确的数据库密码';
        }
    }

    $install_dir = BASE_DIR . 'install' . DS;

    include $install_dir . 'install.html';
    exit;
}

require_once BASE_DIR . 'bootstrap/app.php';
