<?php
$userRole = '0';
$loged_In_user_id = $this->session->userdata("loginuserID");
$imageAbsDir =  base_url().'assets/images/taiyang/';
$user_type = $this->session->userdata("user_type");
?>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/sandapian/menu_manage.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/sandapian/teacherview_manage.css') ?>">
<style>
    @font-face {
        font-family: memberFont;
        src: url(<?= base_url('assets/fonts/AdobeGothicStd-Bold.otf')?>);
    }
    .member_item{
        font-family: memberFont;
    }
</style>
<div class="bg">
    <img src="<?= $imageAbsDir.'base/bg.png';?>" class="background_image">
</div>
<div class="bg_content_area">
    <div style="position: relative; height: 100%">
        <img id="table_bg_image" src="<?= $imageAbsDir.'teacherview/bg_teacher_course.png';?>">
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
<div class="teacher_assign_class" style="text-align:-webkit-center;overflow: auto">
    <?php foreach ($classlists as $classlist):?>
        <div class="class_name_btn_wrapper"
             id = "<?= $classlist->image_name;?>"
             style="background: url('<?= $imageAbsDir."teacherview/".$classlist->image_name.'.png';?>') no-repeat;background-size: 100% 100% ">
            <button type="button"
                    data-class_name ="<?= $classlist->attr_name;?>"
                    data-image_name="<?= $classlist->image_name;?>"
                    class="custom_classlist_btn"></button>
        </div>
    <?php endforeach;?>
</div>
<!------------------Student content list----------------->
<style>
    .edit_content_area{position: absolute;top:29%;left:9.5%;width:80.5%;height:62.5%;overflow: auto}
    .content_name {width:27%;padding-left: 20px;position: relative;text-align: center}
    .include_course {width:30%;text-align: center}
    .author_name {width:9%;padding-left: 0;}
    .save_time{width:15%;text-align: center}
    .evaluation_field{width:15%;}

    .op-level-btn{
        position: absolute;
        background-size: 100% 100%;
        top:12.5%;
        width:15%;
        height:75%;
    }
    .op-level-btn0 {
        background: url(<?= $imageAbsDir.'teacherview/oplevel0.png';?>);
        background-size: 100% 100%;
        left:15%;
    }
    .op-level-btn1{
        background: url(<?= $imageAbsDir.'teacherview/oplevel1.png';?>);
        background-size: 100% 100%;
        left:33%;
    }
    .op-level-btn2 {
        background: url(<?= $imageAbsDir.'teacherview/oplevel2.png';?>);
        background-size: 100% 100%;
        left:51%;
    }
    .op-level-btn3{
        background: url(<?= $imageAbsDir.'teacherview/oplevel3.png';?>);
        background-size: 100% 100%;
        left:69%;
    }
    .op-level-btn-sel0 {
        background: url(<?= $imageAbsDir.'teacherview/oplevelr0.png';?>);
        background-size: 100% 100%;
        left:15%;
    }
    .op-level-btn-sel1{
        background: url(<?= $imageAbsDir.'teacherview/oplevelr1.png';?>);
        background-size: 100% 100%;
        left:33%;
    }
    .op-level-btn-sel2 {
        background: url(<?= $imageAbsDir.'teacherview/oplevelr2.png';?>);
        background-size: 100% 100%;
        left:51%;
    }
    .op-level-btn-sel3{
        background: url(<?= $imageAbsDir.'teacherview/oplevelr3.png';?>);
        background-size: 100% 100%;
        left:69%;
    }

    #edit_list_items tr td
    {
        vertical-align: middle;
        color:#707070;
        font-weight: bold;
        border-top: 1px solid #c5afaf;
        font-size: 15px;
    }
    .ncontent_title
    {
        text-decoration: none !important;
        color:#6d6f6c ;
        font-weight: bold;
        font-size: 15px;
    }
    .op_delete_note_btn{background: url(<?= $imageAbsDir.'workview/delete.png'?>) no-repeat;background-size:100% 100%;position: absolute;top:10%;width:13%;height:80%;left:41%}
    .op_download_note_btn {background: url(<?= $imageAbsDir.'workview/download.png'?>) no-repeat;position: absolute;top:10%;width:13%;height:80%;left:61%;background-size: 100% 100%}
    .op_delete_btn {background: url(<?= $imageAbsDir.'workview/delete.png'?>) no-repeat;background-size:100% 100%;position: absolute;top:10%;width:13%;height:80%;left:32%}
    .op_download_btn {background: url(<?= $imageAbsDir.'workview/download.png'?>) no-repeat;position: absolute;top:10%;width:13%;height:80%;left:55%;background-size: 100% 100%}
    .content_title_link { font-size:15px;text-decoration: none !important;color: #707070;font-weight: bold}
    .notename_filed_note {width: 45.5%;height: 30px;text-align: center;}
    .operation_field_note {width: 20%;position: relative;}
    #search_content_box {position: absolute;top:16.48%;left:9.79%;width:28.1%;height:4.7%;font-size:1.8rem }
    #content_search_btn {position: absolute;top:16.4%;left:38.5%;width:2.7%;height: 4.9%}
    .category_search_wrap {
        position: absolute;
        top:16.48%;left:42%;width:8%;height: 4.7%;
        overflow: hidden;
        background: url(<?= $imageAbsDir.'workview/arrow.png'?>) no-repeat right  #fff;background-size: 30% 100%;
    }
    #category_search_sel { width:100%;height: 100%;background: transparent; -webkit-appearance: none;color:#6f6f6f;font-size:20px;font-weight: bold }

    /***********LightBox For MyNote********************/
    .backdrop_bg {position:absolute;top:0px;left:0px;width:100%;height:100%;background:#000;opacity: .0; filter:alpha(opacity=0);display:none;}
    .box {position: absolute;top:36.2%;left:35.6%;width:31.6%;height:33.3%;background: url(<?= $imageAbsDir.'workview/note_bg.png' ?>); no-repeat;background-size: 100% 100%;display:none;}
    .note_modal{position: relative;width:100%;height:100%;}
    #note_content{position: absolute;left:10%;top:30%;width:80%;height:60%;overflow: auto;}
    #note_content p {font-size:30px;color:#fff;font-weight: bold}
    #close_note_btn {position:absolute;width:6%;height:10%;top:6%;right:4%;}
    /***********LightBox********************/
    /**********************Audio Player*******************************/
    .audio_player{position: absolute;bottom:6.6%;left:34.1%;width:34%;height:0;background: url(<?= $imageAbsDir.'workview/audio_bg.png' ?>) no-repeat;background-size: 100% 100%}
    #pButton{ position: absolute; left:1.5%; top:10.9%; width:7%; height:79% }
    #pButton img{ width: 100%; height: 100% }
    #timeline{ position: absolute; left: 10.02%; top:31%; width: 85.65%; height: 18.02% }
    #timeline img{ width: 100%; height: 100% }
    #playhead{ position: absolute; left: 10.7%; top: 26%; width: 5%; height: 51.5% }
    #playhead img{ width: 100%; height: 100% }
    /**********************Delete Modal*******************************/
    #confirm_delete_btn { position: absolute; background: url(<?= $imageAbsDir.'base/yes.png'?>) no-repeat;background-size: 100% 100%; width: 17%;height: 17%; left: 19%;top: 68%;}
    #no_btn { position: absolute;background: url(<?= $imageAbsDir.'base/no.png'?>) no-repeat;background-size: 100% 100%; width: 17%;height: 17%;right:19%;top:68%;}
    #local_delete_chk {display:none;position: absolute;background: url(<?= $imageAbsDir.'base/localwork.png'?>) no-repeat;background-size: 100% 100%; width: 28%; height: 12%; top:41%;left:13%;}
    #cloud_delete_chk {display:none;position: absolute;background: url(<?= $imageAbsDir.'base/cloudwork.png'?>) no-repeat;background-size: 100% 100%;width: 28%;height: 12%; top:41%; right:13%;}
</style>
<div class="edit_content_area" style="display: none">
    <div class="table-responsive">
        <table class="table" id="edit_list_items">
            <tr style="height: 30px;">

            </tr>
        </table>
    </div>
</div>
<!------------------Student content list---------------------------->
<!------------------Search controls---------------------->
<input type="text" id = "search_content_box" style="display: none">
<a class="btn" id="content_search_btn"
   style="background:url(<?= $imageAbsDir.'workview/search.png';?>) no-repeat;background-size: 100% 100%;display: none">
</a>
<div class="category_search_wrap" style="display: none">
    <select id="category_search_sel">
        <option selected value="10"><?= $this->lang->line('SortSelection');?></option>
        <option value="0"><?= $this->lang->line('ContentName');?></option>
        <option value="1"><?= $this->lang->line('IncludeCourse');?></option>
        <option value="3"><?= $this->lang->line('SaveTime');?></option>
    </select>
</div>
<!------------------Search controls---------------------->
<!------------------Class List--------------------------->
<div id="class_member_area" style="position: absolute;">
    <div class="class_member_tbl_area">
        <div class="left-block-member">
            <div class="member_item_wrapper">
            </div>
        </div>
        <div class="right-block-member">
        </div>
    </div>
</div>
<!------------------Class List---------------------->
<!-------------------Note Viewer------------------------->
<div class="backdrop_bg"></div>
<div class="box">
    <div class="note_modal">
        <a class="btn" id="close_note_btn" style="background:url(<?= $imageAbsDir.'workview/close.png'?>) no-repeat;background-size: 100% 100%;"></a>
        <div id="note_content"></div>
    </div>
</div>
<script>
    $('.boxclose').click(function(){
        close_box();
    });
    function showNoteContent()
    {
        $('.backdrop_bg, .box').animate({'opacity':'.6'}, 200, 'linear');
        $('.box').animate({'opacity':'1.00'}, 200, 'linear');
        $('.backdrop_bg, .box').css('display', 'block');
    }
    function close_box()
    {
        $('.backdrop_bg, .box').animate({'opacity':'0'}, 200, 'linear', function(){
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
<!-----------------------------lightbox-------------------------------------------------->
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

    //  var local_del = '0';//    var cloud_del = '0';

    var current_className = '';
    var current_classbgname = '';
    var curPageNo = 0;
    var totalPageCount = 0;
    var studentContentEditStatus = false;///if this variable is true then teacher edit contents of students or display lists of class members
    var curUserIdForEdit = '-1';

    var prev_btn = $('.previous_Btn');
    var next_btn = $('.next_Btn');
    var tableBg = $('#table_bg_image');
    var imageDir1 = base_url+'assets/images/frontend/mywork/';
    prev_btn.mouseover(function(){
        $(this).css({"background":"url("+imageDir1+"prev_hover.png) no-repeat",'background-size' :'100% 100%'});
    });
    prev_btn.mouseout(function(){
        $(this).css({"background":"url("+imageDir1+"prev.png) no-repeat",'background-size' :'100% 100%'});
    });
    next_btn.mouseover(function(){
        $(this).css({"background":"url("+imageDir1+"next_hover.png) no-repeat",'background-size' :'100% 100%'});
    });
    next_btn.mouseout(function(){
        $(this).css({"background":"url("+imageDir1+"next.png) no-repeat",'background-size' :'100% 100%'});
    });
    function hover_delete(self){self.style.backgroundImage   = "url("+imageDir+"workview/delete_hover.png)";}
    function out_delete(self){self.style.backgroundImage   = "url("+imageDir+"workview/delete.png)";}
    function hover_download(self){self.style.backgroundImage   = "url("+imageDir+"workview/download_hover.png)";}
    function out_download(self){ self.style.backgroundImage   = "url("+imageDir+"workview/download.png)";}
    function clickStudent()///ajax_function for teacher let to edit student and itself information
    {
        $.ajax({
           type:"post",
           url:baseURL+'nwork/getContents',
           dataType:"json",
           data:{userid:curUserIdForEdit,content_slug:curTab},
           success:function(res){
                if(res.status==='success'){
                    $('#edit_list_items').html(res.data);
                }else{
                    alert('Can not display contents');
                    console.log(res);
                }
           }
        });
    }
    function changePage(self)
    {
        studentContentEditStatus = true;
        $('#class_member_area').hide();
        $('.edit_content_area').show();
        $('#search_content_box').show();
        $('#content_search_btn').show();
        $('.category_search_wrap').show();
        tableBg.attr('src',imageDir+'teacherview/bg_student_'+curTab+'.png');

        curUserIdForEdit = self.getAttribute('data-userid');
        clickStudent();
    }
    function changeContentEval(userid,contentId,hegeVal){
        $.ajax({
            type:"post",
            url:baseURL+'nwork/changedContentEval',
            dataType:"json",
            data:{userid:userid,contentId:contentId,hegeVal:hegeVal,content_slug:curTab},
            success:function(res){
                if(res.status==='success'){
                    $('#edit_list_items').html(res.data);
                }else{
                    alert('Can not display contents');
                    console.log(res);
                }
            }
        });
    }
    function content_delete_ajax(contentId){
        jQuery.ajax({
            url:baseURL+"nwork/delete_content",
            type:"post",
            dataType: "json",
            data:{userId:userId,contentId:contentId,content_type:curTab},
            success: function(res){
                if(res.status='success')
                {
                    $('#edit_list_items').html(res.data);
                }else{
                    alert('Can not delete content!');
                }
            }
        });
    }
    function showNContent(self) {
        var dataUrl = self.getAttribute('data-file');
        if(curTab!='note')
        {
            $('.audio_player').animate({'opacity':'1','height':'5.9%'}, 300, 'linear');
            music = document.getElementById('music'); // id for audio element
            $("#audioSource").attr("src", baseURL+dataUrl).detach().appendTo("#music");
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
    function content_delete(self){
        var contentId = self.getAttribute('data-contentid');
        local_del = cloud_del ='0';
        content_delete_ajax(contentId);
//        if(curTab!='note')
//        {
//            deleteConfirmMsg();
//        }else{
////            content_delete_ajax(contentId);
//        }
    }
    function show_content(self)  {
        var dataUrl = self.getAttribute('data-contentUrl');
        alert(dataUrl);
    }
    $("#search_content_box").keyup(function () {

        var input, filter, table, tr, td, i;
        input = document.getElementById("search_content_box");
        filter = input.value.toUpperCase();
        table = document.getElementById("edit_list_items");
        tr = table.getElementsByTagName("tr");
        // Loop through all table rows, and hide those who don't match the search query
        var fieldCnt = 4;
        if(curTab=='note'){
            fieldCnt =3;
        }

        for (i = 0; i < tr.length; i++) {
            var cmpst = 0;
            for(j=0;j<fieldCnt;j++)//fieldCnt is search filed count
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
        var sortfield = $(this).val();
        if(curTab=='note'&&sortfield==3){
            sortTable(2);
        }
        else {
            sortTable(sortfield);
        }
    });
    function sortTable(columNo){
        if(columNo==10) return;
        var table, rows, switching, i, x, y, shouldSwitch;
        table = document.getElementById("edit_list_items");
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
    function fitWindow()
    {
        var tableWfont = 0.011*window.innerWidth;
        var tableHfont =  0.016*window.innerHeight;

        var sortWfont = 0.01*window.innerWidth;
        var sortHfont =  0.016*window.innerHeight;

        var realFont = (tableWfont>tableHfont)? tableHfont:tableWfont;
        var realSortFont = (sortWfont>sortHfont)? sortHfont:sortWfont;

        $('#edit_list_items tr td').css('font-size',realFont+'px');
        $('.ncontent_title').css('font-size',realFont+'px');
        $('.content_title_link').css('font-size',realFont+'px');
        $('#category_search_sel').css('font-size',realSortFont+'px');
    }
    fitWindow();
    $(window).resize(function(){
        fitWindow();
    })
</script>
<script src="<?= base_url('assets/js/sandapian/menu_manage.js')?>"></script>
<script src="<?= base_url('assets/js/sandapian/teacherview_manage.js')?>"></script>
