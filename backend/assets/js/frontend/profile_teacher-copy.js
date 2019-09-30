/**
 * Created by Administrator on 6/12/2017.
 */
$(window).ready(function () {

    var content_List = JSON.parse(sharedList);
    var totalPageCount = 0;
    var curPageNum = 0;
    function make_contentItem(content_title,content_id){

        var output_html = '';
        output_html += '<div class="item_left">';
        output_html +=    '<div class="col-md-10 item_title">';
        output_html +=       '<a href="' + baseURL+'community/view/' +content_id+'">'+content_title+'</a>';
        output_html +=     '</div>';
        output_html +=     '<div class="col-md-2 item_delete">';
        output_html +=       '<a href="#" '+ 'data-content_id = "'+content_id+'" onclick="delSharedItemShowModal(this)">'+deleteStr+'</a>';
        output_html +=     '</div>';
        output_html += '</div>';
        return output_html;
    }
    function Init_Pager(content_list){
        var output_html = '';
        if(content_list.length==0) return;
        for(var i=0;i<content_list.length;i++){
            var tempObj = content_list[i];
            var item_title = tempObj['content_title'];
            var conent_id = tempObj['content_id'];
            var temvar = i%6;
            var pageNum = (i-temvar)/6;
            if(temvar==0){
                if(i==0)output_html += '<div style="display: none;" class="col-md-6 content_block left-block-page '+'content_page-'+pageNum+'">';
                else output_html += '</div><div  style="display: none;" class="col-md-6 content_block '+'content_page-'+pageNum+'">';
                output_html += make_contentItem(item_title,conent_id);
            }else if(i%6==3){
                output_html += '</div><div style="display: none;" class="col-md-6 content_block right-block-page'+' content_page-'+pageNum+'">';
                output_html += make_contentItem(item_title,conent_id);
            }else{
                output_html += make_contentItem(item_title,conent_id);
            }
            totalPageCount = pageNum;
        }
        output_html += '</div>';
        $('#shared_content_list_area').html(output_html);
    }
    function  Show_Page(pageNo) {

        var left_block_class = '.content_page-'+pageNo;
        $(left_block_class).show();

    }
    Init_Pager(content_List);
    Show_Page('0');
    function Hide_OldPage(pageNo) {
        var left_block_class = '.content_page-'+pageNo;
        $(left_block_class).hide();
    }
    function Prev_Shared_Content(){

        if(curPageNum==0) return;
        Hide_OldPage(curPageNum);
        curPageNum--;
        Show_Page(curPageNum);

    }
    function Next_Shared_Content(){
        if(curPageNum==totalPageCount) return;
        Hide_OldPage(curPageNum);
        curPageNum++;
        Show_Page(curPageNum);
    }
    $('#Prev_Shared_Items').click(function () {

        Prev_Shared_Content();

    });
    $('#Next_Shared_Items').click(function () {

        Next_Shared_Content();
    })
    $('#shared_content_delete_btn').click(function () {

        var content_id = $(this).attr('content_id');
        $.ajax({
            type:'post',
            url:baseURL+'users/delete_shared_content',
            dataType: "json",
            data:{user_id:teacherId,content_id:content_id},
            success:function(res){
                if(res.status=='success'){
                    Init_Pager(res.data);
                    Show_Page(curPageNum);
                    $('#my_shared_content_del_modal').modal('toggle');
                }else{
                    alert('Can not Delete Shared Content!');
                }
            }
        });
    })

    //commentedList

    var commented_list = JSON.parse(commentedList);
    var totalCommentPageCount = 0;
    var curCommentPageNum = 0;
    function comment_make_contentItem(content_title,content_id){

        var output_html = '';
        output_html += '<div class="item_left">';
        output_html +=    '<div class="col-md-10 item_title">';
        output_html +=       '<a href="' + baseURL+'community/view/' +content_id+'">'+content_title+'</a>';
        output_html +=     '</div>';
        output_html +=     '<div class="col-md-2 item_delete">';
        output_html +=       '<a href="#" '+ 'data-content_id = "'+content_id+'" onclick="deleteCommentShowModal(this)">'+deleteStr+'</a>';
        output_html +=     '</div>';
        output_html += '</div>';
        return output_html;
    }
    function comment_Init_Pager(content_list){
        var output_html = '';
        if(content_list.length==0) return;
        for(var i=0;i<content_list.length;i++){
            var tempObj = content_list[i];

            console.log(tempObj);

            var item_title = tempObj['content_title'];
            var conent_id = tempObj['content_id'];
            var temvar = i%6;
            var pageNum = (i-temvar)/6;
            if(temvar==0){
                if(i==0)output_html += '<div style="display: none;" class="col-md-6 content_block left-block-page '+'comment_content_page-'+pageNum+'">';
                else output_html += '</div><div  style="display: none;" class="col-md-6 content_block '+'comment_content_page-'+pageNum+'">';
                output_html += comment_make_contentItem(item_title,conent_id);
            }else if(i%6==3){
                output_html += '</div><div style="display: none;" class="col-md-6 content_block right-block-page'+' comment_content_page-'+pageNum+'">';
                output_html += comment_make_contentItem(item_title,conent_id);
            }else{
                output_html += comment_make_contentItem(item_title,conent_id);
            }
            totalCommentPageCount = pageNum;
        }
        output_html += '</div>';
        $('#commented_content_list_area').html(output_html);
    }
    function  comment_Show_Page(pageNo) {

        var left_block_class = '.comment_content_page-'+pageNo;
        $(left_block_class).show();

    }
    comment_Init_Pager(commented_list);
    comment_Show_Page('0');
    function comment_Hide_OldPage(pageNo) {
        var left_block_class = '.comment_content_page-'+pageNo;
        $(left_block_class).hide();
    }
    function comment_Prev_Shared_Content(){

        if(curCommentPageNum==0) return;
        comment_Hide_OldPage(curCommentPageNum);
        curCommentPageNum--;
        comment_Show_Page(curCommentPageNum);
    }
    function comment_Next_Shared_Content(){
        if(curCommentPageNum==totalCommentPageCount) return;
        comment_Hide_OldPage(curCommentPageNum);
        curCommentPageNum++;
        comment_Show_Page(curCommentPageNum);
    }
    $('#Prev_Commented_Items').click(function () {

        comment_Prev_Shared_Content();

    });
    $('#Next_Commented_Items').click(function () {

        comment_Next_Shared_Content();
    });
    $('#commented_content_delete_btn').click(function () {
        var content_id = $('#commented_content_delete_btn').attr('content_id');
        $.ajax({
            type:'post',
            url:baseURL+'users/delete_commented_content',
            dataType: "json",
            data:{user_id:teacherId,content_id:content_id},
            success:function(res){
                if(res.status=='success'){
                    comment_Init_Pager(res.data);
                    comment_Show_Page(curCommentPageNum);
                    $('#my_commented_content_del_modal').modal('toggle');
                }else{
                    alert('Can not Delete Shared Content!');
                }
            }
        });
    })
});