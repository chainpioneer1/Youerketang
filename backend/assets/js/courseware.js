// script for course view page.

$('.bg').css({background: 'url(' + imageDir + 'courseview/bg.png) no-repeat'});

var nav = $('.courseview-nav .mainnav-item');
var courseItem = $('.courseview-item');
var courseId = parseInt($('#courseId').val());
$(function () {

    nav.on('mouseover', function () {
        this.style.background = 'url(' + imageDir + 'courseview/nav'
            + $(this).attr('item_id') + '_hover.png) no-repeat';
    });
    nav.on('mouseout', function () {
        if ($(this).attr('active') != 'true')
            this.style.background = 'url(' + imageDir + 'courseview/nav'
                + $(this).attr('item_id') + '.png) no-repeat';
    });
    nav.on('mouseup', function () {
        $('.courseview-subnav').fadeOut('middle');
        $('.courseview-subnav[item_id=' + $(this).attr('item_id') + ']').fadeIn('middle');
        for (var i = 0; i < nav.length; i++) {
            if (i + 1 == parseInt($(this).attr('item_id'))) continue;
            nav[i].style.background = 'url(' + imageDir
                + 'courseview/nav' + (i + 1) + '.png) no-repeat';
            nav[i].removeAttribute('active');
        }
        $(this).attr('active', 'true');
        $(this).trigger('mouseover');
    });
    courseItem.on('mouseover', function () {
        if ($(this).attr('href') == '#')
            $(this).css({color: 'white'});
    })
    courseItem.on('mouseout', function () {
        if ($(this).attr('href') == '#')
            $(this).css({color: $(this).attr('old_color')});
    })
    for (var i = 0; i < nav.length; i++) {
        nav[i].style.background = 'url(' + imageDir
            + 'courseview/nav' + (i + 1) + '.png) no-repeat';
        nav[i].setAttribute('item_id', (i + 1));
        if (i == parseInt(courseId / 13)) {
            $(nav[i]).trigger('mouseup');
        }
    }
    if (parseInt(courseId) < 52) {
        $(courseItem[courseId]).trigger('click');
    } else {
        var url = baseURL;
        var item = {};
        for (var i = 0; i < all_coursewares.length; i++) {
            item = all_coursewares[i];
            if (item.ncw_id == (courseId + 1).toString()) {
                break;
            }
        }
        switch (parseInt(item.ncw_type)) {
            case 1:
                url += item.ncw_file+'/index.html';
                break;
            case 2:
                url += "assets/js/toolset/video_player/vplayer.php?ncw_file=" + baseURL + item.ncw_file + "";
                break;
            case 3:
                url += "assets/js/toolset/video_player/iplayer.php?ncw_file=" + baseURL + item.ncw_file + "";
                break;
            case 4:
                url += "assets/js/toolset/video_player/docviewer.php?ncw_file=" + baseURL + item.ncw_file + "";
                break;
        }
        showPackage(url);
        $(nav[0]).trigger('mouseup');
    }
});

function showPackage(url, element) {
    $('#courseware_iframe').attr('src', url);
    courseItem.css({background: 'transparent'});

    if (element != undefined)
        $(element).css({'background': 'rgba(255,255,255,0.2)'});
}

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