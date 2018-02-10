<?php
require_once 'function.php';

$arr = unburdenShow($conn);
$num = $arr['num'];
$content = $arr['content'];
?>
<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="author" content="冯小贤,i@mdzz.name" />
    <meta name="version" content="<?=VERSION?>" />
    <title><?=TITLE?></title>
    <meta name="keywords" content="表白墙冯小贤,表白墙,表白,冯小贤" />
    <meta name="description" content="表白还是亲口说的比较好，这个只是给她(他)一个小小惊喜，说的不要太肉麻，适当就行了" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="baidu-site-verification" content="JLXM1AZUdE" />
    <link rel="stylesheet" href="<?=SITEURL?>css/pintuer.css" />
    <link rel="stylesheet" href="<?=SITEURL?>css/style.css" />
    <script src="https://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
    <script src="<?=SITEURL?>js/jquery.jrumble.1.3.min.js"></script>
    <script src="<?=SITEURL?>js/pintuer.js"></script>
  </head>

  <body>
    <div class="container opacity-big main">
      <div class="margin-big-top">
        <a href="<?=SITEURL?>"><img src="<?=SITEURL?>img/background.png" style="width:100%" /></a>
        <div class="margin-left margin-right say">
          <a href="b.php">
            <button id="bbb" class="button button-block button-big bg-sub bounce">想跟你说</button>
          </a>
        </div>
      </div>
      <hr />
      <!--div class="margin text-right">
        <form action="s.php" class="search text-left">
            <input type="text" class="input input-big" placeholder="找找你要找的人吧" />
        </form>
      </div-->
      <div class="margin text-right">
        <p>有 <span class="tag bg-dot"><?=$num; ?></span> 条表白了呢~</p>
      </div>
      <div class="margin" id="u">
        <?=$content; ?>
      </div>
    </div>
    <?php include 'footer.php';?>
  </body>

</html>