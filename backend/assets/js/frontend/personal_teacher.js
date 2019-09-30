/**
 * Created by Administrator on 6/12/2017.
 */
$(window).ready(function () {

    var imageDir = baseURL + "assets/images/frontend";
    var course_menu_img = $('#course_menu_img');
    current_className = $('.custom_classlist_btn:first').attr('data-class_name');
    current_classbgname = $('.custom_classlist_btn:first').attr('data-image_name');
    $('#'+current_classbgname).css('background','url('+imageDir+'/studentwork/'+current_classbgname+'_sel.png'+')');
    $('#'+current_classbgname).css('background-size','100% 100%');
    clickClass();
    //$('.teacher_assign_class button:first-child').css('background','#ff0');
    $(".custom_classlist_btn").click(function () {

        $('#'+current_classbgname).css('background','url('+imageDir+'/studentwork/'+current_classbgname+'.png'+')');
        $('#'+current_classbgname).css('background-size','100% 100%');
        current_className = $(this).attr('data-class_name');
        current_classbgname = $(this).attr('data-image_name');
        $(this).parent().css('background','url('+imageDir+'/studentwork/'+current_classbgname+'_sel.png'+')');
        $(this).parent().css('background-size','100% 100%');
        clickClass();
    });
    $('#script_ATag_Btn').click(function () {

        curPageNo = 0;

        content_type_id = '1';
        course_menu_img.attr('src',imageDir+'/studentwork/scriptwork.png');
        clickClass();
    });
    $('#dubbing_ATag_Btn').click(function () {
        curPageNo = 0;
        totalPageCount = 0;
        content_type_id = '2';
        course_menu_img.attr('src',imageDir+'/studentwork/dubbingwork.png');
        clickClass();
    });
    $('#head_ATag_Btn').click(function () {
        curPageNo = 0;
        totalPageCount = 0;
        content_type_id = '3';
        course_menu_img.attr('src',imageDir+'/studentwork/headwork.png');
        clickClass();
    });
    $('#shooting_ATag_Btn').click(function () {
        curPageNo = 0;
        totalPageCount = 0;
        content_type_id = '4';
        course_menu_img.attr('src',imageDir+'/studentwork/shootingwork.png');
        clickClass();

    });
    $('.exit-btn').mouseout(function(){
        $('.exit_btn_img').attr('src',imageDir+'/studentwork/exit.png');
    });
    $('.exit_btn_img').mouseover(function(){
        $('.exit_btn_img').attr('src',imageDir+'/studentwork/exit_hover.png');
    });

    $('#hdmenu_profile').mouseout(function(){
        $('.hdmenu_img').attr('src',imageDir+'/studentwork/stu_hdmenu_normal.png');
    });
    $('#hdmenu_profile').mouseover(function(){
        $('.hdmenu_img').attr('src',imageDir+'/studentwork/stu_hdmenu_profile_sel.png');
    });
    $('#hdmenu_community').mouseout(function(){
        $('.hdmenu_img').attr('src',imageDir+'/studentwork/stu_hdmenu_normal.png');
    });
    $('#hdmenu_community').mouseover(function(){
        $('.hdmenu_img').attr('src',imageDir+'/studentwork/stu_hdmenu_comm_sel.png');
    });

    $('.previous_Btn').click(function () {

        prevPage();

    });
    $('.next_Btn').click(function () {

        nextPage()

    });
    function hide_OldPage(pageNo){
        var newClassStr = '.member_list_page'+pageNo;
        $(newClassStr).hide();
    }
    function show_NewPage(pageNo) {
        var newClassStr = '.member_list_page'+pageNo;
        $(newClassStr).show();
    }
    function prevPage(){
        if(curPageNo == 0) return;
        hide_OldPage(curPageNo);
        curPageNo--;
        show_NewPage(curPageNo);
    }
    function nextPage(){
        if(curPageNo == totalPageCount) return;
        hide_OldPage(curPageNo);
        curPageNo++;
        show_NewPage(curPageNo);
    }
    function clickClass()
    {
        $.ajax({
            type: "post",
            url: baseURL + "work/getMembers",
            dataType: "json",
            data: {class_name:current_className,content_type_id:content_type_id},
            success: function (res) {
                if (res.status == 'success') {
                    totalPageCount = parseInt(res.totalPageCount);
                    jQuery('.class_member_tbl_area').html(res.data);
                    $('.member_item_wrapper').css({"background":"url("+imageDir+"/studentwork/item_bg.png) no-repeat",'background-size' :'100% 100%'});
                    fitWindow();
                    show_NewPage(curPageNo);

                }
                else//failed
                {
                    alert("Cannot delete CourseWare Item.");
                }
            }
        });
    }

    $(window).resize(function(){
        fitWindow()
    });
    function fitWindow()
    {
        var itemWrapper = $('.member_item_wrapper');
        var fitHeight = window.innerHeight*0.0575;
        var fitMarginTop = window.innerHeight*0.02;
        var fontSizeW = window.innerHeight*0.02;
        var paddingTop = window.innerHeight*0.013;

        if(window.innerHeight<430)
        {
            paddingTop = 0;
        }

        //itemWrapper.css('padding-top',paddingTop+'px');
        itemWrapper.css('margin-top',fitMarginTop+'px');
        itemWrapper.css('height',fitHeight+'px');

        $('.member_item').css('font-size',fontSizeW+'px');
    }
    $('.return_btn').mouseover(function(){

        $(this).css({"background":"url("+imageDir+"/studentwork/back_hover.png) no-repeat",'background-size' :'100% 100%'});
    });
    $('.return_btn').mouseout(function(){

        $(this).css({"background":"url("+imageDir+"/studentwork/back.png) no-repeat",'background-size' :'100% 100%'});

    });
    /******************Pager for student list***************************/
});
