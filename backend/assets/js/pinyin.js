// $('.bg').css({background: 'url(' + imageDir + 'bg' + site_id + '.png) no-repeat'});
$(function () {
    var content_html = "";
    for (var i = 0; i < packageList.length; i++) {
        var item = packageList[i];
        var progress = item.progress;
        if (item.owner_type == 0 + '' && item.lesson_status=='1') {
            content_html += '<div class="list_item" itemid="' + item.id + '" item_type="online">';
            content_html += '<div class="main_item_info" item_type="online"' +
                'style="background:url(' + baseURL + item.image_icon + ');"></div>';
            content_html += '<div class="progress_bg"></div>';
            content_html += '<div class="progress_bar" style="width: ' + (80 * progress / 100) + '%;"></div>';
            content_html += '<div class="progress_info">' + progress + '%</div>';
            content_html += '<div class="item_infobar">' + item.lesson_name + '</div>';
            content_html += '</div>';
        }
    }
    for (var i = 0; i < packageList.length; i++) {
        var item = packageList[i];
        if (item.owner_type == loginUserId && item.lesson_status == '1')
            content_html += '<div class="list_item" itemid="' + item.id + '" item_type="self"' +
                'style="">' + item.lesson_name + '</div>';
    }
    $('.classroom_list_container').html(content_html);
    for (var i = 0; i < packageList.length; i++) {
        var item = packageList[i];
        var progress = item.progress;
        if (progress == 0)
            $('.list_item[itemid="' + item.id + '"] .progress_bg').hide();
    }

    $('.list_item').on('mousedown', function (object) {
        var id = parseInt($(this).attr('itemid'));
        var type = $(this).attr('item_type');
        if (type == 'self') {
            showPreviewPlayer(site_id, id);
        } else {
            $('.list_item .main_item_info[itemid="' + id + '"]').css({background: 'url(' + baseURL + 'assets/images/classroom/kuaile' + id + '.png)'});
            showClass(site_id, id);
        }
    })
    $('.list_item').on('mouseover', function (object) {
        var id = parseInt($(this).attr('itemid'));
        var item;
        for (var i = 0; i < packageList.length; i++) {
            if (packageList[i].id == id)
                item = packageList[i];
        }
        var progress = item.progress;
        if (progress != 0) {
            $('.list_item[itemid="' + item.id + '"] .progress_info').show();
        }
    })
    $('.list_item').on('mouseout', function (object) {
        var id = parseInt($(this).attr('itemid'));
        var item;
        for (var i = 0; i < packageList.length; i++) {
            if (packageList[i].id == id)
                item = packageList[i];
        }
        $('.list_item[itemid="' + item.id + '"] .progress_info').hide();
    })
});

