<?php view('layout/header'); ?>
<div class="container">
    <div class="header">
        <!--div class="hero-head is-centered">
            <a href="#"><img class="w-100" src="/img/background.png"/></a>
            <a class="button is-info say" href="<?php _e(url('say')) ?>">想跟你说</a>
        </div-->
        <hr style="margin: .1rem 0 .625rem">
        <div class="tags is-right">
            有 <span class="tag is-danger"><?php _e((1000 > 999) ? '999+' : '999') ?></span> 条表白了呢~
        </div>
    </div>
    <div class="love">
        <!--男性to女性-->
        <div class="card">
            <div class="card-content bg-1">
                <p class="title">
                    **********...
                </p>
                <p class="subtitle has-text-right">
                    <img src="/img/default.jpg">
                </p>
            </div>
            <footer class="card-footer">
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
            </footer>
        </div>
        <!--女性to男性-->
        <div class="card">
            <div class="card-content bg-1">
                <p class="title">
                    **********...
                </p>
                <p class="subtitle has-text-right">
                    <img src="/img/default.jpg">
                </p>
            </div>
            <footer class="card-footer">
                <div class="card-footer-item">
                    <span class="field has-addons w-100">
                        <span class="control w-100">
                            <input class="input clear-border-radius" type="text" placeholder="">
                        </span>
                        <span class="control">
                            <a class="button is-info clear-border-radius">就是ta</a>
                        </span>
                    </span>
                </div>
            </footer>
        </div>
        <!--没有答案-->
        <div class="card">
            <div class="card-content bg-1">
                <p class="title">
                    啊啊啊啊啊啊啊aaaa阿啊啊啊踩踩踩三...
                </p>
                <p class="subtitle has-text-right">
                    <img src="/img/default.jpg">
                </p>
            </div>
            <footer class="card-footer">
                <div class="card-footer-item">
                </div>
            </footer>
        </div>
    </div>
</div>
<script src="/js/jquery.min.js"></script>
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

        function card(e, n) {
            e.animate({marginTop: n}, 300, function () {
                timer = false;
            });
            return e;
        }
    })()
</script>
<?php view('layout/footer'); ?>
