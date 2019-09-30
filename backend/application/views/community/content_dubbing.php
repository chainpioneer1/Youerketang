<?php
$logged_In_user_id = $this->session->userdata("loginuserID");
$user_type = $this->session->userdata("user_type");
$imageAbsDir =  base_url().'assets/images/frontend/';
$myworkURL = 'work/student';
$returnURL = 'community/index';
$course_menu_img_path = '';
if($user_type=='2'){
    $myworkURL = 'work/script/'.$logged_In_user_id;
    $hd_menu_img_path = $imageAbsDir.'studentwork/';
}else{
    $hd_menu_img_path = $imageAbsDir.'studentwork/stu_';
}
?>

<link rel="stylesheet" href="<?= base_url('assets/css/frontend/community_view_dubbing.css')?>">

<!-----------------------------Vplayer------------------------->
<link rel="stylesheet" href="<?= base_url('assets/css/video/style_video.css') ?>" />
<link rel="stylesheet" href="<?= base_url('assets/css/video/vplayer.css') ?>" />
<script  src="<?= base_url('assets/js/video/vplayer.js')?>"></script>

<!-----------------------------Vplayer------------------------->
<style>

</style>
<input type="hidden" id="base_url" value="<?= base_url()?>">

<div class="bg">
    <img src="<?= base_url('assets/images/frontend/community/dubbing/bg.jpg')?>" class="background_image">
</div>
<div class="hdmenu">
    <div style="position: relative; height: 100%">
        <img class = "hdmenu_img" src="<?= $hd_menu_img_path.'hdmenu_normal.png';?>" usemap="#hdmenu_map">
        <a id = "hdmenu_studentwork" href="<?= base_url($myworkURL)?>" style="top: 27.2%; left: 1.1%; width: 31.9%; height: 48.5%;"></a>
        <a id = "hdmenu_profile" href="<?= base_url().'users/profile/'.$logged_In_user_id;?>" style="top: 3.9%; left: 37.1%; width: 26.1%; height: 90.4%;"></a>
        <a id = "hdmenu_community" href="<?= base_url().'community/index';?>" style="top: 27.2%; left: 67%; width: 31.9%; height: 48.5%;"></a>
    </div>
</div>

<div class="exit-btn">
    <?php if($this->session->userdata("loggedin") == FALSE): ?>
        <a href="<?= base_url('signin/index')?>"><img src="<?= $imageAbsDir.'coursewares/register.png'?>"></a>
    <?php else: ?>
        <a  href="<?= base_url('signin/signout')?>">
            <img class="exit_btn_img" src="<?= $imageAbsDir.'coursewares/exit.png';?>""></a>
    <?php endif; ?>
</div>

<div class="back-btn">
    <a href="#" onclick="history.go(-1)">
        <img id ="back-btn-img" src="<?= $imageAbsDir.'studentwork/back.png'?>">
    </a>
</div>
<div class="avatar-frame">
    <div style="position: relative; height: 100%">
        <img src="<?= $imageAbsDir.'contents-profile.jpg'?>" class="avatar-img" style="z-index: -1">
        <img src="<?= $imageAbsDir.'community/script/avatar_frame.png'?>">
        <label class="user-name"><?= $user_nickname;?></label>
        <label class="school-name"><?= $user_school;?></label>
    </div>
</div>

<div class="player"  style="display: <?php if($content_type_id!='4') echo "none";else echo 'block' ?>">
    <audio id="music" preload="true" autoplay>
        <source src="<?php echo base_url($wavPath);?>">
    </audio>
    <a id="pButton" class="play">
        <img src="<?= $imageAbsDir.'community/dubbing/player_play.png'?>">
    </a>
    <div id="timeline" style="background: url(<?= $imageAbsDir.'community/dubbing/player_sliderbar.png'?>) no-repeat;background-size: 100% 100%"></div>
    <div id="playhead" style="background: url(<?= $imageAbsDir.'community/dubbing/player_slidertap.png'?>) no-repeat;background-size: 100% 100%"></div>
</div>

<?php if($content_type_id!='4'){ ?>
    <div class="shooting-frame">
        <img src="<?= $imageAbsDir.'community/shooting/video_frame.png'?>">
    </div>
    <div class="shooting-content">
        <video controls id="videoPlayer" class="video-js vjs-default-skin vjs-big-play-centered" style="background:#343434;object-fit: fill;" autoplay>
            <source src="<?php echo base_url($bgPath)?>" type="video/mp4">
        </video>
        <script>
            var music = document.getElementById('music');
            var vplayer = videojs('videoPlayer',{controls:true,width:1280,height:712,preload:'auto',loop:false},function(){
                vplayer.on('play', function(){
                    music.play();
                    console.log('play');
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
    </div>
<?php }else{ ?>
<div class="dubbing-content">
    <div style="height: 100%; width:100%;">
       <img src="<?= base_url($bgPath);?>">
    </div>
</div>
<?php } ?>

<div class="comment-write">
    <div style="position: relative; height: 100%">
        <img src="<?= $imageAbsDir.'community/script/comment_write_bg.png'?>">
        <textarea class="form-control" rows="3" id="comment"></textarea>
    </div>
</div>

<div class="like-btn">
    <a id="vote_btn"><img src="<?= $imageAbsDir.'community/script/like_btn.png';?>"></a>
</div>

<div class="like-count" style="background: url(<?= base_url('assets/images/frontend/community/script/like_countbg.png')?>);background-size:100% 100%">
    <label id="vote_number_lbl"><?php if(strlen($vote_num)<2) echo '0'.$vote_num;else echo $vote_num; ?></label>
</div>

<div class="comment-btn">
    <a id = "addOnComment"><img src="<?= $imageAbsDir.'community/script/comment_btn.png';?>"></a>
</div>

<div class="comment-list">
    <div class="" id="totalCommentArea" style="text-align: left;">
        <?php foreach ($commentSets as $comemntItem):?>
            <div class="comment_item_area">
                <p style="font-weight: bold"><?= $comemntItem->fullname.'&nbsp&nbsp&nbsp&nbsp&nbsp'.$comemntItem->create_time;?></p>
                <p style="color:#6cc"><?= $comemntItem->comment_desc;?></p>
            </div>
        <?php endforeach;?>
    </div>
</div>

<script>
    var hdmenuImgPath = '<?= $hd_menu_img_path;?>';
    window.addEventListener('load', function(){
        var logedIn_UserId = '<?php echo $logged_In_user_id;?>';
        var contentId = '<?php echo $content_id;?>';
        var voteStatus = '0';
        var base_url = $('#base_url').val();
        $('.like-btn img').mouseenter(function(){
            $(this).attr('src', base_url + '/assets/images/frontend/community/script/like_btn_hover.png');
        });
        $('.like-btn img').mouseout(function(){
            $(this).attr('src', base_url + '/assets/images/frontend/community/script/like_btn.png');
        });
        $('.comment-btn img').mouseenter(function(){
            $(this).attr('src', base_url + '/assets/images/frontend/community/script/comment_btn_hover.png');
        });
        $('.comment-btn img').mouseout(function(){
            $(this).attr('src', base_url + '/assets/images/frontend/community/script/comment_btn.png');
        });

        var vote_lbl = $('#vote_number_lbl');
        $('#vote_btn').click(function () {
            if(voteStatus=='0') voteStatus='1';
            else voteStatus='0';
            $.ajax({
                type:'post',
                url:base_url+'community/update_voteNum',
                dataType:'json',
                data:{content_id:contentId,vote_status:voteStatus},
                success:function(res){
                    if(res.status=='success'){
                        var realvoteStr = (res.data.length<2)? ('0'+res.data):res.data;
                        vote_lbl.text(realvoteStr);
                    }else{
                        alert('Can not give vote numbers');
                    }
                }
            });
        });

        $('#addOnComment').click(function () {

            var comment_desc = $('#comment').val();
            $.ajax({
                type:"post",
                url:base_url+'community/add_comment',
                dataType:"json",
                data:{content_id:contentId,comment_user_id:logedIn_UserId,comment_desc:comment_desc},
                success:function(res){
                    if(res.status=='success'){
                        $('#totalCommentArea').html(res.data);
                        $('#comment').val('');
                    }else{

                        alert('Can not add comment');

                    }
                }

            });
        });

    })
</script>

<script>
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
    $('.back-btn').mouseover(function(){
        $('#back-btn-img').attr('src',base_url+"assets/images/frontend/studentwork/back_hover.png");
    });
    $('.back-btn').mouseout(function(){
        $('#back-btn-img').attr('src',base_url+"assets/images/frontend/studentwork/back.png");
    });
    $('.exit-btn').mouseout(function(){
        $('.exit_btn_img').attr('src',base_url+'assets/images/frontend/studentwork/exit.png');
    });
    $('.exit_btn_img').mouseover(function(){
        $('.exit_btn_img').attr('src',base_url+'assets/images/frontend/studentwork/exit_hover.png');
    });
</script>
<script src="<?= base_url('assets/js/frontend/menu_manage.js') ?>" type="text/javascript"></script>
