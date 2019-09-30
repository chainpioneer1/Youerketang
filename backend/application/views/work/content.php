<?php
$logged_In_user_id = $this->session->userdata("loginuserID");
$user_type = $this->session->userdata("user_type");
$imageAbsDir =  base_url().'assets/images/frontend/';
$myworkURL = 'work/student';
$returnURL = 'work/script';
$hd_menu_img_path = '';

if($user_type=='2'){

    $myworkURL = 'work/script/'.$logged_In_user_id;
    $hd_menu_img_path = $imageAbsDir.'studentwork/';
    if($content_type_id == '1')
    {
        $returnURL = $myworkURL;
    }else{///this mean $content_type_id is 3 , head work
        $returnURL = 'work/head';
    }
}else{
    $hd_menu_img_path = $imageAbsDir.'studentwork/stu_';
}

?>
<link rel = "stylesheet" type="text/css" href="<?= base_url('assets/css/frontend/menu_manage.css')?>">
<link rel = "stylesheet" type="text/css" href="<?= base_url('assets/css/frontend/work_view.css')?>">
<div class="bg">
    <img src="<?= base_url('assets/images/frontend/mywork/scriptview_bg.jpg')?>" class="background_image">
</div>
<div class="hdmenu">
    <div style="position: relative; height: 100%">
        <img class = "hdmenu_img" src="<?= $hd_menu_img_path.'hdmenu_normal.png';?>" usemap="#hdmenu_map">
        <a id = "hdmenu_studentwork" href="<?= base_url($myworkURL);?>" style="top: 27.2%; left: 1.1%; width: 31.9%; height: 48.5%;"></a>
        <a id = "hdmenu_profile" href="<?= base_url().'users/profile/'.$logged_In_user_id;?>" style="top: 3.9%; left: 37.1%; width: 26.1%; height: 90.4%;"></a>
        <a id = "hdmenu_community" href="<?= base_url().'community/index';?>" style="top: 27.2%; left: 67%; width: 31.9%; height: 48.5%;"></a>
    </div>
</div>
<div class="exit-btn">
    <?php if($this->session->userdata("loggedin") == FALSE): ?>
        <a href="<?= base_url('signin/index')?>">
            <img  class= "exit_btn_img" src="<?= base_url('assets/images/frontend/coursewares/register.png')?>""></a>
    <?php else: ?>
        <a href="<?= base_url('signin/signout')?>">
            <img class= "exit_btn_img" src="<?= base_url('assets/images/frontend/coursewares/exit.png')?>""></a>
    <?php endif; ?>
</div>
<!---------$user_id is owner of content---------->
<a  onclick="history.go(-1)"
    class="return_btn"
    style="background:url(<?= base_url('assets/images/frontend/studentwork/back.png')?>) no-repeat;background-size: 100% 100%;">
</a>
<?php if($user_id == $logged_In_user_id ){?><!---------if visitor is user that wrote content..------------->
<a  href="#" id="shareContent_Btn"
    class="share_content_btn"
    style="background:url(<?= base_url('assets/images/frontend/mywork/workshare.png')?>) no-repeat;background-size: 100% 100%;">
</a>
<?php } ?>
<?php  if($content_type_id =='1'){?>
    <a  href="#" class="scriptPrint_Icon"
        style="background:url(<?= base_url('assets/images/frontend/mywork/scriptprint.png')?>) no-repeat;background-size: 100% 100%;">
    </a>
<?php }else{?>
    <a  href="#" class = "headImgPrint_Icon"
        style="background:url(<?= base_url('assets/images/frontend/mywork/headprint.png')?>) no-repeat;background-size: 100% 100%;">
    </a>
<?php } ?>

<div class="work_view_area">
    <?php if($content_type_id=='1') { ?>
        <div style="text-align: center;">
            <h1 class="scriptwork_title"  style="font-weight: bold;color:#ee4331;"><?php echo $content_title; ?></h1>
        </div>
        </br></br>
        <div class="content-wrap" id="content_wrap" style="left: 0; top: 15%; width: 100%; height: 85%">
            <?= $scriptText ?>
        </div>
        <?php
    }else if($content_type_id=='5'){?>
        <div  id="headImage_wrapper">
            <img id = "headImage" style="width:100%" src="<?= base_url().$headImagePath;?>">
        </div>
    <?php }?>
</div>

<!-----------Share content Modal------------>
<style type="text/css">
    .modal-backdrop{position:absolute;top:0;left:0;width:100%; height:100%;background:#000; opacity: .0;filter:alpha(opacity=0);z-index:50;display:none;}
    .custom-modal{position:absolute;top:30%;left:35%;width:30.5%;height:31.2%;background:#ffffff;z-index:51;display:none;border-radius:10%;}
    .share_modal_content
    {
        background: url(<?= $imageAbsDir.'mywork/share_confirmbg1.png'?>);
        background-size: 100% 100%;
        width:100%;
        height:100%;
    }
    #content_share_btn
    {
        position: absolute; width:20%; height:20%; left:14%;top:68%;
        background: url(<?= $imageAbsDir.'mywork/yes.png'?>) no-repeat;
        background-size: 100% 100%;
    }
    .share_close_btn
    {
        position: absolute; width:20%;height:20%;left:67%;top:68%;
        background: url(<?= $imageAbsDir.'mywork/no.png'?>) no-repeat;
        background-size: 100% 100%;
    }
</style>
<div class="modal-backdrop"></div>
<div class="custom-modal" id="share_content_modal">
    <div  class="share_modal_content">
        <a href="#" id="content_share_btn" content_id = "<?php echo $content_id;?>"></a>
        <a href="#" class="share_close_btn"></a>
    </div>
</div>
<!-----------share content Modal------------>
<script>
    var contentTitle = '<?php echo $content_title;?>';
    var hdmenuImgPath = '<?= $hd_menu_img_path;?>';
    function showCustomModal()
    {
        $('.modal-backdrop, .custom-modal').animate({'opacity':'.8'}, 300, 'linear');
        $('#share_content_modal').animate({'opacity':'1.00'}, 300, 'linear');
        $('.modal-backdrop, .custom-modal').css('display', 'block');
    }
    function close_modal()
    {
        $('.modal-backdrop, .custom-modal').animate({'opacity':'0'}, 300, 'linear', function(){
            $('.modal-backdrop, .custom-modal').css('display', 'none');
        });
    }
</script>
<script src="<?= base_url('assets/js/frontend/menu_manage.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/frontend/work_view.js') ?>" type="text/javascript"></script>
