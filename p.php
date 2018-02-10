<?php
require_once 'function.php';

$mid = !empty($_GET['bid']) ? @$_GET['bid'] : 404;

//echo $mid;
$arr = unburdenPage($conn,$mid,$js);
$info = $arr['info'];
$content = $arr['content'];
$mb = $arr['js'];

if($info[11]) {
    $from = '***';
    $to = $info[2];
    $change = <<<EOT
<script>
$(function() {
    var e = $('#vindication .vindication');
    var h = e.children('.v-main').data('hide');
    e.find('.v-header .form-inline').show();
    e.find('strong.to').text(decodeStr(h.k).substr(0,1)+'*');
    e.find('strong.from').text(decodeStr(h.j).substr(0,1)+'**('+decodeStr(h.j).length+'个字哟');
    //e.find('strong.tel').text("Tel:520");
    $('title').text('***想对***说...    - 表白墙 - 想大声说爱你');
})
</script>
EOT;
}else {
    $from = $info[1];
    $to = $info[2];
    $change = <<<EOT
<script>
$(function() {
    var e = $('#vindication .vindication');
    var h = e.children('.v-main').data('hide');
    e.find('.v-header .form-inline').hide();
    e.find('strong.to').text(decodeStr(h.k));
    e.find('strong.from').text(decodeStr(h.j));
    //e.find('strong.tel').text(decodeStr(h.t));
    $('title').text(decodeStr(h.j)+'想对'+decodeStr(h.k)+'说...    - 表白墙 - 想大声说爱你');
})
</script>
EOT;
}
?>
<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="author" content="冯小贤,i@mdzz.name" />
    <meta name="version" content="<?=VERSION?>" />
    <title><?php echo $from . '想对' . $to . '说...';?> - <?=TITLE?></title>
    <meta name="keywords" content="<?=$info[1]?>,<?=$info[2]?>,表白墙,表白,<?=$info[6]?>" />
    <meta name="description" content="给她(他)一个小小惊喜，说的不要太肉麻，适当就行了" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" href="<?=SITEURL?>css/pintuer.css" />
    <link rel="stylesheet" href="<?=SITEURL?>css/style.css" />
    <script src="https://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
    <script src="<?=SITEURL?>js/jquery.jrumble.1.3.min.js"></script>
    <script src="<?=SITEURL?>js/pintuer.js"></script>
  </head>

  <body style="<?echo $bg[$arr['bg']];?>">
    <div class="container bg-white main">
      <div class="margin-big-top">
        <a href="<?=SITEURL?>"><img src="<?=SITEURL?>img/background.png" style="width:100%" /></a>
        <div class="margin-left margin-right say">
          <a href="b.php">
            <button id="bbb" class="button button-block button-big bg-yellow-light">想跟你说</button>
          </a>
        </div>
      </div>
      <hr />
      <div class="margin text-right">
        <ul class="bread">
          <li><a href="<?=SITEURL?>" class="icon-home">首页</a></li>
          <li>表白</li>
          <li>当前第 <span class="tag bg-dot"><?=$info[14]?></span> 条</li>
        </ul>
        <p><a id="share" href="javascript:;">点我分享到朋友圈</a></p>
      </div>
      <div id="vindication" class="margin">
        <?=$arr['content']?>
      </div>
      <div class="margin">
        <div class="comment">
          <button class="button button-big button-block bg-sub margin-bottom dialogs" data-toggle="click" data-target="#mydialog" data-mask="1">评论</button>
          <div id="mydialog">
            <div class="dialog">
              <div class="dialog-head">
                <span class="close rotate-hover"></span><strong>评论</strong>
              </div>
              <form id="p-comment" class="form-x" action="comment.php" method="get">
                <div class="dialog-body">
                  <div class="form-group">
                    <div id="hide">
                      <input name="u" type="hidden" value="1" />
                      <input name="mid" type="hidden" value="<?=$mid?>" />
                      <input name="re" type="hidden" value="0" />
                    </div>
                    <div class="label">
                      <label for="username">你的名字 *</label>
                    </div>
                    <div class="field">
                      <input name="username" type="text" id="username" class="input" placeholder="你的名称(最短3位)" />
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="label">
                      <label for="qq">QQ号码</label>
                    </div>
                    <div class="field">
                      <input type="text" class="input" id="qq" name="qq" maxlength="11" value="" placeholder="不填QQ号码使用默认头像">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="label">
                      <label for="sex">性别</label>
                    </div>
                    <div class="field">
                      <div class="button-group radio">
                        <label class="button">
                          <input name="sex" value="1" type="radio"><span class="icon icon-mars"></span>男
                        </label>
                        <label class="button">
                          <input name="sex" value="0" type="radio"><span class="icon icon-venus"></span>女
                        </label>
                        <label class="button active">
                          <input name="sex" value="2" type="radio" checked><span class="icon icon-transgender"></span>不告诉你
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="label">
                      <label for="content">想说</label>
                    </div>
                    <div class="field">
                      <textarea name="content" rows="5" id="content" class="input" placeholder="想给 ta 说的.."></textarea>
                    </div>
                  </div>
                </div>
                <div class="form-button dialog-foot">
                  <a id="ccc" class="button dialog-close">取消</a>
                  <button id="send" class="button bg-green" type="submit">确认</button>
                </div>
              </form>
            </div>
          </div>
          <div class="margin-big-top" style="background:#f5f5f5">
            <ul class="c-XN">
              <?php commentShow($conn,$mid);?>
            </ul>
          </div>
        </div>
      </div>
      <audio id="mp3" src="https://m7.music.126.net/20170512000324/238d775f078d6a10bc93518ff7f09715/ymusic/560f/01e4/f573/386bce63707818f53f331130eaf8d767.mp3" autoplay loop>您的浏览器不支持 audio 标签。</audio>
    <script>document.getElementById('mp3').volume = 0.5</script>
    </div>
    <?php include 'footer.php';?>
      <div id="mcover" style="display:none;"><img src="<?=SITEURL?>img/guide.png" /></div>
  </body>
<?=$mb;?>

</html>