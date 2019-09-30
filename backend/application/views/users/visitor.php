<?php $loged_In_user_id = $this->session->userdata("loginuserID");
?>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/frontend/menu_manage.css')?>"
      xmlns="http://www.w3.org/1999/html">
<link rel = "stylesheet" type="text/css" href="<?= base_url('assets/css/frontend/profile_visitor.css')?>">
<div class="bg">
    <img src="<?= base_url('assets/images/frontend/profile/empty_bg2.png')?>" class="background_image">
</div>
<a  onclick="history.go(-1)"
    class="return_btn"
    style="background:url(<?= base_url('assets/images/frontend/studentwork/back.png')?>) no-repeat;background-size: 100% 100%;">
</a>

<div class="profile_bg">
    <img src="<?= base_url('assets/images/frontend/profile/profile_bg.png')?>" class="profile_image">
</div>
<!-----------------------------------teacher personal Info Field--------------------------------------------------------------->
<div class="static_info_fields" >
    <div class="visitor_username_lbl">
        <p id="username_p"><?php echo $userInfo->username;?></p>
    </div>
    <div class="visitor_school_lbl">
        <p id="school_p"><?php echo $userInfo->school_name;?></p>
    </div>
</div>
<!-----------------------------------class manage Info Field--------------------------------------------------------------------------->
<!-----------------------------------Pagination Buttons-------------------------------------------------------------------------------->
<a  href="#" class="share_prev_btn"
    style="background:url(<?= base_url('assets/images/frontend/profile/prev.png')?>) no-repeat;background-size: 100% 100%;">
</a>
<a  href="#" class="share_next_btn"
    style="    z-index:9999;background:url(<?= base_url('assets/images/frontend/profile/next.png')?>) no-repeat;background-size: 100% 100%;">
</a>
<!-----------------------------------Pagination Buttons---------------------------------------------------------------------------------->
<style>
    .item_left
    {
        background: url(<?= base_url('assets/images/frontend/profile/item_bg2.png')?>) no-repeat;
        background-size: 100% 100%;
        width:80%;
    }
</style>
<div class="share_list_wrapper" id="shared_list_area">
</div>
<script>
    var sharedList = '<?php echo json_encode($sharedLists);?>';
</script>
<script src="<?= base_url('assets/js/frontend/menu_manage.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/frontend/profile_visitor.js') ?>" type="text/javascript"></script>