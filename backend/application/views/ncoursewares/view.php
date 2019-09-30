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
$dataUrl = '';
$loged_In_user_id = $this->session->userdata("loginuserID");
$imageAbsDir =  base_url().'assets/images/taiyang/';
$user_type = $this->session->userdata("user_type");

$usrLoginStatus = '0';

if($this->session->userdata("loggedin") != FALSE)
{
    $usrLoginStatus = '1';
}

?>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/sandapian/menu_manage.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/sandapian/ncw_manage.css') ?>">
<style type="text/css">
    .modal-backdrop { position:absolute;top:0;left:0;width:100%; height:100%; background:#000; opacity: .0;filter:alpha(opacity=0);z-index:50;display:none;}
    .custom-modal  {  position:absolute; top:41.5%; left:23.3%;  width:53.6%;height:14.07%;  background:#fff;z-index:51; display:none;border-radius:10%;}
    .msg_modal_content  {background: url(<?= $imageAbsDir.'base/warning_msg.png'?>); background-size: 100% 100%; width:100%; height:100%; }
    .navbar-collapse.collapse {
        display: block!important;
        height: auto!important;
        padding-bottom: 0 !important;
        overflow: visible!important;
    }
    .navbar-collapse {
        width: auto !important;
        border-top: 0!important;
        -webkit-box-shadow: none!important;
        box-shadow: none!important;
    }
    .side_pad_btn_wrapper { position: absolute;top:0;left:0;width:100%;height:100%; display: none}
    .side_lang_btn {position: absolute; right: 1.8%; width: 9%; height: 8%; }
    .sid_pad_bg {position:absolute;right:0;top:28%;width:13%;height:40%}
    #leftarrow_btn {position:absolute;right:12.4%;width:3%;height:7%}
    #rightarrow_btn {position:absolute;right:28.8%;width:1.85%;height:4.9%;}
</style>
<div class="bg">
    <img src="<?= $imageAbsDir.'base/bg.png';?>" class="background_image">
</div>

<div class="iframe_border1">
    <img src="<?= $imageAbsDir.'nunits/border_1.png';?>" style="width:100%;height:100%">
</div>
<div class="iframe_border2">
    <img src="<?= $imageAbsDir.'nunits/border_2.png';?>" style="width:100%;height:100%">
</div>
<a href="<?= base_url('nchildcourse/index');?>"
   class="btn" id="sh_backhome_btn"
   style="background:url(<?= $imageAbsDir.'base/backhome.png';?>) no-repeat;background-size: 100% 100%;z-index: 60;">
</a>

<a href="#"
   class="btn" id="sh_text_btn"
   style="background:url(<?= $imageAbsDir.'nunits/text_r.png';?>) no-repeat;background-size: 100% 100%">
</a>
<a href="#"
   class="btn" id="sh_title_btn"
   style="background:url(<?= $imageAbsDir.'nunits/'.$nccsName.'.png';?>) no-repeat;background-size: 100% 100%;">
</a>

<?php if($this->session->userdata("loggedin") != FALSE){?>
    <a href="<?= base_url().'users/profile/'.$loged_In_user_id;?>"
       class="btn" id="sh_profile_btn"
       style="background:url(<?= $imageAbsDir.'base/profile.png';?>) no-repeat;background-size: 100% 100%;z-index: 60;">
    </a>
    <a href="<?= base_url('signin/signout')?>"
       class="btn" id="sh_exit_btn"
       style="background:url(<?= $imageAbsDir.'base/exit.png';?>) no-repeat;background-size: 100% 100%;z-index: 60;">
    </a>
<?php }else{?>
    <a href="<?= base_url('signin/index')?>"
       class="btn" id="sh_login_btn"
       style="background:url(<?= $imageAbsDir.'base/login.png';?>) no-repeat;background-size: 100% 100%;z-index: 60;">
    </a>
<?php } ?>
<div class="nunit_wrapper">
<div id="sidenav1">
    <div class="collapse navbar-collapse" id="sideNavbar">
        <div class="panel-group" id="accordion">
            <?php foreach ($nunitSet as $nunit):?>
            <div class="panel panel-default" style="background-color: rgba(255,255,255,0);border-color:rgba(255,255,255,0);">
                <div class="panel-heading" style="padding:0 0">
                    <h4 class="panel-title">
                       <a data-toggle="collapse" data-parent="#accordion"
                          href="#<?= 'nunit_'.$nunit->nunit_id;?>"
                          style ="background: url(<?= base_url().$nunit->nunit_photo;?>) no-repeat;
                                  background-size: 100% 100%;
                                  height:68px;">
                       </a>
                    </h4>
                </div>
                <div id="<?= 'nunit_'.$nunit->nunit_id;?>" class="panel-collapse collapse">
                    <ul class="list-group" style="border-top-style:none;">
                        <?php  $ncwCnt = 0;foreach($ncwsSet as $ncws):
                            if($ncws->nunit_id==$nunit->nunit_id){
                            $topVal = $ncwCnt*15+10; $topValStr = $topVal.'%';
                            $dataUrl = base_url().$ncws->ncw_file;
                            ?>
                                <li>
                                    <a href="#" class="new_courseware_item" onclick="changeVideo(this)"
                                       style="background:url(<?= base_url().$ncws->ncw_photo;?>) no-repeat;
                                              background-size: 100% 100%;height:150px;
                                              "
                                       data-url="<?= $dataUrl;?>"
                                       data-ncourseid ="<?= $ncws->ncw_id;?>"
                                       free_courseware="<?= $ncws->nfree;?>"
                                    ></a>
                                </li>
                            <?php $ncwCnt++;} ?>
                        <?php endforeach;?>
                    </ul>
                </div>
            </div>
            <?php endforeach;?>
            <!-- end hidden Menu items -->
        </div>
    </div>
</div>
</div>
<!------------------IFrame area---------------------->
<div class="iframe_border">
    <img src="<?= $imageAbsDir.'nunits/border.png';?>" style="width:100%;height:100%;">
</div>
<div class="script-content" >
    <iframe src="" id="new_courseware_iframe" style="border:none"></iframe>
    <div class="side_pad_btn_wrapper">
        <img src="<?= $imageAbsDir.'sidepad/cnPad_r.png'?>" class="sid_pad_bg">
        <a href="#"  class="btn side_lang_btn" lang="cnCH" id="cnCH_btn"
           style="background:url(<?= $imageAbsDir.'sidepad/cnCH.png';?>) no-repeat;background-size: 100% 100%;top: 30%;"></a>
        <a href="#"  class="btn side_lang_btn" lang="cnEN" id="cnEN_btn"
           style="background:url(<?= $imageAbsDir.'sidepad/cnEN.png';?>) no-repeat;background-size: 100% 100%;top: 39%;"></a>
        <a href="#"  class="btn side_lang_btn" lang="cnCHEN" id="cnCHEN_btn"
           style="background:url(<?= $imageAbsDir.'sidepad/cnCHEN_r.png';?>) no-repeat;background-size: 100% 100%;top: 48%;"></a>
        <a href="#"  class="btn side_lang_btn" lang="cnNONE" id="cnNONE_btn"
           style="background:url(<?= $imageAbsDir.'sidepad/cnNONE.png';?>) no-repeat;background-size: 100% 100%;top:57%;"></a>
        <a href="#"  class="btn" id="leftarrow_btn"
           style="background:url(<?= $imageAbsDir.'sidepad/cnOpen.png';?>) no-repeat;background-size: 100% 100%;top:44%;"></a>
    </div>
</div>

<a href="#"  class="btn" id="rightarrow_btn"
   style="background:url(<?= $imageAbsDir.'sidepad/cnOpen.png';?>) no-repeat;background-size: 100% 100%;top:51.6%;"></a>

<div class="script-content-text" style="display:none;z-index: 50;overflow: hidden">
    <iframe src="" id="new_courseware_iframe_text" style="
    border:none"></iframe>

</div>
<?php if($this->session->userdata("loggedin") != FALSE){?>
    <?php if($user_type=='2'){?>
    <a href="<?= base_url('nwork/view').'/'.$loged_In_user_id?>"
       class="btn" id="workview_btn"
       style="background:url(<?= $imageAbsDir.'workview/workview.png';?>) no-repeat;background-size: 100% 100%;">
    </a>
    <?php }?>
    <?php if($user_type=='1'){?>
        <a href="<?= base_url('nwork/teacher').'/'.$loged_In_user_id?>"
           class="btn" id="workview_btn"
           style="background:url(<?= $imageAbsDir.'workview/workview.png';?>) no-repeat;background-size: 100% 100%;">
        </a>
    <?php }?>
<?php } ?>
<!------------------IFrame area---------------------->
<!-------------------Warning Message Area------------>
<!-----------Msg content Modal------------>
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
    var iframeStatus = 'video';
    var curLang = 'cnCHEN';

    $('.panel-collapse:first').addClass('in');
    var curDataUrl = '';
    /*********Ifraem communication variable**************/
    var ncourseware_id = '';
    var  login_status = '<?=  $usrLoginStatus;?>';
    var login_username = '<?php if(isset($loged_In_user_id)) echo $loged_In_user_id ;else echo '';?>';
    /*********Ifraem communication variable**************/

    if(userRole=='1')
    {
        curDataUrl = $('.new_courseware_item:first').attr('data-url');
        $('#new_courseware_iframe').attr('src',curDataUrl+'/video/package/index.html');
        ncourseware_id = $('.new_courseware_item:first').attr('data-ncourseid');

    }else{
        curDataUrl = $("a[free_courseware|='1']" ).first().attr('data-url');
        ncourseware_id = $("a[free_courseware|='1']" ).first().attr('data-ncourseid');
         if(curDataUrl){
            $('#new_courseware_iframe').attr('src',curDataUrl+'/video/package/index.html');
        }else{
            alert('There is no content to show you!')
        }
    }
    function changeVideo(self){
        curDataUrl = self.getAttribute('data-url');
        ncourseware_id = self.getAttribute('data-ncourseid');
        var free_cws = self.getAttribute('free_courseware');
        if(free_cws=='1' || userRole=='1') {
            $('#'+curLang+'_btn').css({"background":"url("+imageDir+"sidepad/"+curLang+".png) no-repeat",'background-size' :'100% 100%'});
            curLang = 'cnCHEN';
            $('#'+curLang+'_btn').css({"background":"url("+imageDir+"sidepad/"+curLang+"_r.png) no-repeat",'background-size' :'100% 100%'});
            $('#new_courseware_iframe').attr('src',curDataUrl+'/video/package/index.html');
        }
        else{
            showMsgModal();
        }
    }
    $('#sh_text_btn').click(function(){
        iframeStatus ='text';

        $('.script-content').hide();
        $('.script-content-text').show();
        $('#new_courseware_iframe_text').attr('src',curDataUrl+'/text/index.html');
    });
    $('#sh_backhome_btn').click(function(){

        if(iframeStatus=='video')
        {
            $(this).attr('href',baseURL+'nchildcourse/index');
        }else{
            $(this).attr('href','#');
            location.reload();
        }
    });
    $('#workview_btn').mouseover(function(){
        $(this).css({"background":"url("+imageDir+"workview/workview_sel.png) no-repeat",'background-size' :'100% 100%'});
    });
    $('#workview_btn').mouseout(function(){
        $(this).css({"background":"url("+imageDir+"workview/workview.png) no-repeat",'background-size' :'100% 100%'});
    });
    function fitWindow()
    {
        var ncwHeight = 0.13*window.innerHeight;
        var nunitTitle = 0.0635*window.innerHeight;
        $('.new_courseware_item').css('height',ncwHeight+'px');
        $('.panel-title a').css('height',nunitTitle+'px');
    }
    $(window).resize(function(){
        fitWindow();
    });
    fitWindow();
</script>
<script src="<?= base_url('assets/js/sandapian/menu_manage.js')?>"></script>
<script src="<?= base_url('assets/js/ncourseware.js')?>"></script>
