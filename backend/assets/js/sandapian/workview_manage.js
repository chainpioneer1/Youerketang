$(window).ready(function(){

   var courseBtn = $('#course_btn');
   var textBtn = $('#text_btn');
   var noteBtn  =$('#mynote_btn');
   var tableBg = $('#table_bg_image');

   courseBtn.click(function(){
       curTab = 'course';
       tableBg.attr('src',imageDir+'workview/course_bg.png');
       changeTable_ajax();

   });
   textBtn.click(function () {
       curTab = 'text';
       tableBg.attr('src',imageDir+'workview/text_bg.png');
       changeTable_ajax();

   });
   noteBtn.click(function(){
       curTab = 'note';
       tableBg.attr('src',imageDir+'workview/mynote_bg.png');
       changeTable_ajax();

   });

    /***********************************Page Update********************************/
    function changeTable_ajax() {
        jQuery.ajax({
            url:baseURL+"nwork/change_table",
            type:"post",
            dataType: "json",
            data:{userId:userId,content_type:curTab},
            success: function(res){
                if(res.status='success')
                {

                    $('#content_list_items').html(res.data);
                    fitWindow();


                }else{
                    alert('Can not upload work!');
                }
            }
        });
    }
    $('#content_search_btn').mouseover(function(){ $(this).css({"background":"url("+imageDir+"workview/search_hover.png) no-repeat",'background-size' :'100% 100%'}); });
    $('#content_search_btn').mouseout(function(){ $(this).css({"background":"url("+imageDir+"workview/search.png) no-repeat",'background-size' :'100% 100%'}); });
    $('#confirm_delete_btn').mouseover(function(){$(this).css({"background":"url("+imageDir+"base/yes_hover.png) no-repeat",'background-size' :'100% 100%'});});
    $('#no_btn').mouseover(function(){$(this).css({"background":"url("+imageDir+"base/no_hover.png) no-repeat",'background-size' :'100% 100%'});});
    $('#confirm_delete_btn').mouseout(function(){ $(this).css({"background":"url("+imageDir+"base/yes.png) no-repeat",'background-size' :'100% 100%'});});
    $('#no_btn').mouseout(function(){$(this).css({"background":"url("+imageDir+"base/no.png) no-repeat",'background-size' :'100% 100%'});});

    $('#local_delete_chk').click(function(){
       if(local_del=='0'){
           $(this).css({"background":"url("+imageDir+"base/localwork_hover.png) no-repeat",'background-size' :'100% 100%'});
           local_del = '1';
       }else{
           $(this).css({"background":"url("+imageDir+"base/localwork.png) no-repeat",'background-size' :'100% 100%'});
           local_del = '0';
       }
    });
    $('#cloud_delete_chk').click(function(){
        if(cloud_del=='0'){
            $(this).css({"background":"url("+imageDir+"base/cloudwork_hover.png) no-repeat",'background-size' :'100% 100%'});
            cloud_del = '1';
        }else{
            $(this).css({"background":"url("+imageDir+"base/cloudwork.png) no-repeat",'background-size' :'100% 100%'});
            cloud_del = '0';
        }
    });
    $('#no_btn').click(function () {
        close_del_box();
    })


});