
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/frontend/teacher_work/teacher_work_deliver_index.css') ?>">
<div class="bg" id="main-background-full"></div>
<div class="deliver_container" itemid="1" style="display: none">
    <div class="title_container class_title"></div>
    <div class="class_list_container">
        <div class="class_list_item" itemid="1">
            <div class="check_container" onclick="checkClass(this)"></div>
            <div class="check_classname_container">一年级一班</div>
        </div>
    </div>
    <div class="next_container class_next_btn" onclick="selectClass(this)"></div>
</div>
<div class="deliver_container" itemid="2" style="display: none">
    <div class="title_container name_title"></div>
    <div class="input_container">
        <input type="text" id="uname" name="uname" required placeholder="请输入作业的名称" />
        <span class="name_remove_btn" onclick="removeName(this)"></span>
    </div>
    <div class="next_container name_next_btn" onclick="selectClass(this)"></div>
</div>
<div class="deliver_container" itemid="3" style="display: none">
    <div class="title_container course_list_title"></div>
    <div class="course_list_container">
        <div class="course_bg_container"></div>
        <div class="course_list_content_container" style="top:0;left: 0;width: 100%;height: 100%;z-index: 1000;">
            <div class="course_list_item" itemid="1">
                <div class="course_check_container"></div>
            </div>
        </div>
    </div>
    <div class="next_container course_next_btn" onclick="selectClass(this)"></div>
</div>
<div class="question_container" itemid="4" style="display: none">
    <div class="title_container question_title">
    </div>
    <div class="test_time_container">
        <input type="number" maxlength="3" min="1" id="timetext" required placeholder="" value="">
    </div>
    <div class="all_option_btn" itemflag="0" onclick="selectAllProblems(this)"></div>
    <div class="question_list_container">
        <div class="question_list_item" itemid="1">
            <div class="option_btn"></div>
            <div class="prob_type_img"></div>
            <div class="prob_img"></div>
            <div class="speaker_btn"></div>
            <div class="seperate_container"></div>
            <div class="answer_container">
                <div class="answer_item" itemid="1">
                    <div class="answer_title">A</div>
                    <div class="answer_bg">
                        <div class="answer_btn" style="background: url(<?=base_url('uploads/problem_set/1.png')?>) no-repeat;"></div>
                    </div>
                </div>
                <div class="answer_item" itemid="2">
                    <div class="answer_title">B</div>
                    <div class="answer_bg">
                        <div class="answer_btn" style="background: url(<?=base_url('uploads/problem_set/1.png')?>) no-repeat;"></div>
                    </div>
                </div>
                <div class="answer_item" itemid="3">
                    <div class="answer_title">C</div>
                    <div class="answer_bg">
                        <div class="answer_btn" style="background: url(<?=base_url('uploads/problem_set/1.png')?>) no-repeat;"></div>
                    </div>
                </div>
                <div class="answer_item" itemid="4">
                    <div class="answer_title">D</div>
                    <div class="answer_bg">
                        <div class="answer_btn" style="background: url(<?=base_url('uploads/problem_set/1.png')?>) no-repeat;"></div>
                    </div>
                </div>
            </div>
            <div class="display_btn"></div>
        </div>
        <div class="question_list_item" itemid="2">
            <div class="option_btn"></div>
            <div class="prob_type_img"></div>
            <div class="prob_img"></div>
            <div class="speaker_btn"></div>
            <div class="seperate_container"></div>
            <div class="answer_container">
                <div class="answer_item" itemid="1">
                    <div class="answer_title">A</div>
                    <div class="answer_bg">
                        <div class="answer_btn" itemid="1"></div>
                    </div>
                </div>
                <div class="answer_item" itemid="2">
                    <div class="answer_title">B</div>
                    <div class="answer_bg">
                        <div class="answer_btn" itemid="2"></div>
                    </div>
                </div>
            </div>
            <div class="display_btn"></div>
        </div>
        <div class="question_list_item" itemid="3">
            <div class="option_btn"></div>
            <div class="prob_type_img"></div>
            <div class="prob_img"></div>
            <div class="speaker_btn"></div>
            <div class="seperate_container"></div>
            <div class="answer_container">
                <div class="play_container"></div>
            </div>
            <div class="display_btn"></div>
        </div>
        <div class="question_list_item" itemid="4">
            <div class="option_btn"></div>
            <div class="prob_type_img"></div>
            <div class="prob_img"></div>
            <div class="speaker_btn"></div>
            <div class="seperate_container"></div>
            <div class="answer_container">
                <div class="answer_text">aaa</div>
                <div class="play_container"></div>
            </div>
            <div class="display_btn"></div>
        </div>
        <div class="question_list_item" itemid="1">
            <div class="option_btn"></div>
            <div class="prob_type_img"></div>
            <div class="prob_img"></div>
            <div class="speaker_btn"></div>
            <div class="seperate_container"></div>
            <div class="answer_container">
                <div class="answer_item" itemid="1">
                    <div class="answer_title">A</div>
                    <div class="answer_bg">
                        <div class="answer_btn"></div>
                    </div>
                </div>
                <div class="answer_item" itemid="2">
                    <div class="answer_title">B</div>
                    <div class="answer_bg">
                        <div class="answer_btn"></div>
                    </div>
                </div>
                <div class="answer_item" itemid="3">
                    <div class="answer_title">C</div>
                    <div class="answer_bg">
                        <div class="answer_btn"></div>
                    </div>
                </div>
                <div class="answer_item" itemid="4">
                    <div class="answer_title">D</div>
                    <div class="answer_bg">
                        <div class="answer_btn"></div>
                    </div>
                </div>
            </div>
            <div class="display_btn"></div>
        </div>

    </div>
    <div class="ans_info_msg"></div>
    <div class="question_footer">
        <div class="add_btn" onclick="addPackage(this)"></div>
        <div class="display_status"></div>
        <div class="layout_job_btn" onclick="layoutJob(this)"></div>
        <div class="question_next_btn" onclick="decideQuestion(this)"></div>
    </div>
</div>
<div class="confirm_container" style="display: none">
    <div class="title_container confirm_title"></div>
    <div class="confirm_win_container">
        <div class="confirm_bg"></div>
        <div class="confirm_class_name">一年级1班</div>
        <div class="confirm_date_container">
            <input class="datetime_text" type="datetime" readonly>
        </div>
    </div>
    <div class="next_container confirm_next_btn" onclick="confirm(this)"></div>
</div>
<!----success modal-->
<div id="success_modal" class="modal fade" >
    <a data-dismiss="modal" id="return_success_btn" onclick="hideModal(this)"></a>
</div>
<script>
    var class_list = JSON.parse('<?php echo json_encode($class_list);?>');
    var site_id = <?= $this->session->userData('_siteID') ?>;
</script>
<script src="<?= base_url('assets/js/teacher_work/teacher_work_deliver_index.js') ?>" type="text/javascript"></script>