
var currentScreenId = 1;

var isClassSelect = false;
var selectedClassID = 0;

var working_name = '';

var checkedPackageIDArray = [0,0,0,0,0,0,0,0,0,0,0,0,0];
var checkedPackageCount = 0;

var problemSetList;
var isAllSelect = false;
var isPlayingArray = [];
var selectedProblemIDArray = [];
var selectProbIDList = [];
var selectedProblemCount = 0;
var timetext;
var isDecided = false;
$(function () {
    $('.deliver_container[itemid=1]').css("display","block");

    var content_html = "";
    for (var i = 0; i < class_list.length; i++) {
        content_html += '<div class="class_list_item" itemid="' + (i + 1) + '">' +
            '<div class="check_container" onclick="checkClass(this)"></div>' +
            '<div class="check_classname_container" onclick="checkClass(this)">' + class_list[i].class_name + '</div>' +
            '</div>';
    }
    $('.class_list_container').html(content_html);

    content_html = "";
    for (var i = 0 ; i < 13 ; i++){
        content_html += '<div class="course_list_item" itemid="' + (i + 1) + '" onclick="checkPackage(this)">' +
            '<div class="course_check_container"></div>' +
            '</div>';
    }
    $('.course_list_content_container').html(content_html);

    content_html = "";


});

function selectClass(self) {
    var id = $(self).parent().attr("itemid");
    if (id === "1"){
        if (isClassSelect === true){
            console.log(selectedClassID);
            $('.deliver_container[itemid=1]').css("display","none");
            $('.deliver_container[itemid=2]').css("display","block");
        }
    }else if (id === "2"){
        if ($('#uname').val() === ''){
            alert("没有作业名称");
        } else {
            working_name = $('#uname').val();
            $('.deliver_container[itemid=2]').css("display","none");
            $('.deliver_container[itemid=3]').css("display","block");
        }
    }else if (id === "3"){
        if (checkedPackageCount > 0){


            var packageList = [];
            for (var i = 0 ; i < 13 ; i++){
                if (checkedPackageIDArray[i] === 1)packageList.push(i + 1);
            }
            console.log(packageList);
            $.ajax({
                type: "post",
                url: baseURL+"teacher_work/getProblem",
                dataType: "json",
                data: {package_id_list:packageList},
                success: function(res) {
                    if(res.status=='success') {
                        problemSetList = res.data;
                        console.log(problemSetList);
                        for (var i = 0 ; i < problemSetList.length ; i++){
                            isPlayingArray[i] = 0;
                            selectedProblemIDArray[i] = 0;
                        }
                        $('.test_time_container').css("display","none");
                        $('.question_container').css("display","block");
                        $('.layout_job_btn').css("display","none");
                        $('.ans_info_msg').css("display","none");
                        $('.deliver_container[itemid=3]').css("display","none");
                        problem_set_output_content(problemSetList);
                    }else{
                        alert("Cannot delete CourseWare Item.");
                    }
                }
            });
        }
    }
}

function problem_set_output_content(problemSetList) {
    var content_html = "";
    for (var i = 0 ; i < problemSetList.length ; i++){
        var item = problemSetList[i];
        switch (parseInt(item.prob_type)){
            case 1:
                content_html += '<div class="question_list_item" itemid="'+ (i + 1) +'">' +
                    '            <div class="option_btn" onclick="selectProblem(this)"></div>' +
                    '            <div class="prob_type_img" style="background: url(' + baseURL + '/assets/images/teacher_work/deliver/question_type.png);"></div>' +
                    '            <div class="prob_img" style="background: url(' + baseURL + item.prob_img + ');"></div>' +
                    '            <div class="speaker_btn" onclick="playSound(this)"></div>' +
                    '            <div class="seperate_container"></div>' +
                    '            <div class="answer_container">' +
                    '                <div class="answer_item" itemid="1">' +
                    '                    <div class="answer_title">A</div>' +
                    '                    <div class="answer_bg">' +
                    '                        <div class="answer_btn" style="background: url(' + baseURL + item.ans_img1 + ') no-repeat;"></div>' +
                    '                    </div>' +
                    '                </div>' +
                    '                <div class="answer_item" itemid="2">' +
                    '                    <div class="answer_title">B</div>' +
                    '                    <div class="answer_bg">' +
                    '                        <div class="answer_btn" style="background: url(' + baseURL + item.ans_img2 + ') no-repeat;"></div>' +
                    '                    </div>' +
                    '                </div>' +
                    '                <div class="answer_item" itemid="3">' +
                    '                    <div class="answer_title">C</div>' +
                    '                    <div class="answer_bg">' +
                    '                        <div class="answer_btn" style="background: url(' + baseURL + item.ans_img3 + ') no-repeat;"></div>' +
                    '                    </div>' +
                    '                </div>' +
                    '                <div class="answer_item" itemid="4">' +
                    '                    <div class="answer_title">D</div>' +
                    '                    <div class="answer_bg">' +
                    '                        <div class="answer_btn" style="background: url(' + baseURL + item.ans_img4 + ') no-repeat;"></div>' +
                    '                    </div>' +
                    '                </div>' +
                    '            </div>' +
                    '            <div class="display_btn"></div>' +
                    '        </div>';
                break;
            case 2:
                content_html += '<div class="question_list_item" itemid="'+ (i + 1) +'">' +
                    '            <div class="option_btn" onclick="selectProblem(this)"></div>' +
                    '            <div class="prob_type_img" style="background: url(' + baseURL + '/assets/images/teacher_work/deliver/question_type.png);"></div>' +
                    '            <div class="prob_img" style="background: url(' + baseURL + item.prob_img + ');"></div>' +
                    '            <div class="speaker_btn" onclick="playSound(this)"></div>' +
                    '            <div class="seperate_container"></div>' +
                    '            <div class="answer_container">' +
                    '                <div class="answer_item" itemid="1">' +
                    '                    <div class="answer_title">A</div>' +
                    '                    <div class="answer_bg">' +
                    '                        <div class="answer_btn" itemid="1"></div>' +
                    '                    </div>' +
                    '                </div>' +
                    '                <div class="answer_item" itemid="2">' +
                    '                    <div class="answer_title">B</div>' +
                    '                    <div class="answer_bg">' +
                    '                        <div class="answer_btn" itemid="2"></div>' +
                    '                    </div>' +
                    '                </div>' +
                    '            </div>' +
                    '            <div class="display_btn"></div>' +
                    '            </div>';
                break;
            case 3:
                content_html += '<div class="question_list_item" itemid="' + (i + 1) + '">' +
                    '            <div class="option_btn" onclick="selectProblem(this)"></div>' +
                    '            <div class="prob_type_img" style="background: url(' + baseURL + '/assets/images/teacher_work/deliver/question_type.png);"></div>' +
                    '            <div class="prob_img" style="background: url(' + baseURL + item.prob_img + ');"></div>' +
                    '            <div class="speaker_btn" onclick="playSound(this)"></div>' +
                    '            <div class="seperate_container"></div>' +
                    '            <div class="answer_container">' +
                    '                <div class="play_container"></div>' +
                    '            </div>' +
                    '            <div class="display_btn"></div>' +
                    '        </div>';
                break;
            case 4:
                content_html += '<div class="question_list_item" itemid="' + (i + 1) + '">' +
                    '            <div class="option_btn" onclick="selectProblem(this)"></div>' +
                    '            <div class="prob_type_img" style="background: url(' + baseURL + '/assets/images/teacher_work/deliver/question_type.png);"></div>' +
                    '            <div class="prob_img" style="background: url(' + baseURL + item.prob_img + ');"></div>' +
                    '            <div class="speaker_btn" onclick="playSound(this)"></div>' +
                    '            <div class="seperate_container"></div>' +
                    '            <div class="answer_container">' +
                    '                <div class="answer_text">' + item.ans_txt + '</div>' +
                    '                <div class="play_container"></div>' +
                    '            </div>' +
                    '            <div class="display_btn"></div>' +
                    '        </div>';
                break;
        }
    }
    $('.question_list_container').html(content_html);
}

function removeName(self) {
    $('#uname').val('');
}

function checkClass(self) {
    var id = $(self).parent().attr("itemid");
    if (id == "1"){
        $('.class_list_item[itemid=1]').find('.check_container').css({background:'url(' + baseURL + 'assets/images/teacher_work/deliver/check.png) no-repeat'});
        $('.class_list_item[itemid=2]').find('.check_container').css({background:'url(' + baseURL + 'assets/images/teacher_work/deliver/uncheck.png) no-repeat'});
    }else{
        $('.class_list_item[itemid=2]').find('.check_container').css({background:'url(' + baseURL + 'assets/images/teacher_work/deliver/check.png) no-repeat'});
        $('.class_list_item[itemid=1]').find('.check_container').css({background:'url(' + baseURL + 'assets/images/teacher_work/deliver/uncheck.png) no-repeat'});
    }
    isClassSelect = true;
    selectedClassID = parseInt(id) - 1;
}

function checkPackage(self) {
    var id = $(self).attr('itemid');
    checkedPackageIDArray[id - 1] = 1 - checkedPackageIDArray[id - 1];
    if (checkedPackageIDArray[id - 1] === 1)$('.course_list_item[itemid='+id+']').find('.course_check_container').css({background:'url(' + baseURL + 'assets/images/teacher_work/deliver/check.png) no-repeat'});
    else $('.course_list_item[itemid='+id+']').find('.course_check_container').css({background:'url(' + baseURL + 'assets/images/teacher_work/deliver/uncheck.png) no-repeat'});
    checkedPackageCount = 0;
    for (var i = 0 ; i < 13 ; i++){
        if (checkedPackageIDArray[i] === 1)checkedPackageCount++;
    }
}

function addPackage(self) {
    effectSound.pause();
    clearInterval(interval);
    for (var i = 0 ; i < problemSetList.length ; i++){
        $('.question_list_item[itemid=' + (i + 1) + ']').find('.option_btn').css({background: 'url(' + baseURL + 'assets/images/teacher_work/deliver/xuanru.png) no-repeat'});
        selectedProblemIDArray[i] = 0;
    }
    selectedProblemCount = 0;
    $('.all_option_btn').css({background: 'url(' + baseURL + 'assets/images/teacher_work/deliver/quanxuanru2.png) no-repeat'});
    $('.question_container').css("display","none");
    $('.deliver_container[itemid=3]').css("display","block");
    for (var i = 0 ; i < 13 ; i++){
        if (checkedPackageIDArray[i] === 1)$('.course_list_item[itemid='+(i + 1)+']').find('.course_check_container').css({background:'url(' + baseURL + 'assets/images/teacher_work/deliver/check.png) no-repeat'});
    }
}

var effectSound = new Audio();
var soundOldCallback
function effecSoundPlay( filename, callback ){
    effectSound.pause();
    // effectSound.currentTime = 0;
    if( soundOldCallback != undefined )
        effectSound.removeEventListener('ended', soundOldCallback);
    effectSound.src = filename;
    effectSound.play();
    soundOldCallback = callback;
    effectSound.addEventListener('ended', callback);
}
var interval;
function playSound(self) {
    var id = $(self).parent().attr('itemid');
    isPlayingArray[id - 1] = 1 - isPlayingArray[id - 1];
    effecSoundPlay(baseURL + problemSetList[id - 1].prob_sound, function () {
        isPlayingArray[id - 1] = 0;
        clearInterval(interval);
        $('.question_list_item[itemid=' + id + ']').find('.speaker_btn').css({background: 'url(' + baseURL + 'assets/images/teacher_work/deliver/speaker_btn.png) no-repeat'});
    });
    clearInterval(interval);
    for (var i = 0 ; i < problemSetList.length ; i++){
        $('.question_list_item[itemid=' + (i + 1) + ']').find('.speaker_btn').css({background: 'url(' + baseURL + 'assets/images/teacher_work/deliver/speaker_btn.png) no-repeat'});
    }
    if (isPlayingArray[id - 1] === 1){
        var cnt = 1;
        interval = setInterval(function () {
            if (cnt === 5)cnt = 1;
            $('.question_list_item[itemid=' + id + ']').find('.speaker_btn').css({background: 'url(' + baseURL + 'assets/images/teacher_work/deliver/speaker_btn' + cnt + '.png) no-repeat'});
            cnt++;
        }, 500);

    }else{
        clearInterval(interval);
        effectSound.pause();
        $('.question_list_item[itemid=' + id + ']').find('.speaker_btn').css({background: 'url(' + baseURL + 'assets/images/teacher_work/deliver/speaker_btn.png) no-repeat'});
    }
}

function selectProblem(self) {
    if (isDecided)return;
    var id = $(self).parent().attr("itemid");
    selectedProblemIDArray[id - 1] = 1 - selectedProblemIDArray[id - 1];
    if (selectedProblemIDArray[id - 1] === 1){
        $('.question_list_item[itemid=' + id + ']').find('.option_btn').css({background: 'url(' + baseURL + 'assets/images/teacher_work/deliver/yichu.png) no-repeat'});
    }else {
        $('.question_list_item[itemid=' + id + ']').find('.option_btn').css({background: 'url(' + baseURL + 'assets/images/teacher_work/deliver/xuanru.png) no-repeat'});
    }
    selectedProblemCount = 0;
    selectProbIDList = [];
    for (var i = 0 ; i < problemSetList.length ; i++){
        if (selectedProblemIDArray[i] === 1){
            selectedProblemCount++;
        }
    }
    console.log(selectedProblemCount);
    if (selectedProblemCount > 0)$('.display_status').css("display","block");
    else $('.display_status').css("display","none");
    displayStatus(selectedProblemCount);
}

function selectAllProblems(self) {
    if (isDecided)return;
    var isFlag = 1 - parseInt($(self).attr("itemflag"));
    $(self).attr("itemflag",isFlag + "");
    if (isFlag === 1){
        $('.all_option_btn').css({background: 'url(' + baseURL + 'assets/images/teacher_work/deliver/quanyichu.png) no-repeat'});
        $('.all_option_btn[itemflag="1"]').on('mouseout', function (object) {
            var id = $(this).attr('itemid');
            $(this).css({background: 'url(' + baseURL + 'assets/images/teacher_work/deliver/quanyichu.png)'});
        })

        $('.all_option_btn[itemflag="1"]').on('mouseover', function (object) {
            $(this).css({background: 'url(' + baseURL + 'assets/images/teacher_work/deliver/quanyichu2.png)'});
        })
        selectedProblemCount = problemSetList.length;
        for (var i = 0 ; i < problemSetList.length ; i++){
            $('.question_list_item[itemid=' + (i + 1) + ']').find('.option_btn').css({background: 'url(' + baseURL + 'assets/images/teacher_work/deliver/yichu.png) no-repeat'});
            selectedProblemIDArray[i] = 1;
        }
        console.log(selectedProblemCount);
    }else{
        $('.all_option_btn').css({background: 'url(' + baseURL + 'assets/images/teacher_work/deliver/quanxuanru2.png) no-repeat'});
        $('.all_option_btn[itemflag="0"]').on('mouseout', function (object) {
            var id = $(this).attr('itemid');
            $(this).css({background: 'url(' + baseURL + 'assets/images/teacher_work/deliver/quanxuanru2.png)'});
        })

        $('.all_option_btn[itemflag="0"]').on('mouseover', function (object) {
            $(this).css({background: 'url(' + baseURL + 'assets/images/teacher_work/deliver/quanxuanru.png)'});
        })
        selectedProblemCount = 0;
        for (var i = 0 ; i < problemSetList.length ; i++){
            $('.question_list_item[itemid=' + (i + 1) + ']').find('.option_btn').css({background: 'url(' + baseURL + 'assets/images/teacher_work/deliver/xuanru.png) no-repeat'});
            selectedProblemIDArray[i] = 0;
        }
        console.log(selectedProblemCount);
    }
    if (selectedProblemCount > 0)$('.display_status').css("display","block");
    else $('.display_status').css("display","none");
    displayStatus(selectedProblemCount);
}

function displayStatus(cnt) {
    $('.display_status').html('已选' + cnt + '道题');
    console.log($('.display_status').val());
}

function decideQuestion(self) {
    if (selectedProblemCount === 0){
        alert("您必须至少选择1项");
        return;
    }
    isDecided = true;
    $('.test_time_container').css("display","block");
    $('.layout_job_btn').css("display","block");
    $('.question_next_btn').css("display","none");
    $('.question_title').css({background:'url(' + baseURL + 'assets/images/teacher_work/deliver/zuoyeyulan.png) no-repeat'});
    $('.all_option_btn').css({background: 'url(' + baseURL + 'assets/images/teacher_work/deliver/quanyichu.png) no-repeat'});
    var tempProblemsetList = [];
    for (var i = 0 ; i < problemSetList.length ; i++){
        if (selectedProblemIDArray[i] === 1)tempProblemsetList.push(problemSetList[i]);
    }
    problem_set_output_content(tempProblemsetList);
    for (var i = 0 ; i < tempProblemsetList.length ; i++){
        selectProbIDList.push(tempProblemsetList[i].id);
        $('.question_list_item[itemid=' + (i + 1) + ']').find('.option_btn').css({background: 'url(' + baseURL + 'assets/images/teacher_work/deliver/yichu.png) no-repeat'});
    }
}

function layoutJob(self) {
    if ($('#timetext').val() == ''){
        $('.ans_info_msg').fadeIn('fast');
        setTimeout(function () {
            $('.ans_info_msg').fadeOut('slow');
        },3000);
    }else {
        effectSound.pause();
        clearInterval(interval);
        for (var i = 0 ; i < problemSetList.length ; i++){
            $('.question_list_item[itemid=' + (i + 1) + ']').find('.speaker_btn').css({background: 'url(' + baseURL + 'assets/images/teacher_work/deliver/speaker_btn.png) no-repeat'});
            isPlayingArray[i] = 0;
        }
        $('.bg').css({background: 'url(' + baseURL + 'assets/images/teacher_work/deliver/bianantuce.png) no-repeat'});
        $('.confirm_container').css("display","block");
        $('.question_container').css("display","none");
        $('.confirm_class_name').html(class_list[selectedClassID].class_name);
    }
}

function confirm(self) {
    console.log(class_list[selectedClassID].teacher_id);
    console.log(class_list[selectedClassID].id);
    console.log(selectProbIDList);
    console.log($('#timetext').val());
    console.log($('#uname').val());
    $.ajax({
        type: "post",
        url: baseURL+"teacher_work/addTeacherWork",
        dataType: "json",
        data: {
            teacher_id:class_list[selectedClassID].teacher_id,
            class_id:class_list[selectedClassID].id,
            problem_info:"[" + selectProbIDList.toString() + "]",
            period_time:$('#timetext').val(),
            task_name:$('#uname').val(),
            end_time:$('.datetime_text').val()
        },
        success: function(res) {
            if(res.status=='success') {
                $('#success_modal').modal({
                    backdrop: 'static',
                    keyboard: false
                });

                $('#success_modal').on("click", function () {
                    hideModal(this);
                })
            }else{
                alert("Cannot delete CourseWare Item.");
            }
        }
    });

}

function hideModal(self) {
    $('#success_modal').modal('hide');
    $('.confirm_container').css("display","none");
    $('.deliver_container[itemid=1]').css("display","block");

    isClassSelect = false;
    selectedClassID = 0;

    working_name = '';

    checkedPackageIDArray = [0,0,0,0,0,0,0,0,0,0,0,0,0];
    checkedPackageCount = 0;

    problemSetList;
    isAllSelect = false;
    isPlayingArray = [];
    selectedProblemIDArray = [];
    selectProbIDList = [];
    selectedProblemCount = 0;
    timetext;
    isDecided = false;
}

// function setDateTime(self) {
//     $(self).datetimepicker();
// }