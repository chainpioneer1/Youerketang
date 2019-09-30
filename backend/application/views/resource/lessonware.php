<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/frontend/lessonware.css') ?>">
<script>
    var imageDir = baseURL + "assets/images/resource/";
</script>
<div class="bg" id="main-background-full"></div>
<div class="btn-bar">
    <a class="sel-btn" itemid="1" href="<?= base_url('classroom') . '/index/' . $site_id ?>">课堂教学</a>
    <a class="sel-btn" itemid="2" href="<?= base_url('resource/lessonware') . '/' . $site_id ?>" style="border-bottom: 2px solid black;">我的备课</a>
    <a class="sel-btn" itemid="3" href="<?= base_url('resource/education') . '/' . $site_id ?>">参老资料</a>
    <a class="sel-btn" itemid="4" href="<?= base_url('teacher_work') . '/index/' . $site_id ?>">学生作业</a>
</div>
<div class="lessonware_container">
    <div class="lessonware_list_head">
        <div class="lessonware_add_btn">+新建备课</div>
    </div>
    <div class="lessonware_list_container">
        <?= $lessonList_content ?>
    </div>

</div>
<!--edit modal-->
<div id="lw_modify_modal" class="modal fade">
    <div class="click-event-sensor"></div>
    <div class="lw_username">
        <input type="text" id="uname" name="uname" required
               placeholder="输入新课件名称"/>
        <span class="name_remove_btn"></span>
    </div>
    <div class="lw_next_btn"></div>
</div>
</div>
<!--   edit modal  -->
<!----delete modal-->
<div id="lw_delete_modal" class="modal fade">
    <div class="msg-content">确认删除课件</div>
    <a id="delete_lw_item_btn""></a>
    <a data-dismiss="modal" id="no_lw_item_btn"></a>
</div>
<script>
    var lessonList = JSON.parse('<?php echo json_encode($lessonList);?>');
    var selectedIndex = <?php echo $selectedIndex;?>;
    var site_id = <?= $site_id ?>;
</script>
<script src="<?= base_url('assets/js/lessonware.js') ?>" type="text/javascript"></script>
