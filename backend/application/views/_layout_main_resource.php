<?php $this->load->view("components/page_header"); ?>

<script src="<?= base_url('assets/js/frontend/global.js') ?>"></script>
<?php

$userType = $this->session->userdata('user_type');
$returnPrefix = '';
if($userType == '2')
    $returnPrefix = 'student/';

$this->load->view($subview, $this->data);


?>
<script>
    var loginUserType = '<?=$userType?>';
</script>

<div class="top-bar">
    <a onclick="goPreviousPage(-1)" class="top-back"></a>
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
    try{
        var isFlag = JavaFx;
        $('.top-btn-minimize').show();
        $('.top-btn-close').show();
//        $('.top-profile').css({left:'82.45%'});
//        $('.top-logout').css({left:'82.5%'});
    }catch (e){
        $('.top-btn-minimize').hide();
        $('.top-btn-close').hide();
//        $('.top-profile').css({left:'90.45%'});
//        $('.top-logout').css({left:'90.5%'});
    }
</script>
<?php //$this->load->view("components/resource_toolbar"); ?>

<?php $this->load->view("components/page_footer"); ?>


