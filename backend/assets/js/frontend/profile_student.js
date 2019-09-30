/**
 * Created by Administrator on 6/12/2017.
 */

var totalPageCount = 0;
var curPageNum = 0;

function deleteContent(content_id) {

    if (!confirm("Do you want delete this item now?")) return;
    $.ajax({
        type: 'post',
        url: baseURL + 'users/delete_content',
        dataType: "json",
        data: {user_id: student_id, content_id: content_id},
        success: function (res) {
            if (res.status == 'success') {
                Contents_Init_Pager(res.data);
                Contents_Show_Page(curPageNum);
                // $('#my_shared_content_del_modal').modal('toggle');
            } else {
                alert('Can not Delete Shared Content!');
            }
        }
    });
}

/***************************************Main Login Part***********************************************************/
console.log(contentsJsonList);
var contentsList = JSON.parse(contentsJsonList);

function Content_make_Item(item_order, item_title, item_id, item_type, item_user, item_date) {

    var blockID = Math.floor(item_order / 4);
    var output_html = '';
    if (blockID > 0) {
        output_html += '<div class="comment_item checked_content_' + blockID + '" style="display: none">';
    } else {
        output_html += '<div class="comment_item checked_content_' + blockID + '">';
    }

    output_html += '<div class="comment_item_title"' +
        'onclick="showContent(' + item_id + ')">' + item_title +
        '<span class="item_type_' + item_type + '"></span></div>';
    output_html += '<div class="comment_item_user">' + item_user + '</div>';
    output_html += '<div class="comment_item_date">' + item_date + '</div>';
    output_html += '<div class="comment_item_delete_btn" onclick="deleteContent(' + item_id + ')"></div>';
    output_html += '</div>';

    return output_html;
}

function Contents_Init_Pager(content_list) {
    var output_html = '';
    for (var i = 0; i < content_list.length; i++) {
        var tempObj = content_list[i];
        var item_title = tempObj['content_title'];
        var item_id = tempObj['content_id'];
        var item_date = tempObj['apply_time'];
        var item_user = tempObj['username'];
        var item_type = tempObj['media_type'];
        output_html += Content_make_Item(i, item_title, item_id, item_type, item_user, item_date);
        totalPageCount = Math.floor(i / 4);
    }
    $('#shared_list_area').html(output_html);
}

function Contents_Show_Page(pageNo) {

    var left_block_class = '.checked_content_' + pageNo;
    $(left_block_class).show('slow');
}

Contents_Init_Pager(contentsList);////////////////////////////////////
Contents_Show_Page('0');//////////////////////////////////////////////

function Contents_Hide_OldPage(pageNo) {
    var left_block_class = '.checked_content_' + pageNo;
    $(left_block_class).hide('slow');
}

function Prev_Shared_Content() {

    if (curPageNum == 0) return;
    Contents_Hide_OldPage(curPageNum);
    curPageNum--;
    Contents_Show_Page(curPageNum);

}

function Next_Shared_Content() {
    if (curPageNum == totalPageCount) return;
    Contents_Hide_OldPage(curPageNum);
    curPageNum++;
    Contents_Show_Page(curPageNum);
}

/***********************************Button Manage*************************************/
passEditBtn.mouseover(function () {
    $(this).css({"background": "url(" + imageDir + "pass_change_hover.png) no-repeat", 'background-size': '100% 100%'});
});
passEditBtn.mouseout(function () {
    $(this).css({"background": "url(" + imageDir + "pass_change.png) no-repeat", 'background-size': '100% 100%'});
});
passEditBtn.click(function () {

});
infoEditBtn.mouseover(function () {
    if (saveButtonStatus)///current button is save button
    {
        $(this).css({"background": "url(" + imageDir + "save_hover.png) no-repeat", 'background-size': '100% 100%'});
    } else {
        $(this).css({
            "background": "url(" + imageDir + "info_edit_hover.png) no-repeat",
            'background-size': '100% 100%'
        });
    }
});
infoEditBtn.mouseout(function () {
    if (saveButtonStatus) {
        $(this).css({"background": "url(" + imageDir + "save.png) no-repeat", 'background-size': '100% 100%'});
    } else
        $(this).css({"background": "url(" + imageDir + "info_edit.png) no-repeat", 'background-size': '100% 100%'});
});

/***************Pagination Button Event Manage********************/
/*********share list event manage*************/
sharePrevBtn.mouseover(function () {
    $(this).css({"background": "url(" + imageDir + "prev_hover.png) no-repeat", 'background-size': '100% 100%'});
});
sharePrevBtn.mouseout(function () {
    $(this).css({"background": "url(" + imageDir + "prev.png) no-repeat", 'background-size': '100% 100%'});
});
shareNextBtn.mouseover(function () {
    $(this).css({"background": "url(" + imageDir + "next_hover.png) no-repeat", 'background-size': '100% 100%'});
});
shareNextBtn.mouseout(function () {
    $(this).css({"background": "url(" + imageDir + "next.png) no-repeat", 'background-size': '100% 100%'});
});
deleteShareBtn.mouseover(function () {
    $(this).css({"background": "url(" + imageDir + "delete_hover.png) no-repeat", 'background-size': '100% 100%'});
});
deleteShareBtn.mouseout(function () {
    $(this).css({"background": "url(" + imageDir + "delete.png) no-repeat", 'background-size': '100% 100%'});
});

sharePrevBtn.click(function () {
    Prev_Shared_Content();
});
shareNextBtn.click(function () {
    Next_Shared_Content();
});
