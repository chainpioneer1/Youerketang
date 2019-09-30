$('.bg').css({background: 'url(' + imageDir + 'bg' + site_id + '.png) no-repeat'});
// $('.bg').css({background: 'url(' + imageDir + 'education/bg.png) no-repeat'});
$(function () {

    var content_html = "";
    for (var i = 0; i < packageList.length; i++) {
        var item = packageList[i];
        if (item.owner_type == 0 + "") {
            content_html += '<div class="list_item" itemid="' + item.id + '" item_type="online">';
            content_html += '<div class="main_item_info" item_type="online"' +
                'style="background:url(' + baseURL + item.image_path + ');"></div>';
            content_html += '<div class="item_infobar">' + item.course_name + '</div>';
            content_html += '</div>';
            // content_html += '<div class="list_item" itemid="' + item.id + '"' +
            //     'style="background:url(' + baseURL + '/assets/images/resource/education/kuaile' + item.id + '.png);"></div>';
        }
    }
    $('.resource_list_container').html(content_html);

    $('#resource-nav-item' + (selectedIndex + 1)).css({background: 'url(' + baseURL + '/assets/images/resource/education/menu' + (selectedIndex + 1) + '_clicked.png)'});

    $('#resource-nav-item' + (selectedIndex + 1)).on('mouseout', function (object) {
        var id = $(this).attr('itemid');
        $(this).css({background: 'url(' + baseURL + '/assets/images/resource/education/menu' + (selectedIndex + 1) + '_clicked.png)'});
    })

    $('#resource-nav-item' + (selectedIndex + 1)).on('mouseover', function (object) {
        var id = $(this).attr('itemid');
        $(this).css({background: 'url(' + baseURL + '/assets/images/resource/education/menu' + (selectedIndex + 1) + '_clicked.png)'});
    })

    $('.list_item').on('mousedown', function (object) {
        var id = parseInt($(this).attr('itemid'));
        var item = packageList[id];
        showReference(id);
    })


});
