<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/student/work-history.css') ?>">
<div class="bg"></div>

<div class="work-top-nav">
    <a href="<?= base_url('student/work/index/'.$site_id) ?>" class="work-task"></a>
    <a href="<?= base_url('student/work/history/'.$site_id) ?>" class="work-history"></a>
    <a href="<?= base_url('student/work/wrong/'.$site_id) ?>" class="work-wrong"></a>
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
        <div class="btn-prob-prev"></div>
        <div class="btn-prob-next"></div>
        <!--        <div class="btn-prob-submit"></div>-->
        <!--        <div class="btn-prob-back"></div>-->
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
    var currentTaskId;
    var curId = 0;
    var bg_str = ['history-bg.png', 'bg-success.png', 'bg-fail.png'];
    var type_str = ['选择', '判断', '语音识别', '语音识别'];
    // 0:task list, 1:work start
    $(function () {
        showInterface();
    });

    function showInterface() {
        $('.top-back').attr('onclick', 'goPreviousPage(-1)');
        stopSound();
        reg_step = 1;
        $('.work-frame').hide();
        $('.work-frame[item_type=' + (reg_step) + ']').fadeIn('fast');
        $('.bg').css({'background-image':'url(' + baseURL + '/assets/images/student/work/' + bg_str[reg_step - 1] + ')'});
        $('.work-history').css({'background-image':'url(' + baseURL + '/assets/images/student/work/work_history_hover.png'});
    }

    function showResult() {
        stopSound();
        var marks = getMarks();
        reg_step = 3;
        $('.star-set .star-item').attr('item_type', '0');
        for (var i = 0; i < marks; i++) {
            $('.star-set .star-item[item_id="' + i + '"]').attr('item_type', '1');
        }
        $('.work-frame').hide();
        $('.work-frame[item_type=' + (reg_step) + ']').fadeIn('fast');
        if (marks == 5) $('.bg').css({'background-image':'url(' + baseURL + '/assets/images/student/work/' + bg_str[1] + ')'});
        else $('.bg').css({'background-image':'url(' + baseURL + '/assets/images/student/work/' + bg_str[2] + ')'});
    }

    $('.task-info[item_hover="1"]').on('click', function (object) {
        currentTaskId = JSON.parse($(this).attr('item_id'));
        currentProblems = JSON.parse($(this).attr('item_content'));
        curId = 0;
        console.log(currentProblems);
        startWork(curId);
    });

    $('.btn-prob-back').on('click', function (object) {
        reg_step = 1;
        showInterface();
    });
    $('.btn-prob-prev').on('click', function (object) {
        curId--;
        if (curId < 0)
            curId = 0;
        else
            startWork(curId);
    })
    $('.btn-prob-next').on('click', function (object) {
        curId++;
        if (curId >= currentProblems.length)
            curId = currentProblems.length - 1;
        else
            startWork(curId);
        }
    )
    $('.btn-prob-submit').on('click', function (object) {
        var sel_str = ['A', 'B', 'C', 'D'];
        var item = currentProblems[curId];
        var student_answer = $('.ans-img[item_sel="1"]').attr('item_type');
        var answer_cnt = item.answer_cnt;
        if (answer_cnt == undefined) answer_cnt = 1;
        else answer_cnt++;
        var result = 0;
        switch (item.prob_type) {
            case '1':
            case '2':
                if (student_answer == undefined) {
                    alert('请选择一个');
                    return;
                }
                if (item.prob_answer == student_answer) result = 1;
                break;
            case '3':
            case '4':
                if (true) result = 1;
                break;
        }
        item.answer_cnt = answer_cnt;
        item.student_answer = student_answer;
        item.result = result;
        if (result == 1) {
            $('.right-modal').fadeIn('fast');
        } else {
            $('.wrong-modal .ans-right').html(sel_str[item.prob_answer - 1]);
            $('.wrong-modal').fadeIn('fast');
        }

        currentProblems[curId] = item;

        var marks = getMarks();
        var answer_type = 2;
        if (marks < 5)
            answer_type = 3;

        $.ajax({
            type: "post",
            url: baseURL + "student/work/updateWork",
            dataType: "json",
            data: {
                answer_info: JSON.stringify(currentProblems),
                id: currentTaskId,
                student_mark: marks,
                answer_type: answer_type
            },
            success: function (res) {
                console.log(res);
                if (res.status == 'success') {
                    setTimeout(function () {
                        $('.right-modal').fadeOut('fast');
                        $('.wrong-modal').fadeOut('fast');
                        curId++;
                        if (curId < currentProblems.length)
                            startWork(curId);
                        else
                            showResult();
                    }, 1000);
                }
                else//failed
                {
                    alert("Cannot change answer status.");
                }
            }
        });
    });

    function getMarks() {
        var marks = 0;
        for (var i = 0; i < currentProblems.length; i++) {
            item = currentProblems[i];
            if (item.result == 1) marks++;
        }
        return parseInt(5 * marks / currentProblems.length);
    }

    function startWork(id) {
        $('.top-back').attr('onclick', 'showInterface()');
        $('.work-frame').hide();
        stopSound();
        reg_step = 2;
        $('.problem-item .ans-img').removeAttr('item_sel');
        var item = currentProblems[id];
        if (item.prob_type != 4)
            $('.bg').css({'background-image':'url(' + baseURL + '/assets/images/student/work/history-bg-test' + item.prob_type + '.png)'});
        else
            $('.bg').css({'background-image':'url(' + baseURL + '/assets/images/student/work/history-bg-test3.png)'});

        $('.prob-type').html(type_str[parseInt(item.prob_type) - 1]);
        $('.prob-num').html((id + 1) + ' / ' + currentProblems.length);
        if (item.prob_img != null) {
            $('.prob-img').css({'background-image':'url(' + baseURL + '/' + item.prob_img + ')'});
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
            $('.ans-img[item_type="1"] div').css({'background-image':'url(' + baseURL + '/' + item.ans_img1 + ')'});
            $('.ans-img[item_type="1"]').show();
        } else {
            $('.ans-img[item_type="1"]').hide();
        }
        if (item.ans_img2 != null) {
            $('.ans-img[item_type="2"] div').css({'background-image':'url(' + baseURL + '/' + item.ans_img2 + ')'});
            $('.ans-img[item_type="2"]').show();
        } else {
            $('.ans-img[item_type="2"]').hide();
        }
        if (item.ans_img3 != null) {
            $('.ans-img[item_type="3"] div').css({'background-image':'url(' + baseURL + '/' + item.ans_img3 + ')'});
            $('.ans-img[item_type="3"]').show();
        } else {
            $('.ans-img[item_type="3"]').hide();
        }
        if (item.ans_img4 != null) {
            $('.ans-img[item_type="4"] div').css({'background-image':'url(' + baseURL + '/' + item.ans_img4 + ')'});
            $('.ans-img[item_type="4"]').show();
        } else {
            $('.ans-img[item_type="4"]').hide();
        }
        if (item.ans_txt != null) {
            $('.ans-txt').html(item.ans_txt)
            $('.ans-txt').show();
        } else {
            $('.ans-txt').hide();
        }
        switch (item.prob_type) {
            case '2':
                $('.ans-img[item_type="1"] div').css({'background-image':'url(' + baseURL + '/assets/images/student/work/yes.png)'});
                $('.ans-img[item_type="2"] div').css({'background-image':'url(' + baseURL + '/assets/images/student/work/no.png)'});
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
        $('.problem-item .ans-img').removeAttr('item_sel');
        $(this).attr('item_sel', '1');
    })
    $('.btn-finish').on('click', function (object) {
        $('.btn-prob-back').trigger('click');
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
                $('.ans-record').css({'background-image':'url(' + baseURL + 'assets/images/student/work/record' + imgId + '.png)'})
            }, 500);
            problemAnswerAudioRecord();
//            effecSoundPlay($(this).attr('item_src'), stopRecord);
        } else stopRecord();
    });

    function stopRecord() {
        stopSound();
        problemAnswerAudioRecordStop(currentTaskId, curId);
        imgId = 0;
        clearInterval(interval);
        $('.ans-record').css({'background-image':'url(' + baseURL + 'assets/images/student/work/record.png)'})
    }

    $('.ans-replay').on('click', function () {
        var status = $(this).attr('item_sel');
        var audio_path = currentProblems[curId].ans_audio;

        if (status != '1' && audio_path !== undefined) {
            $(this).attr('item_sel', '1');
            var ext = audio_path.split('.');
            var playPath = '';
            if(ext.length>2){
                for(var i=0; i< ext.length-1; i++){
                    playPath+=ext[i];
                }
            }else playPath = ext[0];
            console.log("--------------" + baseURL + playPath);
            effecSoundPlay(baseURL + playPath+'.m4a' , stopSound);
            interval = setInterval(function () {
                $('.ans-replay').attr('item_sel', '1');
            }, 500);
            problemAnswerAudioPlay();
        } else {
            stopSound()
            problemAnswerAudioPause();
        }
    })

</script>
