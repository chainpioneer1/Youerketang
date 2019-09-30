<?php
$loggedIn_UserID = $this->session->userdata("loginuserID");
$user_type = $this->session->userdata("user_type");
$ownerSt = TRUE;
$imageAbsDir =  base_url().'assets/images/frontend/';
$bac_img_path = $imageAbsDir.'mywork/empty_bg.jpg';
if($loggedIn_UserID != $user_id)//if current user is not owner of work.
{
    $ownerSt = FALSE;
    $bac_img_path = $imageAbsDir.'mywork/empty_bg1.jpg';
}
$myworkURL = 'work/student';
$returnURL = 'coursewares/index';
$hd_menu_img_path = '';
if($user_type=='2'){
    $myworkURL = 'work/script/'.$loggedIn_UserID;
    $returnURL = 'coursewares/index';
    $hd_menu_img_path = $imageAbsDir.'mywork/';
}else{
    $hd_menu_img_path = $imageAbsDir.'mywork/stu_';
}
?>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/frontend/work_list_view.css')?>"  />
<style>
    .list_title  { position:absolute; left:12.9%;width:58.5%;height: 100%; font-size: 20px; background: url(<?= $imageAbsDir.'mywork/item_bg.png';?>); background-size: 100% 100%; padding-top: 12px; padding-left: 5%;text-decoration: none !important;}
    .list_title2 { position:absolute; left:6.67%;width:58.5%;height: 100%; font-size: 20px; background: url(<?= $imageAbsDir.'mywork/item_bg.png';?>); background-size: 100% 100%; padding-top: 12px; padding-left: 5%;text-decoration: none !important;}
    .list_upload { position:absolute; left:76.5%;width:11%;height: 100%; background-size: 100% 100%;}
    .list_delete { position:absolute; right:6%; width:4.43%; height: 100%; background: url(<?= $imageAbsDir.'mywork/delete.png';?>); background-size: 100% 100%; }
    .list_delete_tech { position:absolute; right:21%; width:4.43%; height: 100%; background: url(<?= $imageAbsDir.'mywork/delete.png';?>); background-size: 100% 100%; }
    .list_delete2 {position:absolute;right:18%;width:4.43%;height: 100%;background: url(<?= $imageAbsDir.'mywork/delete.png';?>);background-size: 100% 100%;}
    .list_share  {position:absolute;right:0;width:4.43%;height: 100%;background: url(<?= $imageAbsDir.'mywork/share.png';?>);background-size: 100% 100%;}
    .list_share_tech  {position:absolute;right:15%;width:4.43%;height: 100%;background: url(<?= $imageAbsDir.'mywork/share.png';?>);background-size: 100% 100%;}
</style>
<div class="bg">
    <img src="<?=$bac_img_path ?>" class="background_image">
</div>
<div class="course_type_menu">
    <div style="position: relative; height: 100%">
        <img id="course_menu_img" src="<?= $menu_img_path;?>" usemap="#course_type_menu_map">
        <a href="<?=base_url('work/script').'/'.$user_id;?>"   style="top: 8.51%; left: 1.219%; width: 21.18%; height: 81%;"></a>
        <a href="<?=base_url('work/dubbing').'/'.$user_id;?>"  style="top: 8.51%; left: 26.829%; width: 21.18%; height: 81%;"></a>
        <a href="<?=base_url('work/head').'/'.$user_id;?>"   style="top: 8.51%; left: 52.29%; width: 21.18%; height: 81%;"></a>
        <a href="<?=base_url('work/shooting').'/'.$user_id;?>"  style="top: 8.51%; left: 77.82%; width: 21%; height: 81%;"></a>
    </div>
</div>
<!-------------Head Menu------------------------------------------------------->
<div class="hdmenu">
    <div style="position: relative; height: 100%">
        <img class = "hdmenu_img" src="<?= $hd_menu_img_path.'hdmenu_normal.png';?>" usemap="#hdmenu_map">
        <a id = "hdmenu_studentwork" href="<?= base_url($myworkURL);?>" style="top: 27.2%; left: 1.1%; width: 31.9%; height: 48.5%;"></a>
        <a id = "hdmenu_profile" href="<?= base_url().'users/profile/'.$loggedIn_UserID;?>" style="top: 3.9%; left: 37.1%; width: 26.1%; height: 90.4%;"></a>
        <a id = "hdmenu_community" href="<?= base_url().'community/index';?>" style="top: 27.2%; left: 67%; width: 31.9%; height: 48.5%;"></a>
    </div>
</div>
<div class="exit-btn">
    <?php if($this->session->userdata("loggedin") == FALSE): ?>
        <a href="<?= base_url('signin/index')?>"><img  class= "exit_btn_img" src="<?= $imageAbsDir.'coursewares/exit.png';?>""></a>
    <?php else: ?>
        <a href="<?= base_url('signin/signout')?>"><img class= "exit_btn_img" src="<?= $imageAbsDir.'coursewares/exit.png';?>""></a>
    <?php endif; ?>
</div>
<a  onclick="history.go(-1)"
    class="return_btn"
    style="background:url(<?= base_url('assets/images/frontend/studentwork/back.png')?>) no-repeat;background-size: 100% 100%;">
</a>

<a  href="<?= base_url('home/index')?>"
    class="home_btn"
    style="background:url(<?= base_url('assets/images/frontend/home/home_btn.png')?>) no-repeat;background-size: 100% 100%;">
</a>

<a  href="#"
    class="previous_Btn"
    style="background:url(<?= base_url('assets/images/frontend/community/prev.png')?>) no-repeat;background-size: 100% 100%;">
</a>

<a  href="#"
    class="next_Btn"
    style="background:url(<?= base_url('assets/images/frontend/community/next.png')?>) no-repeat;background-size: 100% 100%;">
</a>

<div class="content_list_wrapper" ></div>

<!-----------delete modal------------------>
<div class="modal fade" id="delete_contentItem_modal">
    <div class="modal-dialog modal-sm" role="document" style="margin-top: 300px">
        <form action="" method="post" id="content_delete_form">
            <div class="modal-content">
                <div class="modal-header" style="padding-right:20px;padding-top: 3px;padding-bottom: 10px;text-align: center">
                    <h5 class="modal-title" style="margin-top: 5px;font-weight: bold"><?php if($user_type=='1') echo $this->lang->line('DeleteConfirmMsg_Teacher'); else echo $this->lang->line('DeleteConfirmMsg');?></h5>
                </div>
                <?php if($loggedIn_UserID==$user_id){///current logged in user is student?>
                    <div class="modal-body" style="text-align: center">
                        <label class="checkbox-inline"><input type="checkbox" value="" id="localfile_chk"><?php echo $this->lang->line('LocalFile');?></label>
                        <label class="checkbox-inline" style="margin-left: 30px;"><input type="checkbox" value="" id="cloudfile_chk"><?php echo $this->lang->line('CloudFile');?></label>
                    </div>
                <?php } ?>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6" style="text-align: center">
                            <button type="submit" class="btn btn-primary" id="content_delete_btn"><?php echo $this->lang->line('Yes');?></button>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6" style="text-align: center">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('No');?></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-----------Share content Modal------------>
<style type="text/css">
    .modal-backdrop { position:absolute;top:0;left:0;width:100%; height:100%;background:#000; opacity: .0;filter:alpha(opacity=0); z-index:50; display:none; }
    .custom-modal   { position:absolute;top:30%;left:35%; width:30.5%;height:31.2%; background:#ffffff;z-index:51;display:none; border-radius:10%;}
    .share_modal_content  {background: url(<?= $imageAbsDir.'mywork/share_confirmbg1.png'?>);background-size: 100% 100%;width:100%; height:100%;}
    #content_share_btn   { position: absolute;background: url(<?= $imageAbsDir.'mywork/yes.png'?>) no-repeat;background-size: 100% 100%;width:20%;height:20%; left:14%; top:68%;}
    .share_close_btn   {  position: absolute;background: url(<?= $imageAbsDir.'mywork/no.png'?>) no-repeat;  background-size: 100% 100%;width:20%; height:20%;left:67%; top:68%;}
</style>
<div class="modal-backdrop"></div>
<div class="custom-modal" id="share_content_modal">
    <div  class="share_modal_content">
      <a href="#" id="content_share_btn"></a>
      <a href="#" class="share_close_btn"></a>
    </div>
</div>
<!-----------share content Modal------------>
<script>
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
<script>
    var prev_btn = $('.previous_Btn');
    var next_btn = $('.next_Btn');
    var localStr = '<?= $this->lang->line('Local');?>';
    var cloudStr = '<?= $this->lang->line('Cloud');?>';

    prev_btn.mouseover(function(){
        $(this).css({"background":"url("+imageDir+"mywork/prev_hover.png) no-repeat",'background-size' :'100% 100%'});
    });
    prev_btn.mouseout(function(){
        $(this).css({"background":"url("+imageDir+"mywork/prev.png) no-repeat",'background-size' :'100% 100%'});
    });
    next_btn.mouseover(function(){
        $(this).css({"background":"url("+imageDir+"mywork/next_hover.png) no-repeat",'background-size' :'100% 100%'});
    });
    next_btn.mouseout(function(){
        $(this).css({"background":"url("+imageDir+"mywork/next.png) no-repeat",'background-size' :'100% 100%'});
    });

    function hiddenImageMark(self) {
        self.style.background= "url(<?= $imageAbsDir.'mywork/localmark_hover.png'?>) 0% 0% / 100% 100%";
    }
    function showImageMark(self) {
        self.style.background= "url(<?= $imageAbsDir.'mywork/localmark.png'?>) 0% 0% / 100% 100%";
    }
    function hiddenImageMarkCloud(self){self.style.background= "url(<?= $imageAbsDir.'mywork/cloudmark_hover.png'?>) 0% 0% / 100% 100%";}
    function showImageMarkCloud(self){self.style.background= "url(<?= $imageAbsDir.'mywork/cloudmark.png'?>) 0% 0% / 100% 100%";}
    function changeUploadOver(self){self.style.background= "url(<?= $imageAbsDir.'mywork/upload_hover.png'?>) 0% 0% / 100% 100%";}
    function changeUploadOut(self){self.style.background= "url(<?= $imageAbsDir.'mywork/upload.png'?>) 0% 0% / 100% 100%";}
    function changeDeleteImgOver(self){self.style.background= "url(<?= $imageAbsDir.'mywork/delete_hover.png'?>) 0% 0% / 100% 100%";}
    function changeDeleteImgOut(self){ self.style.background= "url(<?= $imageAbsDir.'mywork/delete.png'?>) 0% 0% / 100% 100%";}
    function changeShareImgOver(self){self.style.background= "url(<?= $imageAbsDir.'mywork/share_hover.png'?>) 0% 0% / 100% 100%";}
    function changeShareImgOut(self){ self.style.background= "url(<?= $imageAbsDir.'mywork/share.png'?>) 0% 0% / 100% 100%";}
</script>
<script>
    ///at first mouseover effects

    var content_type_id = '<?php echo $content_type_id;?>';
    var loggedUserId = '<?php echo $loggedIn_UserID;?>';
    var contentUserId = '<?php echo $user_id;?>';
    var logedInUsertype ='<?php if($loggedIn_UserID!=$user_id) echo '1' ;else echo '2' ?>' ;
    var userType = '<?= $user_type; ?>';//This value can be student or teacher(1=>teacher, 2=>student)

    var studentId = '<?php echo $user_id;?>';
    var contentListStr = '<?php echo json_encode($contents);?>';
    var contentList = JSON.parse(contentListStr);
    var imageDir = base_url+'assets/images/frontend/';
    var hdmenuImgPath = '<?= $hd_menu_img_path;?>';


    function contentPager(conentList,listWrapper){
        this.curPageNo = 0;
        this.PageCount = 0;
        this.conList = conentList;
        this.listWrapper = listWrapper;
        this.init= function() {
            var output_html = '';
            var modeVar = 0;
            var availableCount = -1;
            for(var i = 0;i<this.conList.length;i++)
            {
                var tempObj = this.conList[i];

                if(logedInUsertype=='1')
                {
                    if(tempObj['public']=='1') availableCount++;
                }else{
                    availableCount++;
                }
                modeVar = availableCount%8;
                var pageNo = (availableCount-modeVar)/8;
                this.PageCount = pageNo;
                if(modeVar==0)
                {
                    if(pageNo!=0) output_html += '</div>';
                    output_html += '<div class = "list_page_'+pageNo+'" style="display: none">';
                    output_html += this.make_item(modeVar,tempObj);

                }else{
                    output_html += this.make_item(modeVar,tempObj);
                }

            }
            output_html += '</div>';
            $('.'+this.listWrapper).html(output_html);
        };
        this.make_item = function (orderNo,contentInfo){
            var interHieght =3.5;
            var itemHeight = 9;
            var topVal = orderNo*itemHeight+interHieght*(orderNo+1);
            var topValStr = topVal+'%';
            var output_html = '';
            if(logedInUsertype=='2'){

                if(userType=='1'){//if user is teacher and teacher see his information
                    output_html += '<div class="list_item_wrapper" style="top:'+topValStr+'">';
                    output_html += '<a class = "local_mark"';
                    if(contentInfo['local']=='1')
                    {
                        output_html += 'href="#" onmouseover="hiddenImageMark(this)" onmouseout="showImageMark(this)"';
                        output_html += 'style="background:url('+imageDir+'mywork/localmark.png);background-size: 100% 100%;left:4%;" >'+'<span class="local_tooltiptext">'+localStr+'</span></a>'
                    }else{
                        output_html += '></a>';
                    }
                    output_html += '<a class = "list_title" href="'+base_url+'work/view/'+contentInfo['content_id']+'">';
                    output_html += contentInfo['content_title']+'</a>';
                    output_html += '<a class = "list_delete" href="#" style="right:21%;" onmouseover="changeDeleteImgOver(this)" onmouseout="changeDeleteImgOut(this)"';
                    output_html += 'onclick="deleteContentItem(this)" content_id="'+contentInfo['content_id']+'" content_local='+contentInfo['local']+' content_cloud = '+contentInfo['public']+'></a>';
                    output_html += '<a class = "list_share" href="#" style="right:15%;" onmouseover="changeShareImgOver(this)" onmouseout="changeShareImgOut(this)" ';
                    output_html += 'onclick="shareContentModal(this)" content_id='+contentInfo['content_id']+'></a>';

                    output_html +='</div>';
                }else{
                    output_html += '<div class="list_item_wrapper" style="top:'+topValStr+'">';
                    output_html += '<a class = "local_mark" ';
                    if(contentInfo['local']=='1')
                    {
                        output_html += 'href="#" onmouseover="hiddenImageMark(this)" onmouseout="showImageMark(this)"';
                        output_html += 'style="background:url('+imageDir+'mywork/localmark.png);background-size: 100% 100%" >'+'<span class="local_tooltiptext">'+localStr+'</span></a>'
                    }else{
                        output_html += '></a>';
                    }
                    output_html += '<a class = "cloud_mark" ';
                    if(contentInfo['public']=='1')
                    {
                        output_html += 'href="#" onmouseover="hiddenImageMarkCloud(this)" onmouseout="showImageMarkCloud(this)"';
                        output_html += 'style="background:url('+imageDir+'mywork/cloudmark.png);background-size: 100% 100%;">'+'<span class="cloud_tooltiptext">'+cloudStr+'</span></a>'
                    }else{
                        output_html += '></a>';
                    }
                    output_html += '<a class = "list_title" href="'+base_url+'work/view/'+contentInfo['content_id']+'">';
                    output_html += contentInfo['content_title']+'</a>';

                    output_html += '<a class = "list_upload" ';
                    if(contentInfo['public']=='0')
                    {
                        output_html += 'href="#" content_id="'+contentInfo['content_id']+'" onmouseover="changeUploadOver(this)" onmouseout="changeUploadOut(this)" ';
                        output_html += 'onclick="uploadWork(this)" style="background:url('+imageDir+'mywork/upload.png);background-size: 100% 100%">'+'</a>'
                    }else{
                        output_html += '></a>';
                    }
                    output_html += '<a class = "list_delete" href="#" onmouseover="changeDeleteImgOver(this)" onmouseout="changeDeleteImgOut(this)"';
                    output_html += 'onclick="deleteContentItem(this)" content_id="'+contentInfo['content_id']+'" content_local='+contentInfo['local']+' content_cloud = '+contentInfo['public']+'></a>';
                    output_html += '<a class = "list_share" href="#" onmouseover="changeShareImgOver(this)" onmouseout="changeShareImgOut(this)" ';
                    output_html += 'onclick="shareContentModal(this)" content_id='+contentInfo['content_id']+'></a>';

                    output_html +='</div>';
                }
            }else{
                if(contentInfo['public']=='1')
                {
                    output_html += '<div class="list_item_wrapper" style="top:'+topValStr+'">';
                    output_html += '<a class = "cloud_mark2" ';
                    if(contentInfo['public']=='1')
                    {
                        output_html += 'href="#" onmouseover="hiddenImageMarkCloud(this)" onmouseout="showImageMarkCloud(this)"';
                        output_html += 'style="background:url('+imageDir+'mywork/cloudmark.png);background-size: 100% 100%">'+'<span class="cloud2_tooltiptext">'+cloudStr+'</span></a>'
                    }else{
                        output_html += '></a>';
                    }
                    output_html += '<a class = "list_title2" href="'+base_url+'work/view/'+contentInfo['content_id']+'">';
                    output_html += contentInfo['content_title']+'</a>';
                    output_html += '<a class = "list_delete2" href="#" onmouseover="changeDeleteImgOver(this)" onmouseout="changeDeleteImgOut(this)"';
                    output_html += 'onclick="deleteContentItem(this)" content_id="'+contentInfo['content_id']+'" content_local='+contentInfo['local']+' content_cloud = '+contentInfo['public']+'></a>';
                    output_html +='</div>';
                }
            }
            return output_html;
        };
        this.showPage = function() {
            var classStr = '.list_page_'+ this.curPageNo;
            $(classStr).show('slow');
        };
        this.hidePage = function() {
            var classStr = '.list_page_'+ this.curPageNo;
            $(classStr).hide();
        };
        this.nextPage = function() {
            if(this.curPageNo>this.PageCount-1) return;
            this.hidePage(this.curPageNo);
            this.curPageNo++;
            this.showPage(this.curPageNo);

        };
        this.prevPage = function() {
            if(this.curPageNo<1) return;
            this.hidePage(this.curPageNo);
            this.curPageNo--;
            this.showPage(this.curPageNo);
        }
    }
    function fitwindow() {
        var realFontSize = window.innerHeight*0.0185;
        var padTopVal = window.innerHeight*0.0111;
        $('.list_title').css('font-size',realFontSize+'px');
        $('.list_title').css('padding-top',padTopVal+'px');
    }
    var pager = new contentPager(contentList,'content_list_wrapper');
    pager.init();
    fitwindow();
    pager.showPage();
    $(window).resize(function(){
        fitwindow();
    });
    prev_btn.click(function(){
        pager.prevPage();
    });
    next_btn.click(function(){
        pager.nextPage();
    });
    function uploadWork(self) {
        var content_id = self.getAttribute('content_id');
        ///set status of cloud in content table as 1 and hide "UploadJob"
        jQuery.ajax({
            type: "post",
            url: baseURL+"work/uploadJob",
            dataType: "json",
            data: {student_id:studentId,content_type_id:content_type_id,content_id: content_id},
            success: function(res) {
                if(res.status=='success') {
                    pager.conList = res.data;
                    pager.init();
                    pager.showPage();
                    fitwindow();
                }
                else//failed
                {
                    alert("Cannot Upload work.");
                }
            }
        });
    }
    $('#content_share_btn').click(function(){

        var content_id = $(this).attr('content_id');
        shareContentItem(content_id);
    });
    jQuery('#content_delete_form').submit(function (e) {

        e.preventDefault();

        var contentDelBtn = $('#content_delete_btn');
        var contentId = contentDelBtn.attr('content_id');
        var contentLocal  = contentDelBtn.attr('content_local');
        var contentCloud = contentDelBtn.attr('content_cloud');

        var ajaxURL = '';
        var ajaxData = {student_id:studentId,content_type_id:content_type_id,content_id: contentId};
        ajaxData.content_local = contentLocal;
        ajaxData.content_cloud = contentCloud;

        if(userType=='1')
        {
            ajaxData.content_cloud = '0';
            ajaxData.content_local = '0';
            ajaxURL = baseURL+"work/delete_content";
        }else{
            if(logedInUsertype=='2'){///this mean current user is student
                if ($('#localfile_chk').is(':checked')) contentLocal = '0';
                if ($('#cloudfile_chk').is(':checked')) contentCloud = '0';

                if (contentLocal == '0' && contentCloud == '0') {
                    ajaxURL = baseURL + "work/delete_content";
                } else {
                    ajaxURL = baseURL + "work/update_content";
                    ajaxData.content_local = contentLocal;
                    ajaxData.content_cloud = contentCloud;
                }
            }else {
                ajaxData.content_cloud = '0';
                ajaxData.content_local = contentLocal;
                ajaxURL = baseURL+"work/update_content";
                if(contentLocal=='0')
                {
                    ajaxURL = baseURL+"work/delete_content";
                }
            }
        }
        console.log(ajaxData);
        jQuery.ajax({
            type: "post",
            url: ajaxURL,
            dataType: "json",
            data: ajaxData,
            success: function(res) {
                if(res.status=='success') {
                    pager.conList = res.data;
                    pager.init();
                    pager.showPage();
                    $('#delete_contentItem_modal').modal('toggle');
                    fitwindow();
                }
                else//failed
                {
                    alert("Cannot Delete work.");
                }
            }
        });
    });
    function deleteContentItem(self) {
          var contentDelBtn = $('#content_delete_btn');
          var content_id = self.getAttribute('content_id');
          var content_local = self.getAttribute('content_local');
          var content_cloud = self.getAttribute('content_cloud');

          contentDelBtn.attr('content_id',content_id);
          contentDelBtn.attr('content_local',content_local);
          contentDelBtn.attr('content_cloud',content_cloud);

          $('#localfile_chk').prop('checked',false);
          $('#cloudfile_chk').prop('checked',false);

          if(userType=='1'){

              $('#delete_contentItem_modal .modal-body').hide();

          }

        var vHeight = window.innerHeight;
        var dlgHeight = $('#delete_contentItem_modal .modal-dialog').height();
        $('#delete_contentItem_modal .modal-dialog').css({'margin-top':(vHeight-dlgHeight-130)/2});

          $('#delete_contentItem_modal').modal({
              backdrop: 'static',keyboard: false
          });
      }
    function shareContentItem(content_id) {
          jQuery.ajax({
              type: "post",
              url: baseURL+"work/share_content",
              dataType: "json",
              data: {student_id:studentId,content_type_id:content_type_id,content_id: content_id},
              success: function(res) {
                  if(res.status=='success') {
                      pager.conList = res.data;
                      pager.init();
                      pager.showPage();
                      close_modal();
                      fitwindow();
                  }
                  else//failed
                  {
                      alert("Cannot Upload work.");
                  }
              }
          });
      }
    function shareContentModal(self) {
         var content_id = self.getAttribute('content_id');
         $('#content_share_btn').attr('content_id',content_id);
         showCustomModal();
      }
</script>
<script src="<?= base_url('assets/js/frontend/work_list_view.js') ?>" type="text/javascript"></script>


