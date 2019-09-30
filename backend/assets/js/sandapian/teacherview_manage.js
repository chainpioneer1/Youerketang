$(window).ready(function(){

    var courseBtn = $('#course_btn');
    var textBtn = $('#text_btn');
    var noteBtn  =$('#mynote_btn');

    var course_menu_img = $('#course_menu_img');
    current_className = $('.custom_classlist_btn:first').attr('data-class_name');
    current_classbgname = $('.custom_classlist_btn:first').attr('data-image_name');
    $('#'+current_classbgname).css('background','url('+imageDir+'teacherview/'+current_classbgname+'_sel.png'+')');
    $('#'+current_classbgname).css('background-size','100% 100%');
    clickClass();
    $('#search_content_box').hide();
    $('#content_search_btn').hide();
    $('.category_search_wrap').hide();

    $(".custom_classlist_btn").click(function () {

        $('#'+current_classbgname).css('background','url('+imageDir+'teacherview/'+current_classbgname+'.png'+')');
        $('#'+current_classbgname).css('background-size','100% 100%');
        current_className = $(this).attr('data-class_name');
        current_classbgname = $(this).attr('data-image_name');
        $(this).parent().css('background','url('+imageDir+'teacherview/'+current_classbgname+'_sel.png'+')');
        $(this).parent().css('background-size','100% 100%');

        clickClass();
        $('.edit_content_area').hide();
        /*Search fields*/
        $('#search_content_box').hide();
        $('#content_search_btn').hide();
        $('.category_search_wrap').hide();
        /*Search fields*/
        $('#class_member_area').show();
        tableBg.attr('src',imageDir+'teacherview/bg_teacher_'+curTab+'.png');
        studentContentEditStatus = false;

    });

    courseBtn.click(function(){
        curTab = 'course';
        if(studentContentEditStatus)
        {
            $('#search_content_box').show();
            $('#content_search_btn').show();
            $('.category_search_wrap').show();
            tableBg.attr('src',imageDir+'teacherview/bg_student_course.png');
            clickStudent();

        }else{
            tableBg.attr('src',imageDir+'teacherview/bg_teacher_course.png');
            clickClass();
        }
    });
    textBtn.click(function () {
        curTab = 'text';
        if(studentContentEditStatus)
        {
            $('#search_content_box').show();
            $('#content_search_btn').show();
            $('.category_search_wrap').show();
            tableBg.attr('src',imageDir+'teacherview/bg_student_text.png');
            clickStudent();


        }else{
            tableBg.attr('src',imageDir+'teacherview/bg_teacher_text.png');
            clickClass();
        }

    });
    noteBtn.click(function(){
        curTab = 'note';
        if(studentContentEditStatus)
        {
            $('#search_content_box').show();
            $('#content_search_btn').show();
            $('.category_search_wrap').show();
            tableBg.attr('src',imageDir+'teacherview/bg_student_note.png');
            clickStudent();

        }else{
            tableBg.attr('src',imageDir+'teacherview/bg_teacher_note.png');
            clickClass();
        }

    });
    $(window).resize(function(){
        fitWindow()
    });
    function fitWindow()
    {
        var itemWrapper = $('.member_item_wrapper');
        var fitHeight = window.innerHeight*0.055;
        var fitMarginTop = window.innerHeight*0.028;
        var fontSizeW = window.innerHeight*0.03;
        var paddingTop = window.innerHeight*0.013;

        if(window.innerHeight<430) {      paddingTop = 0;    }

        //itemWrapper.css('padding-top',paddingTop+'px');
        itemWrapper.css('margin-top',fitMarginTop+'px');
        itemWrapper.css('height',fitHeight+'px');

        $('.member_item').css('font-size',fontSizeW+'px');
    }
    $('#prevPage_Btn').click(function () {

        prevPage();

    });
    $('#nextPage_Btn').click(function () {

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
            url: baseURL + "nwork/getMembers",
            dataType: "json",
            data: {class_name:current_className,content_type_slug:curTab},
            success: function (res) {
                if (res.status == 'success') {
                    totalPageCount = parseInt(res.totalPageCount);
                    jQuery('.class_member_tbl_area').html(res.data);
                    $('.member_item_wrapper').css({"background":"url("+imageDir+"teacherview/item_bg.png) no-repeat",'background-size' :'100% 100%'});
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
    /*************************Edit processing to Contents of Student******************************************/

    /*************************Edit processing to Contents of Student******************************************/
});