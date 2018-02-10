<?php
session_start();
if( isset($_SESSION['username']) )
    header('location:manage.php');
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <title>登陆</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.bootcss.com/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!--[if lt IE 9]>
      <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="../js/md5.js"></script>
    <style type="text/css" media="screen">
        span {
            display:inline-block;
            width:64px;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <a href="../">回到首页</a>
            <h2>管理员登陆页面</h2>
        </header><!-- /header -->
        <article>
            <form id="f" action="check.php" method="post" accept-charset="utf-8">
                <label><span>用户名</span>：<input id="username" type="text" name="username" /></label><br>
                <label><span>密码</span>：<input id="password" type="password" name="password" /></label><br>
                <input type="hidden" name="t" value="login"><input type="submit" value="提交" />
        </form>
        </article><hr>
        <footer>
            <p>关闭网页后并不会退出管理系统，请手动右上角</p>
        </footer>
    </div>
</body>
<script>
$('#username').focus();
$('#f').submit(function() {
    var pwd = $('#password');
    pwd.val(hex_md5(pwd.val().trim()));
});

</script>
</html>