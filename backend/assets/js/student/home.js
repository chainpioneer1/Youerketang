/**
 * Created by Administrator on 6/12/2017.
 */

var nav_left = $('.nav-left');
var nav_right = $('.nav-right');

// $('.bg').css({background: 'url(' + imageDir + 'home/home.png) no-repeat'});
$('.bg').css({background: 'white'});
nav_left.on('click', function (e) {
    var element = $(this);
    var item_id = element.attr('item_id');
    var idx = parseInt(item_id.substr(1));
    idx--;
    if (idx <= 0) idx = 3;
    $('.course-content[item_id=' + (item_id.substr(0, 1)) + (idx) + ']').css({opacity: '1', 'z-index': '1'});
    $('.course-content[item_id=' + item_id + ']').css({opacity: '0', 'z-index': '0'});

});

nav_right.on('click', function (e) {
    var element = $(this);
    var item_id = element.attr('item_id');
    var idx = parseInt(item_id.substr(1));
    idx++;
    if (idx >= 4) idx = 1;
    $('.course-content[item_id=' + (item_id.substr(0, 1)) + (idx) + ']').css({opacity: '1', 'z-index': '1'});
    $('.course-content[item_id=' + item_id + ']').css({opacity: '0', 'z-index': '0'});

});

function showCourse(id) {
    if (CONF.loginUserId != "") {
        location.href = baseURL + "coursewares/view/" + id;
    }
}

var alert_tmr;

function showAlert() {
    var tag = '<img id="alert_msg" style="display: none;"' +
        ' src="../assets/images/frontend/home/register_alert.png">';
    if ($('#alert_msg').attr('id') == undefined) $('body').append(tag);
    $('#alert_msg').fadeIn('fast');
    if (alert_tmr != undefined) clearTimeout(alert_tmr);
    alert_tmr = setTimeout(function () {
        $('#alert_msg').fadeOut('fast');
    },3000);
}