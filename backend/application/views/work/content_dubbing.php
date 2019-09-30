<?php
$logged_In_user_id = $this->session->userdata("loginuserID");
$user_type = $this->session->userdata("user_type");
$imageAbsDir =  base_url().'assets/images/frontend/';
$myworkURL = 'work/student';
$returnURL = 'work/dubbing/'.$user_id;
$course_menu_img_path = '';
if($user_type=='2'){
    $myworkURL = 'work/script/'.$logged_In_user_id;
    $hd_menu_img_path = $imageAbsDir.'studentwork/';
}else{
    $hd_menu_img_path = $imageAbsDir.'studentwork/stu_';
}
?>
<!--------------------Player-------------------->
<link rel="stylesheet" href="<?= base_url('assets/css/video/style_video.css') ?>" />
<link rel="stylesheet" href="<?= base_url('assets/css/video/vplayer.css') ?>" />
<!--------------------Player-------------------->
<!-----------------------------Vplayer------------------------->
<script  src="<?= base_url('assets/js/video/vplayer.js')?>"></script>
<!-----------------------------Vplayer------------------------->

<link rel = "stylesheet" type="text/css" href="<?= base_url('assets/css/frontend/menu_manage.css')?>">
<link rel = "stylesheet" type="text/css" href="<?= base_url('assets/css/frontend/work_view.css')?>">
<div class="bg">
    <?php if($content_type_id=='4'){?>
        <img src="<?= $imageAbsDir.'community/dubbingview_bg.jpg';?>" class="background_image">
    <?php } else{ ?>
        <img src="<?= $imageAbsDir.'community/dubbingview_bg1.jpg';?>" class="background_image">
    <?php } ?>
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
    <a  href="#" id="shareContent_Btn"
        class="share_content_btn"
        style="background:url(<?= base_url('assets/images/frontend/mywork/workshare.png')?>) no-repeat;background-size: 100% 100%;">
    </a>
<?php } ?>


<div class="player" style="display: <?php if($content_type_id!='4') echo "none";else echo 'block';?>">
    <audio id="music" preload="true" autoplay >
        <source src="<?php echo base_url().$wavPath;?>">
    </audio>
    <a id="pButton" class="play">
        <img src="<?= base_url('assets/images/frontend/community/dubbing/player_play.png')?>">
    </a>
    <div id="timeline" style="background: url(<?= base_url('assets/images/frontend/community/dubbing/player_sliderbar.png') ?>) no-repeat;background-size: 100% 100%"></div>
    <div id="playhead" style="background: url(<?= base_url('assets/images/frontend/community/dubbing/player_slidertap.png')?>) no-repeat;background-size: 100% 100%"></div>
</div>

<div class="dubbing-content">
    <div style="height: 100%;width:100%">
        <?php if($content_type_id=='4'){ ?>
            <img src="<?= base_url($bgPath);?>">
        <?php }else{?>
            <video controls id="videoPlayer" class="video-js vjs-default-skin vjs-big-play-centered" style="background:#000;object-fit: fill;position: absolute;width: 100%;height:100%" autoplay>
                <source src="<?= base_url($bgPath);?>" type="video/mp4">
            </video>
            <script>
                var music = document.getElementById('music'); // id for audio element
                var vplayer = videojs('videoPlayer',{controls:true,width:1280,height:712,preload:'auto',loop:false},function(){
                    vplayer.on('play', function(){
                        console.log('play');
                        music.play();
                    });
                    vplayer.on("pause",function(){
                        console.log('stop');
                        music.pause();
                    });
                    vplayer.on("ended",function(){
                        console.log('stop');
                        music.pause();
                    });
                });
            </script>
        <?php }?>
    </div>
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
    var music = document.getElementById('music'); // id for audio element
    var duration = music.duration; // Duration of audio clip, calculated here for embedding purposes
    var pButton = document.getElementById('pButton'); // play button
    var playhead = document.getElementById('playhead'); // playhead
    var timeline = document.getElementById('timeline'); // timeline

    // timeline width adjusted for playhead
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
        } else { // pause music
            music.pause();
            // remove pause, add play
            pButton.className = "";
            pButton.className = "play";
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

