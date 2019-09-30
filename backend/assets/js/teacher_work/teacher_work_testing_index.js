$(function () {
    $('body').fadeIn('fast');
    console.log(checkList);
    displayCheckList(checkList);

    var class_contentHtml = '<option value="0">全部</option>';
    for (var i = 0 ; i < class_list.length ; i++){
        var item = class_list[i];
        class_contentHtml += '<option value="' + (i + 1) + '">' + item.class_name + '</option>';
    }
    $('.class-select').html(class_contentHtml);


});

function changeClass(self) {
    var value = $(self).val();
    if (value == "0"){
        displayCheckList(checkList);
    }else{
        var val = class_list[value - 1].class_name;
        var tempCheckList = [];
        for (var i = 0 ; i < checkList.length ; i++){
            if (val == checkList[i].class_name)tempCheckList.push(checkList[i]);
        }
        displayCheckList(tempCheckList);
    }

    console.log(val);
}

function changeCheckResult(self) {
    var value = $(self).val();
    if (value == "0")displayCheckList(checkList);
    else{
        var tempCheckList = [];
        for (var i = 0 ; i < checkList.length ; i++){
            if (value == checkList[i].read_status)tempCheckList.push(checkList[i]);
        }
        displayCheckList(tempCheckList);
    }
}

function displayCheckList(checkList) {
    var content_html = "";
    for (var i = 0 ; i < checkList.length ; i++){
        var item = checkList[i];
        content_html += '<div class="check_item" >' +
            '                <div class="working_name" itemid="' + item.id + '" onclick="displayProblemSet(' + item.id + ')">' + item.task_name + '</div>' +
            '                <div class="class_name">' + item.class_name + '</div>' +
            '                <div class="comp">完成: ' + item.solved_count + '/' + item.total_count + '</div>' +
            '                <div class="disable_time">截止时间: ' + item.end_time + '</div>' +
            '                <div class="checked_flag" itemid="' + item.id + '" read_status="' + item.read_status + '" onclick="detailedTesting(this)"></div>' +
            '            </div>';
    }
    $('.class_list_container').html(content_html);
}

function updateFlag(id, id_array, read_status) {
    if (id == ''){
        location.href = baseURL + "teacher_work/testing_details/" + id_array + "/" + read_status;
    }else {
        $.ajax({
            type: "post",
            url: baseURL+"teacher_work/updateCheckingState",
            dataType: "json",
            data: {
                id:id,
                id_array:id_array,
            },
            success: function(res) {
                if(res.status=='success') {
                    displayCheckList(res.data);
                }else{
                    alert("Cannot Update Item.");
                }
            }
        });
    }

}

function detailedTesting(self) {
    var id = $(self).attr('itemid');
    var read_status = $(self).attr('read_status');
    updateFlag("", id, read_status);
}

function bulkDetailedTesting(self) {
    updateFlag(loginUserId, '');
}

function displayProblemSet(probInfoId) {
    console.log(probInfoId);
    location.href = baseURL + "teacher_work/viewProblemInfo/" + probInfoId;
}

