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

function showClass(id, isPopup) {
    id = parseInt(id) - 1;
    if (isPopup == undefined) isPopup = false;
    if (isPopup) {
        var win = window.open(baseURL + "classroom/view/" + id, '_blank');
        win.focus();
    } else
        location.href = baseURL + "classroom/view/" + id;
}

function showVideoPlayer(id, isPopup) {
    id = parseInt(id) - 1;
    if (isPopup == undefined) isPopup = false;
    if (isPopup) {
        var win = window.open(baseURL + "resource/playerview/" + id, '_blank');
        win.focus();
    } else
        location.href = baseURL + "resource/playerview/" + id;
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

function showLessonWare(id, title, isPopup) {
    id = parseInt(id);
    localStorage.setItem('title', title);
    if (isPopup == undefined) isPopup = false;
    if (isPopup) {
        var win = window.open(baseURL + "resource/lessonware_home/" + id, '_blank');
        win.focus();
    } else
        location.href = baseURL + "resource/lessonware_home/" + id;

}

