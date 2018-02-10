<?php

//定义版本号
define('VERSION','2.0.1');
//定义站点域名
define('SITEURL', "http://test.com/");
//定义站点标题
define('TITLE', "想大声说爱你 - 表白墙 冯小贤");
//定义站点描述
define('DESCRIPTION', "不要太肉麻，适当就行了");

//定义管理目录
define("ADMIN_PATH", "/admin");

//定义JS个性模板
$js = array(
    '0' => '',
    '1' => '<script src="js/snowfall.jquery.js"></script><script src="js/mb/1.js"></script>',
    '2' => '<script src="js/mb/2.js"></script>'
);
//定义css背景模板
$bg = array(
    '0' => 'background-image:url(img/bg5.jpg);',
    '1' => 'background-image:url(img/bg1.jpg);background-position: -290px 0;',
    '2' => 'background-image:url(img/bg2.jpg);background-position: -190px 0;',
    '3' => 'background-image:url(img/bg3.jpg);background-position: -150px 0;',
    '4' => 'background-image:url(img/bg4.jpg);',
    '5' => 'background-image:url(img/bg5.jpg);',
    '6' => 'background-image:url(img/bg6.jpg);'
);

//数据库配置
$db = array(
    'host'    => '127.0.0.1',  //数据库地址  !!!如不清楚，默认!!!
    'name'    => 'biaobai',  //数据库名
    'user'    => 'biaobai',  //数据库用户
    'pwd'     => 'biaobai',  //数据库密码
    'port'    => '3306',  //数据库端口
    'charset' => 'utf8mb4'  //数据库字符集
);
date_default_timezone_set("Asia/Shanghai");
header("Content-type: text/html; charset=utf-8");

$conn = @mysqli_connect($db['host'],$db['user'],$db['pwd'],$db['name'],$db['port']);
if (!$conn) {
    exit("database connect error");
}
mysqli_set_charset($conn ,'utf8mb4' );

// 快速写入 默认写入1条记录
function qiuck($conn ,$num = 1 ) {
    function abc() {
        return md5(mt_rand(0, 1000)."abcdefghijklmnopqrstuvwxyz");
    }
    for($i=0;$i<$num;$i++) {
        $mid = abc();
        $sql = "insert into `unburden` (`uid`, `ufrom`, `uto`, `content`, `tel`, `ip`, `utime`, `imgUrl`, `effect`, `bg`, `mid`, `is_anonymous`, `hide`) VALUES (NULL, '111', '222', '33333', '', '127.0.0.1', '2017-04-11 04:45:54', 'img/upload/$mid.png', '0', '2', '$mid', '0', '1')";
        $result = mysqli_query($conn ,$sql );
    }
    mysqli_close($conn);
}