<?php

$this->load->view("components/page_header");

$userType = $this->session->userdata('user_type');
$returnPrefix = '';
if ($userType == '2')
    $returnPrefix = 'student/';

?>
<script>
    var imageDir = baseURL + "";
    var loginUserType = '<?=$userType?>';
</script>


<?php $this->load->view($subview); ?>

<div class="top-bar">
    <?php if ($this->session->userdata("loggedin") == TRUE) { ?>
        <a onclick="goPreviousPage(-1)" class="top-back" style="display: none;"></a>
        <a href="<?= base_url('home/index'); ?>" class="home-btn"></a>
        <div class="top-profile-text"><?= $this->session->userdata('user_name') ?></div>
        <div class="top-profile-icon"></div>
        <div class="top-profile-selector" data-sel="0">
            <a data-id="0" href="<?= base_url('users/profile/' . $this->session->userdata('loginuserID')); ?>">个人中心</a>
            <a data-id="1" href="<?= base_url('signin/signout'); ?>">退出登录</a>
        </div>
    <?php } else { ?>
        <a href="<?= base_url($returnPrefix . 'signin'); ?>" class="top-login">登录</a>
        <div class="top-div">|</div>
        <a href="<?= base_url($returnPrefix . 'signin/signup'); ?>" class="top-register">注册</a>
    <?php } ?>

    <a onclick="minimizeApp()" class="top-btn-minimize"></a>
    <a onclick="$('.top-close-bg').fadeIn('fast');" class="top-btn-close"></a>
</div>
<div class="top-close-bg">
    <div class="top-close-modal">
        <a class="top-btn-yes" onclick="closeApp();"></a>
        <a class="top-btn-no" onclick="$('.top-close-bg').fadeOut('fast');"></a>
    </div>
</div>
<script>
    console.log(osStatus);
    $('.top-profile-icon').on('click', function () {
        var selFlag = $('.top-profile-selector').attr('data-sel');
        if (selFlag == 0) {
            $('.top-profile-selector').show();
            $('.top-profile-selector').attr('data-sel', 1);
        }
        else {
            $('.top-profile-selector').hide();
            $('.top-profile-selector').attr('data-sel', 0);
        }
    })

    setTimeout(function () {
        try {
            var isFlag = JavaFx;
            $('.top-btn-minimize').show();
            $('.top-btn-close').show();
//            $('.top-profile').css({left:'82.45%'});
//            $('.top-logout').css({left:'82.5%'});
        } catch (e) {
//            document.getElementsByClassName('top-bar')[0].innerText = e.message;
            $('.top-btn-minimize').hide();
            $('.top-btn-close').hide();
//            $('.top-profile').css({left:'90.45%'});
//            $('.top-logout').css({left:'90.5%'});

//        $('.top-btn-minimize').show();
//        $('.top-btn-close').show();
//        $('.top-profile').css({left:'82.45%'});
//        $('.top-logout').css({left:'82.5%'});
        }
    }, 500);
</script>
<?php $this->load->view("components/page_footer"); ?>

