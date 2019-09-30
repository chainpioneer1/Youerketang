<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/frontend/lessonware_home.css') ?>">
<script>
    var imageDir = baseURL + "assets/images/resource/";
</script>
<div class="bg" id="main-background-full"></div>
<div class="title_container">
    <input type="text" id="title_input" disabled="disabled" name="uname" value=""/>
    <div class="title_edit"></div>
</div>
<div class="preview-btn"></div>
<div class="lessonware_home_container">
    <div class="home_list_item" itemid="1">
        <div class="home_list_item_icon" itemid="1"></div>
        <div class="delete_home_item_btn" onclick="deleteHomeListItem()" itemid="1"></div>
        <div class="home_list_item_label" itemid="1">a的书写</div>
    </div>
</div>
<div class="lessonware_home_course_container">
    <div class="source_btn"></div>
    <div class="local_btn"></div>
    <div class="course_source_container">
        <div class="course_list_container">
            <div class="course_list_item" itemid="1">
                <div class="course_list_item_label">a的认读</div>
                <div class="course_list_item_play_btn"></div>
            </div>
        </div>
        <div class="lesson_list_container">
            <div class="lesson_list_item"></div>
        </div>
    </div>
    <div class="course_local_container">
        <div class="added_course_list_container">
            <div class="course_list_item" itemid="1">
                <div class="course_list_item_label">a的认读</div>
                <div class="course_list_item_play_btn"></div>
            </div>
        </div>
        <div class="upload_container">
            <div class="upload_btn"></div>
        </div>

    </div>
</div>

<form class="form-horizontal" enctype="multipart/form-data"
      action="" id="upload_lw_submit_form" role="form" style="display: none"
      method="post" accept-charset="utf-8">
    <input type="file" id="upload_lw_courseware" class="form-control" name="add_file_name"
           accept=".mp4,.mp3,.wav,.png,.jpg,.pdf,.html">
    <input id="upload_lw_name" name="upload_lw_name">
    <input id="upload_userId" name="upload_userId">
    <input id="upload_lesson_id" name="upload_lesson_id">
    <input id="upload_lw_type" name="upload_lw_type">
</form>

<div class="uploading_backdrop"></div>
<div class="progressing_area" style="display: none">
    <img id="wait_ajax_loader" src='<?php echo base_url('assets/images/ajax-loader.gif'); ?>'/>
    <span style="position: absolute;top: 43%;left: 43%;font-size:18px;color: #fff;z-index: 16000"><?= $this->lang->line('uploading') ?></span>
    <span id="progress_percent">0%</span>
</div>

<div class="cancel_btn"></div>
<div class="save_btn"></div>
<!--edit modal-->
<div id="lw_modify_modal" class="modal fade">
    <div class="lw_username">
        <label class="lw_username_label" for="uname">课件名称:</label>
        <input type="text" id="uname" name="uname" required
               placeholder="输入新建课件名称"/>
        <span class="validity"></span>
    </div>
    <div class="lw_next_btn"></div>
</div>
<iframe class="lessonware_toolset" style="display: none;"></iframe>
<!--   edit modal  -->
<!----delete modal-->
<div id="lw_delete_modal" class="modal fade">
    <a id="delete_lw_item_btn" onclick="cancelEdit(this)" delete_lw_id="1"></a>
    <a data-dismiss="modal" id="no_lw_item_btn"></a>
</div>
<div class="scripts">
<script>

    var lessonList = JSON.parse('<?php echo json_encode($lessonList);?>');
    var packageList = JSON.parse('<?php echo json_encode($packageList);?>');
    var courseList = JSON.parse('<?php echo json_encode($courseList);?>');
    var loggedUserId = "<?= $this->session->userdata('loginuserID')?>";
    var processIndex = <?php echo $processIndex;?>;
    var selectedIndex = <?php echo $selectedIndex;?>;
    var site_id = <?= $site_id ?>;
    $('.scripts').remove();
</script>
</div>
<script src="<?= base_url('assets/js/lessonware_home.js') ?>" type="text/javascript"></script>
