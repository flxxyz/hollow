<?php view('layout/header'); ?>
<div class="container">
    <div class="header">
        <div class="hero-head is-centered">
            <a href="/"><img class="w-100" src="/img/background.png"/></a>
            <a class="button is-info say" href="<?php _e(url('say')) ?>">想跟你说</a>
        </div>
        <div class="tags is-right">
            <span>有&nbsp;</span><span class="tag is-danger"><?php _e(($count > 999) ? '999+' : $count) ?></span><span>&nbsp;条表白了呢~</span>
        </div>
    </div>
    <div class="love">
        <?php foreach ($data as $k => $v): ?>
            <div class="card">
                <?php if(1): ?><a href="/s/<?php _e($v['hash']) ?>"><?php endif; ?>
                <div class="card-content bg-1">
                    <!--p class="info">
                        <time><?php _e($v['ctime']) ?></time>
                    </p-->
                    <p class="title">
                        <?php _e($v['content']) ?>
                    </p>
                    <p class="subtitle has-text-right">
                        <img class="user-pic" src="<?php _e($v['img']) ?>" title="<?php _e($v['user_from']) ?>" alt="<?php _e($v['user_from']) ?>">
                    </p>
                </div>
                <?php if(1): ?></a><?php endif; ?>
                <footer class="card-footer">
                    <?php if(0): ?>
                        <div class="card-footer-item">
                        <span class="field has-addons w-100">
                        <span class="control w-100">
                            <input class="input clear-border-radius" type="text" placeholder="">
                        </span>
                        <span class="control">
                            <a class="button is-danger clear-border-radius">就是ta</a>
                        </span>
                    </span>
                        </div>
                    <?php else: ?>
                        <div class="card-footer-item" style="margin-top: 0">
                            <div class="field has-addons w-100">
                                <div class="heart text-dot" data-id="<?php _e($v['hash']) ?>">
                                    <span class="icon is-small"><i class="far fa-heart" aria-hidden="true"></i></span><span class="heart-rate"><?php _e($v['total']) ?></span>
                                </div>
                                <div class="time">
                                    <time style="color: #4a4a4a"><?php _e($v['ctime']) ?></time>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </footer>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<script>
    (function () {
        var timer = false;
        $('.card-content').click(function () {
            var e = $(this).next().find('.card-footer-item');
            if(e.text().trim() == '') return;
            if(timer) return;
            timer = true;
            if(e.hasClass('active')) {
                card(e, '-38').removeClass('active');
            } else {
                card(e, '0').addClass('active');
            }
        })

        $('.heart').click(function () {
            var e = $(this);
            var n = e.data('id');
            $.ajax({
                url: '/api/like/'+n+'/add',
                type: 'post',
                dataType: 'json',
                success: function (data) {
                    data = data.data;
                    e.find('.fa-heart').removeClass('far').addClass('fas');
                    e.find('.heart-rate').text(data.total);
                },
                error: function (err) {

                }
            })
        });

        function card(e, n) {
            e.animate({marginTop: n}, 300, function () {
                timer = false;
            });
            return e;
        }
    })()
</script>
<?php view('layout/footer'); ?>
