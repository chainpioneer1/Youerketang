// script for mylesson page.

CONF.olditemId = '';
CONF.oldTxt = '';
CONF.newTxt = '';
CONF.titleCnt = 0;
CONF.viewCnt = 8;
CONF.curViewPos = 0;
CONF.curNavId = 1;
CONF.curLessonId = 1;
CONF.isEditMode = false;

var nav = $('.courseview-nav .mainnav-item');
var oldCoursewares;
$(function () {

// for global options.

    if (setSessionConf().isEditMode == undefined) setSessionConf(CONF);
    else CONF = setSessionConf();

    if (CONF.isEditMode) {
        $('.media-done').show('fast');
        $('.media-add').show('fast');
        $('.media-edit').hide('fast');
    } else {
        $('.media-edit').show('fast');
        $('.media-done').hide('fast');
        $('.media-add').hide('fast');
    }

// for mylesson_prepare page.
    nav.on('mouseover', function () {
        this.style.background = 'url(' + baseURL + 'assets/images/taiyang/mylesson_prepare/nav'
            + $(this).attr('item_id') + '_hover.png) no-repeat';
    });
    nav.on('mouseout', function () {
        if ($(this).attr('active') != 'true')
            this.style.background = 'url(' + baseURL + 'assets/images/taiyang/mylesson_prepare/nav'
                + $(this).attr('item_id') + '.png) no-repeat';
    });
    nav.on('mouseup', function () {
        $('.courseview-subnav').hide('fast');
        $('.courseview-subnav[item_id=' + $(this).attr('item_id') + ']').show('fast');
        for (var i = 0; i < nav.length; i++) {
            if (i + 1 == parseInt($(this).attr('item_id'))) continue;
            nav[i].style.background = 'url(' + baseURL
                + 'assets/images/taiyang/mylesson_prepare/nav' + (i + 1) + '.png) no-repeat';
            nav[i].removeAttribute('active');
        }
        $(this).attr('active', 'true');
        $(this).trigger('mouseover');
        var itemId = parseInt($(this).attr('item_id'));
        CONF.curNavId = itemId;
        setSessionConf(CONF);
        showMediaItems(itemId);
    });
    for (var i = 0; i < nav.length; i++) {
        nav[i].style.background = 'url(' + baseURL
            + 'assets/images/taiyang/mylesson_prepare/nav' + (i + 1) + '.png) no-repeat';
        nav[i].setAttribute('item_id', (i + 1));
        // if ((i + 1) == parseInt(CONF.curNavId)) {
        //     $(nav[i]).trigger('mouseup');
        // }
    }

// for mylesson page
    showTitleItems(true);

    if (!setSessionConf().isEditMode) {
        CONF.curLessonId = parseInt($($('.title-item .btn-navigate')[0]).attr('item_id'));
        setSessionConf(CONF);
    }
    $(nav[CONF.curNavId - 1]).trigger('mouseup');
    $('.title-item .btn-navigate[item_id=' + CONF.curLessonId + ']').trigger('click');

});

function updateTitles() {
    $.ajax({
        type: 'POST',
        url: baseURL + 'coursewares/getLessonItems', //rest API url
        dataType: 'json',
        data: {'userId': CONF.loginUserId}, // set function name and parameters
        success: function (data) {
            if (data.status == "success") {
                setSessionLessons(data.data.lessons);
                setSessionCoursewares(data.data.coursewares);
                // setSessionBackupCoursewares(data.data.coursewares, true);
                showTitleItems(true);
                showMediaItems_lesson(CONF.curLessonId);
                showMediaItems(CONF.curNavId);
                $('.title-item .btn-navigate[item_id=' + CONF.curLessonId + ']').trigger('click');
                $('.btn-update').removeClass('btn-editdone');
            }
        },
        error: function (data) {
            //alert('服务器错误。');
        }
    });
}

function showTitleItems(isUpdateCnt) {

    var oldId = '';
    var content_html = "";
    var cnt = 0;
    var titleItems = setSessionLessons();
    if (isUpdateCnt == undefined) isUpdateCnt = false;

    if (isUpdateCnt) CONF.titleCnt = 0;
    $('.title-panel').hide();

    for (var i = 0; i < titleItems.length; i++) {
        var item = titleItems[i];
        // if (oldId != item.childcourse_id) {
        oldId = item.title_id;
        if (isUpdateCnt) CONF.titleCnt++;
        if (cnt >= CONF.curViewPos && cnt < CONF.curViewPos + CONF.viewCnt) {

            content_html += '<div class="title-item" ' +
                ' item_id="' + oldId + '">' +
                '<input class="title-edit" disabled item_id="' + oldId + '" ' +
                ' value="' + item.media_name + '" sel="0"/>' +
                '<a class="btn-navigate" item_id="' + oldId + '"></a>' +
                '<a class="btn-update" item_id="' + oldId + '"></a>' +
                '<a class="btn-delete" item_id="' + oldId + '"></a>' +
                '</div>';
        }
        cnt++;
        // }
    }

    $('.title-panel').html(content_html);
    $('.title-panel').fadeIn('middle');

    var titleEdit = $('.title-edit');

    $('.btn-update').on('click', function (e) {
        e.preventDefault();
        var inputItem = $(this).parent().children()[0];
        var itemId = $(this).attr('item_id');

        $('.title-item .btn-navigate').hide();
        $('.title-item .btn-navigate[item_id=' + itemId + ']').trigger('click');
        if ($(inputItem).attr('disabled') == 'disabled') {// now disabled, enable editing
            CONF.olditemId = itemId;
            CONF.oldTxt = $(inputItem).val();
            $(titleEdit).attr('disabled', 'true');
            $(inputItem).removeAttr('disabled');
            $(inputItem).focus();
            $('.btn-update[item_id=' + itemId + ']').addClass('btn-editdone');

        } else { // edit finished
            $('.btn-update[item_id=' + itemId + ']').removeClass('btn-editdone');
            if (itemId == CONF.olditemId) { //perform update, finish editing
                $(inputItem).val(CONF.newTxt);
                CONF.oldTxt = CONF.newTxt;
                $(inputItem).trigger('blur');

                if (parseInt(itemId) == 10000) {
                    $.ajax({
                        type: 'POST',
                        url: baseURL + 'coursewares/addLessonItem', //rest API url
                        dataType: 'json',
                        data: {
                            author_id: CONF.loginUserId,
                            lesson_name: CONF.newTxt
                        }, // set function name and parameters
                        success: function (data) {
                            updateTitles();
                        },
                        error: function (data) {
                            //alert('服务器错误。');
                        }
                    });
                } else {
                    $.ajax({
                        type: 'POST',
                        url: baseURL + 'coursewares/updateLessonItem', //rest API url
                        dataType: 'json',
                        data: {
                            item_id: itemId,
                            lesson_name: CONF.newTxt,
                            media_infos: ''
                        }, // set function name and parameters
                        success: function (data) {
                            updateTitles();
                        },
                        error: function (data) {
                            //alert('服务器错误。');
                        }
                    });
                }

            }
        }
    });
    $('.title-item .btn-delete').on('click', function (e) {
        e.preventDefault();
        var itemId = $(this).attr('item_id');

        if (!confirm("Do you want delete this item now?")) return;
        var titleItem = $('.title-item[item_id=' + itemId + ']');
        var title = titleItem.find('input')[0].value;

        if (title != "") {
            $.ajax({
                type: 'POST',
                url: baseURL + 'coursewares/removeLessonItem', //rest API url
                dataType: 'json',
                data: {lessonId: itemId}, // set function name and parameters
                success: function (data) {
                    updateTitles();
                },
                error: function (data) {
                    //alert('服务器错误。');
                }
            });
        } else {
            titleItem.remove();
        }

    });
    $(titleEdit).on('blur', function (e) {
        e.preventDefault();
        $('.title-item .btn-navigate').show();
        var element = $(this);
        CONF.newTxt = element.val();
        element.val(CONF.oldTxt);
        clearTimeout(CONF.tmrID[0]);
        CONF.tmrID[0] = setTimeout(function () {
            element.attr('disabled', 'true');
        }, 500);
    });
    $(titleEdit).on('select', function (e) {
        e.preventDefault();
        if ($(this).attr('disabled') == 'disabled') {
            $(this).removeAttr('disabled');
            $(this).focus();
            this.selectionStart = this.selectionEnd;
            $(this).attr('disabled', 'true');
            $(this).val(CONF.newTxt);
        }
    });
    $('.title-item .btn-navigate').on('click', function (e) {
        e.preventDefault();
        var element = $(this);
        var titleId = element.attr('item_id');

        if (titleId == '10000') return;

        $('.title-edit').attr('sel', '0');
        $('.title-edit[item_id=' + titleId + ']').attr('sel', '1');
        $('.title-edit[sel=0]').css({color: 'white', 'font-weight': 'normal'});
        $('.title-edit[item_id=' + titleId + ']').css({color: '#f9ff00', 'font-weight': 'bold'});

        showMediaItems_lesson(titleId);
        CONF.curLessonId = parseInt(titleId);
        setSessionConf(CONF);
    });
    $('.title-item .btn-navigate').on('mousemove', function (e) {
        e.preventDefault();
        // var posx = e.offsetX;
        var element = $(this);
        var titleId = parseInt(element.attr('item_id'));
        $('.title-edit[sel=0]').trigger('mouseout');
        $('.title-edit[item_id=' + titleId + ']').css({color: '#f9ff00', 'font-weight': 'bold'});
    });
    $('.title-item .btn-navigate').on('mouseout', function (e) {
        e.preventDefault();
        $('.title-edit[sel=0]').css({color: 'white', 'font-weight': 'normal'});
    });
}

function showMediaItems_lesson(title_id) { // navId: lesson_id
    title_id = parseInt(title_id);
    var titleItems = setSessionLessons();
    var mediaItems = setSessionCoursewares();
    var content_html = '';
    $('.mylesson-media').hide();

    var titleItem = [];
    for (var i = 0; i < titleItems.length; i++) {
        var item = titleItems[i];
        if (parseInt(item.title_id) == title_id) {
            titleItem = JSON.parse(item.media_infos);
            break;
        }
    }

    for (var i = 0; i < titleItem.length; i++) {
        var item = titleItem[i];
        for (var j = 0; j < mediaItems.length; j++) {
            if (parseInt(item) == parseInt(mediaItems[j].ncw_id)) {
                item = mediaItems[j];
                content_html += '<div class="media-item" ' +
                    'item_id="' + item.ncw_id + '" ' +
                    'item_type="' + item.ncw_type + '" item_url="' + item.ncw_file + '">' +
                    '<div class="media-title">' + item.ncw_name + '</div>' +
                    '<div class="media-submenu" item_id="' + item.ncw_id + '">' +
                    '<a class="btn-prev" item_id="' + item.ncw_id + '"></a>' +
                    '<a class="btn-next" item_id="' + item.ncw_id + '"></a>' +
                    '<a class="btn-delete" item_id="' + item.ncw_id + '"></a>' +
                    '</div>' +
                    '</div>';
                break;
            }
        }
    }
    $('.mylesson-media').html(content_html);

    $('.mylesson-media').fadeIn('middle');

    $('.media-item').on('click', function (e) {
        var itemid = $(this).attr('item_id');
        if (!CONF.isEditMode) {
            var item_type = $(this).attr('item_type');
            if (item_type == '4') {
                window.open(baseURL + $(this).attr('item_url'), '_blank', 'menubar=no,width=400,height=10,status=no');
            } else if (item_type == '5') {
                window.open(baseURL + $(this).attr('item_url'), '_blank', 'menubar=no,width=680,height=400,status=no');
            } else {
                showCourseware(itemid);
            }
        } else {
            // $('.media-item .media-submenu').hide();
            var mediaPanel = $(this).parent();
            clearTimeout(CONF.tmrID[0]);
            CONF.tmrID[0] = setTimeout(function () {
                $(mediaPanel)
                    .find('.media-item .media-submenu[item_id=' + itemid + ']')
                    .show('fast');
            }, 3);
        }
    })
    $('.media-item .media-submenu a').on('click', function (e) {
        e.preventDefault();
        var subMenu = $(this).parent();
        var mediaItem = $(subMenu).parent();
        clearTimeout(CONF.tmrID[1]);
        CONF.tmrID[1] = setTimeout(function () {
            clearTimeout(CONF.tmrID[0]);
            $(subMenu).hide('fast');
        }, 1);
        var btn_type = $(this).attr('class');
        var itemid = $(this).attr('item_id'); // ncwId
        switch (btn_type) {
            case 'btn-prev':
                updateSessionCoursewares(CONF.curLessonId, itemid, -1);
                $('.btn-navigate[item_id=' + CONF.curLessonId + ']').trigger('click');
                break;
            case 'btn-next':
                updateSessionCoursewares(CONF.curLessonId, itemid, 1);
                $('.btn-navigate[item_id=' + CONF.curLessonId + ']').trigger('click');
                break;
            case 'btn-delete':
                updateSessionCoursewares(CONF.curLessonId, itemid, 0);
                $('.btn-navigate[item_id=' + CONF.curLessonId + ']').trigger('click');
                break;
        }
    })
}

function showMediaItems(title_id) { // navid: course id

    var titleItems = setSessionLessons();
    var mediaItems = setSessionCoursewares();
    var static_content_html = '';
    var temp_content_html = '';

    $('.mylesson-staticmedia').hide();
    $('.mylesson-tmpmedia').hide();

    var titleItem = [];
    for (var i = 0; i < titleItems.length; i++) {
        var item = titleItems[i];
        if (parseInt(item.title_id) == CONF.curLessonId) {
            titleItem = JSON.parse(item.media_infos);
            break;
        }
    }

    for (var i = 0; i < mediaItems.length; i++) {
        var item = mediaItems[i];
        if (item.ncw_publish != '1') continue;

        var isChecked = false;
        for (var j = 0; j < titleItem.length; j++) {
            if (titleItem[j] == item.ncw_id) {
                isChecked = true;
                break;
            }
        }

        if (item.ncw_author_id == '0' &&
            Math.floor((parseInt(item.ncw_id) - 1) / 13) == (parseInt(title_id) - 1)) {
            static_content_html += '<div class="media-item" ' +
                'item_id="' + item.ncw_id + '" ' +
                'item_type="' + item.ncw_type + '">' +
                '<div class="item-checked" item_id="' + item.ncw_id + '" ' +
                'style="display:' + ((isChecked) ? "block" : "none") + '"></div>' +
                '<div class="media-title">' + item.ncw_name + '</div>' +
                '<div class="media-submenu" item_id="' + item.ncw_id + '">' +
                '<a class="btn-view" item_id="' + item.ncw_id + '"></a>' +
                '<a class="btn-select" item_id="' + item.ncw_id + '"></a>' +
                '</div>' +
                '</div>';
        }
        else if (isChecked && parseInt(CONF.curLessonId) == parseInt(item.ncw_sn)) {
            temp_content_html += '<div class="media-item" ' +
                'item_id="' + item.ncw_id + '" ' +
                'item_type="' + item.ncw_type + '">' +
                '<div class="media-title">' + item.ncw_name + '</div>' +
                '<div class="media-submenu" item_id="' + item.ncw_id + '">' +
                '<a class="btn-delete-temp" item_id="' + item.ncw_id + '"></a>' +
                '</div>' +
                '</div>';
        }
    }
    $('.mylesson-staticmedia').html(static_content_html);
    $('.mylesson-tmpmedia').html(temp_content_html);

    $('.mylesson-staticmedia').fadeIn('middle');
    $('.mylesson-tmpmedia').fadeIn('middle');


    $('.media-item').on('click', function (e) {
        var itemid = $(this).attr('item_id');
        if (!CONF.isEditMode) {
            showCourseware(itemid);
        } else {
            // $('.media-item .media-submenu').hide();
            var mediaPanel = $(this).parent();
            clearTimeout(CONF.tmrID[0]);
            CONF.tmrID[0] = setTimeout(function () {
                $(mediaPanel)
                    .find('.media-item .media-submenu[item_id=' + itemid + ']')
                    .show('fast');
            }, 3);
        }
    })
    $('.media-item .media-submenu a').on('click', function (e) {
        e.preventDefault();
        var subMenu = $(this).parent();
        var mediaItem = $(subMenu).parent();
        clearTimeout(CONF.tmrID[1]);
        CONF.tmrID[1] = setTimeout(function () {
            clearTimeout(CONF.tmrID[0]);
            $(subMenu).hide('fast');
        }, 1);
        var btn_type = $(this).attr('class');
        var itemid = $(this).attr('item_id');
        switch (btn_type) {
            case 'btn-view':
                showCourseware(itemid);
                break;
            case 'btn-select':
            case 'btn-select btn-selcancel':
                var chkStatus = $(mediaItem).find('.item-checked').css('display');
                var isChecked = (chkStatus == 'none');
                if (chkStatus == 'none') {
                    $(mediaItem).find('.item-checked').show('fast');
                    $(this).addClass('btn-selcancel');
                    updateSessionCoursewares(CONF.curLessonId, itemid);
                } else {
                    $(mediaItem).find('.item-checked').hide('fast');
                    $(this).removeClass('btn-selcancel');
                    updateSessionCoursewares(CONF.curLessonId, itemid, 0);
                }
                break;
            case 'btn-delete-temp':
                if (!confirm("Do you want delete this item now?")) break;
                $('.media-item[item_id=' + itemid + ']').hide('middle');
                updateSessionCoursewares(CONF.curLessonId, itemid, 0);
                // $.ajax({
                //     type: 'POST',
                //     url: baseURL + 'coursewares/removeLessonCourseware', //rest API url
                //     dataType: 'json',
                //     data: {courseId: itemid}, // set function name and parameters
                //     success: function (data) {
                //         updateTitles();
                //     },
                //     error: function (data) {
                //         //alert('Server Error');
                //     }
                // });
                break;
        }
    })


}

$('.mylesson-media').on('click', function () {
    $('.mylesson-media .media-item .media-submenu').hide('fast');
});

$('.title-bottom a').on('click', function (e) { // arrow buttons
    e.preventDefault();
    var itemid = parseInt($(this).attr('item_id'));
    var old = CONF.curViewPos;
    switch (itemid) {
        case 1:
            if (CONF.curViewPos - CONF.viewCnt >= 0)
                CONF.curViewPos -= CONF.viewCnt;
            break;
        case 2:
            if (CONF.curViewPos + CONF.viewCnt < CONF.titleCnt)
                CONF.curViewPos += CONF.viewCnt;
            break;
    }
    if (old != CONF.curViewPos) showTitleItems();
});

$('.mylesson-title .title-add').on('click', function (e) {
    e.preventDefault();
    var lessons = setSessionLessons();
    var newId = 10000;
    lessons[lessons.length] = {
        title_id: newId.toString(),
        media_name: ''
    };
    setSessionLessons(lessons);
    showTitleItems(true);
})

$('.media-edit').on('click', function () {
    CONF.isEditMode = true;
    setSessionConf(CONF);
    $(this).hide('fast');
    $('.media-add').show('fast');
    $('.media-done').show('fast');
});

$('.media-done').on('click', function (e) {
    e.preventDefault();
    CONF.isEditMode = false;
    setSessionConf(CONF);
    var isUpdated = false;
    var item;
    var lessons = setSessionLessons();
    for (var i = 0; i < lessons.length; i++) {
        var item = lessons[i];
        if (item.title_id == CONF.curLessonId) {
            isUpdated = true;
            break;
        }
    }
    if (isUpdated) {
        $.ajax({
            type: 'POST',
            url: baseURL + 'coursewares/updateLessonItem', //rest API url
            dataType: 'json',
            data: {
                item_id: item.title_id,
                lesson_name: "",
                media_infos: item.media_infos
            }, // set function name and parameters
            success: function (data) {
                $('.media-done').hide('fast');
                $('.media-item .media-submenu').hide('fast');
                $('.media-add').hide('fast');
                $('.media-edit').show('fast');
            },
            error: function (data) {
                //alert('服务器错误。');
            }
        });
    } else {
        $('.media-done').hide('fast');
        $('.media-item .media-submenu').hide('fast');
        $('.media-add').hide('fast');
        $('.media-edit').show('fast');
    }
});

$('.media-add').on('click', function () {
    CONF.isEditMode = true;
    setSessionConf(CONF);
    var lessons = setSessionLessons();
    var isUpdated = false;
    var item;
    for (var i = 0; i < lessons.length; i++) {
        item = lessons[i];
        if (parseInt(item.title_id) == parseInt(CONF.curLessonId)) {
            isUpdated = true;
            break;
        }
    }
    if (isUpdated) {
        $.ajax({
            type: 'POST',
            url: baseURL + 'coursewares/updateLessonItem', //rest API url
            dataType: 'json',
            data: {
                item_id: item.title_id,
                lesson_name: "",
                media_infos: item.media_infos
            }, // set function name and parameters
            success: function (data) {
                location.href = baseURL + "coursewares/mylesson_prepare";
            },
            error: function (data) {
                //alert('服务器错误。');
            }
        });
    } else {
        location.href = baseURL + "coursewares/mylesson_prepare";
    }
});

$('.mylesson-staticmedia').on('click', function () {
    $('.mylesson-staticmedia .media-item .media-submenu').hide('fast');
});

function mylesson_prepare_done() {

    var isUpdated = false;
    var lessons = setSessionLessons();
    var item;
    for (var i = 0; i < lessons.length; i++) {
        item = lessons[i];
        if (parseInt(item.title_id) == parseInt(CONF.curLessonId)) {
            isUpdated = true;
            break;
        }
    }
    if (isUpdated) {
        $.ajax({
            type: 'POST',
            url: baseURL + 'coursewares/updateLessonItem', //rest API url
            dataType: 'json',
            data: {
                item_id: item.title_id,
                lesson_name: "",
                media_infos: item.media_infos
            }, // set function name and parameters
            success: function (data) {
                location.href = baseURL + 'coursewares/mylesson';
            },
            error: function (data) {
                //alert('服务器错误。');
            }
        });
    } else {
        location.href = baseURL + 'coursewares/mylesson';
    }
}

function mylesson_prepare_cancel() {
    location.href = baseURL + 'coursewares/mylesson';
}

$('.mylesson-tmpmedia').on('click', function () {
    $('.mylesson-tmpmedia .media-item .media-submenu').hide('fast');
});


$('.media-upload').on('click', function (e) {
    e.preventDefault();
    $('#upload_ncw_courseware').val('');
    $('#upload_ncw_courseware').trigger('click');
});

$('#upload_ncw_courseware').on('change', function (event) {
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
        $('#upload_ncw_name').val(filename);
        $('#upload_ncw_type').val(name[name.length - 1]);
    }
    $('#upload_lesson_id').val(CONF.curLessonId);
    $('#upload_userId').val(CONF.loginUserId);
    var lessonItems = setSessionLessons();
    var lessonItem;
    for (var i = 0; i < lessonItems.length; i++) {
        var item = lessonItems[i];
        if (lessonItems[i].title_id == CONF.curLessonId) {
            lessonItem = item;
            break;
        }
    }
    $('#upload_lessonItem').val(JSON.stringify(lessonItem));
    $('#upload_ncw_submit_form').submit();
});

jQuery("#upload_ncw_submit_form").submit(function (e) {

    e.preventDefault();

    $(".uploading_backdrop").show();
    $(".progressing_area").show();

    var fdata = new FormData(this);

    $.ajax({
        url: baseURL + "coursewares/add_lesson_courseware",
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
            updateTitles();
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


$(window).load(function () {

    if (window.addEventListener) {
        window.addEventListener('message', receiveMessage, false);
    } else {
        window.attachEvent('onmessage', receiveMessage);
    }

    //init for script work
    var subware_path = $('#script').attr('subware_path');
    var sw_publish = $('#script').attr('subware_publish');

    if (sw_publish == '1') {
        if (subware_path != 'nosubware') {
            $('iframe').attr('src', baseURL + subware_path);
            $('iframe').attr('height', '800px');
        } else {
            $('.nosubware_msg').show();
        }

    }

    function updateSubwareAccessTime(swTypeId) {

        $.ajax({
            type: "post",
            url: base_url + 'coursewares/update_SW_Access',
            dataType: 'json',
            data: {subware_type_id: swTypeId},
            success: function (res) {
                if (res.status == 'success') {

                } else {
                }
            }
        });
    }

    $('#script').click(function () {
        var subware_path = $(this).attr('subware_path');
        if (subware_path != 'nosubware') {
            $('iframe').attr('src', baseURL + subware_path);
            $('iframe').attr('height', '800px');
        } else {
            $('.nosubware_msg').show();
            updateSubwareAccessTime('1');
        }

        $('#script_image').attr('src', base_url + 'assets/images/frontend/coursewares/view/script_hover.png');
        $('#flash_image').attr('src', base_url + 'assets/images/frontend/coursewares/view/flash.png');
        $('#dubbing_image').attr('src', base_url + 'assets/images/frontend/coursewares/view/dubbing.png');
        $('#shooting_image').attr('src', base_url + 'assets/images/frontend/coursewares/view/shooting.png');

        curr_sw = 'script_sw';
    });
    $('#flash').click(function () {
        var subware_path = $(this).attr('subware_path');
        var sw_publish = $(this).attr('subware_publish');
        if (sw_publish != '1') return;
        if (subware_path != 'nosubware') {
            $('iframe').attr('src', baseURL + subware_path);
            $('iframe').attr('height', '800px');
        } else {
            $('.nosubware_msg').show();
            updateSubwareAccessTime('2');
        }

        $('#script_image').attr('src', base_url + 'assets/images/frontend/coursewares/view/script.png');
        $('#flash_image').attr('src', base_url + 'assets/images/frontend/coursewares/view/flash_hover.png');
        $('#dubbing_image').attr('src', base_url + 'assets/images/frontend/coursewares/view/dubbing.png');
        $('#shooting_image').attr('src', base_url + 'assets/images/frontend/coursewares/view/shooting.png');

        curr_sw = 'flash_sw';

    });

    $('#dubbing').click(function () {

        var subware_path = $(this).attr('subware_path');
        var sw_publish = $(this).attr('subware_publish');
        if (sw_publish != '1') return;
        if (subware_path != 'nosubware') {
            $('iframe').attr('src', baseURL + subware_path);
            $('iframe').attr('height', '800px');
        } else {
            $('.nosubware_msg').show();
            updateSubwareAccessTime('3');
        }

        $('#script_image').attr('src', base_url + 'assets/images/frontend/coursewares/view/script.png');
        $('#flash_image').attr('src', base_url + 'assets/images/frontend/coursewares/view/flash.png');
        $('#dubbing_image').attr('src', base_url + 'assets/images/frontend/coursewares/view/dubbing_hover.png');
        $('#shooting_image').attr('src', base_url + 'assets/images/frontend/coursewares/view/shooting.png');

        curr_sw = 'dubbing_sw';

    });

    $('#shooting').click(function () {
        var subware_path = $(this).attr('subware_path');
        var sw_publish = $(this).attr('subware_publish');
        if (sw_publish != '1') return;

        if (subware_path != 'nosubware') {
            $('iframe').attr('src', baseURL + subware_path);
            $('iframe').attr('height', '800px');
        } else {
            $('.nosubware_msg').show();
            updateSubwareAccessTime('4');
        }

        $('#script_image').attr('src', base_url + 'assets/images/frontend/coursewares/view/script.png');
        $('#flash_image').attr('src', base_url + 'assets/images/frontend/coursewares/view/flash.png');
        $('#dubbing_image').attr('src', base_url + 'assets/images/frontend/coursewares/view/dubbing.png');
        $('#shooting_image').attr('src', base_url + 'assets/images/frontend/coursewares/view/shooting_hover.png');

        curr_sw = 'shooting_sw';

    });

    function receiveMessage(event) {

        var iframe = document.getElementById('courseware_iframe').contentWindow;
        var message = event.data; //this is the message
        message = JSON.parse(message);

        if (message.type == 'get-courseware-id') {
            var courseware_id = $('#script').data('courseware_id');
            var response = {
                type: 'courseware-id',
                value: courseware_id,
                login_status: login_status,
                login_username: login_username,
                base_URL: base_url
            };
            iframe.postMessage(JSON.stringify(response), '*');
        }
    }


});