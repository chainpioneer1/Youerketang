<?php
$loged_In_user_id = $this->session->userdata("loginuserID");
$user_type = $this->session->userdata("user_type");
$imageAbsDir = base_url() . 'assets/images/frontend/';
$myworkURL = 'work/student';
$returnURL = 'work/student';
$course_menu_img_path = '';
if ($user_type == '2') {
    $myworkURL = 'work/script/' . $loged_In_user_id;
    $returnURL = 'coursewares/index';
    $hd_menu_img_path = $imageAbsDir . 'community/';
} else {
    $hd_menu_img_path = $imageAbsDir . 'community/stu_';
}
?>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/frontend/menu_manage.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/frontend/community_student_manage.css') ?>">
<!-----------------------------Custom Style---------------------------------------------------------------->

<div class="courseview-nav">
    <div class="mainnav-item"></div>
    <div class="mainnav-item"></div>
</div>

<!----------------------------------------------------------Task System Area--------------------------------------------------------------->
<div class="teachertask-list">
    <div class="community_list_wrapper" id="community_list_area">
    </div>
    <a href="#" class="previous_Btn"></a>
    <a href="#" class="next_Btn"></a>
    <!----------------------------------------------------------Search bar area--------------------------------------------------------------->
    <div class="search-bar" item_type="task">
        <div class="search-keyword">
            <input class="input-keyword">
            <div class="btn-search"></div>
        </div>
        <div class="select-searchtype" onclick="$('.select-searchtype-hover').fadeIn('fast');" sel_id="0"></div>
        <div class="select-searchtype-hover" onclick="$('.select-searchtype-hover').fadeOut('fast');">
            <div class="sel-tasktime" sel_id="0"></div>
            <div class="sel-taskname" sel_id="1"></div>
            <div class="sel-mark" sel_id="2"></div>
        </div>
        <div class="btn-newtask" style="display: none"></div>
    </div>
</div>
<!----------------------------------------------------------Sharing works Area--------------------------------------------------------------->
<div class="teachertask-sharing" style="display: none;">
    <div class="community_task_check">
        <div class="task-item-container" id="teacher-sharing-contents-container">
            <div class="my-task-item-wrapper" item_id="1">
                <div class="sharing-title">awer</div>
                <div class="sharing-author">awe5er</div>
                <div class="sharing-time">2018-03-20 13:32:04</div>
            </div>
            <div class="my-task-item-wrapper" item_id="2">
                <div class="sharing-title">awer</div>
                <div class="sharing-author">awe5er</div>
                <div class="sharing-time">2018-03-20 13:32:04</div>
            </div>
            <div class="my-task-item-wrapper" item_id="3">
                <div class="sharing-title">awer</div>
                <div class="sharing-author">awe5er</div>
                <div class="sharing-time">2018-03-20 13:32:04</div>
            </div>
        </div>
    </div>

    <a href="#" class="previous_Btn"></a>
    <a href="#" class="next_Btn"></a>

    <div class="search-bar" item_type="check">
        <div class="search-keyword">
            <input class="input-keyword">
            <div class="btn-search"></div>
        </div>
        <div class="select-searchtype" onclick="$('.select-searchtype-hover').fadeIn('fast');" sel_id="0"></div>
        <div class="select-searchtype-hover" onclick="$('.select-searchtype-hover').fadeOut('fast');">
            <div class="sel-sharetitle" sel_id="0"></div>
            <div class="sel-sharetime" sel_id="1"></div>
        </div>
        <a href="#" class="btn-uploadwork" style="display: none"></a>
    </div>

</div>

<div class="community_upload_work" style="display: none;">
    <input class="new-work-name">
    <textarea class="new-work-desc"></textarea>

    <input name="new_task_content_id" id="new_content_id" hidden>
    <input name="new_teacher_task_id" id="new_teacher_task_id" hidden>

    <div class="new-work-addcontents">
        <a class="new-work-content" item_type="1"></a>
        <div class="new-work-add-btn" onclick="new_work_add_content();"></div>
    </div>
    <a href="#" class="new-task-btn-save"></a>
    <a href="#" class="new-task-btn-cancel" onclick="$('.community_upload_work').hide('fast');"></a>
</div>
<form class="form-horizontal" enctype="multipart/form-data"
      action="" id="upload_media_submit_form" role="form" style="display: none"
      method="post" accept-charset="utf-8">
    <input type="file" id="upload_media_file"
           class="form-control"
           name="add_file_name" accept=".jpg,.png,.bmp,.gif,.mp4">
    <input id="upload_media_name" name="media_name">
    <input id="upload_media_type" name="media_type">
</form>
<div class="uploading_backdrop"></div>
<div class="progressing_area" style="display: none">
    <img id="wait_ajax_loader" src='<?php echo base_url('assets/images/frontend/ajax-loader-1.gif'); ?>'/>
    <span style="position: absolute;top: 43%;left: 43%;font-size:18px;color: #fff;z-index: 16000"><?= $this->lang->line('uploading') ?></span>
    <span id="progress_percent">0%</span>
</div>

<script>
    var myTaskSets = '<?php echo json_encode($myTaskList);?>';
    var myTeacherContentSets = '<?php echo json_encode($teacherContentsList);?>';

    $('.bg').css({background: 'url(' + baseURL + 'assets/images/frontend/community/community_student_bg.png'});
</script>
<script src="<?= base_url('assets/js/frontend/community_student_manage.js') ?>" type="text/javascript"></script>