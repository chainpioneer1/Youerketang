<div class="bg"></div>
<style>
    a {
        background: #ff655a;
        color: white;
        text-decoration: none !important;
        width: calc(11vw);
        height: calc(3.5vw);
        line-height: calc(3.5vw);
        font-size: calc(1.7vw);
        top: 62%;
        text-align: center;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        font-family: "Microsoft YaHei";
        left: calc(34vw);
    }

    a:hover, a:focus {
        color: white;
        background: #666;
    }

    input {
        left: 31%;
        width: 39%;
        top: 51.3%;
        font-size: calc(1.6vw);
        background: transparent;
        font-family: "Microsoft YaHei";
        height: calc(3vw);
        line-height: calc(3vw);
    }
    .notifyMsg{
        position: absolute;
        color: red;
        text-align: center;
        left: 50%;
        top: 70%;
        width: auto;
        height: auto;
        -webkit-transform: translateX(-50%);
        -moz-transform: translateX(-50%);
        -ms-transform: translateX(-50%);
        -o-transform: translateX(-50%);
        transform: translateX(-50%);
    }
</style>
<form method="post" class="activation_form" action="<?= base_url('home/activation') ?>">
    <input type="text" name="code" maxlength="8" placeholder="请输入授权码">
    <a href="<?= ($this->session->userdata('user_type') == '1') ? base_url('signin/signout') : base_url('student/signin/signout') ?>">取消</a>
    <a href="javascript:;" style="left:calc(55vw);" data-type="submit">确定</a>
    <button type="submit" hidden></button>
</form>
<?php
if (isset($errMsg)) {
    echo '<div class="notifyMsg">' . $errMsg . '</div>';
}
?>


<script>
    $(function () {
        $('.bg').css({background: 'url(' + baseURL + 'assets/images/frontend/signin/bg_activation.png)'});
        $('.top-bar').remove();
    })
    $('a[data-type="submit"]').on('click', function () {
        $('.activation_form').submit();
    })
</script>
