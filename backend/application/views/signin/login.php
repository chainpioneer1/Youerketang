<?php
if ($form_validation != 'No') $form_validation = 'Information error';
?>
<script>
    var isErr = '<?=$form_validation?>';
</script>


<div class="bg"></div>

<form method="post" class="login_form" action="<?= base_url('signin/signin') ?>">
    <input type="text" name="username" maxlength="18" id="username" placeholder="请输入手机号码">
    <input type="password" name="password" maxlength="18" id="password" placeholder="请输入登录密码">
    <input type="text" name="user_type" hidden id="user_type" value="1">
    <a type="image" name="submit" class="login-btn">登 录</a>
    <a href="<?= base_url('signin/signup'); ?>" class="register-txt">还没注册, 立即注册</a>
<!--    <a href="--><?//= base_url('signin/forgot'); ?><!--" class="forgot-txt">立即注册</a>-->
    <button type="submit" hidden></button>
</form>
<div class="login-err"><?= $this->lang->line('login_error') ?></div>

<script>
    $('.bg').css({background: 'url(' + baseURL + 'assets/images/frontend/signin/bg.png)'});
    $(function () {
        $('.top-bar').remove();
        if (isErr != 'No') {
            $('.login-err').fadeIn('fast');
        }
        $('.login-btn').on('click', function (object) {
            $('.login_form').submit();
        })
    })
    sessionStorage.removeItem('ci_session');

</script>

<script src="<?= base_url('assets/js/frontend/login.js') ?>"></script>
