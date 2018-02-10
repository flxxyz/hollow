<?php
require_once 'config.inc.php';
/**
 * 输出表白id
 *
 * @param [type] $conn
 * @param [type] $uid
 * @return void
 */
function unburdenNum($conn,$uid) {
    $sql = "select `mid` from `unburden` where `uid` = '{$uid}' limit 1";
    $query = mysqli_query($conn,$sql);
    //$num = mysqli_num_rows($query);
    
    $mid = '';
    while($row = @mysqli_fetch_row($query)) {
        $mid = $row[0];
    }
    //mysqli_close($conn);
    return $mid;
}

/**
 * 输出表白
 *
 * @param [type] $conn
 * @return void
 */
function unburdenShow($conn) {
    $content = '';
    $sql = "select `ufrom`,`uto`,`content`,`qq`,`utime`,`mid`,`is_anonymous`,`hide` from `unburden` order by `uid` desc";
    $query = mysqli_query($conn ,$sql);
    $num = mysqli_num_rows($query);
    
    while($row = mysqli_fetch_row($query)) {
        //var_dump($row);
        if($row[6]) {
            $row[0] = '匿名';
        }
        $hide = $row[7] ? true : false;
        
        if(mb_strlen($row[2],'UTF8') > 38) $row[2] = mb_substr($row[2],0,40) . "...";
        
        $content .= hideText($hide ,$row );
        
    }
    mysqli_close($conn);
    
    if(!$num) $content = '<p>暂时没有表白</p>';
    return array("num"=>$num,"content"=>$content);
}

/**
 * 写入表白
 *
 * @param [type] $conn
 * @param [type] $arr
 * @return void
 */
function unburdenWriter($conn ,$arr) {
    if(trim($arr['qq']) === '') {
        $arr['qq'] = '2130271049';
    }
    $sql = "insert into `unburden`(`uid`,`ufrom`,`uto`,`content`,`qq`,`tel`,`ip`,`utime`,`imgUrl`,`effect`,`bg`,`mid`,`is_anonymous`,`hide`)values(NULL,'{$arr['from']}','{$arr['to']}','{$arr['content']}','{$arr['qq']}','{$arr['tel']}','{$arr['ip']}','{$arr['time']}','','{$arr['effect']}','{$arr['bg']}','".MD5($arr['time'].mt_rand(0, 1000))."','{$arr['anonymous']}','{$arr['hide']}');";
    mysqli_query($conn ,$sql);
    $num = mysqli_insert_id($conn);
    $mid = unburdenNum($conn ,$num);
    $imgUrl = unburdenImage($arr['pic'] ,$mid );
    unburdenImageWriter($conn ,$mid ,$imgUrl );
    return $num;
}

/**
 * 写入表白的图片
 *
 * @param [type] $img
 * @param [type] $mid
 * @return void
 */
function unburdenImage($img ,$mid ) {
    $fileType = array(
        "image/png",
        "image/jpeg",
        "image/gif",
        "image/pjpeg"
    );
    $allowExt = array("gif", "jpeg", "jpg", "png");  // 等待匹配的扩展名
    $TmpExt = explode(".", @$img["pic"]["name"]);  // 匹配扩展名
    $ext = end($TmpExt);  // 取数组最后项
    $type = $img["pic"]["type"];
    $size = $img["pic"]["size"] < 3145728;  // 限制小于5M
    
    if( in_array($type ,$fileType ) && $size && $ext ) {
        if( $img["pic"]["error"] > 0 ) {
            //echo "Error: " . $img["pic"]["error"] . "<br />";
            return '';
        }else {
            if(is_dir('img/upload/')) {
                //echo "不创建目录";
            }else {
                //echo "创建目录";
                // 使用 iconv 避免字符集导致的目录错误，参数3 为开启创建子目录
                mkdir(iconv("UTF-8" ,"GBK" ,'img/upload/' ) ,0777 );
            }
            
            $fileName = $img["pic"]["name"];
            if(file_exists($fileName)) {
                //echo '文件存在';
                return '文件存在';
            }else {
                $name = end($TmpExt);
                $newPath = "img/upload/{$mid}.{$name}";
                $imgURL = $newPath;
                $oldPath = $_FILES["pic"]["tmp_name"];
                rename($oldPath, $newPath );
            }
        }
    }else {
        $imgURL = "";
    }
    return $imgURL;
}

/**
 * 图片地址更新进数据库
 *
 * @param [type] $conn
 * @param [type] $mid
 * @param string $url
 * @return void
 */
function unburdenImageWriter($conn ,$mid ,$url = "" ) {
    $sql = "update `unburden` set `imgUrl` = '{$url}' where `mid` = '{$mid}'";
    //echo $sql;
    $query = mysqli_query($conn,$sql);
    $rc = mysqli_affected_rows($conn);  //更新成功返回值，不更新返回 0
}

/**
 * 表白页面信息
 *
 * @param [type] $conn
 * @param [type] $mid
 * @param [type] $js
 * @return void
 */
function unburdenPage($conn ,$mid ,$js) {
    if($mid === 404) statu404();
    
    $content = '';
    $sql = "set @ID=0;";
    $query = mysqli_query($conn ,$sql);
    $sql = "select * from (select *,@ID:=@ID+1 as num from `unburden`) n where `mid`='$mid';";
    $query = mysqli_query($conn ,$sql);
    
    $row = mysqli_fetch_row($query);
    //var_dump($row);
    
    $num = $row[14];
    $qq = QQAvatar($row[4]);
    $from = $row[1];
    $to = $row[2];
    $text = $row[3];  // 内容不变
    $time = @date('Y.m.d' ,time($row[7]) );
    $img = "<div class='margin-left margin-right'><img src='$row[8]' style='width:100%'/></div>";
    if($row[5] == '') {
        $tel = 'Tel: 520';
    }else{
        $tel = 'Tel:' . $row[5];
    }
    
    
    $from1 = base64_encode($from);
    $to1 = base64_encode($to);
    $mid1 = base64_encode($mid);
    $tel1 = base64_encode($tel);
    $hide = base64_encode($row[13]);
    $len = mb_strlen($row[1],'UTF8');
    
    $content .= <<<EOT
    <div class="vindication border border-red-light margin-bottom">
        <div class="bg-2 v-header">
            <p class="padding-top padding-left text-yellow">
                <img src="{$qq}" style="width:25px;border-radius:50%" />
                <strong class="padding-left to">{$to}</strong>
                <span class="form-inline float-right text-right margin-right">
                    <input class="input input-small input-auto" type="text" placeholder="猜猜是谁发的" />
                    <button class="button button-little bg-sub" type="button">就是Ta</button>
                </span>
            </p>
        </div>
        <div class="bg-3 text-dot v-main" data-hide='{"j":"{$from1}","k":"{$to1}","m":"$mid1","a":"{$hide}","t":"$tel1"}'>
            <p class="padding-top padding-big-left padding-big-right text-break opacity-none">
                {$text}{$img}
            </p>
            <div class="padding-left opacity-none v-footer" style="margin:0">
                <!--div class="b-time">
                    时间:{$time}
                </div-->
                <div class="padding-right text-right">
                    来自:<strong class="padding-left from">***({$len}个字哟)</strong>
                </div>
            </div>
            <div class="margin-top margin-bottom padding-right text-right">
                <strong class="tel">{$tel}</strong>
            </div>
        </div>
    </div>
EOT;
    return array("info"=>$row,"content"=>$content,"js"=>$js[$row[9]],"bg"=>$row[10]);
}

/**
 * 表白页面显示所有评论
 *
 * @param [type] $conn
 * @param [type] $mid
 * @return void
 */
function commentShow($conn,$mid) {
    $content = '';
    $sql = "select * from `comment` where `mid`='{$mid}' order by `uid`"; // desc
    $query = mysqli_query($conn ,$sql);
    
    $i = 0;
    while($row = @mysqli_fetch_row($query)) {
        if($row[4] != ''){
            $qq = QQAvatar($row[4]);
        }else {
            $qq = QQAvatar('2130271049');
        }

        switch ($row[5]) {
            case '0':
                $author = 'text-venus';
                $sex = 'icon icon-venus';
                break;
            case '1':
                $author = 'text-mars';
                $sex = 'icon icon-mars';
                break;
            default:
                $author = 'text-transgender';
                $sex = 'icon icon-transgender';
                break;
        }
        
        if($i++ == 0) {
            $content .= '<h3 class="margin-bottom">评论列表</h3>';
        }
        $mid = $row[0];
        $name = $row[2];
        $text = $row[3];
        $time = $row[6];
        $content .= <<<EOT
        <li id="u{$mid}" class="c-XN-li border-small border-bottom">
            <a href="#u{$mid}" class="author {$author}">
                <img class="radius-circle" src="{$qq}" title="" />{$name}
            </a>
            <span class="{$sex}"></span>
            <p class="content">{$text}</p>
            <div class="foot">
                <span class="time">{$time}</span>
                <!--span class="to dialogs" data-toggle="click" data-target="#re" data-mask="1" data-name="{$name}">回复</span-->
            </div>
        </li>
EOT;
    }

    if($content == '') $content = '<p>暂时没有留言哦~</p>';
    mysqli_close($conn);
    echo $content;
}

/**
 * 写入评论
 *
 * @param [type] $conn
 * @param [type] $get
 * @return void
 */
function commentWriter($conn,$get) {
    $url = SITEURL.'p.php';
    checkUrl($url);

    $sql = "select `uid` from `unburden` where `mid`='{$get['mid']}'";
    $query = mysqli_query($conn ,$sql);
    $token = mysqli_fetch_row($query);
    if(!empty($get['u']) && !$token[0]) {
        statu404();
    }
    //var_dump($token);
    if($get['username'] == '') statu404();
    if($get['sex']  == '') statu404();
    if($get['content']  == '') statu404();
    if($get['re']  == '') statu404();
    
    $sql = "insert into `comment`(`uid`,`mid`,`name`,`content`,`qq`,`sex`,`utime`,`re`)values(NULL,'{$get['mid']}','{$get['username']}','{$get['content']}','{$get['qq']}','{$get['sex']}','".@date('Y-m-d H:i:s')."','{$get['re']}')";
    $query = mysqli_query($conn ,$sql);
    $num = mysqli_insert_id($conn);
    mysqli_close($conn);
    //echo "{$url}?spm={$get['mid']}#u{$num}";
    header("location: {$url}?bid={$get['mid']}#u{$num}");
    
}

function hideText($bool ,$arr ) {
    $from = $arr[0];
    $to = $arr[1];
    $text = $arr[2];
    $qq = QQAvatar($arr[3]);
    $time = @date('Y.m.d',time($arr[4]));
    $mid = $arr[5];
    $hide = base64_encode($arr[7]);
    
    if($bool) {
        $len = mb_strlen($from,'UTF8');
        $from1 = base64_encode($from);
        $to1 = base64_encode($to);
        $mid1  = base64_encode($mid);
        
        return <<<EOT
        <a class="vindication border border-red-light margin-bottom">
            <div class="bg-2 v-header">
                <p class="padding-top padding-left text-yellow">
                    <img src="{$qq}" style="width:25px;border-radius:50%" />
                    <strong class="padding-left to">{$to}</strong>
                    <span class="form-inline float-right text-right margin-right">
                        <input class="input input-small input-auto" type="text" placeholder="猜猜是谁发的" />
                        <button class="button button-little bg-sub" type="button">就是Ta</button>
                    </span>
                </p>
            </div>
            <div class="bg-3 text-dot v-main" data-hide='{"j":"{$from1}","k":"{$to1}","m":"{$mid1}","a":"{$hide}"}'>
                <p class="padding-top padding-big-left padding-big-right text-break opacity-none">
                    {$text}
                </p>
                <div class="padding-left opacity-none v-footer">
                    <!--div class="b-time">
                        时间:{$time}
                    </div-->
                    <div class="padding-right float-right">
                        来自:<strong class="padding-left from">***({$len}个字哟)</strong>
                    </div>
                </div>
            </div>
        </a>
EOT;
    }else {
        $from1 = base64_encode($from);
        $to1 = base64_encode($to);
        $mid1  = base64_encode($mid);
        return <<<EOT
        <a class="vindication border border-red-light margin-bottom" href="p.php?bid={$mid}" title="{$from}想对{$to}说...">
            <div class="bg-2 v-header">
                <p class="padding-top padding-left text-yellow">
                    <img src="{$qq}" style="width:25px;border-radius:50%" /><strong class="padding-left to">{$to}</strong>
                </p>
                <span class="form-inline float-right text-right margin-right" style="display:none">
                    <input class="input input-small input-auto" type="text" placeholder="猜猜是谁发的" />
                    <button class="button button-little bg-sub" type="button">就是Ta</button>
                </span>
            </div>
            <div class="bg-3 text-dot v-main" data-hide='{"j":"{$from1}","k":"{$to1}","m":"{$mid1}","a":"{$hide}"}'>
                <p class="padding-top padding-big-left padding-big-right text-break opacity-none">
                    {$text}
                </p>
                <div class="padding-left opacity-none v-footer">
                    <!--div class="b-time">
                        时间:{$time}
                    </div-->
                    <div class="padding-right float-right">
                        来自:<strong class="padding-left from">{$from}</strong>
                    </div>
                </div>
            </div>
        </a>
EOT;
    }
}






/*  公用函数  */
function statu404() {header("HTTP/1.1 404 Not Found");header("Status: 404 Not Found");exit;}
function token() {return mt_rand(1,9).mt_rand(0,9);}
function get_ip() {
    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
        $ip = getenv("HTTP_CLIENT_IP");
    else
        if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        else
            if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
                $ip = getenv("REMOTE_ADDR");
            else
                if (isset ($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
                    $ip = $_SERVER['REMOTE_ADDR'];
                else
                    $ip = "unknown";
    return $ip;
}
function checkUrl($siteurl) {
    if(!isset($_SERVER['HTTP_REFERER'])) {
        //echo "referer:".@$_SERVER['HTTP_REFERER'];
        header("location:".$siteurl);
        exit;
    }

    //echo var_dump(!stripos($siteurl,'//'.$_SERVER['HTTP_HOST']));
    if(!stripos($siteurl,'//'.$_SERVER['HTTP_HOST'])) {
        header("location:".$_SERVER['HTTP_REFERER']);
        exit;
    }
    //echo siteurl.'p.php';
    //echo "referer:".@$_SERVER['HTTP_REFERER'];
    //echo $_SERVER["REQUEST_URI"];
}
function QQAvatar($qq='2130271049') {
    $qq = base64_encode(token() . $qq );
    return "https://api.flxxyz.com/qq/api-v2.php?q=$qq&s=100";
    //return "http://q.qlogo.cn/headimg_dl?dst_uin=$qq&spec=100"; //备用接口
}


