var uncompletedNum = 0;
var isCompleted = false;
$(function () {
    $('body').fadeIn('fast');
    console.log(checkDetailed_List);
    $('#time_input').datetimepicker();
    if (isChecked == "2") $(".control_btn").hide();

    $('.control_btn').on("click", function () {
        isCompleted = !isCompleted;
        if (isCompleted) {
            $('.control_btn').attr('complete', 'complete');
            $('#time_input').removeAttr("disabled");
            $('#time_input').css({"background": "white"});
            $('#time_input').focus();
        } else {
            $('.control_btn').removeAttr('complete');
            $('#time_input').attr('disabled', 'disabled');
            $('#time_input').css({'background': 'transparent'});
        }
    });

    $('#time_input').on('blur', function (object) {
    });

    var content_html = "";
    console.log(checkDetailed_List);

    for (var i = 0; i < checkDetailed_List.length; i++) {
        var item = checkDetailed_List[i];
        if (item.answer_type == "1") uncompletedNum++;
        content_html += '<tr><td style="text-align: center;" width="12%">'
            + '<div style="position: relative;width: 100%;">'
            + item.user_name
            + '<div class="add_working" style="' + (item.answer_type == "3" ? '' : 'display:none') + '"></div>'
            + '</div>';
        content_html += '</td>'
            + '<td style="text-align: center;" width="12%">' + (item.answer_type == "1" ? '未完成' : '完成') + '</td>'
            + '<td style="text-align: center;" width="12%">' + (item.answer_type == "1" ? '-' : item.period_time + '分钟') + '</td>'
            + '<td style="text-align: center;" width="24%">' + (item.answer_type == "1" ? '---- -- --' : item.end_time) + '</td>'
            + '<td style="text-align: center;" width="24%">'
            + '<div class="comment_container">';
        if (item.first_mark === '6')item.first_mark = '0';
        for (var j = 0; j < parseInt(item.first_mark); j++) {
            content_html += '<div class="comment_stars" item_checked="1"></div>'
        }

        for (var j = parseInt(item.first_mark); j < 5; j++) {
            content_html += '<div class="comment_stars" item_checked="0"></div>'
        }
        content_html += '</div>'
            + '</td>'
            + '<td style="text-align: center;cursor: pointer;" width="16%" itemid="' + item.id + '" onclick="studentProblemSet(this)">详情 < </td>'
            + '</tr>';
    }
    $('.people_number').html(uncompletedNum + "人");
    $('.class_list_container table tbody').html(content_html);
});

function studentProblemSet(self) {
    var id = parseInt($(self).attr("itemid"));
    location.href = baseURL + "teacher_work/viewAnswerInfo/" + id;
}

function updateStatus(self) {
    if (isChecked == "1") updateFlag("", testID);
    else {
        if (checkDetailed_List.length > 0)
		sessionStorage.setItem('testID',testID);
        window.open(baseURL + "teacher_work/testing_report/" + testID, '_blank');
    }
}

function updateFlag(id, id_array) {
    var endTime = $('#time_input').val();
    $.ajax({
        type: "post",
        url: baseURL + "teacher_work/updateCheckingState",
        dataType: "json",
        data: {
            id: id,
            id_array: id_array,
            end_time: endTime
        },
        success: function (res) {
            if (res.status == 'success') {
                history.go(-1);
            } else {
                alert("Cannot Update Item.");
            }
        }
    });
}