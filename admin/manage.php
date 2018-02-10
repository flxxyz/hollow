<?php
session_start();
if( isset($_SESSION['username']) ) {

}else {
    exit('非法访问');
}

$name = base64_decode($_SESSION['username']);

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8" />
    <title>管理中心</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://cdn.bootcss.com/jquery/3.1.1/jquery.min.js"></script>
    <script src="http://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!--[if lt IE 9]>
      <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div class="container">
        <header>
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2>管理中心</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-right">
                    <p><a href="../" target="_blank">回到首页</a> | 你好呀！<?=$name?> <a class="btn btn-info btn-sm" href="check.php?t=logout">注销</a></p>
                </div>
            </div>
            <div class="col-md-12 text-danger text-right bg-info">
                <p>关闭网页并不会退出系统，请手动右上角注销</p>
            </div>
        </header>
        <article class="landlord-list">
            <section class="head">
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>ID</th>
                        <th>来自</th>
                        <th>给他</th>
                        <th>内容</th>
                        <th>时间</th>
                        <th>操作</th>
                    </tr>
                    <tbody class="main text-center">
                        <!--tr>
                            <td scope="row">ID</td>
                            <td>1</td>
                            <td>2</td>
                            <td>3</td>
                            <td>4</td>
                            <td class="text-center"><a href="#">删除</a></td>
                        </tr-->
                        <td colspan="6" class="lead">正在加载哟...</td>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="col-md-2" colspan="6">
                                <div class="page"></div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </section>
        </article>
        <section class="foot">
        </section>
    </div>
</body>
<script>

$(function() {
    var n = 0;
    var Data = {};
    var main = $('.main');
    init(++n);
    add();

function init($page) {
    //main.text('').append('<td colspan="6" class="lead">正在加载哟...</td>');
    $.get('api.php',{page: $page},function(response ,status ,xhr ) {
        if(!parseInt(response.error)) {
            var data = response.data;
            var page = response.page;
            var page_sum = response.page_sum;
            var len = response.length;
            var page_len = response.page_length;

            //console.log("page ---- " + page);
            //console.log("page_sum ---- " + page_sum);

            // 输出数据
            Data = {};  // 清空当前页数据
            $.each(data, function(index, val) {
                var i = $('<td></td>').text(val.id).addClass('uid');
                var f = $('<td></td>').text(val.from);
                var y = $('<td></td>').text(val.to);
                var c = $('<td></td>').text(val.content);
                var t = $('<td></td>').text(val.time);
                var o = $('<td></td>').html('<a class="btn btn-danger btn-sm" href="javascript:;">删除</a>');
                var tr = $('<tr></tr>').append(i,f,y,c,t,o);
                Data[index] = tr;
            })
            var pn = $('.page');
            var perv = $('<a href="#page'+(page)+'" class="prev pull-left btn btn-primary">上一页</a>');
            var next = $('<a href="#page'+(page+2)+'" class="next pull-right btn btn-primary">下一页</a>');
            if(len === page_len) {
                // 输出分页按钮
                if(page > 0 && page < (page_sum-1) ) {
                    pn.text('').append(perv,next);
                }else if(page == 0 ){
                    pn.text('').append(next);
                }else if(page == (page_sum-1) ) {
                    pn.text('').append(perv);
                }
            }else if((page <= page_sum-1)  && (page > 1)) {
                pn.text('').append(perv);
            }
                

            // 绑定事件
            $('.next').click(function() {
                n++;
                init(n);
                add();
            });
            $('.prev').click(function() {
                n--;
                init(n);
                add();
            });
        }else
            main.append('<td colspan="6" class="lead">没有数据</td>');
    });
}

function add() {
    main.text('').append('<td colspan="6" class="lead">正在加载哟...</td>');
    $(document).ajaxSuccess(function() {
        main.text('');
        $.each(Data, function(index, val) {
            main.append(Data[index]);
        });
        $('.main tr td a.btn').each(function(index, el) {
            $(this).click(function() {
                if( confirm('确定删除嘛？') ) {
                    var yeye = $(this).parent().parent();
                    var id = yeye.children('.uid').text();
                    var url = 'check.php?t=del&id='+id;
                    $(this).attr('href',url);
                    yeye.remove();
                }
            });
        });
    });
}
})
</script>
</html>
