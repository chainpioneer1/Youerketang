<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/frontend/teacher_work/teacher_work_testing_index.css') ?>">
<div class="bg" id="main-background-full"></div>
<div class="btn-bar">
    <a class="sel-btn" itemid="1" href="<?= base_url('classroom') . '/index/' . $site_id ?>">课堂教学</a>
    <a class="sel-btn" itemid="2" href="<?= base_url('resource/lessonware') . '/' . $site_id ?>">我的备课</a>
    <a class="sel-btn" itemid="3" href="<?= base_url('resource/education') . '/' . $site_id ?>">参老资料</a>
    <a class="sel-btn" itemid="4" href="<?= base_url('teacher_work') . '/index/' . $site_id ?>" style="border-bottom: 2px solid black;">学生作业</a>
</div>
<div class="testing_container">
<!--    <div class="title_container class_title"></div>-->
    <div class="class_container">
        <div class="sort_container">
            <select class="class-select" onchange="changeClass(this)">
                <option value="0">全部</option>
                <option value="1">一年级一班</option>
                <option value="2">一年级二班</option>
            </select>
            <select class="status-select" onchange="changeCheckResult(this)">
                <option value="0">全部</option>
                <option value="2">已查阅</option>
                <option value="1">待查阅</option>
            </select>
        </div>
        <div class="class_list_container">
            <div class="check_item" itemid="1">
                <div class="working_name">作业20180208</div>
                <div class="class_name">一年级一班</div>
                <div class="comp">完成 ：8/25</div>
                <div class="disable_time">截止时间 ：2018-03-01 22:22</div>
                <div class="checked_flag"></div>
            </div>

            <div class="check_item" itemid="2">
                <div class="working_name">作业20180208</div>
                <div class="class_name">一年级一班</div>
                <div class="comp">完成 ： 8/25</div>
                <div class="disable_time">截止时间 ：2018-03-01 22:22</div>
                <div class="checked_flag"></div>
            </div>
        </div>
    </div>

    <div class="next_container class_next_btn" onclick="bulkDetailedTesting(this)"></div>
    <div class="next_container class_create_btn" onclick="location.href=baseURL+'teacher_work/deliver';"></div>
</div>
<script>
    var checkList = JSON.parse('<?php echo json_encode($checkList);?>');
    var class_list = JSON.parse('<?php echo json_encode($class_list);?>');
</script>
<script src="<?= base_url('assets/js/teacher_work/teacher_work_testing_index.js') ?>" type="text/javascript"></script>