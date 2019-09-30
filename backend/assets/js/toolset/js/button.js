var trans_mode = false;

window.addEventListener('load',function(){
    $('#page_nav_prev').click(function(){
        $('.translte-elem').remove();
        prevPage();
    });
    $('#page_nav_next').click(function () {
        $('.translte-elem').remove();
        nextPage();
    });
    $('#page_nav_prev').mouseenter(function(){
        $('#page_nav_prev').find('img').attr('src', 'images/pagenave-prev-hover.gif');
    });
    $('#page_nav_prev').mouseleave(function(){
        $('#page_nav_prev').find('img').attr('src', 'images/pagenave-prev.png');
    });
    $('#page_nav_next').mouseenter(function(){
        $('#page_nav_next').find('img').attr('src', 'images/pagenave-next-hover.gif');
    });
    $('#page_nav_next').mouseleave(function(){
        $('#page_nav_next').find('img').attr('src', 'images/pagenave-next.png');
    });

    if(isMobile){
       var btnComment = document.getElementById('btn_comment');
       btnComment.addEventListener('touchstart',function () {
           changeToComment();
       });
        var btnTranslate = document.getElementById('btn_translate');
        btnTranslate.addEventListener('touchstart',function () {
            changeToTranslate();
        });
    }else{
        $('#btn_comment').click(function(){
            changeToComment();
        });
        $('#btn_translate').click(function(){
            changeToTranslate();
        });
    }


    $('#btn_words').click(function(){
        select_effect($(this));
        changeMode( 'words' );
    });
    $('#btn_scriptread').click(function(){
        select_effect($(this));

        if( typeof current_page == 'undefined' || current_page == null ){
            current_page = 0;
        }

        window.location = 'read.html?page=' + current_page;
     });

    $('#btn_song').click(function(){
        select_effect($(this));
        window.location = 'song.html'
    });

    $('#btn_scriptmake').click(function(){
        select_effect($(this));
        window.location = 'makescript.html'
    });

    $('#btn_headmake').click(function(){
        select_effect($(this));
        window.location = 'makehead.html'
    });

    $('#btn_print').click(function(){
        select_effect($(this));
        changeMode( 'print' );
    });

    $('#language_status_btn').click(function () {
        if( current_mode == 'comment' )
            return;

        if( trans_mode == true ){
            $(this).find('img').attr('src', 'images/btn-chinese.png');
            trans_mode = false;
        } else {
            $(this).find('img').attr('src', 'images/btn-chinese_hover.png');
            trans_mode = true;
        }
    });
});

function changeToTranslate() {

    if(cur_language=='_en'){

        if(current_page=='0') $('#page_0').css({'background-image':'url(images/page00_cn.jpg)'});
        $(this).attr('data-language','western');
        $(this).find('img').attr('src', 'images/btn-translate_hover.png');
        $('.page_en').hide();
        $('.page_cn').show();
        cur_language = '_cn';
        clicked_translate = '1';
        if(total_paly_status == false){
            $('#sound_play_btn').trigger('click');
        }

    }else {

        if(current_page=='0') $('#page_0').css({'background-image':'url(images/page00_en.jpg)'});
        $(this).attr('data-language','china');
        $(this).find('img').attr('src', 'images/btn-translate.png');
        $('.page_en').show();
        $('.page_cn').hide();
        cur_language = '_en';
    }
    $('.translte-elem').remove();

}

function changeToComment() {

    if( current_mode == 'comment' ){
        $('#btn_comment').find('img').attr('src', 'images/btn-comment.png');
        changeMode('sound');
    } else {
        if(cur_language=='_cn') {
            $('#btn_translate').trigger('click');
        }
        if( typeof current_page == 'undefined' || current_page == null ){
            window.location = 'index.html?comment';
            return;
        }

        var imgsrc = $('#btn_scriptread').find('img').attr('src');
        if( imgsrc.indexOf('_hover') > 0 ){
            window.location = 'index.html?comment&page=' + current_page;
            return;
        }

        select_effect($('#btn_comment'));
        changeMode( 'comment' );
    }
}
function select_effect(elem){
    remove_select_effect();
    var img_src = $(elem).find('img').attr('src');
    img_src = img_src.replace('.png', '') + '_hover.png';
    $(elem).find('img').attr('src', img_src);
}

function remove_select_effect(){
    var elems = $('.btn_elem img');
    for( var i=0; i<elems.length; i++ ){
        var elem = elems[i];
        var img_src = $(elem).attr('src');
        img_src = img_src.replace('_hover', '');
        //alert(img_src);
        $(elem).attr('src', img_src);
    }
}

