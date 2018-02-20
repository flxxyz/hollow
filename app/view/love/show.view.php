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
                <a class="button is-info say bg-yellow-light text-yellow" href="<?php _e(url('say')) ?>">想跟你说</a>
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
                        <header class="modal-card-head">
                            <p class="modal-card-title">评论 <span class="at"></span></p>
                            <button class="delete" aria-label="close"></button>
                        </header>
                        <section class="modal-card-body">
                            <form>
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
                            </form>
                        </section>
                        <footer class="modal-card-foot">
                            <button class="button is-success">发送</button>
                            <button class="button" type="reset">重置</button>
                        </footer>
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
                            <li id="u<?php _e($item['id']) ?>" class="c-XN-li border-small border-bottom">
                                <a href="#u<?php _e($item['id']) ?>" class="author <?php
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
                                            <li id="u<?php _e($v['id']) ?>"
                                                class="c-XN-li <?php _e(($k != (count($item['children']) - 1)) ? 'border-small border-bottom' : '') ?>">
                                                <a href="#u<?php _e($v['id']) ?>" class="author <?php
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
                                                    <span class="reply" data-id="<?php _e($v['id']) ?>" data-reply="1">回复</span>
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
            like_ajax('get', 'get', $('.heart'));
            $('.heart').click(function () {
                like_ajax('add', 'post', $(this));
            });
            $('.comment').click(function () {
                active_model();
            });
            $('.delete').click(function () {
                $('.modal').removeClass('is-active');
            })
            $('.reply').each(function (i, e) {
                comment(e);
            })

            function like_ajax(n, t, e) {
                $.ajax({
                    url: '/api/like/<?php _e($explain['hash']) ?>/' + n,
                    type: t,
                    dataType: 'json',
                    success: function (data) {
                        if (n == 'add') {
                            $('.fa-heart').removeClass('far').addClass('fas');
                        }
                        data = data.data;
                        e.find('.heart-rate').text(data.total);
                    },
                    error: function (err) {

                    }
                })
            }

            function comment(el) {
                $(el).click(function () {
                    active_model();
                    var m = $('.modal'), e = $(this), id = e.data('id'), text = '';
                    if (typeof e.data('reply') !== 'undefined')
                        text = '@' + $('#u' + id + ' .name').text();
                    m.find('.at').text(text);
                    m.find('.textarea').val(text + ' ');
                    console.log($(this).removeStorage('aaa'));
                })
            }

            function active_model() {
                var m = $('.modal');
                m.hasClass('is-active') ? m.removeClass('is-active') : m.addClass('is-active');
            }
        })()
    </script>
<?php view('layout/footer'); ?>