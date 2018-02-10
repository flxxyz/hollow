<?php
define('PATH', __DIR__ . '/');
require_once '../config.inc.php';
header('content-type:application/json;charset=utf-8;');
session_start();

$time = time();
$error = '{"username":"'.$_SESSION['username'].'","length":"","page":"","page_sum":"","page_length":"","time-stamp":'.$time.',"data":[],"error":1}';

// 存在$_SESSION['username'] 继续执行
if( isset($_SESSION['username']) ) {
    $name = $_SESSION['username'];
}else {
    exit($error);
}

// 取 $page 页数
$page = isset($_GET['page']) && ($_GET['page'] != '' ) ? $_GET['page'] : 1;
if( isset($_GET['page']) && ($page != '') && ($page != 0) ) {
    if(is_numeric($page)) {
        // 转换第一页为 0
        $page = ($page-1);
    }else{
        exit($error);
    }
}else {
    exit($error);
}

// 启动数据连接
$db = $conn;

// 定义查询条数
$pageLength = 12;

// 统计总记录条数
$sql = "select uid from `unburden`";
$result = mysqli_query($db ,$sql );
$num = mysqli_num_rows($result);

// 取出共几页
$sum = floor( ($num/$pageLength)+1 );

// 限制页数不能超过最大页数 $sum
if( $page >= $sum )
$page = $sum-1;

// 输出相应页数的记录
$record = $page * $pageLength;
$sql = "select * from `unburden` order by `uid` desc limit $record,$pageLength";
$result = mysqli_query($db ,$sql );
$rowSelect = mysqli_num_rows($result);

// 组合数据结构
$array = array(
    'username'    => $name,
    'length'      => $rowSelect,
    'page'        => $page,
    'page_sum'    => $sum,
    'page_length' => $pageLength,
    'time-stamp'  => $time,
    'data'        => array()
);
while($row = mysqli_fetch_array($result)) {
    //var_dump($row);
    $rowArray = array(
        'id'        => $row[0],
        'from'      => $row[1],
        'to'        => $row[2],
        'content'   => $row[3],
        'tel'       => $row[5],
        'time'      => $row[7],
        'anonymous' => $row[12],
        'hide'      => $row[13]
    );
    $array['data'][] = $rowArray;
}
$array['error'] = 0;

// 断开数据连接
mysqli_close($db);

// 输出数据
echo json_encode($array ,JSON_UNESCAPED_UNICODE );  // json_unescaped_unicode