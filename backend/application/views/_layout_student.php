<?php

$this->load->view("components/page_header_student");

$userType = $this->session->userdata('user_type');
$returnPrefix = '';
if ($userType == '2')
    $returnPrefix = 'student/';

?>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/frontend/custom_student.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/student/custom.css') ?>">
<script>
    var imageDir = baseURL + "";
    var loginUserType = '<?=$userType?>';
</script>

<?php $this->load->view($subview); ?>

<div class="top-bar">
    <a onclick="goPreviousPage(-1)" class="top-back"></a>
    <?php if ($this->session->userdata("loggedin") == TRUE) { ?>
        <a href="<?= base_url('users/profile/' . $this->session->userdata('loginuserID')); ?>"
           class="top-profile"></a>
    <?php } else { ?>
        <a href="<?= base_url($returnPrefix . '/signin'); ?>" class="top-login"> </a>
    <?php } ?>
<!--    <a onclick="closeApp()" class="top-btn-minimize"></a>-->
<!--    <a onclick="$('.top-close-bg').fadeIn('fast');" class="top-btn-close"></a>-->
</div>
<!--<div class="top-close-bg">-->
<!--    <div class="top-close-modal">-->
<!--        <a class="top-btn-yes" onclick="closeApp();"></a>-->
<!--        <a class="top-btn-no" onclick="$('.top-close-bg').fadeOut('fast');"></a>-->
<!--    </div>-->
<!--</div>-->

<?php $this->load->view("components/page_footer"); ?>

