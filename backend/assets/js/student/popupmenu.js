/**
 * Created by Administrator on 6/12/2017.
 */
$(window).ready(function () {

    var popUpSt = 0;
    var slide_div = $('#slide_menu_head');
    slide_div.click(function () {
        if(popUpSt==0){

            $('#slide_menu_area').css('right','16%');
            $('#slide_menu_body').show('slow');
            slide_div.html('<a href="#" id ="slide_arrow_key" style="font-size: 40px;text-decoration: none">&Rang;</a>');
            popUpSt = 1;
        }else{

            $('#slide_menu_area').css('right','13%');
            $('#slide_menu_body').hide();
            slide_div.html('<a href="#" id ="slide_arrow_key" style="font-size: 40px;text-decoration: none">&Lang;</a>');
            popUpSt = 0;
        }

    });


});