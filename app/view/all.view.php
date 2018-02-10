<!doctype html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php _e($title); ?></title>
</head>
<body>
<?php foreach ($result as $item): ?>
<p><?php _e($item); ?></p>
<?php endforeach; ?>
<p><a href="http://edgecats.net" target="_blank">去看🐱片</a></p>
</body>
</html>