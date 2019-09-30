/**
 * Created by Administrator on 7/7/2017.
 */

var nav = $('.mainnav-item');
var prev_btn = $('.previous_Btn');
var next_btn = $('.next_Btn');

var courseId = parseInt($('#courseId').val());
var currentTab = '0';//0：我的任务, if 1 then 现在页是教师的作品
var myTaskList;
var teacherContentList;
var cur_pageNo = 0;
var totalPageCount = 0;

var cur_TeacherPageNo = 0;
var totalTeacherPageCount = 0;

var imageDir = baseURL + "assets/images/frontend/community/";

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

    if (currentTab == 1) //My task
    {
        prevMyTaskPage();

    } else {
        prevTeacherContentPage();
    }

});
next_btn.click(function () {
    if (currentTab == 1) //My task
    {
        nextMyTaskPage();
    } else {
        nextTeacherContentPage();
    }
});

$(function () {
    nav.on('mouseover', function () {
        this.style.background = 'url(' + baseURL + 'assets/images/frontend/community/nav_student'
            + $(this).attr('item_id') + '_hover.png) no-repeat';
    });
    nav.on('mouseout', function () {
        if ($(this).attr('active') != 'true')
            this.style.background = 'url(' + baseURL + 'assets/images/frontend/community/nav_student'
                + $(this).attr('item_id') + '.png) no-repeat';
    });

    nav.on('mouseup', function () {
        switch ($(this).attr('item_id')) {
            case '1':
                if ($('.teachertask-list').css('display') == 'none'
                ) {
                    $('.teachertask-sharing').fadeOut('fast', function () {
                        $('.teachertask-list').fadeIn('fast');
                        currentTab = 0;
                    });
                }
                break;
            case '2':
                if ($('.teachertask-sharing').css('display') == 'none') {
                    $('.teachertask-list').fadeOut('fast', function () {
                        $('.teachertask-sharing').fadeIn('fast');
                        currentTab = 1;
                    });
                }
                break;
        }
        $('.mylesson-media[item_id=1' + ']').css({
            opacity: '1',
            'z-index': '1'
        });
        for (var i = 0; i < nav.length; i++) {
            if (i + 1 == parseInt($(this).attr('item_id'))) continue;
            nav[i].style.background = 'url(' + baseURL + 'assets/images/frontend/community/nav_student'
                + (i + 1) + '.png) no-repeat';
            nav[i].removeAttribute('active');
        }
        $(this).attr('active', 'true');
        $(this).trigger('mouseover');
    });
    for (var i = 0; i < nav.length; i++) {
        nav[i].style.background = 'url(' + baseURL + 'assets/images/frontend/community/nav_student'
            + (i + 1) + '.png) no-repeat';
        nav[i].setAttribute('item_id', (i + 1));
        if (i == parseInt(courseId / 13)) {
            $(nav[i]).trigger('mouseup');
        }
    }
    $(nav[0]).trigger('mouseup');

});

$('.btn-newtask').on('click', function () {
    $('.community_new_task').show('fast');
});
$('.btn-uploadwork').on('click', function () {
    $('.community_upload_work').show('fast');
});

function viewTeacherTask(contentID) { //Show Teacher Task to Student

    window.open(baseURL + 'community/contentview/' + contentID, '_blank','menubar=no,width=500,height=500,status=no');

}

/***************************Filter Buttons Manage**************************************************/
$('.search-bar .select-searchtype-hover div').on('click', function (e) {
    e.preventDefault();
    $('.search-bar .select-searchtype').attr('sel_id', $(this).attr('sel_id'));
    var searchType = $(this).parent().parent().parent().attr('class');
    var back = 'url(' + baseURL + 'assets/images/frontend/community/';
    switch (searchType) {
        // case 'teachertask-list':
        //     back += 'sel_bg_list1' + $(this).attr('sel_id') + '.png)';
        //     break;
        case 'teachertask-student-check':
            back += 'sel_bg_student1' + $(this).attr('sel_id') + '.png)';
            break;
        // case 'teachertask-sharing':
        //     back += 'sel_bg_share1' + $(this).attr('sel_id') + '.png)';
        //     break;
        case 'teachertask-list':
            back += 'sel_bg_list2' + $(this).attr('sel_id') + '.png)';
            break;
        case 'teachertask-sharing':
            back += 'sel_bg_share2' + $(this).attr('sel_id') + '.png)';
            break;
    }
    $('.'+searchType+' .search-bar .select-searchtype').css({background:back});
});

$('.teachertask-list .search-bar .btn-search').on('click', function (e) {
    e.preventDefault();
    var keyword = $(this).parent().children()[0].value;
    var newList = [];
    if (keyword == '') {
        newList = JSON.parse(myTaskSets);

        myTaskInitPager(newList);
        showMyTaskPage(0);
        return;
    }
    var searchField = ['apply_time', 'content_title', 'content_mark'];
    var searchType = parseInt($(this).parent().parent().find('.select-searchtype').attr('sel_id'));
    var j = 0;
    var contentList = JSON.parse(myTaskSets);
    for (var i = 0; i < contentList.length; i++) {
        var item = contentList[i];
        if (item[searchField[searchType]].indexOf(keyword) != -1) {
            newList[j] = item;
            j++;
        }
    }
    myTaskInitPager(newList);
    showMyTaskPage(0);
});

$('.teachertask-sharing .search-bar .btn-search').on('click', function (e) {
    e.preventDefault();
    var keyword = $(this).parent().children()[0].value;
    var newList = [];
    if (keyword == '') {
        newList = teacherContentList;
        TeacherContentInitPager(newList);
        showTeacherContentPage(0);
        return;
    }
    var searchField = ['content_title', 'apply_time'];
    var searchType = parseInt($(this).parent().parent().find('.select-searchtype').attr('sel_id'));
    var j = 0;
    var contentList = teacherContentList;
    for (var i = 0; i < contentList.length; i++) {
        var item = contentList[i];
        if (item[searchField[searchType]].indexOf(keyword) != -1) {
            newList[j] = item;
            j++;
        }
    }
    TeacherContentInitPager(newList);
    showTeacherContentPage(0);
});

function makeMyTaskItem(orderNo, contentInfo) {

    var output_html = '';
    var blockInfo = Math.floor(orderNo / 4);
    output_html += '<div class="my-task-item-wrapper my-task-block-' + blockInfo + '" style="display: none">';

    output_html += '<div class="my-task-title" onclick="viewTeacherTask(' + contentInfo.teacher_task_id + ')">' + contentInfo.content_title + '</div>';
    output_html += '<div class="my-task-deadline">' + contentInfo.apply_time + '</div>';
    output_html += '<div class="my-task-operation">';
    output_html += '<a href="#" class="btn-update" ' +
        ' content_title="' + contentInfo.content_title + '"' +
        ' content_desc="' + contentInfo.content_description + '"' +
        ' content_id="' + contentInfo.content_id + '"' +
        ' content_path="' + contentInfo.content_path + '"' +
        ' media_type="' + contentInfo.media_type + '"' +
        ' onclick="updateMyTask(this)"></a>\n';

    var markStr = contentInfo.content_mark;
    var isPublish = contentInfo.publish;

    if (isPublish == '1') {
        output_html += '<a href="#" class="btn-restore-submit" onclick="restoreSubmitTask(' + contentInfo.content_id + ')"></a>\n';
    }
    else {
        output_html += '<a href="#" class="btn-submit" onclick="SubmitTask(' + contentInfo.content_id + ')"></a>\n';
    }

    output_html += '</div>';
    output_html += '<div class="my-task-view">';
    output_html += '<a href="#" class="btn-preview" onclick="showContent(' + contentInfo.content_id + ')"></a>';
    output_html += '</div>';

    if (markStr != null) {
        output_html += '<div href="#" class="check-item-mark">';
        for (var i = 0; i < parseInt(markStr); i++) {
            output_html += '<div class="check-item-star"></div>\n';
        }
        output_html += '</div>';
    }
    output_html += '</div>';

    return output_html;
}

function myTaskInitPager(contentlist) {
    var output_html = '';
    for (var i = 0; i < contentlist.length; i++) {
        var tempObj = contentlist[i];
        if (tempObj.isChecked == 1)
            output_html += makeMyTaskItem(i, tempObj);
    }
    totalPageCount = Math.floor(contentlist.length / 4);

    $('#community_list_area').html(output_html);
}

function showMyTaskPage(pageNo) {
    $('.my-task-block-' + pageNo).fadeIn(400);
}

function hideMyTaskPage(pageNo) {
    $('.my-task-block-' + pageNo).fadeOut(400);
}

function nextMyTaskPage() {
    if (cur_pageNo > totalPageCount - 1) return;
    else {
        hideMyTaskPage(cur_pageNo);
        setTimeout(function () {
            cur_pageNo++;
            showMyTaskPage(cur_pageNo);
        }, 400);
    }
}

function prevMyTaskPage() {
    if (cur_pageNo < 1) return;
    else {
        hideMyTaskPage(cur_pageNo);
        setTimeout(function () {
            cur_pageNo--;
            showMyTaskPage(cur_pageNo);
        }, 400)
    }
}

myTaskList = JSON.parse(myTaskSets);
myTaskInitPager(myTaskList);
showMyTaskPage(0);

function updateMyTask(self) {

    var content_title = self.getAttribute('content_title');
    var content_desc = self.getAttribute('content_desc');
    var media_type = self.getAttribute('media_type');
    if (content_desc == 'null') content_desc = '';
    var content_id = self.getAttribute('content_id');
    var content_path = self.getAttribute('content_path');

    $('.new-work-name').val(content_title);
    $('.new-work-desc').val(content_desc);
    $('#new_content_id').val(content_id);

    var uploadBtnHtml = '<div class="new-work-add-btn" onclick="new_work_add_content();"></div>';

    if (media_type != '0' && content_path!='') {
        var srcList = content_path.split(';');
        for (var i = 0; i < srcList.length; i++) {
            uploadBtnHtml += '<a class="new-work-content" item_type="' + media_type + '" item_path="' + srcList[i] + '"></a>';
        }
    }

    $('.new-work-addcontents').html(uploadBtnHtml);

    $('.community_upload_work').show('fast');

}

function new_work_add_content() {
    $('#upload_media_file').val('');
    $('#upload_media_file').trigger('click');
}

function SubmitTask(content_id) {

    $.ajax({
        type: 'post',
        url: baseURL + 'community/s_SubmitTask',
        dataType: 'json',
        data: {content_id: content_id},
        success: function (res) {

            if (res.status === 'success') {

                myTaskList = res.data;
                myTaskInitPager(myTaskList);
                showMyTaskPage(cur_pageNo);

            } else {
                alert('不可以上交');
                console.log(res);
            }
        }
    })
}

function restoreSubmitTask(content_id) {

    $.ajax({
        type: 'post',
        url: baseURL + 'community/s_RestoreSubmitTask',
        dataType: 'json',
        data: {content_id: content_id},
        success: function (res) {
            if (res.status === 'success') {

                myTaskList = res.data;
                myTaskInitPager(myTaskList);
                showMyTaskPage(cur_pageNo);

            } else {

                alert('当前作品无法撤回');
                console.log(res);
            }
        }
    })

}


$('.new-task-btn-save').click(function () {

    var content_title = $('.new-work-name').val();
    var content_desc = $('.new-work-desc').val();
    var content_id = $('#new_content_id').val();
    var teacher_task_id = $('#new_teacher_task_id').val();

    var mediaType = $($('.new-work-content')[0]).attr('item_type');
    if(mediaType ==undefined) mediaType='0';

    var mediaContents = '';
    var j = 0;
    $('.new-work-content').each(function () {
        if (j != 0) mediaContents += ';';
        mediaContents += $(this).attr('item_path');
        j++;
    });
    // if (mediaType != null) mediaType = 1;
    var contentData = {
        content_id: content_id,
        content_title: content_title,
        media_type: mediaType,
        content_desc: content_desc,
        media_contents: mediaContents
    };
    if (teacher_task_id != "null") {
        console.log('Updated Data');
        console.log(contentData);
        $.ajax({
            type: 'post',
            url: baseURL + 'community/s_EditMyTask',
            dataType: 'json',
            data: contentData,
            success: function (res) {

                if (res.status == 'success') {
                    ///List Refresh and Pagination
                    myTaskList = res.data;
                    myTaskInitPager(myTaskList);
                    showMyTaskPage(cur_pageNo);

                    $('.community_upload_work').hide('fast');

                } else {
                    alert('Server Error');
                    console.log(res);
                }
            }
        })
    } else {
        alert("Can't edit task");
    }
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
    var old_type = $($('.new-work-addcontents').children()[1]).attr('item_type');
    if (old_type != media_type) {
        $('.new-work-addcontents').html('<div class="new-work-add-btn" onclick="new_work_add_content();"></div>');
    } else {
        if (old_type == '2') {
            alert('Only 1 video is allowed to uploading.');
            return;
        } else if (media_type == '1' && $('.new-work-addcontents').children().length > 6) {
            alert('The count of images should be less than 6.');
            return;
        }
    }

    $('#upload_media_submit_form').submit();
});

$("#upload_media_submit_form").submit(function (e) {

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
            var content_html = $('.new-work-addcontents').html();
            content_html += '<a class="new-work-content" ' +
                'item_type="' + media_type + '" ' +
                'item_path="' + media_path + '"></a>';

            $('.new-work-addcontents').html(content_html);
        }
        else//failed
        {
            alert('Operation failed : ' + ret.data);
            $(".uploading_backdrop").hide();
            $(".progressing_area").hide();
        }
    });

});

/*
::Get Contents From List
 */
function makeTeacherContentItem(orderNo, contentInfo) {

    var output_html = '';
    var blockInfo = Math.floor(orderNo / 4);
    output_html += '<div class="my-task-item-wrapper teacher-task-block-' + blockInfo + '" style="display: none">';
    output_html += '<div class="sharing-title" onclick="viewTeacherTask(' + contentInfo.content_id + ')">' + contentInfo.content_title + '</div>';
    output_html += '<div class="sharing-author">' + contentInfo.fullname + '</div>';
    output_html += '<div class="sharing-time">' + contentInfo.apply_time + '</div>';
    output_html += '</div>';

    return output_html;
}

function TeacherContentInitPager(contentlist) {
    var output_html = '';
    for (var i = 0; i < contentlist.length; i++) {
        var tempObj = contentlist[i];
        output_html += makeTeacherContentItem(i, tempObj);
    }
    totalTeacherPageCount = Math.floor(contentlist.length / 4);

    $('#teacher-sharing-contents-container').html(output_html);
}

function showTeacherContentPage(pageNo) {
    $('.teacher-task-block-' + pageNo).fadeIn(400);
}

function hideTeacherContentPage(pageNo) {
    $('.teacher-task-block-' + pageNo).fadeOut(400);
}

function nextTeacherContentPage() {
    if (cur_TeacherPageNo > totalTeacherPageCount - 1) return;
    else {
        hideTeacherContentPage(cur_TeacherPageNo);
        setTimeout(function () {
            cur_TeacherPageNo++;
            showTeacherContentPage(cur_TeacherPageNo);
        }, 400);
    }
}

function prevTeacherContentPage() {
    if (cur_TeacherPageNo < 1) return;
    else {
        hideMyTaskPage(cur_TeacherPageNo);
        setTimeout(function () {
            cur_TeacherPageNo--;
            showMyTaskPage(cur_TeacherPageNo);
        }, 400)
    }
}

teacherContentList = JSON.parse(myTeacherContentSets);
TeacherContentInitPager(teacherContentList);
showTeacherContentPage(0);