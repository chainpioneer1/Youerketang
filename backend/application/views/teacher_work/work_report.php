<link rel="stylesheet" type="text/css"
      href="<?= base_url('assets/css/frontend/teacher_work/teacher_work_report.css') ?>">
<script src="<?= base_url('assets/js/chart.bundle.js') ?>"></script>


<div class="bg"></div>
<div class="report-title">2018年3月5日作业 作业报告</div>
<div class="work-top-nav">
    <a href="#" class="bg-nav" item_type="1" item_sel="1"></a>
    <a href="#" class="bg-nav" item_type="2"></a>
</div>
<div class="work-frame" item_type="1" style="display: none">
    <div class="mean-time"></div>
    <div class="canvas-container">
        <canvas id="chart-area"></canvas>
    </div>
</div>
<div class="work-frame" item_type="2" style="display: none">
    <div class="show-detail" style="cursor: pointer" onclick="showDetail()">asdfasdf</div>
    <div class="left-arrow" style="cursor: pointer" onclick="showDetail()"></div>
    <div class="canvas-container" style="border: none">
        <div class="canvas-item">
            <div class="chart">
                <canvas id="chart-area1"></canvas>
            </div>
            <div class="chart-number">90%</div>
            <div class="chart-title">第一题</div>
        </div>
        <div class="canvas-item">
            <div class="chart">
                <canvas id="chart-area2"></canvas>
            </div>
            <div class="chart-number">90%</div>
            <div class="chart-title">第一题</div>
        </div>
        <div class="canvas-item">
            <div class="chart">
                <canvas id="chart-area3"></canvas>
            </div>
            <div class="chart-number">90%</div>
            <div class="chart-title">第一题</div>
        </div>
        <div class="canvas-item">
            <div class="chart">
                <canvas id="chart-area4"></canvas>
            </div>
            <div class="chart-number">90%</div>
            <div class="chart-title">第一题</div>
        </div>
        <div class="canvas-item">
            <div class="chart">
                <canvas id="chart-area5"></canvas>
            </div>
            <div class="chart-number">90%</div>
            <div class="chart-title">第一题</div>
        </div>
    </div>
</div>
<div class="work-frame" item_type="3" style="display: block">
    <div class="show-detail-anal" style="cursor: pointer" onclick="showDetailAnal()">答题详情</div>
    <div class="question_list_container">
        <div class="question_list_item" itemid="1">
            <div class="prob_type_img"></div>
            <div class="prob_img"></div>
            <div class="speaker_btn"></div>
            <div class="seperate_container"></div>
            <div class="answer_container">
                <div class="answer_item" itemid="1">
                    <div class="answer_title">A</div>
                    <div class="answer_bg" item_checked="1">
                        <div class="answer_btn"
                             style="background: url(<?= base_url('uploads/problem_set/1.png') ?>) no-repeat;"></div>
                    </div>
                </div>
                <div class="answer_item" itemid="2">
                    <div class="answer_title">B</div>
                    <div class="answer_bg">
                        <div class="answer_btn"
                             style="background: url(<?= base_url('uploads/problem_set/1.png') ?>) no-repeat;"></div>
                    </div>
                </div>
                <div class="answer_item" itemid="3">
                    <div class="answer_title">C</div>
                    <div class="answer_bg">
                        <div class="answer_btn"
                             style="background: url(<?= base_url('uploads/problem_set/1.png') ?>) no-repeat;"></div>
                    </div>
                </div>
                <div class="answer_item" itemid="4">
                    <div class="answer_title">D</div>
                    <div class="answer_bg">
                        <div class="answer_btn"
                             style="background: url(<?= base_url('uploads/problem_set/1.png') ?>) no-repeat;"></div>
                    </div>
                </div>
            </div>
            <div class="display_btn"></div>
            <div class="show-wrong-detail" style="cursor: pointer" onclick="showWrongDetail(this)">
                <div class="wrong-title">错误学生</div>
                <div class="student-count">5人</div>
                <div class="right-arrow"></div>
            </div>

        </div>
        <div class="question_list_item" itemid="2">
            <div class="prob_type_img"></div>
            <div class="prob_img"></div>
            <div class="speaker_btn"></div>
            <div class="seperate_container"></div>
            <div class="answer_container">
                <div class="answer_item" itemid="1">
                    <div class="answer_title">A</div>
                    <div class="answer_bg" item_checked="1">
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
<div class="right-modal"></div>
<div class="wrong-modal">
    <div class="ans-right">B</div>
</div>
<input class="check-list" value='<?= json_encode($checkDetailedList); ?>' style="display: none">
<script>
    var mTmr = 0;
    var reg_step = 1;
    var currentProblems;
    var currentTaskId;
    var curId = 0;
    var bg_str = ['bg.png', 'bg-success.png', 'bg-fail.png'];
    var type_str = ['选择', '判断', '语音识别', '语音识别'];
    var checkDetailedList;
    var problemSetList;
    var testID = '<?=$test_id?>';
    // 0:task list, 1:work start
    $(function () {
        checkDetailedList = JSON.parse($('.check-list').val());
        console.log(checkDetailedList);
        $('.report-title').html(checkDetailedList[0].task_name + "   作业报告");
        problemSetList = JSON.parse(checkDetailedList[0].answer_info);
        $('.bg').css({background: 'url(' + baseURL + '/assets/images/teacher_work/report/' + bg_str[0] + ')'});

        showInterface();
    });

    $('.bg-nav').on('click', function (object) {
        $('.bg-nav').removeAttrs('item_sel');
        var item_type = $(this).attr('item_type');
        $(this).attr('item_sel', '1');
        switch (item_type) {
            case '1':
                showInterface();
                break;
            case '2':
                showDetailAnal();
                break;
        }
    })

    function showInterface() {
        $('.work-frame').hide();
        $('.top-back').attr('onclick', 'goPreviousPage(-1)');

        var total_mean_time = 0, uncomplete_count = 0, complete_count = 0, fixing_count = 0;
        for (var i = 0; i < checkDetailedList.length; i++) {
            var item = checkDetailedList[i];
            total_mean_time += parseInt(checkDetailedList[i].spent_time);
            if (item.answer_type === "2" && item.student_mark === "5") complete_count++;
            else if (item.answer_type === "2" && item.first_mark !== "5" && item.first_mark !== "6" && item.student_mark === "5") fixing_count++;
            else if (item.answer_type === "1") uncomplete_count++;
        }
        $('.mean-time').html('班级平均用时' + (total_mean_time / (checkDetailedList.length * 60)).toFixed(1) + '分钟');
        stopSound();
        reg_step = 1;
        $('.work-frame[item_type=' + (reg_step) + ']').fadeIn('fast', function () {
            var config = {
//                type: 'pie',
                type: 'pie',
                data: {
                    datasets: [{
                        data: [complete_count, fixing_count, uncomplete_count],
                        backgroundColor: ['#2ecdad', '#ff7800', '#afafaf'],
                        label: '统计'
                    }],
                    labels: ['全对人数', '订正人数', '未完成作业人数']
                },
                options: {
                    responsive: true,
                    legend: {position: 'bottom'}
                }
            };

            var ctx = document.getElementById('chart-area').getContext('2d');
            window.myPie = new Chart(ctx, config);

        });
    }

    var problemCount = 0;

    function showDetailAnal() {
        $('.work-frame').hide();
        $('.top-back').attr('onclick', 'goPreviousPage(-1)');
        $('.show-detail').html('查看答题详情');
        stopSound();
        reg_step = 2;

        problemCount = JSON.parse(checkDetailedList[0].answer_info).length;
        var content_html = "";
        for (var i = 0; i < problemCount; i++) {
            isPlayingArray[i] = 0;
            var complete_count = 0;
            var solved_count = 0;
            for (var j = 0; j < checkDetailedList.length; j++) {
                var mark_result = JSON.parse(checkDetailedList[j].answer_info)[i].student_first_result;
                if (mark_result === 1) complete_count++;
                if (mark_result !== undefined) solved_count++;
            }
            var complete_percent = Math.floor(complete_count / solved_count * 100);
            if (solved_count == 0) complete_percent = 0;

            content_html += '<div class="canvas-item" style="cursor: pointer" onclick="showDetailInfo(this)" item_id = "' + (i + 1) + '">' +
                '            <div class="chart"><canvas id="chart-area' + (i + 1) + '"></canvas></div>' +
                '            <div class="chart-number">' + complete_percent + '%</div>' +
                '            <div class="chart-title">第' + (i + 1) + '题</div>' +
                '        </div>';

        }
        $('.work-frame[item_type="2"] .canvas-container').html(content_html);

        $('.work-frame[item_type=' + (reg_step) + ']').fadeIn('fast', function () {

            var config = {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [20, 80],
                        backgroundColor: ['#2ecdad', '#ff7800'],
                        label: ''
                    }],
                    labels: ['', '', '']
                },
                options: {
                    responsive: true,
                    legend: {position: 'bottom', display: false},
                    title: {display: false, text: 'Chart.js Doughnut Chart'},
                    animation: {animateScale: true, animateRotate: true}
                }
            };
            for (var i = 0; i < problemCount; i++) {
                var complete_count = 0;
                var solved_count = 0;
                for (var j = 0; j < checkDetailedList.length; j++) {
                    var mark_result = JSON.parse(checkDetailedList[j].answer_info)[i].student_first_result;
                    if (mark_result === 1) complete_count++;
                    if (mark_result !== undefined) solved_count++;
                }
                var complete_percent = Math.floor(complete_count / solved_count * 100);
                if (solved_count == 0) complete_percent = 0;
                var config = {
                    type: 'doughnut',
                    data: {
                        datasets: [{
                            data: [complete_percent, 100 - complete_percent],
                            backgroundColor: ['#2ecdad', '#ff7800'],
                            label: ''
                        }],
                        labels: ['', '', '']
                    },
                    options: {
                        responsive: true,
                        legend: {position: 'bottom', display: false},
                        title: {display: false, text: 'Chart.js Doughnut Chart'},
                        animation: {animateScale: true, animateRotate: true}
                    }
                };
                var ctx = document.getElementById('chart-area' + (i + 1)).getContext('2d');
                window.myPie = new Chart(ctx, config);
            }
        });
    }

    function showDetail() {
        $('.work-frame[item_type=2]').fadeOut('fast');
        $('.work-frame[item_type=3]').fadeIn('slow');
        problem_set_output_content(problemSetList, "");
    }

    function showDetailInfo(self) {
        $('.work-frame[item_type=2]').fadeOut('fast');
        $('.work-frame[item_type=3]').fadeIn('slow');
        var item_id = $(self).attr("item_id");
        console.log(item_id);
        problem_set_output_content(problemSetList, item_id);
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
        if (marks == 5) $('.bg').css({background: 'url(' + baseURL + '/assets/images/teacher_work/report/' + bg_str[1] + ')'});
        else $('.bg').css({background: 'url(' + baseURL + '/assets/images/teacher_work/report/' + bg_str[2] + ')'});
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
            $('.bg').css({background: 'url(' + baseURL + '/assets/images/teacher_work/report/bg-test' + item.prob_type + '.png)'});
        else
            $('.bg').css({background: 'url(' + baseURL + '/assets/images/teacher_work/report/bg-test3.png)'});

        $('.prob-type').html(type_str[parseInt(item.prob_type) - 1]);
        $('.prob-num').html((id + 1) + ' / ' + currentProblems.length);
        if (item.prob_img != null) {
            $('.prob-img').css({background: 'url(' + baseURL + '/' + item.prob_img + ')'});
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
            $('.ans-img[item_type="1"] div').css({background: 'url(' + baseURL + '/' + item.ans_img1 + ')'});
            $('.ans-img[item_type="1"]').show();
        } else {
            $('.ans-img[item_type="1"]').hide();
        }
        if (item.ans_img2 != null) {
            $('.ans-img[item_type="2"] div').css({background: 'url(' + baseURL + '/' + item.ans_img2 + ')'});
            $('.ans-img[item_type="2"]').show();
        } else {
            $('.ans-img[item_type="2"]').hide();
        }
        if (item.ans_img3 != null) {
            $('.ans-img[item_type="3"] div').css({background: 'url(' + baseURL + '/' + item.ans_img3 + ')'});
            $('.ans-img[item_type="3"]').show();
        } else {
            $('.ans-img[item_type="3"]').hide();
        }
        if (item.ans_img4 != null) {
            $('.ans-img[item_type="4"] div').css({background: 'url(' + baseURL + '/' + item.ans_img4 + ')'});
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
                $('.ans-img[item_type="1"] div').css({background: 'url(' + baseURL + '/assets/images/teacher_work/report/yes.png)'});
                $('.ans-img[item_type="2"] div').css({background: 'url(' + baseURL + '/assets/images/teacher_work/report/no.png)'});
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
                    background: 'url(' + baseURL + 'assets/images/teacher_work/report/play' + imgId + '.png)'
                })
            }, 500);
            effecSoundPlay($(this).attr('item_src'), stopSound);
        } else stopSound();
    });

    function stopSound() {
        effecSoundPlay('');
        imgId = 0;
        clearInterval(interval);
        $('.prob-sound').css({
            background: 'url(' + baseURL + 'assets/images/teacher_work/report/play.png)'
        })
    }

    function problem_set_output_content(problemSetList, item_id) {
        var content_html = "";
        for (var i = 0; i < problemSetList.length; i++) {
            if (item_id !== "") {
                if ((i + 1) + "" !== item_id) continue;
            }
            var item = problemSetList[i];
            var complete_count = 0;
            var solved_count = 0;
            for (var j = 0; j < checkDetailedList.length; j++) {
                var mark_result = JSON.parse(checkDetailedList[j].answer_info)[i].student_first_result;
                if (mark_result === 1) complete_count++;
                if (mark_result !== undefined) solved_count++;

            }
            var uncomplete_count = solved_count - complete_count;
            switch (parseInt(item.prob_type)) {
                case 1:
                    content_html += '<div class="question_list_item" itemid="' + (i + 1) + '">' +
                        '            <div class="prob_type_img" style="background: url(' + baseURL + '/assets/images/teacher_work/deliver/question_type.png);"></div>' +
                        '            <div class="prob_img" style="background: url(' + baseURL + item.prob_img + ');"></div>' +
                        '            <div class="speaker_btn" onclick="playSound(this)"></div>' +
                        '            <div class="seperate_container"></div>' +
                        '            <div class="answer_container">' +
                        '                <div class="answer_item" itemid="1">' +
                        '                    <div class="answer_title">A</div>' +
                        '                    <div class="answer_bg" item_checked="' + ((item.prob_answer == "1") ? 1 : 0) + '">' +
                        '                        <div class="answer_select_btn" style="background: url(' + baseURL + item.ans_img1 + ') no-repeat;"></div>' +
                        '                    </div>' +
                        '                </div>' +
                        '                <div class="answer_item" itemid="2">' +
                        '                    <div class="answer_title">B</div>' +
                        '                    <div class="answer_bg" item_checked="' + ((item.prob_answer == "2") ? 1 : 0) + '">' +
                        '                        <div class="answer_select_btn" style="background: url(' + baseURL + item.ans_img2 + ') no-repeat;"></div>' +
                        '                    </div>' +
                        '                </div>' +
                        '                <div class="answer_item" itemid="3">' +
                        '                    <div class="answer_title">C</div>' +
                        '                    <div class="answer_bg"  item_checked="' + ((item.prob_answer == "3") ? 1 : 0) + '">' +
                        '                        <div class="answer_select_btn" style="background: url(' + baseURL + item.ans_img3 + ') no-repeat;"></div>' +
                        '                    </div>' +
                        '                </div>' +
                        '                <div class="answer_item" itemid="4">' +
                        '                    <div class="answer_title">D</div>' +
                        '                    <div class="answer_bg"  item_checked="' + ((item.prob_answer == "4") ? 1 : 0) + '">' +
                        '                        <div class="answer_select_btn" style="background: url(' + baseURL + item.ans_img4 + ') no-repeat;"></div>' +
                        '                    </div>' +
                        '                </div>' +
                        '            </div>' +
                        '            <div class="display_btn"></div>' +
                        '        </div>' +
                        '            <div class="show-wrong-detail" item_count="' + uncomplete_count + '" itemid="'+(i+1)+'" ' +
                        '                   style="cursor: pointer" onclick="showWrongDetail(this)">\n' +
                        '                <div class="wrong-title">错误学生</div>' +
                        '                <div class="student-count">' + uncomplete_count + '人</div>' +
                        '                <div class="right-arrow"></div>' +
                        '            </div>';
                    break;
                case 2:
                    content_html += '<div class="question_list_item" itemid="' + (i + 1) + '">' +
                        '            <div class="prob_type_img" style="background: url(' + baseURL + '/assets/images/teacher_work/deliver/question_type.png);"></div>' +
                        '            <div class="prob_img" style="background: url(' + baseURL + item.prob_img + ');"></div>' +
                        '            <div class="speaker_btn" onclick="playSound(this)"></div>' +
                        '            <div class="seperate_container"></div>' +
                        '            <div class="answer_container">' +
                        '                <div class="answer_item" itemid="1">' +
                        '                    <div class="answer_title">A</div>' +
                        '                    <div class="answer_bg" item_checked="' + ((item.prob_answer == "1") ? 1 : 0) + '">' +
                        '                        <div class="answer_btn" itemid="1"></div>' +
                        '                    </div>' +
                        '                </div>' +
                        '                <div class="answer_item" itemid="2">' +
                        '                    <div class="answer_title">B</div>' +
                        '                    <div class="answer_bg" item_checked="' + ((item.prob_answer == "2") ? 1 : 0) + '">' +
                        '                        <div class="answer_btn" itemid="2"></div>' +
                        '                    </div>' +
                        '                </div>' +
                        '            </div>' +
                        '            <div class="display_btn"></div>' +
                        '        </div>' +
                        '            <div class="show-wrong-detail" item_count="' + uncomplete_count + '" itemid="'+(i+1)+'" ' +
                        '                   style="cursor: pointer" onclick="showWrongDetail(this)">\n' +
                        '                <div class="wrong-title">错误学生</div>' +
                        '                <div class="student-count">' + uncomplete_count + '人</div>' +
                        '                <div class="right-arrow"></div>\n' +
                        '            </div>';
                    break;
                case 3:
                    content_html += '<div class="question_list_item" itemid="' + (i + 1) + '">' +
                        '            <div class="prob_type_img" style="background: url(' + baseURL + '/assets/images/teacher_work/deliver/question_type.png);"></div>' +
                        '            <div class="prob_img" style="background: url(' + baseURL + item.prob_img + ');"></div>' +
                        '            <div class="speaker_btn" onclick="playSound(this)"></div>' +
                        '            <div class="seperate_container"></div>' +
                        '            <div class="answer_container">' +
                        '                <div class="play_container"></div>' +
                        '            </div>' +
                        '            <div class="display_btn"></div>' +
                        '        </div>' +
                        '            <div class="show-wrong-detail" item_count="' + uncomplete_count + '" itemid="'+(i+1)+'" ' +
                        '                   style="cursor: pointer" onclick="showWrongDetail(this)">\n' +
                        '                <div class="wrong-title">错误学生</div>' +
                        '                <div class="student-count">' + uncomplete_count + '人</div>' +
                        '                <div class="right-arrow"></div>' +
                        '            </div>';
                    break;
                case 4:
                    content_html += '<div class="question_list_item" itemid="' + (i + 1) + '">' +
                        '            <div class="prob_type_img" style="background: url(' + baseURL + '/assets/images/teacher_work/deliver/question_type.png);"></div>' +
                        '            <div class="prob_img" style="background: url(' + baseURL + item.prob_img + ');"></div>' +
                        '            <div class="speaker_btn" onclick="playSound(this)"></div>' +
                        '            <div class="seperate_container"></div>' +
                        '            <div class="answer_container">' +
                        '                <div class="answer_text">' + item.ans_txt + '</div>' +
                        '                <div class="play_container"></div>' +
                        '            </div>' +
                        '            <div class="display_btn"></div>' +
                        '        </div>' +
                        '            <div class="show-wrong-detail" item_count="' + uncomplete_count + '" itemid="'+(i+1)+'" ' +
                        '                   style="cursor: pointer" onclick="showWrongDetail(this)">\n' +
                        '                <div class="wrong-title">错误学生</div>' +
                        '                <div class="student-count">' + uncomplete_count + '人</div>' +
                        '                <div class="right-arrow"></div>' +
                        '            </div>';
                    break;
            }
        }
        $('.question_list_container').html(content_html);
    }

    var isPlayingArray = [];

    function playSound(self) {
        var id = $(self).parent().attr('itemid');
        isPlayingArray[id - 1] = 1 - isPlayingArray[id - 1];
        effecSoundPlay(baseURL + problemSetList[id - 1].prob_sound, function () {
            isPlayingArray[id - 1] = 0;
            clearInterval(interval);
            $('.question_list_item[itemid=' + id + ']').find('.speaker_btn').css({background: 'url(' + baseURL + 'assets/images/teacher_work/deliver/speaker_btn.png) no-repeat'});
        });
        clearInterval(interval);
        for (var i = 0; i < problemSetList.length; i++) {
            $('.question_list_item[itemid=' + (i + 1) + ']').find('.speaker_btn').css({background: 'url(' + baseURL + 'assets/images/teacher_work/deliver/speaker_btn.png) no-repeat'});
        }
        if (isPlayingArray[id - 1] === 1) {
            var cnt = 1;
            interval = setInterval(function () {
                if (cnt === 5) cnt = 1;
                $('.question_list_item[itemid=' + id + ']').find('.speaker_btn').css({background: 'url(' + baseURL + 'assets/images/teacher_work/deliver/speaker_btn' + cnt + '.png) no-repeat'});
                cnt++;
            }, 500);

        } else {
            clearInterval(interval);
            effectSound.pause();
            $('.question_list_item[itemid=' + id + ']').find('.speaker_btn').css({background: 'url(' + baseURL + 'assets/images/teacher_work/deliver/speaker_btn.png) no-repeat'});
        }
    }

    function showWrongDetail(self) {
        var count = $(self).attr('item_count');
        if (count === '0') return;
        var id = $(self).attr('itemid');
        window.open(baseURL + 'teacher_work/testing_report_student/' + testID + '/' + parseInt(id - 1), '_blank');
    }

</script>
