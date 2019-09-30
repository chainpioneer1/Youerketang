/**
 * Created by Administrator on 6/12/2017.
 */
$(window).ready(function () {

    var content_List = JSON.parse(sharedList);
    var imageDir = baseURL + "assets/images/frontend/profile/";
    var sharePrevBtn = $('.share_prev_btn');
    var shareNextBtn = $('.share_next_btn');

    var totalPageCount = 0;
    var curPageNum = 0;
    function make_contentItem(orderNum,content_title,content_id){

        var intervalOfItem = 7.9;
        var itemHeight = 13.9 ;

        var item_top = (orderNum+1)*intervalOfItem + orderNum*itemHeight;
        var item_top_str = item_top+'%';

        var output_html = '';
        output_html += '<div class="item_left" style="top:'+item_top_str+'">';
        output_html +=    '<div class="item_title">';
        output_html +=       '<a href="' + baseURL+'community/view/' +content_id+'">'+content_title+'</a>';
        output_html +=     '</div>';
        output_html +=     '<div class="item_delete" style="display:none">';
        output_html +=       '<a href="#" '+ 'data-content_id = "'+content_id+'" onclick="delSharedItemShowModal(this)">'+''+'</a>';
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
            var temvar = i%8;
            var pageNum = (i-temvar)/8;
            if(temvar==0){
                if(i==0)output_html += '<div style="display: none;" class="col-xs-6 content_block left-block-page '+'content_page-'+pageNum+'">';
                else output_html += '</div><div  style="display: none;" class="col-xs-6 content_block '+'content_page-'+pageNum+'">';
                output_html += make_contentItem(temvar%4,item_title,conent_id);
            }else if(i%8==4){
                output_html += '</div><div style="display: none;" class="col-xs-6 content_block right-block-page'+' content_page-'+pageNum+'">';
                output_html += make_contentItem(0,item_title,conent_id);
            }else{
                output_html += make_contentItem(temvar%4,item_title,conent_id);
            }
            totalPageCount = pageNum;
        }
        output_html += '</div>';
        $('#shared_list_area').html(output_html);
    }
    function  Show_Page(pageNo) {

        var left_block_class = '.content_page-'+pageNo;
        $(left_block_class).show('50');

    }
    Init_Pager(content_List);
    Show_Page('0');
    function Hide_OldPage(pageNo) {
        var left_block_class = '.content_page-'+pageNo;
        $(left_block_class).hide('50');
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
    $('.share_prev_btn').click(function () {

        Prev_Shared_Content();

    });
    $('.share_next_btn').click(function () {
        Next_Shared_Content();
    });
    function fitwindow()
    {
        var innerH = window.innerHeight;
        var innerW = window.innerWidth;
        if(innerW<600||innerH<500)
        {
            $('.item_title a').css('font-size','14px');
        }else
        {
            $('.item_title a').css('font-size','20px');
        }
        console.log('innerH:'+innerH+" innerW:"+innerW);
        var realfont = 0.03*innerH;
        $('.static_info_fields p').css('font-size',realfont+'px');
    }
    $(window).resize(function(){

        fitwindow();

    });
    fitwindow();

    sharePrevBtn.mouseover(function(){ $(this).css({"background":"url("+imageDir+"prev_hover.png) no-repeat",'background-size' :'100% 100%'}); });
    sharePrevBtn.mouseout(function(){ $(this).css({"background":"url("+imageDir+"prev.png) no-repeat",'background-size' :'100% 100%'}); });
    shareNextBtn.mouseover(function(){ $(this).css({"background":"url("+imageDir+"next_hover.png) no-repeat",'background-size' :'100% 100%'});});
    shareNextBtn.mouseout(function(){ $(this).css({"background":"url("+imageDir+"next.png) no-repeat",'background-size' :'100% 100%'});});
});