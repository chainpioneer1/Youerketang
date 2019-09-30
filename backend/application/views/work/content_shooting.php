<?php
$logged_In_user_id = $this->session->userdata("loginuserID");
$user_type = $this->session->userdata("user_type");
$imageAbsDir =  base_url().'assets/images/frontend/';
$myworkURL = 'work/student';
$returnURL = 'work/shooting/'.$user_id;
$course_menu_img_path = '';
if($user_type=='2'){
    $myworkURL = 'work/script/'.$logged_In_user_id;
    $hd_menu_img_path = $imageAbsDir.'studentwork/';
}else{
    $hd_menu_img_path = $imageAbsDir.'studentwork/stu_';
}
?>
<link rel = "stylesheet" type="text/css" href="<?= base_url('assets/css/frontend/menu_manage.css')?>">
<link rel = "stylesheet" type="text/css" href="<?= base_url('assets/css/frontend/work_view.css')?>">

<!--------------------Player-------------------->
<link rel="stylesheet" href="<?= base_url('assets/css/video/style_video.css') ?>" />
<link rel="stylesheet" href="<?= base_url('assets/css/video/vplayer.css') ?>" />
<!--------------------Player-------------------->
<!-----------------------------Vplayer------------------------->
<script  src="<?= base_url('assets/js/video/vplayer.js')?>"></script>
<!-----------------------------Vplayer------------------------->

<div class="bg">
    <img src="<?= base_url('assets/images/frontend/community/shootingview_bg.jpg')?>" class="background_image">
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
        <a href="<?= base_url('signin/index')?>"><img  class= "exit_btn_img" src="<?= base_url('assets/images/frontend/coursewares/register.png')?>""></a>
    <?php else: ?>
        <a href="<?= base_url('signin/signout')?>"><img class= "exit_btn_img" src="<?= base_url('assets/images/frontend/coursewares/exit.png')?>""></a>
    <?php endif; ?>
</div>
<!---------$user_id is owner of content---------->
<a  onclick="history.go(-1)"
    class="return_btn"
    style="background:url(<?= base_url('assets/images/frontend/studentwork/back.png')?>) no-repeat;background-size: 100% 100%;">
</a>
<?php if($user_id == $logged_In_user_id ){?><!---------if visitor is user that wrote content..------------->
    <a  href="#" id="shooting_share_content"
        class="shooting_share_content"
        style="background:url(<?= base_url('assets/images/frontend/mywork/workshare.png')?>) no-repeat;background-size: 100% 100%;">
    </a>
<?php } ?>
<div class="shooting-content">
   <video controls id="videoPlayer" class="video-js vjs-default-skin vjs-big-play-centered" style="background:#000;object-fit: fill;position: absolute;width: 100%;height:100%" autoplay>
        <source src="<?php echo base_url().$videoPath;?>" type="video/mp4">
    </video>
    <script>
        var vplayer = videojs('videoPlayer',{controls:true,width:1280,height:712,preload:'auto',loop:false},function(){
            vplayer.on('play', function(){
                console.log('play');
            });
            vplayer.on("pause",function(){
                console.log('stop');
            });
            vplayer.on("ended",function(){
                console.log('stop');
            });
        });
    </script>
</div>
<!-----------Share content Modal------------>
<style type="text/css">
    .modal-backdrop { position:absolute;top:0;left:0;width:100%; height:100%;background:#000; opacity: .0; filter:alpha(opacity=0); z-index:50; display:none; }
    .custom-modal   { position:absolute;top:30%;left:35%;width:30.5%;height:31.2%;background:#ffffff;z-index:51;display:none;border-radius:10%;}
    .share_modal_content  { background: url(<?= $imageAbsDir.'mywork/share_confirmbg1.png'?>);background-size: 100% 100%; width:100%; height:100%; }
    #content_share_btn    { position: absolute; background: url(<?= $imageAbsDir.'mywork/yes.png'?>) no-repeat; background-size: 100% 100%; width:20%;height:20%;left:14%;top:68%;}
    .share_close_btn     {  position: absolute; background: url(<?= $imageAbsDir.'mywork/no.png'?>) no-repeat;  background-size: 100% 100%; width:20%;height:20%;left:67%; top:68%;}
</style>
<div class="modal-backdrop"></div>
<div class="custom-modal" id="share_content_modal">
    <div  class="share_modal_content">
        <a href="#" id="content_share_btn" content_id = "<?php echo $content_id;?>"></a>
        <a href="#" class="share_close_btn"></a>
    </div>
</div>
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
