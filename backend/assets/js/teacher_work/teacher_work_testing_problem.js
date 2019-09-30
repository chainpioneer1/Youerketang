var uncompletedNum = 0;
$(function () {
    $('body').fadeIn('fast');
    console.log(checkDetailed_List);
    $('#time_input').datetimepicker();

    $('.control_btn').on("click", function () {
        $('#time_input').removeAttr("disabled");
        $('#time_input').css({"background": "white"});
        $('#time_input').focus();
    })

    $('#time_input').on('blur', function (object) {

        $(this).attr('disabled', 'disabled');
        $(this).css({'background': 'transparent'});
    });

    var content_html = "";
    console.log(checkDetailed_List);

    for (var i = 0; i < checkDetailed_List.length; i++) {
        var item = checkDetailed_List[i];
        if (item.answer_type == "1")uncompletedNum++;
        content_html += '<tr><th style="text-align: center;" width="12%">'
            + item.user_name;
        if (item.answer_type == "3")
            content_html += '<div style="position: relative">'
                + '<div class="add_working" style=""></div>'
                + '</div>';
        content_html += '</th>'
            + '<th style="text-align: center;" width="12%">' + (item.answer_type == "1"?'未完成':'完成') + '</th>'
            + '<th style="text-align: center;" width="12%">' + item.period_time + '分钟</th>'
            + '<th style="text-align: center;" width="24%">'+ item.end_time + '</th>'
            + '<th style="text-align: center;" width="24%">'
            + '<div class="comment_container">';
        for (var j = 0 ; j < parseInt(item.student_mark) ; j++){
            content_html += '<div class="comment_stars" item_checked="1"></div>'
        }

        for (var j = parseInt(item.student_mark) ; j < 5 ; j++){
            content_html += '<div class="comment_stars" item_checked="0"></div>'
        }
        content_html +='</div>'
            + '</th>'
            + '<th style="text-align: center;cursor: pointer;" width="16%" itemid="' + (i + 1) + '">详情</th>'
            + '</tr>';
    }
    $('.people_number').html(uncompletedNum + "人");
    $('.class_list_container table tbody').html(content_html);
});
