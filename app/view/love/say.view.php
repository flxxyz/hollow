<?php view('layout/header'); ?>
    <div class="container">
        <div class="header">
            <div class="hero-head is-centered">
                <a href="/"><img class="w-100" src="/img/background.png"/></a>
                <button class="button is-info say">想跟你说</button>
            </div>
            <div class="tags is-right">
                <nav class="breadcrumb is-small" aria-label="breadcrumbs">
                    <ul>
                        <li>
                            <a href="/" class="text-venus">
                                <span class="icon is-small"><i class="fas fa-home"></i></span>
                                <span>首页</span>
                            </a>
                        </li>
                        <li class="is-active">
                            <a href="#" aria-current="page">
                                <span class="icon is-small"><i class="fas fa-heart" aria-hidden="true"></i></span>
                                <span>写下你的表白</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <hr style="margin: .1rem 0 .625rem">
        </div>
        <div class="love">
            <!--article class="message is-success">
                <div class="message-header">
                    <p>发布成功！</p>
                    <button class="delete" aria-label="delete"></button>
                </div>
                <div class="message-body">
                    查看发布的表白
                </div>
            </article-->
            <div class="bg-2 message-strong text-yellow radius-big">
                <h3><strong>注意:</strong></h3>
                <p>
                        <span class="icon">
                            <i class="far fa-clock"></i>
                        </span>
                    <span>现在北京时间：<strong><?php _e(date('Y-m-d H:i:s')) ?></strong></span>
                </p>
                <p>
                        <span class="icon">
                            <i class="fas fa-map-marker"></i>
                        </span>
                    <span>你的IP：<strong><?php _e(get_client_ip()) ?></strong></span>
                </p>
                <p>
                        <span class="icon">
                            <i class="fas fa-info-circle"></i>
                        </span>
                    <span>毕竟这是给你表白的，别发有损道德的言论</span>
                </p>
            </div>
            <div class="bg-3 message-strong text-dot radius-big">
                <h3><strong>使用说明:</strong></h3>
                <p>
                        <span class="icon">
                            <i class="fas fa-bullhorn"></i>
                        </span>
                    <span><strong>暂时不限制刷屏</strong></span>
                </p>
                <p>
                        <span class="icon">
                            <i class="fas fa-bullhorn"></i>
                        </span>
                    <span><strong>ta的称呼用网名和班级+姓名 你随意</strong></span>
                </p>
                <!--p>
                        <span class="icon">
                            <i class="fas fa-bullhorn"></i>
                        </span>
                    <span>选择<strong>隐藏内容</strong>最好在称呼上有独特的识别</span>
                </p-->
            </div>
            <form>
                <!--div class="field">
                    <label class="label"></label>
                    <div class="control">
                        <input type="hidden" name="anonymous" value="0">
                        <button class="button is-danger anonymous" type="button">
                            <span class="icon is-small"><i class="fas fa-question-circle"></i></span>&nbsp;<span
                                    class="text">你想匿名发给Ta吗?</span>
                        </button>
                    </div>
                </div-->
                <!--div class="field">
                    <label class="label"></label>
                    <div class="control">
                        <input type="hidden" name="hide" value="0">
                        <button class="button is-danger hide" type="button">
                            <span class="icon is-small"><i class="fas fa-question-circle"></i></span>&nbsp;<span
                                    class="text">你想隐藏内容吗?</span>
                        </button>
                    </div>
                </div-->
                <div class="field">
                    <label class="label"></label>
                    <p class="control has-icons-left">
                            <span class="select">
                                <select name="effect">
                                    <option value="">请选择特效（默认无）</option>
                                    <?php foreach ($effect as $k => $v): ?>
                                        <option value="<?php _e($v['id']) ?>"><?php _e($v['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </span>
                        <span class="icon is-small is-left">
                                <i class="fas fa-fire"></i>
                            </span>
                    </p>
                </div>
                <div class="field">
                    <label class="label"></label>
                    <p class="control has-icons-left">
                            <span class="select">
                                <select name="bg">
                                    <option value="">请选择背景（默认无）</option>
                                    <?php foreach ($bg as $k => $v): ?>
                                        <option value="<?php _e($v['id']) ?>"><?php _e($v['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </span>
                        <span class="icon is-small is-left">
                                <i class="fas fa-image"></i>
                            </span>
                    </p>
                </div>
                <div class="field">
                    <div class="control">
                        <input class="input required" name="from" type="text" placeholder="你的名称">
                    </div>
                    <p class="help" data-content="请填入你的名称"></p>
                </div>
                <div class="field">
                    <div class="control">
                        <input class="input required" name="to" type="text" placeholder="送给..  他 或是 她 (同性你们随意)">
                    </div>
                    <p class="help" data-content="请填入ta的名称"></p>
                </div>
                <div class="field">
                    <div class="control">
                        <input class="input" name="qq" type="text" placeholder="TA的QQ号（选填）">
                    </div>
                </div>
                <div class="field">
                    <div class="control">
                        <input class="input" name="phone" type="text" placeholder="你的手机号（选填）">
                    </div>
                </div>
                <div class="field">
                    <div class="control">
                            <textarea class="textarea required" name="content" rows="5"
                                      placeholder="想给 ta 说的.."></textarea>
                    </div>
                    <p class="help" data-content="请填入内容"></p>
                </div>
                <div class="field">
                    <div class="control">
                        <button id="send" class="button w-100 is-primary" type="submit">
                            发布表白
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        (function () {
            $('form').submit(function () {
                return false;
            })
            $('.field .control input.required').bind('change blur', input_common);
            $('.field .control input').bind('change', input_common);
            $('.field .control textarea').bind('change blur', input_common);
            $('#send').click(function () {
                $('.field>.control>.required').each(function (i, e) {
                    var m = $(e), p = m.parent().next();
                    if (m.val() === '')
                        m.addClass('is-danger'), p.addClass('is-danger').text(p.data('content'));
                })

                if (($(".required[name=from]").val() === '') || ($(".required[name=to]").val() === '') || ($(".required[name=content]").val() === '')) return;

                submit();
                $('body,html').animate({scrollTop: 0}, 1000);
            });
            $('.anonymous').click(function () {
                btn_click_common('anonymous', '你想匿名发给Ta吗?', '匿名发给Ta吧');
            });
            $('.hide').click(function () {
                btn_click_common('hide', '你想隐藏内容吗?', '隐藏内容让Ta猜猜看~');
            });

            function submit() {
                $.ajax({
                    url: '/api/say',
                    type: 'post',
                    dataType: 'json',
                    data: $('form').serialize(),
                    success: function (data) {
                        check_message();
                        var msg = data.message;
                        var header_p = $('<p>').text(msg);
                        var header_del = $('<button>').addClass('delete').attr('aria-label', 'delete');
                        var header = $('<div>').addClass('message-header');
                        var body = $('<div>').addClass('message-body');
                        var article = $('<article>').addClass('message');
                        if (data.code == 200) {
                            data = data.data;
                            var url = data.url;
                            header.append(header_p);
                            var body_a = $('<a>').attr('href', url).text('查看发布的表白');
                            body.append(body_a);
                            article.addClass('is-success').append(header, body);
                            $('.love').html('').append(article);
                        } else {
                            header.append(header_del, header_p);
                            article.addClass('is-warning').append(header, body);
                            $('.love').prepend(article);
                            add_del();
                        }
                    },
                    error: function (err) {
                        check_message();
                        var header_p = $('<p>').text('发布失败');
                        var header_del = $('<button>').addClass('delete').attr('aria-label', 'delete');
                        var header = $('<div>').addClass('message-header');
                        var body = $('<div>').addClass('message-body');
                        var article = $('<article>').addClass('message');
                        header.append(header_del, header_p);
                        body.append('Σ(っ °Д °;)っ你的表白好像被未知生物吃掉了');
                        article.addClass('is-warning').append(header, body);
                        $('.love').prepend(article);
                        add_del();
                    }
                });
            }

            function add_del() {
                $('.delete').click(function () {
                    $('.message').remove();
                });
            }

            function check_message() {
                if ($(".message").length > 0)
                    return;
            }

            function input_common() {
                var m = $(this), parent = m.parent(), p = parent.next();
                if (m.val() == '') {
                    m.addClass('is-danger');
                    if (m.hasClass('required'))
                        p.addClass('is-danger').text(p.data('content'));
                    return;
                }

                m.removeClass('is-danger').addClass('is-success');
                if (m.hasClass('required'))
                    p.removeClass('is-danger').text('');
            }

            function btn_click_common(a, b, c) {
                var e = $(this), remove = 'is-primary', add = 'is-danger', text = b, ca = 'fa-question-circle',
                    cr = 'fa-check-circle', v = 0;
                if (e.hasClass('is-danger'))
                    add = 'is-primary', remove = 'is-danger', text = c, ca = 'fa-check-circle', cr = 'fa-question-circle', v = 1;
                e.removeClass(remove).addClass(add);
                e.find('.text').text(text);
                e.find('i').removeClass(cr).addClass(ca);
                $('input[name=' + a + ']').val(v);
            }
        })()
    </script>
<?php view('layout/footer'); ?>