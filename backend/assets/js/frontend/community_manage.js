/**
 * Created by Administrator on 7/7/2017.
 */

var nav = $('.mainnav-item');
var courseId = parseInt($('#courseId').val());
window.studentCheckList = [];
window.shareWorkList = [];
$(function () {

    var date = new Date();
    date.setDate(date.getDate() - 1);
    $('*[name=date10]').appendDtpicker({
        "closeOnSelected": true,
        "dateOnly": false,
        "locale": "cn"
    });
    $('*[name=date10]').handleDtpicker('setDate', date);

    nav.on('mouseover', function () {
        this.style.background = 'url(' + baseURL + 'assets/images/frontend/community/nav'
            + $(this).attr('item_id') + '_hover.png) no-repeat';
    });
    nav.on('mouseout', function () {
        if ($(this).attr('active') != 'true')
            this.style.background = 'url(' + baseURL + 'assets/images/frontend/community/nav'
                + $(this).attr('item_id') + '.png) no-repeat';
    });
    nav.on('mouseup', function () {
        switch ($(this).attr('item_id')) {
            case '1':
                if ($('.teachertask-list').css('display') == 'none' &&
                    $('.community_new_task').css('display') == 'none' &&
                    $('.teachertask-student-check').css('display') == 'none'
                ) {
                    $('.community_upload_work').fadeOut('fast');
                    $('.teachertask-sharing').fadeOut('fast', function () {
                        $('.teachertask-list').fadeIn('fast');
                    });
                }
                break;
            case '2':
                if ($('.community_upload_work').css('display') == 'none' &&
                    $('.teachertask-sharing').css('display') == 'none'
                ) {
                    $('.teachertask-list').fadeOut('fast');
                    $('.community_new_task').fadeOut('fast');
                    $('.teachertask-student-check').fadeOut('fast', function () {
                        $('.teachertask-sharing').fadeIn('fast');
                    });
                }
                break;
        }
        $('.mylesson-media[item_id=1' + ']').css({
            opacity: '1',
            'z-index': '1'
        })
        for (var i = 0; i < nav.length; i++) {
            if (i + 1 == parseInt($(this).attr('item_id'))) continue;
            nav[i].style.background = 'url(' + baseURL + 'assets/images/frontend/community/nav'
                + (i + 1) + '.png) no-repeat';
            nav[i].removeAttribute('active');
        }
        $(this).attr('active', 'true');
        $(this).trigger('mouseover');
    });
    for (var i = 0; i < nav.length; i++) {
        nav[i].style.background = 'url(' + baseURL + 'assets/images/frontend/community/nav'
            + (i + 1) + '.png) no-repeat';
        nav[i].setAttribute('item_id', (i + 1));
        if (i == parseInt(courseId / 13)) {
            $(nav[i]).trigger('mouseup');
        }
    }
    $(nav[0]).trigger('mouseup');

});

$('.btn-newtask').on('click', function () {
    $('.add-class-input').val('');
    $('.new-task-name').val('');
    // $('.new-task-deadtime').val('');
    setDateString();
    $('.new-task-desc').val('');
    $('.new-task-addcontents').html('<div class="new-task-add-btn" onclick="new_task_add_content();"></div>');


    $('.community_new_task').attr('item_id', '');
    $('.community_new_task').show('fast');
});

function setDateString(str) {
    if (str == '' || str == undefined) str = (new Date()).toLocaleString();
    var now = new Date(Date.parse(str));
    // now = new Date();

    var str_y = now.getFullYear();
    var str_m = now.getMonth();
    var str_d = now.getDate();
    var curD = str_y + '-' + convNumLen(str_m + 1) + '-' + convNumLen(str_d);

    var str_h = now.getHours();
    var str_i = parseInt(now.getMinutes() / 10) * 10;

    var curT = convNumLen(str_h) + ':' + convNumLen(str_i);
    var content_html = '';
    var weekday = ['星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'];

    now = new Date;
    str_y = now.getFullYear();
    str_m = now.getMonth();
    str_d = now.getDate();
    for (var i = str_d; i < str_d + 30; i++) {
        var tmp = new Date(str_y, str_m, i);
        var yy = tmp.getFullYear();
        var mm = tmp.getMonth();
        var dd = tmp.getDate();
        var ww = tmp.getDay();

        var tmpD = yy + '-' + convNumLen(mm + 1) + '-' + convNumLen(dd);
        var st = '';
        if (tmpD == curD) st = 'selected="selected"';
        content_html += '<option value="' + tmpD + '" ' + st + '>' + tmpD + ', ' + weekday[ww] + '</option>';
    }
    $('.time-year').html(content_html);
    // $('.time-year').val(curD);

    content_html = '';
    for (var i = 0; i < 24; i++) {
        for (var j = 0; j < 60; j += 10) {
            var tmpT = convNumLen(i) + ':' + convNumLen(j);
            var st = '';
            if (tmpT == curT) st = 'selected="selected"';
            content_html += '<option value="' + tmpT + '" ' + st + '>' + tmpT + '</option>';
        }
    }
    $('.time-hr-min').html(content_html);
    // $('.time-hr-min').val(curT);

}

function convNumLen(num) {
    if (parseInt(num) < 10) return '0' + num;
    else return num;
}

function new_task_add_content() {
    $('#upload_media_file').val('');
    $('#upload_media_file').trigger('click');
}

$('.btn-uploadwork').on('click', function () {
    $('.new-work-name').val('');
    $('.new-work-desc').val('');
    $('.new-task-addcontents').html('<div class="new-task-add-btn" onclick="new_task_add_content();"></div>');
    $('.new-work-addcontents').html('<div class="new-work-add-btn" onclick="new_task_add_content();"></div>');

    $('.community_upload_work').attr('item_id', '');
    $('.community_upload_work').show('fast');
});

$('#upload_media_file').on('change', function (event) {
    event.stopPropagation(); // Stop stuff happening
    event.preventDefault(); // Totally stop stuff happening
    files = event.target.files;

    if (this.files[0].size > 60000000) {
        window.alert("课件要不超过60M.");
        return;
    }

    var fullPath = $(this).val();
    if (fullPath) {
        var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
        var filename = fullPath.substring(startIndex);
        if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
            filename = filename.substring(1);
        }
        var name = filename.split('.');
        filename = "";
        for (var i = 0; i < name.length - 1; i++) {
            filename += name[i];
        }
        $('#upload_media_name').val(filename);
        $('#upload_media_type').val(name[name.length - 1]);
    }

    var media_type = (name[name.length - 1] == 'mp4') ? '2' : '1';
    var old_type = $($('.new-task-addcontents').children()[1]).attr('item_type');
    if (old_type != media_type) {
        $('.new-task-addcontents').html('<div class="new-task-add-btn" onclick="new_task_add_content();"></div>');
        $('.new-work-addcontents').html('<div class="new-work-add-btn" onclick="new_task_add_content();"></div>');
    } else {
        if (old_type == '2') {
            alert('Only 1 video is allowed to uploading.');
            return;
        } else if (media_type == '1' && $('.new-task-addcontents').children().length > 6) {
            alert('The count of images should be less than 6.');
            return;
        }
    }

    $('#upload_media_submit_form').submit();
});

jQuery("#upload_media_submit_form").submit(function (e) {

    e.preventDefault();

    $(".uploading_backdrop").show();
    $(".progressing_area").show();

    var fdata = new FormData(this);

    $.ajax({
        url: baseURL + "community/upload_contents",
        type: "POST",
        data: fdata,
        contentType: false,
        cache: false,
        processData: false,
        async: true,
        xhr: function () {
            //upload Progress
            var xhr = $.ajaxSettings.xhr();
            if (xhr.upload) {
                xhr.upload.addEventListener('progress', function (event) {
                    var percent = 0;
                    var position = event.loaded || event.position;
                    var total = event.total;
                    if (event.lengthComputable) {
                        percent = Math.ceil(position / total * 100);
                    }
                    $("#progress_percent").text(percent + '%');

                }, true);
            }
            return xhr;
        },
        mimeType: "multipart/form-data"
    }).done(function (res) { //
        var ret;
        try {
            ret = JSON.parse(res);
        } catch (e) {
            $(".uploading_backdrop").hide();
            $(".progressing_area").hide();
            alert('Operation failed : ' + e);
            console.log(e);
            return;
        }
        if (ret.status == 'success') {
            $(".uploading_backdrop").hide();
            $(".progressing_area").hide();
            var media_path = ret.data.media_path;
            var media_type = ret.data.media_type;
            var content_html_task = $('.new-task-addcontents').html();
            content_html_task += '<a class="new-task-content" ' +
                'item_type="' + media_type + '" ' +
                'item_path="' + media_path + '"></a>';
            var content_html_work = $('.new-work-addcontents').html();
            content_html_work += '<a class="new-work-content" ' +
                'item_type="' + media_type + '" ' +
                'item_path="' + media_path + '"></a>';

            $('.new-task-addcontents').html(content_html_task);
            $('.new-work-addcontents').html(content_html_work);
        }
        else//failed
        {
            alert('Operation failed : ' + ret.data);
            $(".uploading_backdrop").hide();
            $(".progressing_area").hide();
            // jQuery('#ncw_edit_modal').modal('toggle');
            // alert(ret.data);
        }
    });

});

$('.add-class-btn').on('click', function () {
    var listTag = $('.add-class-list');
    if (listTag.css('display') == 'none') {
        listTag.fadeIn('fast');
    } else {
        listTag.fadeOut('fast');
    }
});

$('.add-class-list .add-class-item').on('click', function () {
    $('.add-class-input').val($(this).html());
    $('.add-class-list').fadeOut('fast');
});

function new_task_save() {
    var content_id = $('.community_new_task').attr('item_id');

    if (content_id == undefined) content_id = "";

    var content_class = $('.add-class-input').val();
    var content_title = $('.new-task-name').val();
    var content_desc = $('.new-task-desc').val();
    var apply_time = $('.time-year').val() + ' ' + $('.time-hr-min').val();
    var mediaTag = $('.new-task-addcontents').children();

    var content_path = "";

    for (var i = 1; i < mediaTag.length; i++) {
        if (i != 1) content_path += ";";
        content_path += $(mediaTag[i]).attr('item_path');
    }

    if (content_class == '' || content_title == ''
        || content_desc == '' || apply_time == '') {
        alert("Please input all of items.");
        return;
    }
    var now = new Date();
    var dateStr = now.getFullYear() + '-' + (now.getMonth() + 1) + '-' + now.getDate() + ' ';
    dateStr += now.getHours() + ':' + now.getMinutes() + ':' + now.getSeconds();

    console.log(content_id);
    var contentItem = {
        content_title: content_title,
        content_type_id: 1, // 1-task, 2-sharing, 3-student
        media_type: $(mediaTag[1]).attr('item_type'),
        content_user_id: CONF.loginUserId,
        content_school_id: CONF.loginUserSchoolId,
        content_class: content_class,
        content_description: content_desc,
        apply_time: apply_time,
        updated_time: dateStr,
        content_path: content_path,
        // publish: 0
    };

    $.ajax({
        type: "post",
        url: baseURL + "community/updateContentItem",
        dataType: "json",
        data: {content_id: content_id, contentItem: contentItem},
        success: function (res) {
            if (res.status == 'success') {
                var contentList = res.data;
                contentSets = JSON.stringify(contentList);
                $('.community_new_task').hide('fast');
                comm_init_pager(contentList);
                comm_show_page(cur_pageNo);
            }
            else//failed
            {
                alert("can not filter by content type");
            }
        }
    });
}

function new_work_save() {
    var content_id = $('.community_upload_work').attr('item_id');

    if (content_id == undefined) content_id = "";

    var content_title = $('.new-work-name').val();
    var content_desc = $('.new-work-desc').val();
    var mediaTag = $('.new-work-addcontents').children();

    var content_path = "";

    for (var i = 1; i < mediaTag.length; i++) {
        if (i != 1) content_path += ";";
        content_path += $(mediaTag[i]).attr('item_path');
    }

    if (content_title == '' || content_desc == '') {
        alert("Please input all of items.");
        return;
    }

    var now = new Date();
    var dateStr = now.getFullYear() + '-' + (now.getMonth() + 1) + '-' + now.getDate() + ' ';
    dateStr += now.getHours() + ':' + now.getMinutes() + ':' + now.getSeconds();

    var contentItem = {
        content_title: content_title,
        content_type_id: 2, // 1-task, 2-sharing, 3-student
        content_user_id: CONF.loginUserId,
        media_type: $(mediaTag[1]).attr('item_type'),
        content_school_id: CONF.loginUserSchoolId,
        content_class: '',
        content_description: content_desc,
        content_path: content_path,
        apply_time: dateStr,
        updated_time: dateStr,
        publish: 0
    };

    $.ajax({
        type: "post",
        url: baseURL + "community/updateContentItem",
        dataType: "json",
        data: {content_id: content_id, contentItem: contentItem},
        success: function (res) {
            if (res.status == 'success') {
                var contentList = res.data;
                $('.community_upload_work').hide('fast');
                comm_init_pager_sharing(contentList);
                comm_show_page(cur_pageNo);
            }
            else//failed
            {
                alert("can not filter by content type");
            }
        }
    });
}

$('.search-bar .select-searchtype-hover div').on('click', function (e) {
    e.preventDefault();
    $('.search-bar .select-searchtype').attr('sel_id', $(this).attr('sel_id'));
    var searchType = $(this).parent().parent().parent().attr('class');
    var back = 'url(' + baseURL + 'assets/images/frontend/community/';
    switch (searchType) {
        case 'teachertask-list':
            back += 'sel_bg_list1' + $(this).attr('sel_id') + '.png)';
            break;
        case 'teachertask-student-check':
            back += 'sel_bg_student1' + $(this).attr('sel_id') + '.png)';
            break;
        case 'teachertask-sharing':
            back += 'sel_bg_share1' + $(this).attr('sel_id') + '.png)';
            break;
        case 'teachertask-list':
            back += 'sel_bg_list2' + $(this).attr('sel_id') + '.png)';
            break;
        case 'teachertask-sharing':
            back += 'sel_bg_share2' + $(this).attr('sel_id') + '.png)';
            break;
    }
    $('.' + searchType + ' .search-bar .select-searchtype').css({background: back});
});

$('.teachertask-list .search-bar .btn-search').on('click', function (e) {
    e.preventDefault();
    var keyword = $(this).parent().children()[0].value;
    var newList = [];
    if (keyword == '') {
        newList = JSON.parse(contentSets);
        comm_init_pager(newList);
        comm_show_page(0);
        return;
    }
    var searchField = ['content_title', 'share_time', 'school'];
    var searchType = parseInt($(this).parent().parent().find('.select-searchtype').attr('sel_id'));
    var j = 0;
    var contentList = JSON.parse(contentSets);
    for (var i = 0; i < contentList.length; i++) {
        var item = contentList[i];
        if (item[searchField[searchType]].indexOf(keyword) != -1) {
            newList[j] = item;
            j++;
        }
    }
    comm_init_pager(newList);
    comm_show_page(0);
});

$('.teachertask-student-check .search-bar .btn-search').on('click', function (e) {
    e.preventDefault();
    var keyword = $(this).parent().children()[0].value;

    var searchField = ['fullname', 'publish', 'content_mark', 'content_mark'];
    var searchType = parseInt($(this).parent().parent().find('.select-searchtype').attr('sel_id'));
    var j = 0;
    var contentList = studentCheckList;
    var newList = [];
    for (var i = 0; i < contentList.length; i++) {
        var item = contentList[i];
        switch (searchType) {
            case 0:
                if (keyword == '') {
                    commTaskCheckShow(studentCheckList);
                    return;
                }
                if (item[searchField[searchType]].indexOf(keyword) != -1) {
                    newList[j] = item;
                    j++;
                }
                break;
            case 1:
                if (keyword == '') {
                    commTaskCheckShow(studentCheckList);
                    return;
                }
                var statusStr = (item.publish == '1') ? '已上交' : '未上交';
                if (statusStr.indexOf(keyword) != -1) {
                    newList[j] = item;
                    j++;
                }
                break;
            case 2:
                if (item.content_mark != '0' && item.publish == '1') {
                    newList[j] = item;
                    j++;
                }
                break;
            case 3:
                if (item.content_mark == '0' && item.publish == '1') {
                    newList[j] = item;
                    j++;
                }
                break;
        }
    }
    commTaskCheckShow(newList);
});

$('.teachertask-sharing .search-bar .btn-search').on('click', function (e) {
    e.preventDefault();
    var keyword = $(this).parent().children()[0].value;
    var newList = [];

    if (keyword == '') {
        newList = JSON.parse(contentSets);
        comm_init_pager_sharing(newList);
        comm_show_page(0);
        return;
    }
    var searchField = ['content_title', 'share_time'];
    var searchType = parseInt($(this).parent().parent().find('.select-searchtype').attr('sel_id'));
    var j = 0;
    var contentList = JSON.parse(contentSets);
    for (var i = 0; i < contentList.length; i++) {
        var item = contentList[i];
        if (item[searchField[searchType]].indexOf(keyword) != -1) {
            newList[j] = item;
            j++;
        }
    }
    comm_init_pager_sharing(newList);
    comm_show_page(0);
});

function showTaskCheckList(contentId) {
    var contentList = JSON.parse(contentSets);
    window.currentTaskID = contentId;
    studentCheckList = [];
    var kk = 0;
    for (var i = 0; i < contentList.length; i++) {
        var item = contentList[i];
        if (parseInt(item.teacher_task_id) == contentId && parseInt(item.content_type) == 3) {
            studentCheckList[kk] = item;
            kk++;
        }
    }
    commTaskCheckShow(studentCheckList);
}

function commTaskCheckShow(contentList) {
    var content_html = '';
    for (var i = 0; i < contentList.length; i++) {
        var item = contentList[i];
        content_html += '<div class="task-check-item" item_id="' + item.content_id + '">\n';
        content_html += '<div class="check-item-student">' + item.fullname + '</div>\n';
        content_html += '<div class="check-item-status">' + ((item.publish == '1') ? '已上交' : '未上交') + '</div>\n';
        if (item.publish == '1') {
            content_html += '<div class="check-item-content">\n';
            content_html += '<a href="#" class="btn-view" onclick="showContent(' + item.content_id + ')"></a>\n';
            content_html += '</div>\n';
            content_html += '<div href="#" class="check-item-mark">\n';
            for (var j = 0; j < 5; j++) {
                if (item.content_mark == '0')
                    content_html += '<div class="check-item-star" mark_id="' + (j + 1) + '"></div>\n';
                else
                    content_html += '<div class="check-item-star"  mark_id="' + (j + 1) + '"' +
                        ' mark_set="' + (item.content_mark) + '"></div>\n';
            }
            content_html += '</div>\n';
        }
        content_html += '</div>';
    }
    $('.teachertask-student-check .task-item-container').html(content_html);

    for (var i = 0; i < contentList.length; i++) {
        var item = contentList[i];
        if (item.content_mark != '0')
            setMarks(item.content_mark, item.content_id, true);
    }

    $('.teachertask-student-check').show('fast');


    var all_star = $('.check-item-star');

    all_star.on('mousemove', function (e) {
        e.preventDefault();
        var mark_id = parseInt($(this).attr('mark_id'));
        var record_id = $(this).parent().parent().attr('item_id')
        setMarks(mark_id, record_id);
    });

    all_star.on('mouseout', function (e) {
        e.preventDefault();
        var mark_set = parseInt($(this).attr('mark_set'));
        var mark_id = parseInt($(this).attr('mark_id'));
        var record_id = $(this).parent().parent().attr('item_id')
        var all_stars = $(this).parent().children();
        var isChecked = true;
        if (mark_set != undefined)
            isChecked = true;
        // var oldmark = mark_id;
        // for (var i = 0; i < all_stars.length; i++) {
        //     if (oldmark != parseInt($(all_stars[i]).attr('mark_id'))) {
        //         isChecked = false;
        //         break;
        //     }
        // }
        if (!isChecked)
            setMarks(0, record_id);
        else
            setMarks(mark_set, record_id);
    });

    all_star.on('click', function (e) {
        $(this).trigger('mousemove');
        e.preventDefault();
        var mark_id = parseInt($(this).attr('mark_id'));
        var record_id = $(this).parent().parent().attr('item_id')
        var all_stars = $(this).parent().children();
        // var isChecked = true;
        // var oldmark = mark_id;
        // for (var i = 0; i < all_stars.length; i++) {
        //     if (oldmark != parseInt($(all_stars[i]).attr('mark_id'))) {
        isChecked = false;
        //         break;
        //     }
        // }
        if (isChecked) return;
        if (!confirm('Do you want give ' + mark_id + ' stars to this student?')) return;

        var contentItem = {
            'content_mark': mark_id
        }
        $.ajax({
            type: "post",
            url: baseURL + "community/updateContentItem",
            dataType: "json",
            data: {content_id: record_id, contentItem: contentItem},
            success: function (res) {
                if (res.status == 'success') {
                    contentSets = JSON.stringify(res.data);
                    showTaskCheckList(currentTaskID);
                }
                else//failed
                {
                    alert("can not filter by content type");
                }
            }
        });
        setMarks(mark_id, record_id, true);
    });
}

function setMarks(mark_id, itemId, status) {
    if (status == undefined) status = false;
    mark_id = parseInt(mark_id);
    var all_stars = $('.task-check-item[item_id=' + itemId + '] .check-item-star');
    for (var i = 0; i < all_stars.length; i++) {
        if (i < mark_id)
            $(all_stars[i]).css({background: 'url(' + baseURL + 'assets/images/frontend/community/status_star_hover.png)'});
        else
            $(all_stars[i]).css({background: 'url(' + baseURL + 'assets/images/frontend/community/status_star.png)'});
    }
    if (status) {
        $(all_stars).attr('mark_set', mark_id);
    }
}

function updateTaskItem(content_id, isPublished) {

    if (isPublished == undefined) isPublished = false;

    if (isPublished) {
        alert('当前任务无法修改.');
        return;
    }

    var item_tag = $('.teachertask-list .community_list_wrapper .comm_item_wrapper[item_id=' + content_id + ']');
    var content_class = item_tag.find('.comm_school').html();
    var content_title = item_tag.find('.comm_content_title').val();
    var content_path = item_tag.find('.comm_content_path').val();
    var content_desc = item_tag.find('.comm_content_desc').val();
    var content_sharetime = item_tag.find('.comm_shareTime').html();
    var media_type = item_tag.find('.comm_content_path').attr('media_type');


    var content_html = '<div class="new-task-add-btn" onclick="new_task_add_content();"></div>';
    if (content_path != '') {
        content_path = content_path.split(';');
        for (var i = 0; i < content_path.length; i++) {
            content_html += '<a class="new-task-content" ' +
                'item_type="' + media_type + '" ' +
                'item_path="' + content_path[i] + '"></a>';
        }
    }
    $('.new-task-addcontents').html(content_html);

    $('.add-class-input').val(content_class);
    $('.new-task-name').val(content_title);
    setDateString(content_sharetime);
    // $('.new-task-deadtime').val(content_sharetime);
    $('.new-task-desc').val(content_desc);

    $('.community_new_task').attr('item_id', content_id);
    $('.community_new_task').show('fast');
}

function updateWorkItem(content_id) {

    var item_tag = $('.teachertask-sharing .task-item-container .task-check-item[item_id=' + content_id + ']');
    var content_title = item_tag.find('.sharing-title').html();
    var content_path = item_tag.find('.comm_content_path').val();
    var content_desc = item_tag.find('.comm_content_desc').val();
    var media_type = item_tag.find('.comm_content_path').attr('media_type');


    var content_html = '<div class="new-work-add-btn" onclick="new_task_add_content();"></div>';
    if (content_path != '') {
        content_path = content_path.split(';');
        for (var i = 0; i < content_path.length; i++) {
            content_html += '<a href="#" class="new-work-content" ' +
                'item_type="' + media_type + '" onclick="showContent(' + content_id + ')" ' +
                'item_path="' + content_path[i] + '"></a>';
        }
    }
    $('.new-work-addcontents').html(content_html);

    $('.new-work-name').val(content_title);
    $('.new-work-desc').val(content_desc);

    $('.community_upload_work').attr('item_id', content_id);
    $('.community_upload_work').show('fast');
}

function deleteTaskItem(content_id, isPublished) {

    if (isPublished == undefined) isPublished = false;

    if (isPublished) {
        alert('当前任务无法删除.');
        return;
    }

    if (!confirm('Do you want to delete this content?')) return;

    $.ajax({
        type: "post",
        url: baseURL + "community/deleteContentItem",
        dataType: "json",
        data: {content_id: content_id},
        success: function (res) {
            if (res.status == 'success') {
                var contentList = res.data;
                comm_init_pager(contentList);
                comm_init_pager_sharing(contentList);
                comm_show_page(0);
            }
            else//failed
            {
                alert("can not filter by content type");
            }
        }
    });
}

function deployTaskItem(content_id, publish) {

    if (!confirm('This action cannot to be backed. Do you want to deploy this content?')) return;
    if (publish == undefined) publish = 1;
    var contentItem = {
        publish: publish
    };

    $.ajax({
        type: "post",
        url: baseURL + "community/updateContentItem",
        dataType: "json",
        data: {content_id: content_id, contentItem: contentItem},
        success: function (res) {
            if (res.status == 'success') {
                var contentList = res.data;
                comm_init_pager(contentList);
                comm_init_pager_sharing(contentList);
                comm_show_page(0);
            }
            else//failed
            {
                alert("can not filter by content type");
            }
        }
    });
}

$(window).ready(function () {

    var contentList = JSON.parse(contentSets);
    window.cur_pageNo = 0;
    var totalPageCount = 0;
    var totalPageCount_sharing = 0;

    var imageDir = baseURL + "assets/images/frontend/community/";
    var orderByTimeBtn = $('.orderByCreateTime_Btn');
    var orderByReviewsBtn = $('.orderByMaxReviews_Btn');

    var latestListDiv = $('.latestlist');
    var latestListImg = $('.latestlist_img');
    var latestListBtn0 = $('#latestlist_btn0');
    var latestListBtn1 = $('#latestlist_btn1');
    var latestListBtn2 = $('#latestlist_btn2');

    var maxreviewListDiv = $('.maxreviewslist');
    var maxreviewImg = $('.maxreviewslist_img');
    var maxreviewListBtn0 = $('#maxreviewslist_btn0');
    var maxreviewListBtn1 = $('#maxreviewslist_btn1');
    var maxreviewListBtn2 = $('#maxreviewslist_btn2');

    var filterScriptBtn = $('.filterByScript_Btn');
    var filterDubbingBtn = $('.filterByDubbing_Btn');
    var filterHeadBtn = $('.filterByHead_Btn');
    var filterShootingBtn = $('.filterByShooting_Btn');

    $('#hdmenu_studentwork').mouseout(function () {
        $('.hdmenu_img').attr('src', hdmenuImgPath + 'hdmenu_comm_sel.png');
    });
    $('#hdmenu_studentwork').mouseover(function () {
        $('.hdmenu_img').attr('src', hdmenuImgPath + 'hdmenu_work_sel.png');
    });
    $('#hdmenu_profile').mouseout(function () {
        $('.hdmenu_img').attr('src', hdmenuImgPath + 'hdmenu_comm_sel.png');
    });
    $('#hdmenu_profile').mouseover(function () {
        $('.hdmenu_img').attr('src', hdmenuImgPath + 'hdmenu_profile_sel.png');
    });

    $('.return_btn').mouseover(function () {
        $(this).css({
            "background": "url(" + baseURL + "assets/images/frontend/studentwork/back_hover.png) no-repeat",
            'background-size': '100% 100%'
        });
    });
    $('.return_btn').mouseout(function () {
        $(this).css({
            "background": "url(" + baseURL + "assets/images/frontend/studentwork/back.png) no-repeat",
            'background-size': '100% 100%'
        });
    });
    $('.home_btn').mouseover(function () {
        $(this).css({
            "background": "url(" + baseURL + "assets/images/frontend/home/home_btn_hover.png) no-repeat",
            'background-size': '100% 100%'
        });
    });
    $('.home_btn').mouseout(function () {
        $(this).css({
            "background": "url(" + baseURL + "assets/images/frontend/home/home_btn.png) no-repeat",
            'background-size': '100% 100%'
        });
    });

    $('.exit-btn').mouseout(function () {
        $('.exit_btn_img').attr('src', baseURL + "assets/images/frontend/studentwork/exit.png");
    });
    $('.exit_btn_img').mouseover(function () {
        $('.exit_btn_img').attr('src', baseURL + "assets/images/frontend/studentwork/exit_hover.png");
    });

    orderByTimeBtn.mouseover(function () {
        $(this).css({
            "background": "url(" + imageDir + "latestpub_hover.png) no-repeat",
            'background-size': '100% 100%'
        });
    });
    orderByTimeBtn.mouseout(function () {
        $(this).css({"background": "url(" + imageDir + "latestpub.png) no-repeat", 'background-size': '100% 100%'});
    });
    orderByTimeBtn.click(function () {
        orderByTimeBtn.hide();
        latestListDiv.show();
    });
    latestListBtn0.click(function () {
        orderByTimeBtn.show();
        latestListDiv.hide();
    });
    latestListBtn1.mouseover(function () {
        latestListImg.attr('src', imageDir + 'latestlist_hover2.png');
    });
    latestListBtn2.mouseover(function () {
        latestListImg.attr('src', imageDir + 'latestlist_hover1.png');
    });
    latestListBtn1.mouseout(function () {
        latestListImg.attr('src', imageDir + 'latestlist_none.png');
    });
    latestListBtn2.mouseout(function () {
        latestListImg.attr('src', imageDir + 'latestlist_none.png');
    });
    /*********************/
    latestListBtn1.click(function () {
        latestListDiv.hide();
        orderByTimeBtn.show();
        cur_workstatus = '1';
        if (initStatus == 'NOCLICKEDTYPE') {///search by lasted creation date
            orderByWorkStatus('1');
        } else {
            filterByWorkType(initStatus);

        }
    });
    latestListBtn2.click(function () {
        latestListDiv.hide();
        orderByTimeBtn.hide();//////hide this button and show button with max reviewed image
        orderByReviewsBtn.show();
        cur_workstatus = '2';
        if (initStatus == 'NOCLICKEDTYPE') {///search by max revies
            orderByWorkStatus('2');
        } else {
            filterByWorkType(initStatus);
        }
    });
    /****************************review button********************************/
    orderByReviewsBtn.mouseover(function () {
        $(this).css({
            "background": "url(" + imageDir + "maxreview_hover.png) no-repeat",
            'background-size': '100% 100%'
        });
    });
    orderByReviewsBtn.mouseout(function () {
        $(this).css({"background": "url(" + imageDir + "maxreview.png) no-repeat", 'background-size': '100% 100%'});
    });
    orderByReviewsBtn.click(function () {
        orderByReviewsBtn.hide();
        maxreviewListDiv.show();
    });
    maxreviewListBtn0.click(function () {
        orderByReviewsBtn.show();
        maxreviewListDiv.hide();
    });
    maxreviewListBtn1.mouseover(function () {
        maxreviewImg.attr('src', imageDir + 'maxreviewslist_hover2.png');
    });
    maxreviewListBtn2.mouseover(function () {
        maxreviewImg.attr('src', imageDir + 'maxreviewslist_hover1.png');
    });
    maxreviewListBtn1.mouseout(function () {
        maxreviewImg.attr('src', imageDir + 'maxreviewslist_none.png');
    });
    maxreviewListBtn2.mouseout(function () {
        maxreviewImg.attr('src', imageDir + 'maxreviewslist_none.png');
    });
    /*********************/
    maxreviewListBtn1.click(function () {
        maxreviewListDiv.hide();
        orderByTimeBtn.show();
        orderByReviewsBtn.hide();
        cur_workstatus = '1';
        if (initStatus == 'NOCLICKEDTYPE') {///search by lasted creation date
            orderByWorkStatus('1');

        } else {
            filterByWorkType(initStatus);
        }
    });
    maxreviewListBtn2.click(function () {
        maxreviewListDiv.hide();
        orderByTimeBtn.hide();
        orderByReviewsBtn.show();
        cur_workstatus = '2';
        if (initStatus == 'NOCLICKEDTYPE') {///search by max revies
            orderByWorkStatus('2');
        } else {
            filterByWorkType(initStatus);
        }

    });
    /***************************Filter Buttons Manage**************************************************/
    filterScriptBtn.click(function () {
        $(this).css({
            "background": "url(" + imageDir + "scriptwork_hover.png) no-repeat",
            'background-size': '100% 100%'
        });
        filterDubbingBtn.css({
            "background": "url(" + imageDir + "dubbingwork.png) no-repeat",
            'background-size': '100% 100%'
        });
        filterHeadBtn.css({
            "background": "url(" + imageDir + "headwork.png) no-repeat",
            'background-size': '100% 100%'
        });
        filterShootingBtn.css({
            "background": "url(" + imageDir + "shootingwork.png) no-repeat",
            'background-size': '100% 100%'
        });
        initStatus = '1';
        filterByWorkType(initStatus);

    });
    filterDubbingBtn.click(function () {
        $(this).css({
            "background": "url(" + imageDir + "dubbingwork_hover.png) no-repeat",
            'background-size': '100% 100%'
        });
        filterScriptBtn.css({
            "background": "url(" + imageDir + "scriptwork.png) no-repeat",
            'background-size': '100% 100%'
        });
        filterHeadBtn.css({
            "background": "url(" + imageDir + "headwork.png) no-repeat",
            'background-size': '100% 100%'
        });
        filterShootingBtn.css({
            "background": "url(" + imageDir + "shootingwork.png) no-repeat",
            'background-size': '100% 100%'
        });
        initStatus = '2';
        filterByWorkType(initStatus);

    });
    filterHeadBtn.click(function () {
        $(this).css({
            "background": "url(" + imageDir + "headwork_hover.png) no-repeat",
            'background-size': '100% 100%'
        });
        filterScriptBtn.css({
            "background": "url(" + imageDir + "scriptwork.png) no-repeat",
            'background-size': '100% 100%'
        });
        filterDubbingBtn.css({
            "background": "url(" + imageDir + "dubbingwork.png) no-repeat",
            'background-size': '100% 100%'
        });
        filterShootingBtn.css({
            "background": "url(" + imageDir + "shootingwork.png) no-repeat",
            'background-size': '100% 100%'
        });
        initStatus = '5';
        filterByWorkType(initStatus);

    });
    filterShootingBtn.click(function () {
        $(this).css({
            "background": "url(" + imageDir + "shootingwork_hover.png) no-repeat",
            'background-size': '100% 100%'
        });
        filterScriptBtn.css({
            "background": "url(" + imageDir + "scriptwork.png) no-repeat",
            'background-size': '100% 100%'
        });
        filterDubbingBtn.css({
            "background": "url(" + imageDir + "dubbingwork.png) no-repeat",
            'background-size': '100% 100%'
        });
        filterHeadBtn.css({
            "background": "url(" + imageDir + "headwork.png) no-repeat",
            'background-size': '100% 100%'
        });
        initStatus = '6';
        filterByWorkType(initStatus);

    });

    function make_item(orderNo, contentInfo) {
        var output_html = '';
        var interVal = 3.2;
        var itemHight = 9.2;
        var topVal = orderNo * itemHight + (orderNo + 1) * interVal;
        var topValStr = topVal + "%";
        output_html += '<div class="comm_item_wrapper" style = "top:' + topValStr + '" ' +
            'item_id="' + contentInfo.content_id + '">';
        output_html += '<div class="comm_school">' + contentInfo['school'] + '</div>';
        output_html += '<a href="#" class="comm_author" onclick="showContent(' + contentInfo.content_id + ')">' +
            contentInfo['content_title'] + '</a>';
        output_html += '<div class="comm_shareTime">' + contentInfo['share_time'] + '</div>';

        output_html += '<input class="comm_content_desc" style="display:none;" ' +
            'value="' + contentInfo.content_desc + '">';
        output_html += '<input class="comm_content_title" style="display:none;" ' +
            'value="' + contentInfo.content_title + '">';
        output_html += '<input class="comm_content_path" style="display:none;" ' +
            'value="' + contentInfo.content_path + '" media_type="' + contentInfo.media_type + '">';
        if (contentInfo.publish == "1") {
            output_html += '<div class="comm_title">' +
                '<div class="btn-delete" onclick="deleteTaskItem(' + contentInfo.content_id + ',true)"></div> ' +
                '<div class="btn-update" onclick="updateTaskItem(' + contentInfo.content_id + ',true)"></div> ';

            output_html += '<div class="btn-deployed"></div>';
        } else {
            output_html += '<div class="comm_title">' +
                '<div class="btn-delete" onclick="deleteTaskItem(' + contentInfo.content_id + ')"></div> ' +
                '<div class="btn-update" onclick="updateTaskItem(' + contentInfo.content_id + ')"></div> ';

            output_html += '<div class="btn-deploy" ' +
                'onclick="deployTaskItem(' + contentInfo.content_id + ')"></div> ';
        }
        output_html += '</div>';
        var listTmp = JSON.parse(contentSets);
        var tot = 0;
        var upd = 0;
        for (var kk = 0; kk < listTmp.length; kk++) {
            var itemm = listTmp[kk];
            if (parseInt(itemm.teacher_task_id) == parseInt(contentInfo.content_id) &&
                parseInt(itemm.content_type) == 3) {
                tot++;
                if (parseInt(itemm.publish) == 1)
                    upd++;
            }
        }
        output_html += '<div class="comm_viewNum">完成:' + upd + '/' + tot +
            ' <a href="#" onclick="showTaskCheckList(\'' + contentInfo['content_id'] + '\');" ' +
            'class="btn-preview"></a>' + '</div>';
        output_html += '</div>';
        return output_html;
    }

    function make_item_sharing(orderNo, contentInfo) {
        var output_html = '';
        var interVal = 3.2;
        var itemHight = 9.2;
        var topVal = orderNo * itemHight + (orderNo + 1) * interVal;
        var topValStr = topVal + "%";
        output_html += '<div class="task-check-item" style = "top:' + topValStr + '" ' +
            'item_id="' + contentInfo.content_id + '">';
        output_html += '<a href="#" class="sharing-title" onclick="showContent(' + contentInfo.content_id + ')">' +
            contentInfo['content_title'] + '</a>';
        output_html += '<div class="sharing-author">' + contentInfo['author'] + '</div>';
        output_html += '<div class="sharing-time">'
            + contentInfo['share_time'] + '</div>';

        output_html += '<input class="comm_content_desc" style="display:none;" ' +
            'value="' + contentInfo.content_desc + '">';
        output_html += '<input class="comm_content_title" style="display:none;" ' +
            'value="' + contentInfo.content_title + '">';
        output_html += '<input class="comm_content_path" style="display:none;" ' +
            'value="' + contentInfo.content_path + '" media_type="' + contentInfo.media_type + '">';
        output_html += '<div class="sharing-operation">';
        // + contentInfo['title']
        if (contentInfo.publish == "1")
            output_html += '<div class="btn-unshare" ' +
                'onclick="deployTaskItem(' + contentInfo.content_id + ',0)"></div> ';
        else
            output_html += '<div class="btn-share" ' +
                'onclick="deployTaskItem(' + contentInfo.content_id + ',1)"></div> ';
        output_html += '<div class="btn-delete" onclick="deleteTaskItem(' + contentInfo.content_id + ')"></div> '
            + '<div class="btn-update" onclick="updateWorkItem(' + contentInfo.content_id + ')"></div> ';
        output_html += '</div>';
        output_html += '</div>';
        return output_html;
    }

    window.comm_init_pager = function comm_init_pager(contentlist) {

        var j = 0;
        var newList = [];
        for (var i = 0; i < contentlist.length; i++) {
            var item = contentlist[i];
            if (parseInt(item.content_user_id) == parseInt(CONF.loginUserId) &&
                item.content_type == '1'
            ) {
                newList[j] = item;
                j++;
            }
        }
        contentlist = newList;
        var output_html = '';
        for (var i = 0; i < contentlist.length; i++) {
            var tempObj = contentlist[i];
            var modeVar = i % 3;
            var pageNo = (i - modeVar) / 3;
            totalPageCount = pageNo;
            if (modeVar == 0) {
                if (pageNo != 0) output_html += '</div>';
                output_html += '<div class = "comm_page_' + pageNo + '" style="display: none">';
                output_html += make_item(modeVar, tempObj);
            } else {
                output_html += make_item(modeVar, tempObj);
            }
        }
        output_html += '</div>';
        $('#community_list_area').html(output_html);
    };

    window.comm_init_pager_sharing = function comm_init_pager_sharing(contentlist) {

        var j = 0;
        var newList = [];
        for (var i = 0; i < contentlist.length; i++) {
            var item = contentlist[i];
            if (parseInt(item.content_user_id) == parseInt(CONF.loginUserId) &&
                item.content_type == '2'
            ) {
                newList[j] = item;
                j++;
            }
        }
        contentlist = newList;
        var output_html = '';
        for (var i = 0; i < contentlist.length; i++) {
            var tempObj = contentlist[i];
            var modeVar = i % 3;
            var pageNo = (i - modeVar) / 3;
            totalPageCount_sharing = pageNo;
            if (modeVar == 0) {
                if (pageNo != 0) output_html += '</div>';
                output_html += '<div class = "comm_page_' + pageNo + '" style="display: none">';
                output_html += make_item_sharing(modeVar, tempObj);
            } else {
                output_html += make_item_sharing(modeVar, tempObj);
            }
        }
        output_html += '</div>';
        $('.task-item-container').html(output_html);
    };

    window.comm_show_page = function comm_show_page(pageNo) {
        cur_pageNo = pageNo;
        var classStr = '.comm_page_' + pageNo;
        $(classStr).fadeIn('fast');
    };

    function comm_hide_page(pageNo) {
        var classStr = '.comm_page_' + pageNo;
        $(classStr).fadeOut('fast');
    }

    function comm_next_page() {
        if (cur_pageNo > totalPageCount - 1) return;
        else {
            comm_hide_page(cur_pageNo);
            cur_pageNo++;
            comm_show_page(cur_pageNo);

        }
    }

    function comm_prev_page() {
        console.log('current Page No:' + cur_pageNo);
        if (cur_pageNo < 1) return;
        else {
            comm_hide_page(cur_pageNo);
            cur_pageNo--;
            comm_show_page(cur_pageNo);
        }
    }

    function comm_next_page_sharing() {
        if (cur_pageNo > totalPageCount_sharing - 1) return;
        else {
            comm_hide_page(cur_pageNo);
            cur_pageNo++;
            comm_show_page(cur_pageNo);

        }
    }

    var contentList = JSON.parse(contentSets);

    comm_init_pager(contentList);
    comm_init_pager_sharing(contentList);
    comm_show_page(0);

    function filterByWorkType(contentType) {
        cur_pageNo = 0;
        $.ajax({
            type: "post",
            url: baseURL + "community/orderByContentType",
            dataType: "json",
            data: {orderBySelect: cur_workstatus, content_type_id: contentType},
            success: function (res) {
                if (res.status == 'success') {
                    comm_init_pager(res.data);
                    comm_show_page(0);
                    fitWindow();
                }
                else//failed
                {
                    alert("can not filter by content type");
                }
            }
        });
    }

    function orderByWorkStatus(orderBySelect_Id) {
        cur_pageNo = 0;
        $.ajax({
            type: "post",
            url: baseURL + "community/orderBySelect",
            dataType: "json",
            data: {orderBySelect: orderBySelect_Id},
            success: function (res) {
                if (res.status == 'success') {
                    comm_init_pager(res.data);
                    comm_show_page(0);
                    fitWindow();
                }
                else//failed
                {
                    alert("can not order by work status");
                }
            }
        })
    }

    var prev_btn = $('.previous_Btn');
    var next_btn = $('.next_Btn');
    var next_btn_sharing = $('.next_Btn_sharing');

    prev_btn.mouseover(function () {
        $(this).css({"background": "url(" + imageDir + "prev_hover.png) no-repeat", 'background-size': '100% 100%'});
    });
    prev_btn.mouseout(function () {
        $(this).css({"background": "url(" + imageDir + "prev.png) no-repeat", 'background-size': '100% 100%'});
    });
    next_btn.mouseover(function () {
        $(this).css({"background": "url(" + imageDir + "next_hover.png) no-repeat", 'background-size': '100% 100%'});
    });
    next_btn.mouseout(function () {
        $(this).css({"background": "url(" + imageDir + "next.png) no-repeat", 'background-size': '100% 100%'});
    });
    prev_btn.click(function () {
        comm_prev_page();
    });
    next_btn.click(function () {
        comm_next_page();
    });
    next_btn_sharing.mouseover(function () {
        $(this).css({"background": "url(" + imageDir + "next_hover.png) no-repeat", 'background-size': '100% 100%'});
    });
    next_btn_sharing.mouseout(function () {
        $(this).css({"background": "url(" + imageDir + "next.png) no-repeat", 'background-size': '100% 100%'});
    });
    next_btn_sharing.click(function () {
        comm_next_page_sharing();
    });

    function fitWindow() {
        var fontHRate = 0.0185;
        var fontWRate = 0.01;
        var realFHSize = (window.innerHeight) * fontHRate;
        var realFWSize = (window.innerWidth) * fontWRate;
        var realFSize = (realFHSize > realFWSize) ? realFWSize : realFHSize;

        var topVal = (20 - realFSize) * 1.3 + 17;

        // $('.comm_title').css('font-size', realFSize);
        // $('.comm_author').css('font-size', realFSize);
        // $('.comm_school').css('font-size', realFSize);
        // $('.comm_viewNum').css('font-size', realFSize);
        // $('.comm_shareTime').css('font-size', realFSize);
        //
        // $('.comm_title').css('top', topVal + '%');
        // $('.comm_author').css('top', topVal + '%');
        // $('.comm_school').css('top', topVal + '%');
        // $('.comm_viewNum').css('top', topVal + '%');
        // $('.comm_shareTime').css('top', topVal + '%');

    }

    fitWindow();
    $(window).resize(function () {
        fitWindow();
    });

});
