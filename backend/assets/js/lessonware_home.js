$('.bg').css({background: 'url(' + baseURL + 'assets/images/resource/lessonware/lessonware2/bg.png) no-repeat'});
var lessonInfoList = [];
var isEditFlag = false;
$(function () {

    $('#title_input').val(localStorage.getItem('title'));

    $('#resource-nav-item' + (selectedIndex + 1)).css({background: 'url(' + baseURL + '/assets/images/resource/education/menu' + (selectedIndex + 1) + '_clicked.png)'});

    $('#resource-nav-item' + (selectedIndex + 1)).on('mouseout', function (object) {
        var id = $(this).attr('itemid');
        $(this).css({background: 'url(' + baseURL + 'assets/images/resource/education/menu' + (selectedIndex + 1) + '_clicked.png)'});
    })

    $('#resource-nav-item' + (selectedIndex + 1)).on('mouseover', function (object) {
        var id = $(this).attr('itemid');
        $(this).css({background: 'url(' + baseURL + 'assets/images/resource/education/menu' + (selectedIndex + 1) + '_clicked.png)'});
    })
    lessonList_OutPut(processIndex);
    courseList_OutPut(processIndex);
    if (lessonList.length > 0 ){
        for (var i = 0; i < lessonList.length; i++) {
            if (lessonList[i].id === processIndex + "") lessonInfoList = lessonList[i].lesson_info.replace("[", "").replace("]", "").split(",");
        }
    }
    homeList_OutPut(processIndex, lessonInfoList);
    local_courseList_OutPut(courseList);

    $('.source_btn').css({background: 'url(' + baseURL + 'assets/images/resource/lessonware/lessonware2/source_btn_clicked.png) no-repeat'});
    $('.source_btn').on("click", function (object) {
        $('.source_btn').css({background: 'url(' + baseURL + 'assets/images/resource/lessonware/lessonware2/source_btn_clicked.png) no-repeat'});
        $('.local_btn').css({background: 'url(' + baseURL + 'assets/images/resource/lessonware/lessonware2/local.png) no-repeat'});
        $('.course_source_container').css("display", "block");
        $('.course_local_container').css("display", "none");

    })

    $('.local_btn').on("click", function (object) {
        $('.source_btn').css({background: 'url(' + baseURL + 'assets/images/resource/lessonware/lessonware2/source_btn.png) no-repeat'});
        $('.local_btn').css({background: 'url(' + baseURL + 'assets/images/resource/lessonware/lessonware2/local_clicked.png) no-repeat'});
        $('.course_source_container').css("display", "none");
        $('.course_local_container').css("display", "block");
    })

    $('.title_edit').on("click", function (object) {
        $('#title_input').removeAttr("disabled");
        $('#title_input').css({"background": "white"});
        $('#title_input').focus();
    });

    $('#title_input').on('blur', function (object) {
        $(this).attr('disabled', 'disabled');
        $(this).css({'background': 'transparent'});
    });

    $('.lesson_list_item').on("click", function (object) {
        $('.lesson_list_item').css({background: 'url(' + baseURL + 'assets/images/resource/lessonware/lessonware2/xiaodibai.png) no-repeat'});
        $('.lesson_list_item').removeAttr('sel')
        var itemId = $(this).attr("itemid");
        $('.lesson_list_item[itemid=' + itemId + ']').css({background: 'url(' + baseURL + 'assets/images/resource/lessonware/lessonware2/xiaodibai_clicked.png) no-repeat'});
        $('.lesson_list_item[itemid=' + itemId + ']').attr('sel', '1')
        courseList_OutPut(itemId);

        $('.lesson_list_item').on('mouseover', function () {
            var itemId = $(this).attr("itemid");
            $(this).css({background: 'url(' + baseURL + 'assets/images/resource/lessonware/lessonware2/xiaodibai_clicked.png) no-repeat'});
        }).on('mouseout', function () {
            var itemStatus = $(this).attr('sel');
            if (itemStatus != '1')
                $(this).css({background: 'url(' + baseURL + 'assets/images/resource/lessonware/lessonware2/xiaodibai.png) no-repeat'});
        })
    })

    $('.upload_btn').on("click", function (e) {
        e.preventDefault();
        $('#upload_lw_courseware').val("");
        $('#upload_lw_courseware').trigger("click");
    })

    $('.cancel_btn').on("click", function (e) {

        $("#lw_delete_modal").modal({
            backdrop: 'static',
            keyboard: false
        });

        $('.modal-backdrop').on("click", function (object) {
            console.log('hide request')
            $("#lw_delete_modal").modal('hide');
        });
    })

    $('.save_btn').on("click", function (e) {
        console.log(lessonInfoList);
        var lessonInfo = '[';
        if (lessonInfoList.length > 0) {
            for (var i = 0; i < lessonInfoList.length; i++) {
                lessonInfo += lessonInfoList[i];
                if (i != lessonInfoList.length - 1) lessonInfo += ",";
                else lessonInfo += "]";
            }
        } else lessonInfo += "]";
        console.log(lessonInfo);
        if (processIndex != 0) {
            jQuery.ajax({
                type: "post",
                url: baseURL + "resource/updateLessonInfo",
                dataType: "json",
                data: {
                    site_id: site_id,
                    lesson_id: processIndex,
                    lesson_info: lessonInfo,
                    lesson_name: $('#title_input').val()
                },
                success: function (res) {
                    if (res.status == 'success') {
                        $(".lessonware_table table tbody").html(res.data);
                        console.log('lesson updating has been successed!')
                        location.href = baseURL + "resource/lessonware/" + site_id;
                    }
                    else//failed
                    {
                        alert("Cannot update lesson Item.");
                    }
                }
            });
        } else {
            jQuery.ajax({
                type: "post",
                url: baseURL + "resource/addLesson",
                dataType: "json",
                data: {
                    site_id: site_id,
                    lesson_info: lessonInfo,
                    lesson_name: $('#title_input').val(),
                    owner_type: loggedUserId
                },
                success: function (res) {
                    if (res.status == 'success') {
                        $(".lessonware_table table tbody").html(res.data);
                        console.log('lesson adding has been successed!')
                        location.href = baseURL + "resource/lessonware/" + site_id;
                    }
                    else//failed
                    {
                        alert("Cannot add lesson Item.");
                    }
                }
            });
        }
    })

    $('.preview-btn').on("click", function () {
        var lessonInfo = '';
        if (lessonInfoList.length > 0) {
            for (var i = 0; i < lessonInfoList.length; i++) {
                lessonInfo += lessonInfoList[i];
                if (i != lessonInfoList.length - 1) lessonInfo += "_";
            }
        }
        sessionStorage.setItem("__id",$("#title_input").val());
        var win = window.open(baseURL + "resource/warePreviewPlayer/" + processIndex + "/" + lessonInfo , '_blank');
        win.focus();
    })

    $($('.lesson_list_container .lesson_list_item')[0]).trigger('click');

});
function cancelEdit(self) {
    $("#lw_delete_modal").modal('hide');
    location.href = baseURL + "resource/lessonware/" + site_id;
}
function lessonList_OutPut(processIndex) {
    var content_html = "";
    for (var i = 0; i < packageList.length; i++) {
        var item = packageList[i];
        if (item.status == 1)
            content_html += '<div class="lesson_list_item" itemid="' + item.id + '">' +
                item.title + '</div>';
    }
    $('.lesson_list_container').html(content_html);
    $('.lesson_list_item[itemid=' + processIndex + ']').css({background: 'url(' + baseURL + 'assets/images/resource/lessonware/lessonware2/xiaodibai_clicked.png) no-repeat'});
}

function courseList_OutPut(processIndex) {
    var content_html = "";
    for (var i = 0; i < courseList.length; i++) {
        var item = courseList[i];

        if (item.package_id == processIndex && item.owner_type == 0) content_html += '<div class="course_list_item" itemid="' + item.id + '">' +
            '<div class="course_list_item_label" onclick="courseItemClick(this)" itemid="' + item.id + '">' + item.course_name + '</div>' +
            '<div class="course_list_item_play_btn" onclick="courseItemPlay(this)" itemid="' + item.id + '"></div></div>';
    }

    $('.course_list_container').html(content_html);
}

function local_courseList_OutPut(courseList) {
    var content_html = "";
    for (var i = 0; i < courseList.length; i++) {
        var item = courseList[i];
        if (item.owner_type == loggedUserId) content_html += '<div class="course_list_item" itemid="' + item.id + '">' +
            '<div class="course_list_item_label" onclick="courseItemClick(this)" itemid="' + item.id + '">' + item.course_name + '</div>' +
            '<div class="course_list_item_play_btn" onclick="courseItemPlay(this)" itemid="' + item.id + '"></div></div>';
    }

    $('.added_course_list_container').html(content_html);
}

function homeList_OutPut(processIndex, lessonInfoList) {
    var content_html = "";
    for (var i = 0; i < lessonInfoList.length; i++) {
        for (var j = 0; j < courseList.length; j++) {
            if (courseList[j].id == lessonInfoList[i]) {
                var item = courseList[j];
                var courseType = item.course_type;
                if (courseType === '0')courseType = '1';
                content_html += '<div class="home_list_item" itemid="' + item.id + '">'
                    // + '<div class="home_list_item_icon" style="background: url(' + baseURL + '/assets/images/resource/lessonware/lessonware2/tubiao' + courseType + '.png);" '
                    + '<div class="home_list_item_icon" style="background: url(' + baseURL + item.image_path+');" '
                    + 'itemid="' + item.id + '"></div>'
                    + '<div class="delete_home_item_btn" onclick="deleteHomeListItem(this)" itemid="' + item.id + '"></div>'
                    + '<div class="home_list_item_label" itemid="' + item.id + '">' + item.course_name + '</div>'
                    + '</div>';
            }
        }

    }
    console.log(content_html);
    $('.lessonware_home_container').html('');
    $('.lessonware_home_container').html(content_html);
    $('.lessonware_home_container .home_list_item').on('mouseover', function () {
        var itemId = $(this).attr('itemid');
        $(this).css({background: 'rgba(0,0,0,.1)', 'border-radius': '10%'});
        $(this).find('div.delete_home_item_btn').fadeIn('fast');
    }).on('mouseout', function () {
        var itemId = $(this).attr('itemid');
        $(this).css({background: 'transparent'});
        $(this).find('div.delete_home_item_btn').fadeOut('fast');
    })
}

function courseItemClick(self) {
    var itemId = self.getAttribute("itemid");
    console.log(lessonInfoList);
    if (lessonInfoList.indexOf(itemId) === -1) {
        lessonInfoList.push(itemId);
        console.log(lessonInfoList);
        homeList_OutPut(itemId, lessonInfoList);
    } else alert("已经存在");

}

function courseItemPlay(self) {
    var itemId = self.getAttribute("itemid");
    showVideoPlayer(itemId, 1);
    return;
    var url = baseURL;
    var item;
    for (var i = 0; i < courseList.length; i++) {
        if (courseList[i].id == itemId) item = courseList[i];
    }
    switch (parseInt(item.course_type)) {
        case 1:
            url += item.course_path + '/index.html';
            break;
        case 2:
            url += "assets/js/toolset/video_player/vplayer.php?ncw_file=" + baseURL + item.course_path + "";
            break;
        case 3:
            url += "assets/js/toolset/video_player/iplayer.php?ncw_file=" + baseURL + item.course_path + "";
            break;
        case 4:
            url += "assets/js/toolset/video_player/docviewer.php?ncw_file=" + baseURL + item.course_path + "";
            break;
        case 5:
            url += "assets/js/toolset/video_player/docviewer.php?ncw_file=" + baseURL + item.course_path + "";
            break;
    }
    console.log(url);
    $('.lessonware_toolset').attr("src", '');
    $('.lessonware_toolset').attr("src", url);
    $('.lessonware_toolset').fadeIn('slow');
}

function deleteHomeListItem(self) {
    var delete_id = self.getAttribute("itemid");
    console.log(lessonInfoList);
    lessonInfoList.splice(lessonInfoList.indexOf(delete_id), 1);
    console.log(lessonInfoList);
    homeList_OutPut(processIndex, lessonInfoList);
}

$('#upload_lw_courseware').on('change', function (event) {
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
        console.log(filename);
        var name = filename.split('.');
        filename = "";
        for (var i = 0; i < name.length - 1; i++) {
            filename += name[i];
        }
        console.log(name[name.length - 1]);
        $('#upload_lw_name').val(filename);
        $('#upload_lw_type').val(name[name.length - 1]);
    }
    $('#upload_lesson_id').val(0);
    $('#upload_userId').val(loggedUserId);
    $('#upload_lw_submit_form').submit();
});

jQuery("#upload_lw_submit_form").submit(function (e) {

    e.preventDefault();

    $(".uploading_backdrop").show();
    $(".progressing_area").show();

    var fdata = new FormData(this);
    $.ajax({
        url: baseURL + "resource/add_lesson_courseware",
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
        console.log(res);
        try {
            ret = JSON.parse(res);
        } catch (e) {
            $(".uploading_backdrop").hide();
            $(".progressing_area").hide();
            alert('Operation failed : ' + JSON.stringify(e));
            console.log(e);
            return;
        }
        if (ret.status == 'success') {
            $(".uploading_backdrop").hide();
            $(".progressing_area").hide();
            courseList = ret.courseList;
            local_courseList_OutPut(ret.data);
        }
        else//failed
        {
            alert('Operation failed : ' + res);
            $(".uploading_backdrop").hide();
            $(".progressing_area").hide();
            // jQuery('#ncw_edit_modal').modal('toggle');
            // alert(ret.data);
        }
    });

});