
$(window).ready(function(){


    var backBtn = $('#sh_backhome_btn');
    var profileBtn = $('#sh_profile_btn');
    var loginBtn =$('#sh_login_btn');
    var exitBtn = $('#sh_exit_btn');

    backBtn.mouseout(function(){
        $(this).css({"background":"url("+imageDir+"base/backhome.png) no-repeat",'background-size' :'100% 100%'});
    });
    backBtn.mouseover(function(){
        $(this).css({"background":"url("+imageDir+"base/backhome_hover.png) no-repeat",'background-size' :'100% 100%'});
    });
    profileBtn.mouseout(function(){
        $(this).css({"background":"url("+imageDir+"base/profile.png) no-repeat",'background-size' :'100% 100%'});
    });
    profileBtn.mouseover(function(){
        $(this).css({"background":"url("+imageDir+"base/profile_hover.png) no-repeat",'background-size' :'100% 100%'});
    });

    loginBtn.mouseout(function(){
        $(this).css({"background":"url("+imageDir+"base/login.png) no-repeat",'background-size' :'100% 100%'});
    });
    loginBtn.mouseover(function(){
        $(this).css({"background":"url("+imageDir+"base/login_hover.png) no-repeat",'background-size' :'100% 100%'});
    });
    exitBtn.mouseout(function(){
        $(this).css({"background":"url("+imageDir+"base/exit.png) no-repeat",'background-size' :'100% 100%'});
    });
    exitBtn.mouseover(function(){
        $(this).css({"background":"url("+imageDir+"base/exit_hover.png) no-repeat",'background-size' :'100% 100%'});
    });

});