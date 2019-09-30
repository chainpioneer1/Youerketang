var isPlayingArray = [];
$(function () {
    problem_set_output_content(problemInfo);
});

function problem_set_output_content(problemSetList) {
    var content_html = "";
    for (var i = 0 ; i < problemSetList.length ; i++){
        isPlayingArray[i] = 0;
        var item = problemSetList[i];
        if(!item.hasOwnProperty('answer_cnt') || item.answer_cnt == undefined) item.answer_cnt = 0;
        if(!item.hasOwnProperty('student_answer') || item.student_answer == undefined) item.student_answer = 0;
        switch (parseInt(item.prob_type)){
            case 1:
                content_html += '<div class="question_list_item" itemid="'+ (i + 1) +'">' +
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
    $('.question_body_container').html(content_html);
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
    effecSoundPlay(baseURL + problemInfo[id - 1].prob_sound, function () {
        isPlayingArray[id - 1] = 0;
        clearInterval(interval);
        $('.question_list_item[itemid=' + id + ']').find('.speaker_btn').css({background: 'url(' + baseURL + 'assets/images/teacher_work/deliver/speaker_btn.png) no-repeat'});
    });
    clearInterval(interval);
    for (var i = 0 ; i < problemInfo.length ; i++){
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