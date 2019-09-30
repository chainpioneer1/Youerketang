$('.bg').css({background: 'url(' + imageDir + 'assets/images/resource/preview/bg.png) no-repeat'});
$('.frame').css({background: 'url(' + imageDir + 'assets/images/resource/preview/frame.png) no-repeat'});
var currentPageIndex = 0;
var totalpageCount = 0;
var countperpage = 6;

$(function () {
    if (courseList.length > 0) {
        totalpageCount = Math.ceil(courseList.length / countperpage);
        showPreviewCourseList(courseList.slice(0, 6));
        courseItemPlay(courseList[0].id, courseList);
        if (courseList.length <= countperpage) {
            $('.prev_btn').css("display", "none");
            $('.next_btn').css("display", "none");
        }
    } else {
        $('.prev_btn').css("display", "none");
        $('.next_btn').css("display", "none");
    }
});

function showPreviewCourseList(courseList) {
    $('.preview_list_container').html('');
    var content_html = "";
    for (var i = 0; i < courseList.length; i++) {
        var item = courseList[i];
        content_html += '<div class="preview_list_item" onclick="itemClick(this)" itemid="' + item.id + '">' + item.course_name + '</div>';
    }
    $('.preview_list_container').html(content_html);
}

function itemClick(self) {
    var itemId = self.getAttribute("itemid");
    courseItemPlay(itemId);
}

function nextCourseList(self) {
    if (currentPageIndex + 1 > totalpageCount) return;
    currentPageIndex++;
    getCourseList(currentPageIndex);
}

function prevCourseList(self) {
    if (currentPageIndex <= 0) return;
    currentPageIndex--;
    getCourseList(currentPageIndex);
}

function getCourseList(currentPageIndex) {
    var tempCourseList;
    var firstSlice = (currentPageIndex) * countperpage;
    var lastSlice = (currentPageIndex + 1) * countperpage;
    if (lastSlice < courseList.length) tempCourseList = courseList.slice(firstSlice, lastSlice);
    else tempCourseList = courseList.slice(firstSlice, courseList.length);
    showPreviewCourseList(tempCourseList);
}

function courseItemPlay(itemid, courseList) {
    if (courseList == undefined) courseList = this.courseList;
    var url = baseURL;
    var item;
    for (var i = 0; i < courseList.length; i++) {
        if (courseList[i].id == itemid) item = courseList[i];
    }
    var isPDF = false;
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
            url = "https://view.officeapps.live.com/op/embed.aspx?src=" + baseURL + item.course_path + "";
            break;
        case 5:
            url += "assets/js/toolset/video_player/pdfplayer.php?ncw_file=" + baseURL + item.course_path + "";
            break;
        case 6:
            url += item.course_path;
            break;
    }
    console.log(url);
    if (isPDF) {
        // history.replaceState(null,null,'');
        $('.course_content_area').attr("src", '');
        $('.course_content_area').fadeOut('fast');
        // $('.pdf_container').fadeIn('fast');
        // $('.pdf_content').attr("src", "");
        // $('.pdf_content').attr("src", baseURL + item.course_path);
        //  $('.pdf_content').fadeOut('slow');
    } else {
        // history.replaceState(null, null, '');
        // $('.pdf_container').attr("src", "");
        $('.pdf_container').fadeOut("fast");
        $('iframe.course_content_area').attr("src", '');
        // history.replaceState(null,null,url);
        $('iframe.course_content_area').attr("src", url);
        $('iframe.course_content_area').fadeIn('slow');
    }
    console.log(history.length);
}

