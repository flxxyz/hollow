<?php
require_once 'function.php';

$js = '';
$arr = array(
'from'      => @$_POST['from'],
'to'        => @$_POST['to'],
'content'   => @$_POST['content'],
'qq'        => @$_POST['qq'],
'tel'       => @$_POST['tel'],
'ip'        => get_ip(),
'time'      => @date('Y-m-d H:i:s'),
'effect'    => @$_POST['effect'],
'bg'        => @$_POST['bg'],
'anonymous' => @$_POST['is'],
'hide'      => @$_POST['hide'],
'pic'       => @$_FILES
);

checkUrl(SITEURL);
if(isset($arr['from'])) {
    if(!empty($arr['from'])) {
        $t = unburdenWriter($conn,$arr);
        if(!empty($t)) {
            $mid = unburdenNum($conn,$t);
            $base64 = base64_encode($mid);
            $js = "<script>var url='{$mid}';sessionStorage.success=1;sessionStorage.Uri=url;sessionStorage.hide+='{$base64}'+','</script>";
        }else {
            $js = "<script>var url='';sessionStorage.success=0;sessionStorage.Uri=url</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="author" content="冯小贤,i@mdzz.name" />
    <meta name="version" content="<?=VERSION?>" />
    <title>写下你的表白 - <?=TITLE?>
    </title>
    <meta name="keywords" content="表白墙,表白" />
    <meta name="description" content="表白还是亲口说的比较好，这个只是给她(他)一个小小惊喜，说的不要太肉麻，适当就行了" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" href="css/pintuer.css" />
    <link rel="stylesheet" href="<?=SITEURL?>css/style.css" />
    <script src="https://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/jquery.jrumble.1.3.min.js"></script>
    <script src="js/pintuer.js"></script>
    <?=$js?>
  </head>

  <body>
    <div class="container opacity-big main">
      <div class="margin-big-top">
        <a href="<?=SITEURL;?>"><img src="img/background.png" style="width:100%" /></a>
        <div class="margin-left margin-right say">
          <a href="b.php">
            <button id="bbb" class="button button-block button-big bg-sub bounce">想跟你说</button>
          </a>
        </div>
      </div>
      <div class="margin text-right">
        <ul class="bread">
          <li><a href="<?=SITEURL;?>" class="icon-home">首页</a></li>
          <li><a href="#" class="icon-heart">写下你的表白</a></li>
        </ul>
      </div>
      <div class="margin" id="success">
        <div class="margin padding bg-2 text-yellow radius-big warning">
          <h3><b>注意:</b></h3>
          <p><span class="icon-info-circle"></span> 现在北京时间：<b><?=@date('Y-m-d H:i:s');?></b></p>
          <p><span class="icon-info-circle"></span> 你的IP：<b><?=get_ip();?></b></p>
          <p><span class="icon-info-circle"></span> 毕竟这是给你表白的，别发有损道德的言论</p>
        </div>
        <div class="margin padding margin-big-bottom bg-3 text-dot radius-big warning">
          <h3><b>使用说明:</b></h3>
          <p><span class="icon-bullhorn"></span> <b>暂时不限制刷屏</b></p>
          <p><span class="icon-bullhorn"></span> <b>Ta</b>的称呼用网名和班级+姓名 你随意</p>
          <!--p><span class="icon-bullhorn"></span> <b>如果你会使用html,css语言的话，还可以书写特殊版式哦~</b></p-->
        </div>
        <div class="margin">
          <form id="b-comment" class="form-tips" action="b.php" method="post" enctype="multipart/form-data">
            <div class="form-group margin-bottom">
              <div class="field">
                <label class="button margin-bottom bg-dot" id="is-an">
                  <input name="is" type="hidden" value="0" />
                  <span name="is-icon" class="icon-question-circle"></span>
                  <span name="is-info">你想匿名发给Ta吗?</span>
                </label>
                <label class="button bg-dot" id="is-hide">
                  <input name="hide" type="hidden" value="0" />
                  <span name="is-icon" class="icon-question-circle"></span>
                  <span name="is-info">你想隐藏内容和Ta的名字吗?</span>
                </label>
              </div>
            </div>
            <div class="form-group margin-bottom" id="effect">
              <div class="field">
                <select name="effect" class="input">
                  <option value="0">请选择特效（默认没有特效）</option>
                  <option value="1">花瓣特效（微信内使用卡顿严重，不建议使用）</option>
                  <option value="2">爱心特效</option>
                </select>
              </div>
            </div>
            <div class="form-group margin-bottom" id="bg">
              <div class="field">
                <select name="bg" class="input">
                  <option value="2">请选择背景（默认花朵2）</option>
                  <option value="1">糖果LOVE</option>
                  <option value="2">2月14红色蝴蝶结</option>
                  <option value="3">Valentine's Day</option>
                  <option value="4">花朵 1</option>
                  <option value="5">花朵 2</option>
                  <option value="6">花朵 3</option>
                </select>
              </div>
            </div>
            <div class="form-group margin-bottom" id="img">
              <div class="field">
                <a class="button input-file bg-sub" href="javascript:void(0);">+ 浏览文件<input type="file" name="pic"></a>
              </div>
            </div>
            <div class="form-group margin-bottom" id="from">
              <div class="field">
                <input name="from" type="text" class="input" data-validate="required:必填" placeholder="你的名称" />
              </div>
            </div>
            <div class="form-group margin-bottom" id="to">
              <div class="field">
                <input name="to" type="text" class="input" data-validate="required:必填" placeholder="送给..  他 或是 她 (同性你们随意)" />
              </div>
            </div>
            <div class="form-group margin-bottom" id="qq">
              <div class="field">
                <input name="qq" type="text" class="input" placeholder="TA的QQ号（选填）" />
              </div>
            </div>
            <div class="form-group margin-bottom" id="tel">
              <div class="field">
                <input name="tel" type="tel" class="input" placeholder="你的手机号（选填）" />
              </div>
            </div>
            <div class="form-group margin-bottom" id="content">
              <div class="field">
                <textarea name="content" rows="5" class="input" data-validate="required:必填" placeholder="想给 ta 说的.."></textarea>
              </div>
            </div>
            <div class="form-button">
              <button id="bbb" class="button button-big button-block bg-sub margin-bottom" type="submit">发布表白</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <?php include 'footer.php';?>
  </body>

  </html>