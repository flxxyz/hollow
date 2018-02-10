<?php
define('PATH', __DIR__ . '/');
require_once '../config.inc.php';
session_start();

$meta = '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">';

if( @$_GET['t'] === 'logout' ) {
    session_destroy();
    $db = $conn;
    $sql = "update `users`set `is_login` = '0' WHERE `id` = 1 ";
    if($result = mysqli_query($db,$sql) )
        echo "$meta 注销成功，3秒后返回登陆页";
    else
        echo "$meta 注销失败";

    mysqli_close($db);
    header("Refresh:3;url=".ADMIN_PATH);
}

if( @$_GET['t'] === 'del' ) {
    if( isset($_GET['id']) && ($_GET['id'] != '') )
        $id = $_GET['id'];
    else{
        echo "$meta 错误参数";
        header("Refresh:1;url=".ADMIN_PATH);exit;
    }
    $db = $conn;
    $sql = " delete from `unburden` where `uid` = $id ";

    if($result = mysqli_query($db,$sql) ) {
        echo "$meta 删除成功，1秒后返回";
    }else
        echo "$meta 删除失败";

    mysqli_close($db);
    header("Refresh:1;url=".ADMIN_PATH);exit;
}


if( @$_POST['t'] === 'login' ) {
    if( isset($_POST['username']) && ($_POST['username'] != '') )
        $name = $_POST['username'];
    else{
        echo "$meta 请填写用户名，2秒后返回登陆";
        header("Refresh:2;url=".ADMIN_PATH);exit;
    }

    if( isset($_POST['password']) && ($_POST['password'] != '') )
        $pwd = $_POST['password'];
    else {
        echo "$meta 请填写密码，2秒后返回登陆";
        header("Refresh:2;url=".ADMIN_PATH);exit;
    }

    $db = $conn;
    $sql = "select * from `users` where `username` = '$name' and `password` = '$pwd' ";
    $result = mysqli_query($db ,$sql );
    //echo '<pre>';

    // $row = mysqli_fetch_array($result);
    // var_dump($row);

    if($row = mysqli_fetch_array($result)) {
        if( isset($_SESSION['username']) )
            ;
        else
            $_SESSION['username'] = base64_encode($row['username']);

        $sql = "update `users`set `is_login` = '1' WHERE `id` = 1 ";
        if($result = mysqli_query($db,$sql) )
            echo "$meta 登陆成功，即将跳转至管理中心";
        else
            echo "$meta 登陆失败";

        mysqli_close($db);
        header("Refresh:1;url=".ADMIN_PATH."/manage.php");exit;
    }else{
        echo "$meta 对不起，用户名或密码错误，3秒后返回登陆页";
        header("Refresh:3;url=".ADMIN_PATH);exit;
    }
}



