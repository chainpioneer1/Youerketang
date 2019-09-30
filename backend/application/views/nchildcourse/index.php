<?php
$userRole = '0';
if($this->session->userdata("loggedin") != FALSE)
{
    $course_permission = $this->session->userdata('course_permission');
    if($course_permission!==NULL)
    {
        $userRole =  $course_permission->sandapian;
    }
}
$loged_In_user_id = $this->session->userdata("loginuserID");
$imageAbsDir =  base_url().'assets/images/taiyang/';
$user_type = $this->session->userdata("user_type");
?>
<style>
    body, html {
        height: 100%;
        margin: 0;
    }
    .background_image { position: fixed; top: 0;left: 0; width:100%;height:100%; background-size: contain; z-index: -2; }
    .ncourse_title_image { position: fixed;top: 3%;left: 32%;width: 35%;height: 16%;background-size: contain;z-index: -1;}
    #sh_firstcs_btn {position: absolute;top:17.87%;left:4.58%;width:27.3%;height:53.6%;background-size: 100% 100%;}
    #sh_secondcs_btn {position: absolute;top:34%;left:36.3%;width:27.3%;height:53.6%;background-size: 100% 100%;}
    #sh_thirdcs_btn {position: absolute;top:17.87%;right:4.58%;width:27.3%;height:53.6%;background-size: 100% 100%;}
</style>

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/sandapian/menu_manage.css') ?>">
<div class="bg">
    <img src="<?= $imageAbsDir.'new_course/bg.png';?>" class="background_image">
</div>
<div class="ncourse_title_bg">
    <img src="<?= $imageAbsDir.'new_course/title.png';?>" class="ncourse_title_image">
</div>

<a href="<?= base_url('home/index');?>"
   class="btn" id="sh_backhome_btn"
   style="background:url(<?= $imageAbsDir.'base/backhome.png';?>) no-repeat;background-size: 100% 100%">
</a>

<?php if($this->session->userdata("loggedin") != FALSE){?>
    <a href="<?= base_url().'users/profile/'.$loged_In_user_id;?>"
       class="btn" id="sh_profile_btn"
       style="background:url(<?= $imageAbsDir.'base/profile.png';?>) no-repeat;background-size: 100% 100%">
    </a>
    <a href="<?= base_url('signin/signout')?>"
       class="btn" id="sh_exit_btn"
       style="background:url(<?= $imageAbsDir.'base/exit.png';?>) no-repeat;background-size: 100% 100%">
    </a>
<?php }else{?>
    <a href="<?= base_url('signin/index')?>"
       class="btn" id="sh_login_btn"
       style="background:url(<?= $imageAbsDir.'base/login.png';?>) no-repeat;background-size: 100% 100%">
    </a>
<?php } ?>
<?php

$firstCsUrl = '';$secondCsUrl = '';$thirdCsUrl = '';
$firstCsFree = '0';$secondCsFree = '0';$thirdCsFree = '0';
$firstCs = '0';$secondCsUrl = '0';$thirdCsUrl = '0';
$firstCsImg = 'assets/images/taiyang/new_course/festival.png';
$secondCsImg = 'assets/images/taiyang/new_course/food.png';
$thirdCsImg = 'assets/images/taiyang/new_course/places.png';

if(isset($nccsSet[0])){
    $firstCsUrl =  base_url('ncoursewares/view').'/'.$nccsSet[0]->childcourse_id;
    $firstCsImg = $nccsSet[0]->childcourse_photo;
    $firstCsFree = $nccsSet[0]->childcourse_isfree;
}
if(isset($nccsSet[1])) {
    $secondCsUrl =  base_url('ncoursewares/view').'/'.$nccsSet[1]->childcourse_id;
    $secondCsImg = $nccsSet[1]->childcourse_photo;
    $secondCsFree = $nccsSet[1]->childcourse_isfree;
}
if(isset($nccsSet[2])) {
    $thirdCsUrl =  base_url('ncoursewares/view').'/'.$nccsSet[2]->childcourse_id;
    $thirdCsImg = $nccsSet[2]->childcourse_photo;
    $thirdCsFree = $nccsSet[2]->childcourse_isfree;
}
?>
<a href="<?= $firstCsUrl;?>"
   class="btn nchildcourse_list" id="sh_firstcs_btn" free_course="<?= $firstCsFree;?>"
   style="background:url(<?= base_url().$firstCsImg;?>) no-repeat;background-size: 100% 100%">
</a>
<a href="<?= $secondCsUrl;?>"
   class="btn nchildcourse_list" id="sh_secondcs_btn" free_course="<?= $secondCsFree;?>"
   style="background:url(<?= base_url().$secondCsImg;?>) no-repeat;background-size: 100% 100%">
</a>
<a href="<?= $thirdCsUrl;?>"
   class="btn nchildcourse_list" id="sh_thirdcs_btn" free_course="<?= $thirdCsFree;?>"
   style="background:url(<?= base_url().$thirdCsImg;?>) no-repeat;background-size: 100% 100%">
</a>
<!-----------Msg content Modal------------>
<style type="text/css">
    .modal-backdrop
    {
        position:absolute;
        top:0;left:0;width:100%; height:100%;
        background:#000; opacity: .0;
        filter:alpha(opacity=0);
        z-index:50;
        display:none;
    }
    .custom-modal
    {
        position:absolute;
        top:41.5%;
        left:23.3%;
        width:53.6%;
        height:14.07%;
        background:#ffffff;
        z-index:51;
        display:none;
        border-radius:10%;
    }
    .msg_modal_content
    {
        background: url(<?= $imageAbsDir.'base/warning_msg.png'?>);
        background-size: 100% 100%;
        width:100%;
        height:100%;
    }
</style>
<div class="modal-backdrop"></div>
<div class="custom-modal" id="warningmsg_content_modal">
    <div  class="msg_modal_content"></div>
</div>
<!-----------Msg content Modal------------>
<script>
    function close_modal()
    {
        $('.modal-backdrop, .custom-modal').animate({'opacity':'0'}, 3500, 'linear', function(){
            $('.modal-backdrop, .custom-modal').css('display', 'none');
        });
    }
    function showMsgModal()
    {
        $('.modal-backdrop, .custom-modal').animate({'opacity':'.8'}, 500, 'linear');
        $('#warningmsg_content_modal').animate({'opacity':'1.00'}, 500, 'linear');
        $('.modal-backdrop, .custom-modal').css('display', 'block');
        close_modal();
    }

</script>
<!-------------------Warning Message Area------------>
<script>
    ///below function is to check of uer permission to courseware;
    var userRole =  '<?= $userRole;?>';
    var imageDir = '<?= $imageAbsDir;?>';
    $('.nchildcourse_list').click(function(){
      var free_course = $(this).attr('free_course');
      if(free_course==='1' || userRole==='1') {
          return 0;
      }
      else{
          showMsgModal();
          $(this).attr('href','#');
      }
    });
    $('#sh_firstcs_btn').mouseover(function(){

        $(this).css('left','4%');
        $(this).css('top','16%');
        $(this).css('width','29%');
        $(this).css('height','55.6%');
    });
    $('#sh_firstcs_btn').mouseout(function(){
        $(this).css('left','4.58%');
        $(this).css('top','17.87%');
        $(this).css('width','27.3%');
        $(this).css('height','53.6%');
    });
    $('#sh_secondcs_btn').mouseover(function(){
        $(this).css('left','35%');
        $(this).css('top','33%');
        $(this).css('width','29%');
        $(this).css('height','55.6%');
    });
    $('#sh_secondcs_btn').mouseout(function(){
        $(this).css('left','36.3%');
        $(this).css('top','34%');
        $(this).css('width','27.3%');
        $(this).css('height','53.6%');
    });
    $('#sh_thirdcs_btn').mouseover(function(){
        $(this).css('right','4%');
        $(this).css('top','16');
        $(this).css('width','29%');
        $(this).css('height','55.6%');
    });
    $('#sh_thirdcs_btn').mouseout(function(){
        $(this).css('right','4.58%');
        $(this).css('top','17.87%');
        $(this).css('width','27.3%');
        $(this).css('height','53.6%');
    });
</script>
<script src="<?= base_url('assets/js/sandapian/menu_manage.js')?>"></script>
