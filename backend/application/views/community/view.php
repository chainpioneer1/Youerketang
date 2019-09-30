<?php
$loged_In_user_id = $this->session->userdata("loginuserID");
$imageAbsDir =  base_url().'assets/images/frontend/';
$user_type = $this->session->userdata("user_type");
$myworkURL = 'work/student';
$hd_menu_img_path = '';
if($user_type=='2'){
    $myworkURL = 'work/script/'.$loged_In_user_id;
    $hd_menu_img_path = $imageAbsDir.'studentwork/';
}else{
    $hd_menu_img_path = $imageAbsDir.'studentwork/stu_';
}
?>
<link rel="stylesheet" href="<?= base_url('assets/css/frontend/community_view.css')?>">

<input type="hidden" id="base_url" value="<?= base_url()?>">
<div class="bg">
    <img src="<?= base_url('assets/images/frontend/community/script/bg.jpg')?>" class="background_image">
</div>
<div class="hdmenu">
    <?php if($this->session->userdata("loggedin") != FALSE): ?>
        <div style="position: relative; height: 100%">
            <img class = "hdmenu_img" src="<?= $hd_menu_img_path.'hdmenu_normal.png';?>">
            <a id = "hdmenu_studentwork" href="<?= base_url($myworkURL);?>" style="top: 27.2%; left: 1.1%; width: 31.9%; height: 48.5%;"></a>
            <a id = "hdmenu_profile" href="<?= base_url().'users/profile/'.$loged_In_user_id;?>" style="top: 3.9%; left: 37.1%; width: 26.1%; height: 90.4%;"></a>
            <a id = "hdmenu_community" href="<?= base_url().'community/index';?>" style="top: 27.2%; left: 67%; width: 31.9%; height: 48.5%;"></a>
        </div>
    <?php endif; ?>
</div>

<div class="exit-btn">
    <?php if($this->session->userdata("loggedin") == FALSE): ?>
        <a href="<?= base_url('signin/index')?>">
            <img src="<?= base_url('assets/images/frontend/coursewares/register.png')?>"></a>
    <?php else: ?>
        <a href="<?= base_url('signin/signout')?>">
            <img class="exit_btn_img" src="<?= base_url('assets/images/frontend/coursewares/exit.png')?>"></a>
    <?php endif; ?>
</div>

<div class="back-btn">
    <a href="#" onclick="history.go(-1)" >
        <img id ="back-btn-img" src="<?= base_url('assets/images/frontend/studentwork/back.png')?>">
    </a>
</div>

<div class="avatar-frame">
    <div style="position: relative; height: 100%">
        <img src="<?= base_url().'assets/images/frontend/contents-profile.jpg'?>" class="avatar-img" style="z-index: -1">
        <img src="<?= base_url('assets/images/frontend/community/script/avatar_frame.png')?>">
        <label class="user-name"><?= $user_nickname;?></label>
        <label class="school-name"><?= $user_school;?></label>
    </div>
</div>

<div class="script-title">
    <div style="text-align: center;">
        <h1><?php echo $content_title; ?></h1>
    </div>
</div>

<div class="script-content">
    <div style="height: 100%; overflow: auto">
        <?php if($content_type_id=='1') {?>
           <div class="script-content-area">
               <?= $scriptText; ?>;
           </div>
        <?php }else if($content_type_id=='5'){?>
            <div style="text-align: center;">
                <img style="position: absolute;left:9%;top: 0;width:82%;height:100%;" src="<?= base_url().$headImagePath;?>">
            </div>
        <?}else if($content_type_id=='6'){
            ?>
        <?php }?>
    </div>
</div>

<div class="comment-write">
    <div style="position: relative; height: 100%">
        <img src="<?= base_url('assets/images/frontend/community/script/comment_write_bg.png')?>">
        <textarea class="form-control" rows="3" id="comment"></textarea>
    </div>
</div>

<div class="like-btn">
    <a id="vote_btn"><img src="<?= base_url('assets/images/frontend/community/script/like_btn.png')?>"></a>
</div>

<div class="like-count" style="background: url(<?= base_url('assets/images/frontend/community/script/like_countbg.png')?>);background-size:100% 100%">
    <label id="vote_number_lbl"><?php if(strlen($vote_num)<2) echo '0'.$vote_num;else echo $vote_num; ?></label>
</div>

<div class="comment-btn">
    <a id = "addOnComment"><img src="<?= base_url('assets/images/frontend/community/script/comment_btn.png')?>"></a>
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
        var logedIn_UserId = '<?php echo $loged_In_user_id;?>';
        var contentId = '<?php echo $content_id;?>';
        var base_url = $('#base_url').val();
        var voteStatus = '0';
        console.log(base_url);

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
    })
</script>
<script src="<?= base_url('assets/js/frontend/menu_manage.js') ?>" type="text/javascript"></script>