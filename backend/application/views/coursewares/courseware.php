<?php $listCount = sizeof($cwSets);
$userRole = '0';
if($this->session->userdata("loggedin") != FALSE)
{
    $course_permission = $this->session->userdata('course_permission');
    if($course_permission!==NULL)
    {
        $userRole =  $course_permission->kebenju;
    }
}
$loged_In_user_id = $this->session->userdata("loginuserID");
$imageAbsDir =  base_url().'assets/images/frontend/';
$user_type = $this->session->userdata("user_type");
$myworkURL = 'work/student';
$hd_menu_img_path = '';
if($user_type=='2'){
    $myworkURL = 'work/script/'.$loged_In_user_id;
    $hd_menu_img_path = $imageAbsDir.'coursewares/';
}else{
    $hd_menu_img_path = $imageAbsDir.'coursewares/stu_';
}
?>
<style>
    body, html {
        height: 100%;
        margin: 0;
    }
    .background_image {
        position: fixed;
        top: 0;left: 0;
        width:100%;height:100%;
        background-size: contain;
        z-index: -1;
    }
    .switch{ position: absolute; left: 38.8%; top: 0.9%; width: 21.61%; height: 7.87%; }
    .switch img{ width: 100%; height: 100% }
    .switch a{ display: block; position: absolute; cursor: pointer}

    .hdmenu{ position: absolute; left: 69.32%; top: 1%; width: 18%; height: 8.8%; }
    .hdmenu img{ width: 100%; height: 100% }
    .hdmenu a{ display: block; position: absolute; cursor: pointer}

    .exit-btn{ position: absolute; left: 87.9%; top: 2.78%; width: 5.31%; height: 4.81%; }
    .exit-btn img{ width: 100%; height: 100% }

    .back-btn{ position: absolute; left: 93.84%; top: 1.37%; width: 4.31%; height: 7.8%; }
    .back-btn img{ width: 100%; height: 100% }

    .coursewarelist-wrapper{ position: absolute; left: 11.72%; top: 15%; width: 77.34%; height: 72.22%; }
    .coursewarelist-wrapper .courseware-list{ width: 30.5%; height: 48.97%; display: inline-block; float: left; margin-right: 2.6%; margin-bottom: 1.15%; position: relative}
    .coursewarelist-wrapper .courseware-list img{ position: absolute; width: 100%; height: 100%; left: 0; top: 0; }
    .coursewarelist-wrapper .courseware-list img.courseware-image-item{ width: 100%; height: 100%; left: 0%; top: 0%; }
    /*.coursewarelist-wrapper .courseware-list img.courseware-image-item{ width: 94.5%; height: 89.52%; left: 2.6%; top: 3.66%; }*/

    .coursewarelist-prevpage{ position: absolute; left: 2.4%; top: 46.48%; width: 5.15%; height: 9.7%; }
    .coursewarelist-prevpage img{ width: 100%; height: 100% }
    .coursewarelist-nextpage{ position: absolute; left: 92.34%; top: 46.48%; width: 5.15%; height: 9.7%; }
    .coursewarelist-nextpage img{ width: 100%; height: 100% }

</style>
<div class="bg">
    <img src="<?= $imageAbsDir.'coursewares/bg.jpg';?>" class="background_image">
</div>

<div class="switch">
    <div style="position: relative; height: 100%; display: none">
        <img src="<?= $imageAbsDir.'coursewares/country_cn.png';?>" id="select_country_img" data-baseurl="<?= base_url('assets/images/frontend/coursewares')?>" data-country="cn">
        <a onclick="selectOnChina()" style="top: 0%; left: 0%; width: 50%; height: 100%;"></a>
        <a onclick="selectWestern()" style="top: 0%; left: 50%; width: 50%; height: 100%;"></a>
    </div>
</div>

<div class="hdmenu">
    <?php if($this->session->userdata("loggedin") != FALSE){?>
        <div style="position: relative; height: 100%">
            <img class = "hdmenu_img" src="<?= $hd_menu_img_path.'hdmenu_normal.png';?>">
            <a id = "hdmenu_studentwork" href="<?= base_url($myworkURL);?>" style="top: 27.2%; left: 1.1%; width: 31.9%; height: 48.5%;"></a>
            <a id = "hdmenu_profile" href="<?= base_url().'users/profile/'.$loged_In_user_id;?>" style="top: 3.9%; left: 37.1%; width: 26.1%; height: 90.4%;"></a>
            <a id = "hdmenu_community" href="<?= base_url().'community/index';?>" style="top: 27.2%; left: 67%; width: 31.9%; height: 48.5%;"></a>
        </div>
    <?php } ?>
</div>

<div class="exit-btn">
    <?php if($this->session->userdata("loggedin") == FALSE): ?>
        <a onmouseover="hover_register()" onmouseout="out_register()" href="<?= base_url('signin/index')?>">
            <img id = "register_image" src="<?= $imageAbsDir.'coursewares/register.png'?>"">
        </a>
    <?php else: ?>
        <a onmouseover="hover_exit()" onmouseout="out_exit()" href="<?= base_url('signin/signout')?>">
            <img id = "exit_image" src="<?= $imageAbsDir.'coursewares/exit.png';?>"">
        </a>
    <?php endif; ?>
</div>

<div class="back-btn">
    <a onmouseover="hover_back()" onmouseout="out_back()" href="#"  onclick="history.go(-1)">
        <img id="back_btn_image" src="<?= $imageAbsDir.'community/script/back.png';?>">
    </a>
</div>

<div class="coursewarelist-wrapper">
    <?php foreach($cwSets as $cw): ?>
        <?php $imageUrl = $cw->courseware_photo; ?>
        <a href = "<?=base_url()?>coursewares/view/<?= $cw->courseware_id?>"
           class="courseware-list"
           unit_type_id="<?= $cw->unit_type_id?>"
           free_course = "<?= $cw->free;?>"
           style="display:none">
            <img src="<?=base_url().$imageUrl?>" class = "courseware-image-item">
            <img src="<?= $imageAbsDir.'coursewares/frame.png'?>">
        </a>
    <?php endforeach; ?>
</div>
<div class="coursewarelist-prevpage">
        <a onclick="prevPageElems();" onmouseover="hover_prev()" onmouseout="out_prev()">
            <img id = "prev_image" src="<?= $imageAbsDir.'coursewares/prev.png'?>">
        </a>
</div>
<div class="coursewarelist-nextpage">
        <a onclick="nextPageElems();" onmouseover="hover_next()" onmouseout="out_next()">
            <img id = "next_image" src="<?=$imageAbsDir.'coursewares/next.png';?>"">
        </a>
</div>
<style type="text/css">
    .modal-backdrop { position:absolute;top:0;left:0;width:100%; height:100%;background:#000; opacity: .0;filter:alpha(opacity=0);z-index:50;display:none;}
    .custom-modal { position:absolute;top:41.5%; left:23.3%;width:53.6%;height:14.07%;background:#ffffff; z-index:51;display:none;border-radius:10%;}
    .msg_modal_content { background: url(<?= base_url('assets/images/taiyang/base/warning_msg.png')?>); background-size: 100% 100%; width:100%;height:100%;}
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
<!-------------------Border manage function --------------------------->
<script>
    var imgArr = new Array();
    var curPage = 0;
    var elemsPerPage = 6;
    var totalElems = 0;
    var totalPages = 0;
    var imageDir = baseURL + "assets/images/frontend";
    var hdmenuImgPath = '<?= $hd_menu_img_path;?>';
    var userType = '<?php echo $user_type?>';
    
    $('.courseware-list:first').attr('isFreeAccount','1');
    
    window.addEventListener('load', function(){
        var imageList = document.getElementsByClassName('courseware-list');
        initPage();
    });
    function selectOnChina(){
        var baseUrl =  $('#select_country_img').data('baseurl');
        $('#select_country_img').attr('src', baseUrl+'/country_cn.png');
        $('#select_country_img').data('country', 'cn');

        initPage();
    }
    function selectWestern() {
        var baseUrl =  $('#select_country_img').data('baseurl');
        $('#select_country_img').attr('src', baseUrl+'/country_eu.png');
        $('#select_country_img').data('country', 'eu');
        initPage();
    }
    function initPage(){
        var country = $('#select_country_img').data('country');
        var imageList = document.getElementsByClassName('courseware-list');
        imgArr = new Array();
        curPage = 0;

        country = ( country == 'cn' )? '1' : '2';

        for(i = 0;i<imageList.length;i++)
        {
            var imgTag = imageList[i];
            if(imgTag.getAttribute('unit_type_id')==country){
                imgArr.push( imgTag );
            }
        }

        totalElems = imgArr.length;
        totalPages = Math.ceil( imgArr.length/elemsPerPage );
        showPage( curPage );
    }
    function showPage( page ){
        $('.courseware-list').hide();
        for( var i=0; i<totalElems; i++ ){
            if( i>=page*elemsPerPage && i<(page+1)*elemsPerPage ){
                var img = imgArr[i];
                $(img).show();
            }
        }
    }
    function nextPageElems(){
        curPage++;
        if( curPage >= totalPages-1  )
            curPage = totalPages-1;
        showPage(curPage);
    }
    function prevPageElems(){
        curPage--;
        if( curPage <= 0 )
            curPage = 0;
        showPage(curPage);
    }
    function hover_exit() { $('#exit_image').attr('src',imageDir+'/studentwork/exit_hover.png'); }
    function out_exit() { $('#exit_image').attr('src',imageDir+'/studentwork/exit.png');}

    function hover_register() { $('#register_image').attr('src',imageDir+'/studentwork/register_sel.png'); }
    function out_register() { $('#register_image').attr('src',imageDir+'/studentwork/register.png');}

    function hover_prev() { $('#prev_image').attr('src',imageDir+'/coursewares/prev_sel.png'); }
    function out_prev() { $('#prev_image').attr('src',imageDir+'/coursewares/prev.png');}

    function hover_next() { $('#next_image').attr('src',imageDir+'/coursewares/next_sel.png'); }
    function out_next() { $('#next_image').attr('src',imageDir+'/coursewares/next.png');}

    function hover_back() { $('#back_btn_image').attr('src',imageDir+'/studentwork/back_hover.png'); }
    function out_back() { $('#back_btn_image').attr('src',imageDir+'/studentwork/back.png');}

</script>
<script src="<?= base_url('assets/js/frontend/menu_manage.js') ?>" type="text/javascript"></script>
<script>
    var userRole =  '<?= $userRole;?>';
    $('.courseware-list').click(function(){
      var free_course = $(this).attr('free_course');
      var free_account = $(this).attr('isFreeAccount');

        if(userType=='')
        {
            if (typeof free_account !== typeof undefined && free_account !== false);
            else{
                alert('需要登录才能查看哦！');
                $(this).attr('href','#');
            }
        }
      if(free_course==='1' || userRole==='1') {
          return 0;
      }
      else{
          showMsgModal();
          $(this).attr('href','#');
      }
    });
</script>
