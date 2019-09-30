var classList = [
    {id: "1", name: "aoe", path: "uploads/class/kuaile_1"},
    {id: "2", name: "iuvyw", path: "uploads/class/kuaile_2"},
    {id: "3", name: "bpmf", path: "uploads/class/kuaile_3"},
    {id: "4", name: "dtnl", path: "uploads/class/kuaile_4"},
    {id: "5", name: "gkh", path: "uploads/class/kuaile_5"},
    {id: "6", name: "jqx", path: "uploads/class/kuaile_6"},
    {id: "7", name: "zcs", path: "uploads/class/kuaile_7"},
    {id: "8", name: "zhchshr", path: "uploads/class/kuaile_8"},
    {id: "9", name: "aieiui", path: "uploads/class/kuaile_9"},
    {id: "10", name: "aoouiu", path: "uploads/class/kuaile_10"},
    {id: "11", name: "ieueer", path: "uploads/class/kuaile_11"},
    {id: "12", name: "aneninunvn", path: "uploads/class/kuaile_12"},
    {id: "13", name: "angengingong", path: "uploads/class/kuaile_13"},
    {id: "14", name: "other", path: "uploads/class/kuaile_14"}
];

$('a').on('click', function (object) {
    // $('body').fadeOut('fast');
});

$(function () {
    setTimeout(function () {
        $('body').fadeIn('fast');
    }, 10);
});

var mobileVerificationCode = ''
var isVerifying = false;
function sendSMSToServer(phoneNumber) {

    //send SMS sending request in backend server.
    $('#loading').css({display: 'block'});
    mobileVerificationCode = '';
    $.ajax({
        type: 'POST',
        url: baseURL + 'application/controllers/sms/SendTemplateSMS.php', //rest API url
        dataType: 'json',
        data: {'phoneNumber': phoneNumber}, // set function name and parameters
        success: function (data) {
            // get SMS code from received data
            if (data['result'] == "success") {
                // alert('Successfully sent verification code.');
                mobileVerificationCode = data['code'];
                isVerifying = false;
            } else {
                console.log(data);
                alert(data.error[0]);
            }
        },
        fail: function (e) {
            console.log(e);
            alert(e.message);
            isVerifying = false;
        }
    });
}

function showClass(site_id, id, isPopup) {
    if (isPopup == undefined) isPopup = false;
    if (isPopup) {
        var win = window.open(baseURL + "classroom/view/" + site_id + "/" + id, '_blank');
        win.focus();
    } else
        location.href = baseURL + "classroom/view/" + site_id + "/" + id;
}

function showVideoPlayer(id, isPopup, type) {
    id = parseInt(id);
    if (isPopup == undefined) isPopup = false;
    if (isPopup) {
        var win = window.open(baseURL + "resource/playerview/" + id, '_blank');
        win.focus();
    } else
        location.href = baseURL + "resource/playerview/" + id;
}

function showLearningVideoPlayer(id, isPopup) {
    if (isPopup == undefined) isPopup = false;
    if (isPopup) {
        var win = window.open(baseURL + "resource/learningPlayerView/" + id, '_blank');
        win.focus();
    } else
        location.href = baseURL + "resource/learningPlayerView/" + id;
}

function showCourseList(id, isPopup) {
    id = parseInt(id);
    if (isPopup == undefined) isPopup = false;
    if (isPopup) {
        var win = window.open(baseURL + "resource/courselist/" + id, '_blank');
        win.focus();
    } else
        location.href = baseURL + "resource/courselist/" + id;

}
function showReference(id, isPopup) {
    id = parseInt(id);
    if (isPopup == undefined) isPopup = false;
    if (isPopup) {
        var win = window.open(baseURL + "resource/referencePlayer/" + id, '_blank');
        win.focus();
    } else
        location.href = baseURL + "resource/referencePlayer/" + id;

}

function showLessonWare(site_id, id, title, isPopup) {
    id = parseInt(id);
    localStorage.setItem('title', title);
    if (isPopup == undefined) isPopup = false;
    if (isPopup) {
        var win = window.open(baseURL + "resource/lessonware_home/" + site_id + "/" + id, '_blank');
        win.focus();
    } else
        location.href = baseURL + "resource/lessonware_home/" + site_id + "/" + id;

}

function showPreviewPlayer(site_id, id, isPopup) {
    id = parseInt(id);
    if (isPopup == undefined) isPopup = false;
    if (isPopup) {
        var win = window.open(baseURL + "resource/previewPlayer/" + site_id + "/" + id, '_blank');
        win.focus();
    } else
        location.href = baseURL + "resource/previewPlayer/" + site_id + "/" + id;

}

var osStatus = getMobileOperatingSystem();

function getMobileOperatingSystem() {
    var userAgent = navigator.userAgent || navigator.vendor || window.opera;
    // Windows Phone must come first because its UA also contains "Android"
    if (/windows phone/i.test(userAgent)) {
        return "Windows Phone";
    }
    if (/android/i.test(userAgent)) {
        return "Android";
    }
    // iOS detection from: http://stackoverflow.com/a/9039885/177710
    if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
        return "iOS";
    }
    return "unknown";
}

function problemAnswerAudioRecord(){
    console.log('record started');
    if (osStatus === 'Android'){
        Android.recordStart();
    }else if (osStatus === 'iOS'){
        window.location = 'recordStart://' + 'testing';
    }
}

function problemAnswerAudioRecordStop(taskId, probId){
    console.log('record stopped');
    if (osStatus === 'Android'){
        console.log(probId + "-----");
        Android.recordStop(taskId, probId);
    }else if (osStatus === 'iOS'){
        window.location = 'recordStop://' + taskId + ";" + probId;
    }
}

function problemAnswerAudioPlay(){
    console.log('play started');
    if (osStatus === 'Android'){
        Android.audioPlay();
    }else if (osStatus === 'iOS'){
        window.location = 'audioPlay://testing';
    }
}

function problemAnswerAudioPause(){
    console.log('paused');
    if (osStatus === 'Android'){
        Android.audioPause();
    }else if (osStatus === 'iOS'){
        window.location = 'audioPause://testing';
    }
}