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
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/js/datetimepicker/jquery.simple-dtpicker.css') ?>">
<!--<link rel="stylesheet" type="text/css" href="--><? //= base_url('assets/css/frontend/menu_manage.css') ?><!--">-->
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/frontend/community_manage.css') ?>">

<!----------------------------------------------------------Filter Buttons By Work Types--------------------------------------------------------------------------->

<div class="courseview-nav">
    <?php
    for ($i = 0; $i < 2; $i++) {
        echo '<div class="mainnav-item"></div>';
    }
    ?>
</div>

<!----------------------------------------------------------Task System Area--------------------------------------------------------------->
<div class="teachertask-list" style="">
    <div class="community_list_wrapper" id="community_list_area">

        <div class="comm_item_wrapper" style="top:10%; display: none;">
            <div class="comm_school">abc</div>
            <a class="comm_author" href="abc">abc</a>
            <div class="comm_shareTime">asd</div>

            <div class="comm_title">
                <div class="btn-delete"></div>
                <div class="btn-update"></div>
                <div class="btn-deploy"></div>
            </div>
            <div class="comm_viewNum">完成:12<a href="asd" class="btn-preview"></a>
            </div>
        </div>

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
            <div class="sel-taskname" sel_id="0"></div>
            <div class="sel-tasktime" sel_id="1"></div>
            <div class="sel-class" sel_id="2"></div>
        </div>
        <div class="btn-newtask"></div>
    </div>
</div>

<div class="community_new_task" style="display: none;">
    <input class="new-task-name">
    <textarea class="new-task-desc"></textarea>
    <div class="new-task-addcontents">
        <a class="new-task-content" item_type="1" item_path=""></a>
        <div class="new-task-add-btn" onclick="new_task_add_content();"></div>
    </div>
    <div class="new-task-class">
        <input class="add-class-input" disabled>
        <div class="add-class-btn"></div>
        <div class="add-class-list">
            <?php
            foreach ($teacherClassList as $item) {
                echo '<div class="add-class-item">' . $item . '</div>';
            }
            ?>
        </div>
    </div>

    <input class="new-task-deadtime" name="date10" style="display: none;">
    <div class="new-task-deadtime">
        <div>
            <select class="time-year">
                <option>2018-3-25</option>
            </select>
        </div>
        <div>
            <select class="time-hr-min">
                <option>01:00</option>
            </select>
        </div>
    </div>

    <a href="#" class="new-task-btn-save" onclick="new_task_save();"></a>
    <a href="#" class="new-task-btn-cancel" onclick="$('.community_new_task').hide('fast');"></a>
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

<div class="teachertask-student-check" style="display: none;">
    <div class="community_task_check">
        <div class="task-item-container">
            <div class="task-check-item" item_id="1">
                <div class="check-item-student">awer</div>
                <div class="check-item-status">awe5er</div>
                <div class="check-item-content">
                    <a href="#" class="btn-view"></a>
                </div>
                <div href="#" class="check-item-mark">
                    <div class="check-item-star" mark_id="1"></div>
                    <div class="check-item-star" mark_id="2"></div>
                    <div class="check-item-star" mark_id="3"></div>
                    <div class="check-item-star" mark_id="4"></div>
                    <div class="check-item-star" mark_id="5"></div>
                </div>
            </div>
            <div class="task-check-item" item_id="2">
                <div class="check-item-student">awer</div>
                <div class="check-item-status">awe5er</div>
                <div class="check-item-content">
                    <a href="#" class="btn-view"></a>
                </div>
                <div href="#" class="check-item-mark">
                    <div class="check-item-star" mark_id="1"></div>
                    <div class="check-item-star" mark_id="2"></div>
                    <div class="check-item-star" mark_id="3"></div>
                    <div class="check-item-star" mark_id="4"></div>
                    <div class="check-item-star" mark_id="5"></div>
                </div>
            </div>
            <div class="task-check-item" item_id="3">
                <div class="check-item-student">awer</div>
                <div class="check-item-status">awe5er</div>
                <div class="check-item-content">
                    <a href="#" class="btn-view"></a>
                </div>
                <div href="#" class="check-item-mark">
                    <div class="check-item-star" mark_id="1"></div>
                    <div class="check-item-star" mark_id="2"></div>
                    <div class="check-item-star" mark_id="3"></div>
                    <div class="check-item-star" mark_id="4"></div>
                    <div class="check-item-star" mark_id="5"></div>
                </div>
            </div>
            <div class="task-check-item" item_id="4">
                <div class="check-item-student">awer</div>
                <div class="check-item-status">awe5er</div>
                <div class="check-item-content">
                    <a href="#" class="btn-view"></a>
                </div>
                <div href="#" class="check-item-mark">
                    <div class="check-item-star" mark_id="1"></div>
                    <div class="check-item-star" mark_id="2"></div>
                    <div class="check-item-star" mark_id="3"></div>
                    <div class="check-item-star" mark_id="4"></div>
                    <div class="check-item-star" mark_id="5"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="search-bar" item_type="check">
        <div class="search-keyword">
            <input class="input-keyword">
            <div class="btn-search"></div>
        </div>
        <div class="select-searchtype" onclick="$('.select-searchtype-hover').fadeIn('fast');" sel_id="0"></div>
        <div class="select-searchtype-hover" onclick="$('.select-searchtype-hover').fadeOut('fast');">
            <div class="sel-student" sel_id="0"></div>
            <div class="sel-status" sel_id="1"></div>
            <div class="sel-reviewed" sel_id="2"></div>
            <div class="sel-unviewed" sel_id="3"></div>
        </div>
        <a href="#" class="btn-back2view" onclick="$('.teachertask-student-check').hide('fast');"></a>
    </div>
</div>

<!----------------------------------------------------------Sharing works Area--------------------------------------------------------------->
<div class="teachertask-sharing" style="display: none;">
    <div class="community_task_check">
        <div class="task-item-container">
            <div class="task-check-item" item_id="1">
                <div class="sharing-title">awer</div>
                <div class="sharing-author">awe5er</div>
                <div class="sharing-time">2018-03-20 13:32:04</div>
                <div href="#" class="sharing-operation">
                    <div class="btn-share"></div>
                    <div class="btn-delete"></div>
                    <div class="btn-update"></div>
                </div>
            </div>
            <div class="task-check-item" item_id="2">
                <div class="sharing-title">awer</div>
                <div class="sharing-author">awe5er</div>
                <div class="sharing-time">2018-03-20 13:32:04</div>
                <div href="#" class="sharing-operation">
                    <div class="btn-unshare"></div>
                    <div class="btn-delete"></div>
                    <div class="btn-update"></div>
                </div>
            </div>
            <div class="task-check-item" item_id="3">
                <div class="sharing-title">awer</div>
                <div class="sharing-author">awe5er</div>
                <div class="sharing-time">2018-03-20 13:32:04</div>
                <div href="#" class="sharing-operation">
                    <div class="btn-share"></div>
                    <div class="btn-delete"></div>
                    <div class="btn-update"></div>
                </div>
            </div>
        </div>
    </div>

    <a href="#" class="previous_Btn"></a>
    <a href="#" class="next_Btn_sharing"></a>

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
        <a href="#" class="btn-uploadwork" onclick=""></a>
    </div>

</div>

<div class="community_upload_work" style="display: none;">

    <input class="new-work-name">
    <textarea class="new-work-desc"></textarea>
    <div class="new-work-addcontents">
        <a class="new-work-content" item_type="1"></a>
        <div class="new-work-add-btn" onclick="new_work_add_content();"></div>
    </div>

    <a href="#" class="new-work-btn-save" onclick="new_work_save();"></a>
    <a href="#" class="new-work-btn-cancel" onclick="$('.community_upload_work').hide('fast');"></a>
</div>

<div class="uploading_backdrop"></div>
<div class="progressing_area" style="display: none">
    <img id="wait_ajax_loader" src='<?php echo base_url('assets/images/frontend/ajax-loader-1.gif'); ?>'/>
    <span style="position: absolute;top: 43%;left: 43%;font-size:18px;color: #fff;z-index: 16000"><?= $this->lang->line('uploading') ?></span>
    <span id="progress_percent">0%</span>
</div>
<input id="contentList" value='<?php echo json_encode($contentList);?>' style="display: none;">
<script>
    var cur_workstatus = '1';
    var initStatus = 'NOCLICKEDTYPE';
    var contentSets = $('#contentList').val();
    var hdmenuImgPath = '<?= $hd_menu_img_path;?>';
    var bgPath =
    $(function () {
        $('.bg').css({'background': 'url(' + baseURL + 'assets/images/frontend/community/comm_bg_task.png)'});
    })

</script>
<script src="<?= base_url('assets/js/datetimepicker/jquery.simple-dtpicker.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/frontend/community_manage.js') ?>" type="text/javascript"></script>