<?php
view('layout/header', [
    'title'       => 'login',
    'keyword'     => 'login',
    'description' => 'login',
]);
?>
    <div class="container">
        <div class="love">
            <form>
                <div class="field">
                    <label class="label">用户名</label>
                    <div class="control">
                        <input class="input" type="text" name="username" placeholder="使用名称或手机号">
                    </div>
                </div>
                <div class="field">
                    <label class="label">密码</label>
                    <div class="control">
                        <input class="input" type="password" name="password">
                    </div>
                </div>
                <div class="field">
                    <p class="control">
                        <button class="button is-success" id="login">登录</button>
                    </p>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(function () {
            no_sub();
            $('#login').click(function () {
                var user = $('input[name=username]').val().length;
                if(user < 3) {
                    return;
                }
                var pass = $('input[name=password]').val().length;
                if(pass < 8 && pass > 16) {
                    return;
                }

                $.ajax({
                    url: '/api/login',
                    type: 'post',
                    dataType: 'json',
                    data: $('form').serialize(),
                    success: function (data) {
                        console.log(data);
                        if(data.code != 200) {
                            return;
                        }

                        data = data.data;
                        setTimeout(function () {
                            window.location.href = data.url;
                        }, 1000);
                    },
                    error: function (err) {
                        console.log(err);
                    }
                })
            });
        })
    </script>
<?php view('layout/footer'); ?>