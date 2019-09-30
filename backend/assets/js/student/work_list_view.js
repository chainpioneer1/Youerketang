/**
 * Created by Administrator on 6/12/2017.
 */
$(window).ready(function () {

    $('.exit-btn').mouseout(function(){
        $('.exit_btn_img').attr('src',imageDir+'studentwork/exit.png');
    });
    $('.exit_btn_img').mouseover(function(){
        $('.exit_btn_img').attr('src',imageDir+'studentwork/exit_hover.png');
    });


    $('#hdmenu_profile').mouseout(function(){
        $('.hdmenu_img').attr('src',hdmenuImgPath+'hdmenu_normal.png');
    });
    $('#hdmenu_profile').mouseover(function(){
        $('.hdmenu_img').attr('src',hdmenuImgPath+'hdmenu_profile_sel.png');
    });

    $('#hdmenu_community').mouseout(function(){
        $('.hdmenu_img').attr('src',hdmenuImgPath+'hdmenu_normal.png');
    });
    $('#hdmenu_community').mouseover(function(){
        $('.hdmenu_img').attr('src',hdmenuImgPath+'hdmenu_comm_sel.png');
    });

    $('.return_btn').mouseover(function(){
        $(this).css({"background":"url("+imageDir+"studentwork/back_hover.png) no-repeat",'background-size' :'100% 100%'});
    });
    $('.return_btn').mouseout(function(){
        $(this).css({"background":"url("+imageDir+"studentwork/back.png) no-repeat",'background-size' :'100% 100%'});
    });
    $('.home_btn').mouseover(function(){
        $(this).css({"background":"url("+imageDir+"home/home_btn_hover.png) no-repeat",'background-size' :'100% 100%'});
    });
    $('.home_btn').mouseout(function(){
        $(this).css({"background":"url("+imageDir+"home/home_btn.png) no-repeat",'background-size' :'100% 100%'});
    })

    $('.share_close_btn').click(function(){
        close_modal();
    });
    $('.share_close_btn').mouseover(function(){
        $(this).css({"background":"url("+imageDir+"mywork/no_sel.png) no-repeat",'background-size' :'100% 100%'});
    });
    $('.share_close_btn').mouseout(function(){
        $(this).css({"background":"url("+imageDir+"mywork/no.png) no-repeat",'background-size' :'100% 100%'});
    });
    $('#content_share_btn').mouseover(function(){
        $(this).css({"background":"url("+imageDir+"mywork/yes_sel.png) no-repeat",'background-size' :'100% 100%'});
    });
    $('#content_share_btn').mouseout(function(){
        $(this).css({"background":"url("+imageDir+"mywork/yes.png) no-repeat",'background-size' :'100% 100%'});
    });

});

