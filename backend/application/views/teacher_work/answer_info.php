
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/frontend/teacher_work/teacher_work_answer_info.css') ?>">
<div class="bg" id="main-background-full"></div>
<div class="question_container" itemid="1">
<!--    <div class="title_container question_title"><div class="test_time_container"></div></div>-->
    <div class="question_list_container">
        <div class="question_head_container">
            <div class="time_text_container"><?=$endTime?></div>
        </div>
        <div class="question_body_container">
            <div class="question_list_item" itemid="1">
                <div class="option_btn">2次</div>
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
        </div>
    </div>
    <div class="question_footer">
        <div class="close_btn" onclick="history.go(-1)"></div>
    </div>
</div>
<script>
    console.log('<?php echo $answer_info;?>');
    var answerInfo = JSON.parse('<?php echo $answer_info;?>');
</script>
<script src="<?= base_url('assets/js/teacher_work/teacher_work_answer_info.js') ?>" type="text/javascript"></script>