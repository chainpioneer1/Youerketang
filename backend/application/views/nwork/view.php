<?php
$userRole = '0';
$loged_In_user_id = $this->session->userdata("loginuserID");
$imageAbsDir =  base_url().'assets/images/taiyang/';
$user_type = $this->session->userdata("user_type");

?>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/sandapian/menu_manage.css') ?>">
<style>
    .background_image { position: fixed; top: 0;left: 0; width:100%;height:100%; background-size: contain; z-index: -2; }
    .bg_content_area{position: absolute;left:7.6%;top:8.4%;width:84.7%;height:86.7%;}
    .bg_content_area img {width:100%;height:100%}
    .table_content_area {position: absolute;top: 30%; left: 9.5%;width: 80.6%;height: 60%;}
    .table_content_area .table td{ vertical-align: middle;color:#707070;font-weight: bold;border-top: 1px solid #c5afaf;font-size: 15px;}
    .qualified_field{width:10%;padding-left: 0;padding-right: 0;position: relative;text-align:-webkit-center;}
    .notename_field {width:30%;text-align: center;padding-bottom: 0;}
    .operation_field {width:15%;position: relative}
    .qualified_filed  img {position: absolute;top:10%;width:50%;height:70%;left:26%}
    .op_delete_btn {background: url(<?= $imageAbsDir.'workview/delete.png'?>) no-repeat;background-size:100% 100%;position: absolute;top:10%;width:21%;height:80%;left:6%}
    .op_download_btn {background: url(<?= $imageAbsDir.'workview/download.png'?>) no-repeat;position: absolute;top:10%;width:21%;height:80%;left:30%;background-size: 100% 100%}
    .op_upload_btn{background: url(<?= $imageAbsDir.'workview/upload.png'?>) no-repeat;background-size:100% 100%;position: absolute;top:10%;width:21%;height:80%;left:55%}

    .notename_filed_note {width: 35.5%;height: 30px;text-align: center;}
    .operation_field_note {width: 23%;position: relative;text-align: center}
    .op_delete_note_btn{background: url(<?= $imageAbsDir.'workview/delete.png'?>) no-repeat;background-size:100% 100%;position: absolute;top:10%;width:15%;height:80%;left:30%}
    .op_download_note_btn {background: url(<?= $imageAbsDir.'workview/download.png'?>) no-repeat;position: absolute;top:10%;width:15%;height:80%;left:52%;background-size: 100% 100%}

    .content_title_link { font-size:14px;text-decoration: none !important;color: #707070;font-weight: bold }
    #search_content_box {position: absolute;top:16.48%;left:9.79%;width:28.1%;height:4.7%;font-size:1.8rem }
    #content_search_btn {position: absolute;top:16.4%;left:38.5%;width:2.7%;height: 4.9%}
    .category_search_wrap {
        position: absolute;
        top:16.48%;left:42%;width:8%;height: 4.7%;
        overflow: hidden;
        background: url(<?= $imageAbsDir.'workview/arrow.png'?>) no-repeat right  #fff;background-size: 30% 100%;
    }
    #category_search_sel { width:100%;height: 100%;background: transparent; -webkit-appearance: none;color:#6f6f6f;font-size:20px;font-weight: bold }
/***********LightBox********************/
    .backdrop_bg {position:absolute;top:0px;left:0px;width:100%;height:100%;background:#000;opacity: .0; filter:alpha(opacity=0);display:none;}
    .box {position: absolute;top:36.2%;left:35.6%;width:31.6%;height:33.3%;background: url(<?= $imageAbsDir.'workview/note_bg.png' ?>); no-repeat;background-size: 100% 100%;display:none;}
    .note_modal{position: relative;width:100%;height:100%;}
    #note_content{position: absolute;left:10%;top:30%;width:80%;height:60%;overflow: auto;}
    #note_content p {font-size:30px;color:#fff;font-weight: bold}
    #close_note_btn {position:absolute;width:6%;height:10%;top:6%;right:4%;}

    .backdrop_bg_del {position:absolute;top:0;left:0;width:100%;height:100%;background:#000;opacity: .0; filter:alpha(opacity=0);display:none;z-index: 50}
    .del_box {position: absolute;top:36.2%;left:35.6%;width:31.5%;height:33.3%;background: url(<?= $imageAbsDir.'base/del_modalbg.png' ?>); no-repeat;background-size: 100% 100%;display:none;  z-index:51;}
    .delete_modal{position: relative;width:100%;height:100%;}

    .audio_player{position: absolute;bottom:6.6%;left:34.1%;width:34%;height:0;background: url(<?= $imageAbsDir.'workview/audio_bg.png' ?>) no-repeat;background-size: 100% 100%}
    #pButton{ position: absolute; left:1.5%; top:10.9%; width:7%; height:79% }
    #pButton img{ width: 100%; height: 100% }
    #timeline{ position: absolute; left: 10.02%; top:31%; width: 85.65%; height: 18.02% }
    #timeline img{ width: 100%; height: 100% }
    #playhead{ position: absolute; left: 10.7%; top: 26%; width: 5%; height: 51.5% }
    #playhead img{ width: 100%; height: 100% }

    #confirm_delete_btn { position: absolute; background: url(<?= $imageAbsDir.'base/yes.png'?>) no-repeat;background-size: 100% 100%; width: 17%;height: 17%; left: 19%;top: 68%;}
    #no_btn { position: absolute;background: url(<?= $imageAbsDir.'base/no.png'?>) no-repeat;background-size: 100% 100%; width: 17%;height: 17%;right:19%;top:68%;}
    #local_delete_chk {position: absolute;background: url(<?= $imageAbsDir.'base/localwork.png'?>) no-repeat;background-size: 100% 100%; width: 28%; height: 12%; top:41%;left:13%;}
    #cloud_delete_chk {position: absolute;background: url(<?= $imageAbsDir.'base/cloudwork.png'?>) no-repeat;background-size: 100% 100%;width: 28%;height: 12%; top:41%; right:13%;}
/***********LightBox********************/
</style>
<div class="bg">
    <img src="<?= $imageAbsDir.'base/bg.png';?>" class="background_image">
</div>
<div class="bg_content_area">
    <div style="position: relative; height: 100%">
        <img id="table_bg_image" src="<?= $imageAbsDir.'workview/course_bg.png';?>">
        <a id="course_btn" href="#" style="position:absolute;top:0; left:3.8%; width: 13.9%; height:7.13%;"></a>
        <a id="text_btn" href="#" style="position:absolute;top: 0; left: 20%; width: 13.9%; height: 7.13%;"></a>
        <a id="mynote_btn" href="#" style="position:absolute;top: 0; left: 36%; width: 13.9%; height: 7.13%;"></a>
    </div>
</div>
<!---------------------------Top Menu Area-------------------------------->
<a href="<?= base_url('nchildcourse/index');?>"
   class="btn" id="sh_backhome_btn"
   style="background:url(<?= $imageAbsDir.'base/backhome.png';?>) no-repeat;background-size: 100% 100%;">
</a>
<?php if($this->session->userdata("loggedin") != FALSE){?>
    <a href="<?= base_url().'users/profile/'.$loged_In_user_id;?>" class="btn" id="sh_profile_btn"  style="background:url(<?= $imageAbsDir.'base/profile.png';?>) no-repeat;background-size: 100% 100%;"> </a>
    <a href="<?= base_url('signin/signout')?>" class="btn" id="sh_exit_btn"  style="background:url(<?= $imageAbsDir.'base/exit.png';?>) no-repeat;background-size: 100% 100%;"></a>
<?php }else{?>
    <a href="<?= base_url('signin/index')?>"  class="btn" id="sh_login_btn" style="background:url(<?= $imageAbsDir.'base/login.png';?>) no-repeat;background-size: 100% 100%;"> </a>
<?php } ?>
<!---------------------------Top Menu Area-------------------------------->
<div class="table_content_area" style="overflow: auto">
    <div class="table-responsive">
       <table class="table" id="content_list_items">
           <?php foreach ($nContents as $content):?>
            <tr>
                <td class="qualified_field">
                    <?php if($content->ncontent_cloud=='1') {?>
                          <img class="img-responsive" src="<?= $imageAbsDir.'workview/level'.$content->ncontent_qualify.'.png'?>" style="">
                    <?php }?>
                </td>
                <td class="notename_field">
                    <a href="#" class="content_title_link"
                       data-contentUrl="<?= $content->ncontent_file;?>" onclick="show_content(this);">
                        <?= $content->ncontent_title;?>
                    </a>
                </td>
                <td style="width:20%;">
                    <?php $includeStr = $content->ncontent_belong_title;
                    if(strlen($includeStr)>20){
                        $firstStr = substr($includeStr,0,20);
                        echo $includeStr;
                    }else echo $includeStr;
                    ?>
                </td>
                <td style="width:14%;">
                    <?= $content->ncontent_createtime;?>
                </td>
                <td  class="operation_field">
                    <a class="op_delete_btn btn" data-contentid="<?= $content->ncontent_id;?>"
                       onclick="content_delete(this)"
                       onmouseover="hover_delete(this)" onmouseout="out_delete(this)"
                       local_st = "<?= $content->ncontent_local ?>"
                       cloud_st = "<?= $content->ncontent_cloud ?>"
                    ></a>
                    <a href="<?= base_url().$content->ncontent_file;?>" download class="op_download_btn btn" data-contentid="<?= $content->ncontent_id;?>"
                        onmouseover="hover_download(this)" onmouseout="out_download(this)"></a>
                    <?php if($content->ncontent_cloud=='0'){?>
                        <a class="op_upload_btn btn" data-contentid="<?= $content->ncontent_id;?>"
                           onclick="content_upload(this)" onmouseover="hover_upload(this)" onmouseout="out_upload(this)"></a>
                    <?php } ?>
                </td>
            </tr>
            <?php endforeach;?>
        </table>
    </div>
</div>
<!------------------Search controls---------------------->
<input type="text" id = "search_content_box">
<a class="btn" id="content_search_btn"
   style="background:url(<?= $imageAbsDir.'workview/search.png';?>) no-repeat;background-size: 100% 100%;">
</a>
<div class="category_search_wrap">
    <select id="category_search_sel">
        <option selected value="10"><?= $this->lang->line('SortSelection');?></option>
        <option value="1"><?= $this->lang->line('ContentName');?></option>
        <option value="2"><?= $this->lang->line('IncludeCourse');?></option>
        <option value="3"><?= $this->lang->line('SaveTime');?></option>
    </select>
</div>
<!------------------Search controls---------------------->
<!-------------------Note Viewer------------------------->
<div class="backdrop_bg"></div>
<div class="box">
   <div class="note_modal">
       <a class="btn" id="close_note_btn" style="background:url(<?= $imageAbsDir.'workview/close.png'?>) no-repeat;background-size: 100% 100%;"></a>
       <div id="note_content"></div>
    </div>
</div>
<!-------------------Note Viewer------------------------->
<div class="backdrop_bg_del"></div>
<div class="del_box">
    <div class="delete_modal">
        <div id="delete_content">
            <a href="#" id = "local_delete_chk"></a>
            <a href="#" id = "cloud_delete_chk"></a>
            <a href="#" id = "confirm_delete_btn"></a>
            <a href="#" id = "no_btn"></a>
        </div>
    </div>
</div>
<script>
    $('.boxclose').click(function(){
        close_box();
    });
    function showNoteContent()  {
        $('.backdrop_bg, .box').animate({'opacity':'.6'}, 200, 'linear');
        $('.box').animate({'opacity':'1.00'}, 200, 'linear');
        $('.backdrop_bg, .box').css('display', 'block');
    }
    function close_box()  {
        $('.backdrop_bg, .box').animate({'opacity':'0'},200, 'linear', function(){
            $('.backdrop_bg, .box').css('display', 'none');
        });
    }
    $('#close_note_btn').click(function(){  close_box(); });


    function deleteConfirmMsg()
    {
        $('.backdrop_bg_del, .del_box').animate({'opacity':'.6'}, 200, 'linear');
        $('.del_box').animate({'opacity':'1.00'}, 200, 'linear');
        $('.backdrop_bg_del, .del_box').css('display', 'block');
    }
    function close_del_box()
    {
        $('.backdrop_bg_del, .del_box').animate({'opacity':'0'},200, 'linear', function(){
            $('.backdrop_bg_del, .del_box').css('display', 'none');
        });
    }
</script>
<!-------------------Audio Player------------------------->
<div class="audio_player" >
    <div style="position: relative;width:100%;height:100%">
        <audio id="music" >
            <source src="" id="audioSource" type="audio/wav">
        </audio>
        <a id="pButton" class="play">
            <img src="<?= $imageAbsDir.'workview/play.png'?>">
        </a>
        <div id="timeline">
            <img src="<?= $imageAbsDir.'workview/timeline_bg.png';?>">
        </div>
        <div id="playhead">
            <img src="<?= $imageAbsDir.'workview/play_head.png'?>">
        </div>
    </div>
</div>
<!-------------------Audio Player------------------------->
<script>
    var imageDir = '<?= $imageAbsDir;?>';
    $('.audio_player').height(0);
    var music = document.getElementById('music'); // id for audio element
    var duration = music.duration; // Duration of audio clip, calculated here for embedding purposes
    var pButton = document.getElementById('pButton'); // play button
    var playhead = document.getElementById('playhead'); // playhead
    var timeline = document.getElementById('timeline'); // timeline

    var timelineWidth = timeline.offsetWidth - playhead.offsetWidth;
    // play button event listenter
    pButton.addEventListener("click", play);
    // timeupdate event listener
    music.addEventListener("timeupdate", timeUpdate, false);
    // makes timeline clickable
    timeline.addEventListener("click", function(event) {
        moveplayhead(event);
        music.currentTime = duration * clickPercent(event);
    }, false);
    // returns click as decimal (.77) of the total timelineWidth
    function clickPercent(event) {
        return (event.clientX - getPosition(timeline)) / timelineWidth;
    }
    // makes playhead draggable
    playhead.addEventListener('mousedown', mouseDown, false);
    window.addEventListener('mouseup', mouseUp, false);
    // Boolean value so that audio position is updated only when the playhead is released
    var onplayhead = false;
    // mouseDown EventListener
    function mouseDown() {
        onplayhead = true;
        window.addEventListener('mousemove', moveplayhead, true);
        music.removeEventListener('timeupdate', timeUpdate, false);
    }
    // mouseUp EventListener
    // getting input from all mouse clicks
    function mouseUp(event) {
        if (onplayhead == true) {
            moveplayhead(event);
            window.removeEventListener('mousemove', moveplayhead, true);
            // change current time
            music.currentTime = duration * clickPercent(event);
            music.addEventListener('timeupdate', timeUpdate, false);
        }
        onplayhead = false;
    }
    // mousemove EventListener
    // Moves playhead as user drags
    function moveplayhead(event) {
        var newMargLeft = event.clientX - getPosition(timeline);
        if (newMargLeft >= 0 && newMargLeft <= timelineWidth) {
            playhead.style.marginLeft = newMargLeft + "px";
        }
        if (newMargLeft < 0) {
            playhead.style.marginLeft = "0px";
        }
        if (newMargLeft > timelineWidth) {
            playhead.style.marginLeft = timelineWidth + "px";
        }
    }
    // timeUpdate
    // Synchronizes playhead position with current point in audio
    function timeUpdate() {
        var playPercent = timelineWidth * (music.currentTime / duration);
        playhead.style.marginLeft = playPercent + "px";
        if (music.currentTime == duration) {
            pButton.className = "";
            pButton.className = "play";
        }
    }

    //Play and Pause
    function play() {
        // start music
        if (music.paused) {
            music.play();
            // remove play, add pause
            pButton.className = "";
            pButton.className = "pause";
            $('#pButton img').attr('src',imageDir+'workview/stop.png');
        } else { // pause music
            music.pause();
            // remove pause, add play
            pButton.className = "";
            pButton.className = "play";
            $('#pButton img').attr('src',imageDir+'workview/play.png');
        }
    }
    // Gets audio file duration
    music.addEventListener("canplaythrough", function() {
        duration = music.duration;
    }, false);

    // getPosition
    // Returns elements left position relative to top-left of viewport
    function getPosition(el) {
        return el.getBoundingClientRect().left;
    }

    var listenAudio = document.getElementById('music');
    listenAudio.onended = function(){
        pButton.className='play';
        $('#pButton img').attr('src',imageDir+'workview/play_hover.png');
        $('.audio_player').animate({'opacity':'0','height':'0'}, 300, 'linear');
    };
    $('#pButton').mouseover(function(){
        if(pButton.className=='pause')
        {
            $('#pButton img').attr('src',imageDir+'workview/stop_hover.png');
        }
        if(pButton.className=='play')
        {
            $('#pButton img').attr('src',imageDir+'workview/play_hover.png');
        }

    });
    $('#pButton').mouseout(function(){
        if(pButton.className=='pause')
        {
            $('#pButton img').attr('src',imageDir+'workview/stop.png');
        }
        if(pButton.className=='play')
        {
            $('#pButton img').attr('src',imageDir+'workview/play.png');
        }
    });


</script>
<!-------------------Audio Player------------------------->
<script>

    var curTab = 'course';
    var userId = '<?= $userId?>';
    var local_del = '0';
    var cloud_del = '0';

    function initConfirmModal(){
        $('#local_delete_chk').css({"background":"url("+imageDir+"base/localwork.png) no-repeat",'background-size' :'100% 100%'});
        $('#cloud_delete_chk').css({"background":"url("+imageDir+"base/cloudwork.png) no-repeat",'background-size' :'100% 100%'});
        local_del = cloud_del ='0';

    }
    function content_upload_ajax(contentId){
        jQuery.ajax({
            url:baseURL+"nwork/upload_content",
            type:"post",
            dataType: "json",
            data:{userId:userId,contentId:contentId,content_type:curTab},
            success: function(res){
                if(res.status='success')
                {
                    $('#content_list_items').html(res.data);

                }else{
                    alert('Can not upload work!');
                }
            }
        });
    }
    function content_delete_ajax(contentId)
    {
        jQuery.ajax({
            url:baseURL + "nwork/delete_content",
            type:"post",
            dataType: "json",
            data:{userId:userId,contentId:contentId,content_type:curTab},
            success: function(res){
                if(res.status='success')
                {
                    $('#content_list_items').html(res.data);
                    close_del_box();
                }else{
                    alert('Can not upload work!');
                }
            }
        });

    }
    function content_upload(self){
        var contentId = self.getAttribute('data-contentid');
        content_upload_ajax(contentId);
    }
    function content_delete(self){
        var contentId = self.getAttribute('data-contentid');
        var contentLocal  = self.getAttribute('local_st');
        var contentCloud = self.getAttribute('cloud_st');
        if(curTab!='note')
        {
            $('#confirm_delete_btn').attr('content_local',contentLocal);
            $('#confirm_delete_btn').attr('content_cloud',contentCloud);
            $('#confirm_delete_btn').attr('contentid',contentId);

            initConfirmModal();
            deleteConfirmMsg();
        }else{
            content_delete_ajax(contentId);
        }
    }
    $('#confirm_delete_btn').click(function(){

        var contentid = $(this).attr('contentid');
        var contentLocal = $(this).attr('content_local');
        var contentCloud = $(this).attr('content_cloud');

        var ajaxURL = '';
        var ajaxData = {userId:userId,contentId:contentid,content_type:curTab};
        ajaxData.content_local = contentLocal;
        ajaxData.content_cloud = contentCloud;
        if (local_del==='1') contentLocal = '0';
        if (cloud_del==='1') contentCloud = '0';

        if (contentLocal === '0' && contentCloud === '0') {
            ajaxURL = baseURL + "nwork/delete_content";
        } else {
            ajaxURL = baseURL + "nwork/update_contentToDelete";
            ajaxData.content_local = contentLocal;
            ajaxData.content_cloud = contentCloud;
        }

        jQuery.ajax({
            url:ajaxURL,
            type:"post",
            dataType: "json",
            data:ajaxData,
            success: function(res){
                if(res.status='success')
                {
                    $('#content_list_items').html(res.data);
                    close_del_box();
                }else{
                    alert('Can not upload work!');
                }
            }
        });

    });
    function show_content(self) {
        var dataUrl = self.getAttribute('data-contentUrl');
        if(curTab!='note')
        {
            $('.audio_player').animate({'opacity':'1','height':'5.9%'}, 300, 'linear');
            music = document.getElementById('music'); // id for audio element
            $("#audioSource").attr("src", dataUrl).detach().appendTo("#music");

            ////we have to check dataURL has base url ......

            var baseUrlPos = dataUrl.indexOf('http');

            if(baseUrlPos<0)
            {
                $("#audioSource").attr("src", baseURL+dataUrl).detach().appendTo("#music");
            }else{
                $("#audioSource").attr("src", dataUrl).detach().appendTo("#music");
            }

            music.load();
            duration = music.duration;
            music.play();
            pButton.className='pause';
            $('#pButton img').attr('src',imageDir+'workview/stop.png');
        }else{
            jQuery.ajax({
                url:baseURL+"nwork/get_NoteDetails",
                type:"post",
                dataType: "json",
                data:{filePath:dataUrl},
                success: function(res){
                    if(res.status='success')
                    {
                        $('#note_content').html(res.data);
                        showNoteContent();
                    }else{
                        alert('Can not show my note!');
                    }
                }
            });
        }
    }
    function hover_delete(self){self.style.backgroundImage   = "url("+imageDir+"workview/delete_hover.png)";}
    function out_delete(self){self.style.backgroundImage   = "url("+imageDir+"workview/delete.png)";}
    function hover_download(self){self.style.backgroundImage   = "url("+imageDir+"workview/download_hover.png)";}
    function out_download(self){ self.style.backgroundImage   = "url("+imageDir+"workview/download.png)";}
    function hover_upload(self) {self.style.backgroundImage   = "url("+imageDir+"workview/upload_hover.png)";}
    function out_upload(self){self.style.backgroundImage   = "url("+imageDir+"workview/upload.png)";}
    $("#search_content_box").keyup(function () {

        var input, filter, table, tr, td, i;
        input = document.getElementById("search_content_box");
        filter = input.value.toUpperCase();
        table = document.getElementById("content_list_items");
        tr = table.getElementsByTagName("tr");
        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            var cmpst = 0;
            for(j=1;j<4;j++)//5 is search filed count
            {
                td = tr[i].getElementsByTagName("td")[j];
                if (td) {
                    if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                        cmpst++;
                    }
                }
            }
            if(cmpst>0)
            {
                tr[i].style.display = "";
            }
            else tr[i].style.display = "none";
        }
    });
    $('#category_search_sel').change(function(){
        sortTable($(this).val());
    });
    function sortTable(columNo){
        if(columNo==10) return;
        var table, rows, switching, i, x, y, shouldSwitch;
        table = document.getElementById("content_list_items");
        switching = true;
        /*Make a loop that will continue until
        no switching has been done:*/
        while (switching) {
            //start by saying: no switching is done:
            switching = false;
            rows = table.getElementsByTagName("TR");
            /*Loop through all table rows (except the
            first, which contains table headers):*/
            for (i = 0; i < (rows.length - 1); i++) {
                //start by saying there should be no switching:
                shouldSwitch = false;
                /*Get the two elements you want to compare,
                one from current row and one from the next:*/
                x = rows[i].getElementsByTagName("TD")[columNo];
                y = rows[i + 1].getElementsByTagName("TD")[columNo];
                //check if the two rows should switch place:
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    //if so, mark as a switch and break the loop:
                    shouldSwitch= true;
                    break;
                }
            }
            if (shouldSwitch) {
                /*If a switch has been marked, make the switch
                and mark that a switch has been done:*/
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
            }
        }
    }
    function fitWindow() {
        var tableWfont = 0.01*window.innerWidth;
        var tableHfont =  0.02*window.innerHeight;

        var sortWfont = 0.01*window.innerWidth;
        var sortHfont =  0.02*window.innerHeight;

        var realFont = (tableWfont>tableHfont)? tableHfont:tableWfont;
        var realSortFont = (sortWfont>sortHfont)? sortHfont:sortWfont;

        $('.table_content_area .table td').css('font-size',realFont+'px');
        $('.content_title_link').css('font-size',realFont+'px');
        $('#category_search_sel').css('font-size',realSortFont+'px');
    }
    fitWindow();
    $(window).resize(function(){
        fitWindow();
    });
    fitWindow();
</script>
<script src="<?= base_url('assets/js/sandapian/menu_manage.js')?>"></script>
<script src="<?= base_url('assets/js/sandapian/workview_manage.js')?>"></script>
