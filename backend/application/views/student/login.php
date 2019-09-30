<?php

if (!isset($form_validation)) $form_validation = 'Information error';
?>
<script>
    var isErr = '<?=json_encode($form_validation)?>';
</script>


<div class="bg"></div>

<form method="post" class="login_form" action="<?= base_url('student/signin/signin') ?>">
    <input type="number" name="username" id="username" placeholder="手机号">
    <input type="password" name="password" maxlength="6" id="password" placeholder="密码">
    <input type="text" name="user_type" hidden id="user_type" value="2">
    <a type="image" name="submit" class="login-btn"></a>
    <a href="<?= base_url('student/signin/signup'); ?>" class="register-txt">信用户注册</a>
    <a href="<?= base_url('student/signin/forgot'); ?>" class="forgot-txt">忘记密码</a>
</form>
<div class="login-err"><?= $this->lang->line('login_error') ?></div>
<div class="success-modal">
    <div class="success-btn" onclick="$(this).parent().fadeOut('fast')"></div>
</div>

<script>
    $('.bg').css({background: 'url(' + baseURL + 'assets/images/student/signin/bg.png)'});
    $(function () {
        if (isErr.indexOf('Waiting')>-1)
            $('.success-modal').fadeIn('fast');
        else if (isErr.indexOf('No')<0) {
            $('.login-err').fadeIn('fast');
        }
        $('.login-btn').on('click', function (object) {
            $('.login_form').submit();
        })
    })

    $('#username').on('input', function (object) {
        var str = $(this).val();
        if (str.length > 11) {
            str = str.substr(0, 11);
        }
        $(this).val(str);
    });

    sessionStorage.removeItem('ci_session');
</script>

<script src="<?= base_url('assets/js/student/login.js') ?>"></script>
