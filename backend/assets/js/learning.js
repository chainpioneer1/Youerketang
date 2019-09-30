$('.bg').css({background: 'url(' + imageDir + 'learning/bg.png) no-repeat'});
$(function () {

    var content_html = "";
    for (var i = 0; i < learningList.length; i++) {
        var item = learningList[i];
        content_html += '<div class="list_item" itemid="' + item.id + '"' +
            'style="background:url(' +
            baseURL + 'assets/images/resource/learning/normal/' + num2Fixed(i+1,3) +
            '.png);"></div>';
    }
    $('.learning_list_container').html(content_html);

    $('#resource-nav-item' + (selectedIndex + 1)).css({background: 'url(' + baseURL + '/assets/images/resource/education/menu' + (selectedIndex + 1) + '_clicked.png)'});

    $('.list_item').on('mouseover', function (object) {
        var id = $(this).attr('itemid');
        //$(this).css({background: 'url(' + baseURL + '/assets/images/resource/learning/fayin' + id + '_clicked.png)'});
        $(this).css({background: 'url(' + baseURL + 'assets/images/resource/learning/clicked/' + num2Fixed(id,3) + '.png)'});
    })
    $('.list_item').on('mouseout', function (object) {
        var id = $(this).attr('itemid');
        $(this).css({background: 'url(' + baseURL + 'assets/images/resource/learning/normal/' + num2Fixed(id,3) + '.png)'});
    })
    $('.list_item').on('mousedown', function (object) {
        var id = parseInt($(this).attr('itemid'));
        var item = learningList[id];
        $(this).css({background: 'url(' + baseURL + 'assets/images/resource/learning/clicked/' + num2Fixed(id,3) + '.png)'});
        showLearningVideoPlayer(id, 1);
    })

    function num2Fixed(num, length) {
        num = parseInt(num);
        var r = "" + num;
        while (r.length < length) {
            r = "0" + r;
        }
        return r;
    }
});

