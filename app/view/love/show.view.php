<?php
$content = $explain['content'];
if (mb_strlen($content) > 32) {
    $content = msubstr($content, 0, 32);
}
view('layout/header', [
    'title'       => $title,
    'keyword'     => "{$explain['user_from']},{$explain['user_to']}",
    'description' => $content,
]);
?>
    <div class="container">
        <div class="header">
            <div class="hero-head is-centered">
                <a href="/"><img class="w-100" src="/img/background.png"/></a>
                <a class="button is-info say bg-yellow-light text-yellow" href="/say">想跟你说</a>
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
                                <span>给<?php _e($explain['user_to']) ?></span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <hr style="margin: .1rem 0 .625rem">
        </div>
        <div class="love">
            <div class="card">
                <div class="card-content bg-1">
                    <p class="title">
                        <?php _e($explain['content']) ?>
                    </p>
                    <p class="subtitle has-text-right">
                        <img class="user-pic" src="<?php _e($explain['img']) ?>"
                             title="<?php _e($explain['user_from']) ?>" alt="<?php _e($explain['user_from']) ?>">
                        <!--span class="user-name t-3"><?php _e($explain['user_from']) ?></span-->
                    </p>
                </div>
                <footer class="card-footer">
                    <div class="card-footer-item" style="margin-top: 0">
                        <div class="field has-addons w-100">
                            <div class="heart text-dot">
                                <span class="icon is-small"><i class="far fa-heart" aria-hidden="true"></i></span><span
                                        class="heart-rate">0</span>
                            </div>
                            <div class="time">
                                <time><?php _e($explain['ctime']) ?></time>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
            <div class="comment-body">
                <button class="button is-info comment">评论</button>
                <div class="modal">
                    <div class="modal-background"></div>
                    <div class="modal-card">
                        <form>
                            <header class="modal-card-head">
                                <p class="modal-card-title">评论 <span class="at"></span></p>
                                <button class="delete exit" aria-label="close"></button>
                                <input type="hidden" name="pid">
                                <input type="hidden" name="id" value="<?php _e($explain['hash']) ?>">
                            </header>
                            <section class="modal-card-body">
                                <p class="edit">你好, <span class="username"></span> <a>修改</a></p>
                                <div class="field">
                                    <div class="control">
                                        <input class="input required" name="from" type="text" placeholder="你的名称">
                                    </div>
                                    <p class="help" data-content="请填入你的名字"></p>
                                </div>
                                <div class="field">
                                    <label class="label"></label>
                                    <p class="control has-icons-left">
                                        <span class="select">
                                            <select name="sex">
                                                <option value="0">女</option>
                                                <option value="1">男</option>
                                                <option value="2">就不告诉你</option>
                                            </select>
                                        </span>
                                        <span class="icon is-small is-left"><i class="fas fa-genderless"></i></span>
                                    </p>
                                </div>
                                <div class="field">
                                    <div class="control">
                                        <input class="input" name="qq" type="text" placeholder="你的QQ号（头像来源选填）">
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="control">
                                        <textarea class="textarea required" name="content" rows="5"
                                                  placeholder=""></textarea>
                                    </div>
                                    <p class="help" data-content="请填入内容"></p>
                                </div>
                            </section>
                            <footer class="modal-card-foot">
                                <button class="button is-success" id="send">发送</button>
                                <button class="button exit">关闭</button>
                                <span class="tips"></span>
                            </footer>
                        </form>
                    </div>
                </div>
                <ul class="c-XN">
                    <?php
                    $comment_status = false;
                    if (isset($comment['children']) && count($comment['children']) > 0) {
                        $comment_status = true;
                        $comment = $comment['children'];
                    }
                    if ($comment_status): ?>
                        <h3 class="margin-bottom">评论列表</h3>
                        <?php foreach ($comment as $item): ?>
                            <li id="comment-<?php _e($item['id']) ?>" class="c-XN-li border-small border-bottom">
                                <a href="#comment-<?php _e($item['id']) ?>" class="author <?php
                                switch ($item['sex']) {
                                    case 0:
                                        echo 'text-venus';
                                        break;
                                    case 1:
                                        echo 'text-mars';
                                        break;
                                    default:
                                        echo 'text-transgender';
                                        break;
                                }
                                ?>">
                                    <img class="radius-circle" src="<?php _e($item['qq']) ?>"
                                         title=""/><?php _e($item['name']) ?>
                                </a>
                                <span class="icon is-small" style=""><i class="fas <?php
                                    switch ($item['sex']) {
                                        case 0:
                                            echo 'fa-venus';
                                            break;
                                        case 1:
                                            echo 'fa-mars';
                                            break;
                                        default:
                                            echo 'fa-transgender';
                                            break;
                                    }
                                    ?>" aria-hidden="true"></i></span>
                                <p class="content"><?php _e($item['content']) ?></p>
                                <div class="foot">
                                    <span class="time"><?php _e($item['ctime']) ?></span>
                                    <span class="reply" data-id="<?php _e($item['id']) ?>">回复</span>
                                </div>
                                <?php if (isset($item['children']) && count($item['children']) > 0): ?>
                                    <hr class="border-small border-bottom">
                                    <ul>
                                        <?php foreach ($item['children'] as $k => $v): ?>
                                            <li id="comment-<?php _e($v['id']) ?>"
                                                class="c-XN-li <?php _e(($k != (count($item['children']) - 1)) ? 'border-small border-bottom' : '') ?>">
                                                <a href="#comment-<?php _e($v['id']) ?>" class="author <?php
                                                switch ($v['sex']) {
                                                    case 0:
                                                        echo 'text-venus';
                                                        break;
                                                    case 1:
                                                        echo 'text-mars';
                                                        break;
                                                    default:
                                                        echo 'text-transgender';
                                                        break;
                                                }
                                                ?>">
                                                    <img class="radius-circle" src="<?php _e($v['qq']) ?>"
                                                         title=""/><span class="name"><?php _e($v['name']) ?></span>
                                                </a>
                                                <span class="icon is-small" style=""><i class="fas <?php
                                                    switch ($v['sex']) {
                                                        case 0:
                                                            echo 'fa-venus';
                                                            break;
                                                        case 1:
                                                            echo 'fa-mars';
                                                            break;
                                                        default:
                                                            echo 'fa-transgender';
                                                            break;
                                                    }
                                                    ?>" aria-hidden="true"></i></span>
                                                <p class="content"><?php _e($v['content']) ?></p>
                                                <div class="foot">
                                                    <span class="time"><?php _e($v['ctime']) ?></span>
                                                    <span class="reply" data-id="<?php _e($item['id']) ?>"
                                                          data-reply="<?php _e($v['id']) ?>">回复</span>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </li>
                        <?php
                        endforeach;
                    else:
                        ?>
                        <p>暂时没有留言哦~</p>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
    <script>
        (function () {
            like_ajax('get', 'get');
            $('.heart').click(function () {
                like_ajax('add', 'post');
            });
            init_comment();
            is_remove_btn(function () {
                $('.modal').removeClass('is-active');
            });
            $('.modal-background').click(function () {
                $('.modal').removeClass('is-active');
            });
            no_sub();
            $('.field .control input.required').bind('change blur', is_input);
            $('.field .control input').bind('change', is_input);
            $('.field .control textarea').bind('change blur', is_input);
            $('#send').click(function () {
                $('.field>.control>.required').each(function (i, e) {
                    var m = $(e), p = m.parent().next();
                    if (m.val() === '')
                        m.addClass('is-danger'), p.addClass('is-danger').text(p.data('content'));
                })

                if (($(".required[name=from]").val() === '') || ($(".required[name=content]").val() === '')) return;

                save_user();

                var t = $("textarea[name=content]").val();
                $("textarea[name=content]").val(t.replace(_id, user));

                $.ajax({
                    url: '/api/comment',
                    type: 'post',
                    dataType: 'json',
                    data: $('form').serialize(),
                    success: function (data) {
                        if (data.code != 200) {
                            $('.tips').attr('class', 'tips text-dot').text('评论失败');
                            return;
                        }

                        $('.tips').attr('class', 'tips has-text-success').text(data.message);
                        setTimeout(function () {
                            $('.modal').removeClass('is-active');
                            $('.c-XN').html(data.data);
                            init_comment_reply();
                        }, 1000);
                    },
                    error: function (err) {
                        $('.tips').attr('class', 'text-dot').text('评论失败');
                    }
                });
            });
            $('.edit a').click(function () {
                $('.edit').hide();
                show_user_event();
            });
            var _id='',user='';

            function like_ajax(n, t) {
                $.ajax({
                    url: '/api/like/<?php _e($explain['hash']) ?>/' + n,
                    type: t,
                    dataType: 'json',
                    success: function (data) {
                        if (n == 'add') {
                            $('.fa-heart').removeClass('far').addClass('fas');
                        }
                        data = data.data;
                        $('.heart').find('.heart-rate').text(data.total);
                    },
                })
            }

            function init_comment() {
                comment($('.comment'));
                init_comment_reply();
            }

            function init_comment_reply() {
                $('.reply').each(function (i, e) {
                    comment($(e));
                });
            }

            function comment(e) {
                e.click(function () {
                    clear_user();
                    set_user();
                    is_user();
                    is_modal();
                    var m = $('.modal'), e = $(this), id = e.data('id'), reply = e.data('reply'), text = '';
                    if (typeof e.data('reply') !== 'undefined') {
                        _id = '#comment-' + reply;
                        text = '@' + $(_id + ' .name').text();
                        user = '<a href="'+_id+'">'+text+'</a>';
                    }
                    $('input[name=pid]').val(id);
                    m.find('.at').text(text);
                    m.find('.textarea').val(text);
                })
            }

            function save_user() {
                $(this).storage('username', $('input[name=from]').val());
                $(this).storage('sex', $('.select select').val());
                $(this).storage('qq', $('input[name=qq]').val());
            }

            function is_user() {
                ($(this).storage('username') !== null && $(this).storage('sex') !== null) ? hide_user_event() : show_user_event();
            }

            function clear_user() {
                $('.tips').text('');
                $('input[name=from]').val('');
                $('.select select').val(0);
                $('input[name=qq]').val('');
            }

            function set_user() {
                $('input[name=from]').val($(this).storage('username'));
                $('.select select').val($(this).storage('sex'));
                $('input[name=qq]').val($(this).storage('qq'));
            }

            function show_user_event() {
                $('.edit').hide();
                $('input[name=from]').parent().parent().show();
                $('.select select').parent().parent().show();
                $('input[name=qq]').parent().parent().show();
            }

            function hide_user_event() {
                $('.edit').show();
                $('.edit .username').text($(this).storage('username'));
                $('input[name=from]').parent().parent().hide();
                $('.select select').parent().parent().hide();
                $('input[name=qq]').parent().parent().hide();
            }
        })()
    </script>
<?php view('layout/footer'); ?>