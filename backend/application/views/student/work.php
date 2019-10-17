<div class="bg"></div>

<div class="work-top-nav">
    <a href="<?= base_url('student/work/index/' . $site_id) ?>" class="work-task"></a>
    <a href="<?= base_url('student/work/history/' . $site_id) ?>" class="work-history"></a>
    <a href="<?= base_url('student/work/wrong/' . $site_id) ?>" class="work-wrong"></a>
</div>
<div class="work-frame" item_type="1">
    <div class="task-list-container"><?= $taskList ?></div>
</div>
<div class="work-frame" item_type="2">
    <div class="problem-item" item_type="1">
        <div class="prob-type">判断</div>
        <div class="prob-num">2 / 4</div>
        <div class="prob-img"></div>
        <div class="prob-sound"></div>
        <div class="ans-img" item_type="1">
            <div></div>
        </div>
        <div class="ans-img" item_type="2">
            <div></div>
        </div>
        <div class="ans-img" item_type="3">
            <div></div>
        </div>
        <div class="ans-img" item_type="4">
            <div></div>
        </div>
        <div class="ans-txt">a a a</div>
        <div class="ans-record"></div>
        <div class="ans-replay"></div>
        <div class="ans-right"></div>
        <div class="btn-prob-submit"></div>
        <div class="btn-prob-back"></div>
    </div>
</div>
<div class="work-frame" item_type="3">
    <div class="problem-result" item_type="1">
        <div class="star-set">
            <div class="star-item" item_id="0" item_type="1"></div>
            <div class="star-item" item_id="1" item_type="1"></div>
            <div class="star-item" item_id="2" item_type="1"></div>
            <div class="star-item" item_id="3" item_type="1"></div>
            <div class="star-item" item_id="4" item_type="1"></div>
        </div>
        <div class="btn-finish"></div>
    </div>
    <div class="problem-result" item_type="2" style="display: none">
        <div class="star-set">
            <div class="star-item" item_id="0" item_type="1"></div>
            <div class="star-item" item_id="1" item_type="1"></div>
            <div class="star-item" item_id="2" item_type="1"></div>
            <div class="star-item" item_id="3" item_type="0"></div>
            <div class="star-item" item_id="4" item_type="0"></div>
        </div>
        <div class="btn-goupdate"></div>
        <div class="btn-finish"></div>
    </div>
</div>
<div class="right-modal"></div>
<div class="wrong-modal">
    <div class="ans-right">B</div>
</div>

<script>
    var mTmr = 0;
    var reg_step = 1;
    var currentProblems;
    var currentStudentMark;
    var currentTaskId;
    var curId = 0;
    var bg_str = ['bg.png', 'bg-success.png', 'bg-fail.png'];
    var btn_str = ['apply', 'next'];
    var btnID = 0;
    var type_str = ['选择', '判断', '语音识别', '语音识别'];
    var btn_status = false;
    // 0:task list, 1:work start
    $(function () {
        showInterface();
    });

    function showInterface() {
        reg_step = 1;
        $('.work-frame').hide();
        $('.work-frame[item_type=' + (reg_step) + ']').fadeIn('fast');
        $('.bg').css({'background-image': 'url(' + baseURL + '/assets/images/student/work/' + bg_str[reg_step - 1] + ')'});
        $('.work-task').css({'background-image': 'url(' + baseURL + '/assets/images/student/work/work_task_hover.png'});
    }

    function showResult() {
        var marks = getMarks();
        reg_step = 3;
        $('.star-set .star-item').attr('item_type', '0');
        for (var i = 0; i < marks; i++) {
            $('.star-set .star-item[item_id="' + i + '"]').attr('item_type', '1');
        }
        $('.work-frame').hide();
        $('.work-frame[item_type=' + (reg_step) + ']').fadeIn('fast');
        $('.problem-result').hide();

        if (marks == 5) {
            $('.bg').css({'background-image': 'url(' + baseURL + '/assets/images/student/work/' + bg_str[1] + ')'});
            $('.problem-result[item_type="1"]').show();
        } else {
            $('.bg').css({'background-image': 'url(' + baseURL + '/assets/images/student/work/' + bg_str[2] + ')'});
//            $('.star-set').hide();
            $('.problem-result[item_type="2"]').show();
        }
        if (currentStudentMark != '6')
            $('.star-set').hide();
        else {
            $('.star-set').show();
            currentStudentMark = marks;
        }
    }

    $('.task-info[item_hover="1"]').on('click', function (object) {
        currentTaskId = JSON.parse($(this).attr('item_id'));
        currentStudentMark = $(this).attr('item_student_mark');
        currentProblems = JSON.parse($(this).attr('item_content'));
        curId = 0;
        startWork(curId);
    });

    $('.btn-prob-back').on('click', function (object) {
        reg_step = 1;
        showInterface();
    });
    $('.btn-prob-submit').on('click', function (object) {
        if (btn_status == true) return;
        btn_status = true;
        var sel_str = ['A', 'B', 'C', 'D'];
        var item = currentProblems[curId];
        if ($(this).attr('itemtype') == '1') {
            updateProblemStatus(item);
            return;
        }
        var student_answer = $('.ans-img[item_sel="1"]').attr('item_type');
        var result = 0;
        switch (item.prob_type) {
            case '1': // yesno problem
            case '2': // option problem
                if (student_answer == undefined) {
//                    alert('请选择一个');
                    return;
                }
                if (item.prob_answer == student_answer) result = 1;
                break;
            case '3': // audio play problem
            case '4': // audio recognition problem
                if (currentProblems[curId].ans_audio == undefined) {
                    return;
                }
                student_answer = 1;
                result = 1;
                break;
        }
        var answer_cnt = item.answer_cnt;
        if (answer_cnt == undefined) {
            answer_cnt = 1;
            item.student_first_answer = student_answer;
            item.student_first_result = result;
        } else answer_cnt++;
        item.answer_cnt = answer_cnt;
        item.student_answer = student_answer;
        item.result = result;
        if (result == 1) {
            $('.right-modal').fadeIn('fast');
            updateProblemStatus(item);
        } else {
            $('.wrong-modal .ans-right').html(sel_str[item.prob_answer - 1]);
            $('.wrong-modal').fadeIn('fast');
            btnID = 1;
            $('.btn-prob-submit').attr('data-status','next');
            $('.btn-prob-submit').attr('itemtype', '1');
            btn_status = false;
        }
    });

    function updateProblemStatus(item) {

        currentProblems[curId] = item;

        var marks = getMarks();
        var answer_type = 2;
        if (marks < 5)
            answer_type = 3;
        var last_spent_time = (new Date()).getTime() / 1000 - first_spent_time;

        $.ajax({
            type: "post",
            url: baseURL + "student/work/updateWork",
            dataType: "json",
            data: {
                answer_info: JSON.stringify(currentProblems),
                id: currentTaskId,
                student_mark: marks,
                answer_type: answer_type,
                spent_time: last_spent_time
            },
            success: function (res) {
                console.log(res);
                if (res.status == 'success') {
                    setTimeout(function () {
                        btn_status = false;
                        $('.right-modal').fadeOut('fast');
                        $('.wrong-modal').fadeOut('fast');
                        curId++;
                        if (curId < currentProblems.length)
                            startWork(curId);
                        else
                            showResult();
                    }, 700);
                } else//failed
                {
                    alert("Cannot change answer status.");
                }
            }
        });
    }

    function getMarks() {
        var marks = 0;
        var modified = 0;
        for (var i = 0; i < currentProblems.length; i++) {
            item = currentProblems[i];
            if (item.result == 1) marks++;
        }
        return Math.ceil(5 * marks / currentProblems.length);
    }

    var spent_time = 0;
    var first_spent_time = 0;

    function startWork(id) {
        first_spent_time = (new Date()).getTime() / 1000;
        reg_step = 2;
        btn_status = false;
        var item = currentProblems[id];
        if (item.hasOwnProperty('result') && item.result == 1) {
            curId++;
            if (curId < currentProblems.length) {
                startWork(curId);
            } else {
                showResult();
//                location.reload();
//                curId = 0;
//                showInterface();
            }
            return;
        }
        btnID = 0;
        $('.btn-prob-submit').removeAttr('data-status');
        $('.btn-prob-submit').attr('itemtype', '0');
        $('.work-frame').hide();
        $('.problem-item .ans-img').removeAttr('item_sel');
        if (item.prob_type != 4)
            $('.bg').css({'background-image': 'url(' + baseURL + '/assets/images/student/work/bg-test' + item.prob_type + '.png)'});
        else
            $('.bg').css({'background-image': 'url(' + baseURL + '/assets/images/student/work/bg-test3.png)'});

        $('.prob-type').html(type_str[parseInt(item.prob_type) - 1]);
        $('.prob-num').html((id + 1) + ' / ' + currentProblems.length);
        if (item.prob_img != null) {
            $('.prob-img').css({'background-image': 'url(' + baseURL + '/' + item.prob_img + ')'});
            $('.prob-img').show();
        } else {
            $('.prob-img').hide();
        }
        if (item.prob_sound != null) {
            $('.prob-sound').attr('item_src', baseURL + '/' + item.prob_sound);
            $('.prob-sound').show();
        } else {
            $('.prob-sound').hide();
        }
        if (item.ans_img1 != null) {
            $('.ans-img[item_type="1"] div').css({'background-image': 'url(' + baseURL + '/' + item.ans_img1 + ')'});
            $('.ans-img[item_type="1"]').show();
        } else {
            $('.ans-img[item_type="1"]').hide();
        }
        if (item.ans_img2 != null) {
            $('.ans-img[item_type="2"] div').css({'background-image': 'url(' + baseURL + '/' + item.ans_img2 + ')'});
            $('.ans-img[item_type="2"]').show();
        } else {
            $('.ans-img[item_type="2"]').hide();
        }
        if (item.ans_img3 != null) {
            $('.ans-img[item_type="3"] div').css({'background-image': 'url(' + baseURL + '/' + item.ans_img3 + ')'});
            $('.ans-img[item_type="3"]').show();
        } else {
            $('.ans-img[item_type="3"]').hide();
        }
        if (item.ans_img4 != null) {
            $('.ans-img[item_type="4"] div').css({'background-image': 'url(' + baseURL + '/' + item.ans_img4 + ')'});
            $('.ans-img[item_type="4"]').show();
        } else {
            $('.ans-img[item_type="4"]').hide();
        }
        if (item.ans_txt != null) {
            $('.ans-txt').html(item.ans_txt);
            $('.ans-txt').show();
        } else {
            $('.ans-txt').hide();
        }
        switch (item.prob_type) {
            case '2':
                $('.ans-img[item_type="1"] div').css({'background-image': 'url(' + baseURL + '/assets/images/student/work/yes.png)'});
                $('.ans-img[item_type="2"] div').css({'background-image': 'url(' + baseURL + '/assets/images/student/work/no.png)'});
                $('.ans-img[item_type="1"]').show();
                $('.ans-img[item_type="2"]').show();
                $('.ans-img[item_type="3"]').hide();
                $('.ans-img[item_type="4"]').hide();
            case '1':
                $('.ans-txt').hide();
                $('.ans-record').hide();
                $('.ans-replay').hide();
                $('.ans-img[item_type="' + item.student_answer + '"]').attr('item_sel', '1');
                break;
            case '3':
            case '4':
                $('.ans-img[item_type="1"]').hide();
                $('.ans-img[item_type="2"]').hide();
                $('.ans-img[item_type="3"]').hide();
                $('.ans-img[item_type="4"]').hide();
                $('.ans-record').show();
                $('.ans-replay').show();
                break;
        }
        $('.work-frame[item_type="2"]').fadeIn('fast');
    }

    $('.problem-item .ans-img').on('click', function (object) {
        btn_status = false;
        $('.problem-item .ans-img').removeAttr('item_sel');
        $(this).attr('item_sel', '1');
        $('.btn-prob-submit').attr('data-status',1);
    })
    $('.btn-finish').on('click', function (object) {
        location.reload();
//        $('.btn-prob-back').trigger('click');
    })
    $('.btn-goupdate').on('click', function (object) {
        curId = 0;
        startWork(curId);
//        $('.btn-prob-back').trigger('click');
    })

    var effectSound = new Audio();
    var soundOldCallback;

    function effecSoundPlay(filename, callback) {
        effectSound.pause();
        // effectSound.currentTime = 0;
        if (soundOldCallback != undefined)
            effectSound.removeEventListener('ended', soundOldCallback);
        if (filename == '') return;
        effectSound.src = filename;
        effectSound.play();
        soundOldCallback = callback;
        effectSound.addEventListener('ended', callback);
    }

    var interval, imgId = 0;
    $('.prob-sound').on('click', function (object) {
        effecSoundPlay('');
        if (imgId == 0) {
            interval = setInterval(function () {
                imgId++;
                if (imgId > 4) imgId = 1;
                $('.prob-sound').css({
                    'background-image': 'url(' + baseURL + 'assets/images/student/work/play' + imgId + '.png)'
                })
            }, 500);
            effecSoundPlay($(this).attr('item_src'), stopSound);
        } else stopSound();
    });

    function stopSound() {
        effecSoundPlay('');
        imgId = 0;
        clearInterval(interval);
        $('.prob-sound').css({'background-image': 'url(' + baseURL + 'assets/images/student/work/play.png)'})
        $('.ans-replay').removeAttr('item_sel');
        problemAnswerAudioPause();
    }

    $('.ans-record').on('click', function (object) {
        effecSoundPlay('');
        if (imgId == 0) {
            interval = setInterval(function () {
                imgId++;
                if (imgId > 4) imgId = 1;
                $('.ans-record').css({'background-image': 'url(' + baseURL + 'assets/images/student/work/record' + imgId + '.png)'})
            }, 500);
            $('.ans-record').attr('item_sel', '1');
            problemAnswerAudioRecord();
//            effecSoundPlay($(this).attr('item_src'), stopRecord);
        } else stopRecord();
    });

    function stopRecord() {
        stopSound();
        problemAnswerAudioRecordStop(currentTaskId, curId);
        imgId = 0;
        clearInterval(interval);
        $('.ans-record').css({'background-image': 'url(' + baseURL + 'assets/images/student/work/record.png)'})
        currentProblems[curId].ans_audio = 'uploads/problem_set/answer/' + currentTaskId + "_" + curId + "_" + 'answer_mp3.mp3';
        btn_status = false;
        $('.ans-record').removeAttr('item_sel');
        $('.btn-prob-submit').attr('data-status',1);
    }

    $('.ans-replay').on('click', function () {
        var status = $(this).attr('item_sel');
        if (status != '1' && currentProblems[curId].ans_audio != undefined) {
            $(this).attr('item_sel', '1');
            var audio_path = currentProblems[curId].ans_audio;
            audio_path = baseURL + audio_path;
            console.log("--------------" + audio_path);
            effecSoundPlay(audio_path, stopSound);
            interval = setInterval(function () {
            }, 500);
            $('.ans-replay').attr('item_sel', '1');
            problemAnswerAudioPlay();
        } else {
            stopSound()
            problemAnswerAudioPause();
        }
    })

</script>
