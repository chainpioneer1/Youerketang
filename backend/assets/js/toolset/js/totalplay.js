var page_arr;


var current_page = 0;
var highlighter;
var cur_language = '_en';


window.addEventListener('load',function(){

    getPagesData();

    $('#sound_play_btn').show();
    $('#sound_play_btn').click(function(){
        if(total_paly_status)
        {
            var page_id = 'page_' + current_page;
            var first_id = $('#'+page_id).find('.dialog_text')[0];
            first_id = $(first_id).attr('id');
            first_id = first_id.substr(0, first_id.length-3);
            $(this).find('img').attr('src','images/sound_playing.gif');
            soundTotalPlay(first_id);
            total_paly_status = false;
        }else
        {
            $(this).find('img').attr('src','images/sound.png');
            audio.pause();
            total_paly_status = true;
        }

        $('.translte-elem').remove();
    });

    var param = window.location.search.substr(1);
    param = param.split('&');
    if( param[0] == 'comment' ){
        select_effect($('#btn_comment'));
        changeMode('comment')
        if( param.length > 1 ){
            var page = param[1].split('=');
            current_page = parseInt(page[1]);
            displayPage(current_page);
        }
    } else {
       // soundTotalPlay('d_0');
        if( param.length > 1 ){
            var page = param[1].split('=');
            current_page = page[1];
            displayPage(current_page);
        }
    }

    $('.dialog_text').click(function(e){

        $('.translte-elem').remove();

        if(cur_language=='_cn')
            return;

        if( current_mode == 'sound' ){
            if( total_paly_status == false )
                $('#sound_play_btn').trigger('click');

            audio.pause();
            var idx = $(this).attr('id');
            idx = parseInt(idx.substr(2));

            audio.src = 'sound/script/' + $(this).data('sound');
            audio.play();
            audio.onended = function(){};

            highlightText(idx);

            if( trans_mode == true ){
                var pos;
                var id = $(this).attr('id');
                id = id.replace('_en', '_cn');
                var trans_text = $('#'+id).html();
                var pos_x = e.clientX;
                var pos_y = e.clientY;
                /****************************************PMS_CODE**********************************/
                var trans_elem = $('<div class="translte-elem">'+trans_text+'</div>');
                $('body').append(trans_elem);
                var tranTxtModalW = ($('.translte-elem').width())/2;
                var tranTxtModalH =  $('.translte-elem').height();
                var curPageW = $('#page_'+current_page).width();
                var curPageH = $('#page_'+current_page).height();
                if(curPageW<(pos_x+tranTxtModalW))
                {
                    pos_x = curPageW-100-tranTxtModalW;
                }else{
                    pos_x = pos_x - tranTxtModalW;
                }
                if(curPageH<(pos_y+tranTxtModalH))
                {
                    pos_y = pos_y - tranTxtModalH-20;
                }else{
                    pos_y = pos_y +20;
                }
                $('.translte-elem').css('top',pos_y);
                $('.translte-elem').css('left',pos_x);

            }
        } else if( current_mode == 'comment' ){
            var idx = $(this).attr('id');
        }
    });

    $('.read_text').click(function(e){
        var pos_x = e.clientX;
        var pos_y = e.clientY;
        pos = getModalPos( pos_x, pos_y );
        showReadModal();
    });


});
function getPagesData(){
    page_arr = new Array();

    var page_elems = $('.page');

    for( var i=0; i<page_elems.length; i++ ){
        var d_arr = new Array();

        var page_id = $(page_elems[i]).attr('id');
        var dialog_elems = $(page_elems[i]).find('.dialog_text');
        for( var j=0; j<dialog_elems.length; j++ ){
            var dialog_id = $(dialog_elems[j]).attr('id');
            var sound =  $(dialog_elems[j]).data('sound');
            d_arr.push({
                id: dialog_id,
                sound: sound
            })
        }
        page_arr.push({
            id: page_id,
            dialog: d_arr
        })
    }

}
function getDialogData( d_id ){
    d_id = d_id+cur_language;
    if( page_arr[current_page] === undefined || page_arr[current_page] === null )
        return false;
    var dialogs = page_arr[current_page].dialog;
    for( var i=0; i<dialogs.length; i++ ){
        if(dialogs[i].id == d_id){
            return dialogs[i];
        }
    }
    return false;
}
function soundTotalPlay(d_id){
    var dialogs = page_arr[current_page].dialog;
    var dialog = getDialogData( d_id );
    if( dialog != false ){

        audio.src = 'sound/script/' + dialog.sound;
        audio.play();
        highlightText(d_id);

    }
    var a = "" + d_id;
    var num = parseInt(a.substr(2));
    num++;
    d_id = 'd_' + num;
    var new_dialog = getDialogData( d_id );
    if( new_dialog != false ){
        audio.onended = function(){
            setTimeout( soundTotalPlay.bind(null, d_id), 100);
        }
    } else {
        current_page++;
        new_dialog = getDialogData( d_id );
        current_page--;
        if( new_dialog != false ){
            audio.onended = function(){
                current_page++;
                displayPage(current_page);
                soundTotalPlay(d_id);
            }
        } else if( current_page == page_arr.length-1 ){
            audio.onended = null;
            console.log('ended1');

        } else {
            current_page--;
            console.log('ended');
            audio.onended = null;
            $('.dialog_text').removeClass('sel');
            $('#sound_play_btn').trigger('click');
        }
    }
}
function highlightText(d_id){
    $('.dialog_text').removeClass('sel');
    $('#'+d_id+cur_language).addClass('sel');
}


function prevPage(){
    if( total_paly_status == false )
        $('#sound_play_btn').trigger('click');
    audio.pause();

    if( current_page-1 < 0 )
        return ;
    current_page--;
    displayPage(current_page);
}

function nextPage(){
    if( total_paly_status == false )
        $('#sound_play_btn').trigger('click');
    audio.pause();

    if( current_page+1 >= page_arr.length )
        return ;
    current_page++;
    displayPage(current_page);
}

function setSndIconPosition() {

    var sndArea = $('#page_'+current_page).find('.section-left');
    var sndAreaRight = $('#page_'+current_page).find('.section-right');

    if(sndArea.length===0) {
        sndArea = sndAreaRight;

    }
    if(current_page===0)////Cover Main Page(Summary title)
    {
        var summaryTitle = $('#d_0_en');
        var summaryTitleMargintop = summaryTitle.css('marginTop').replace('px', '');

        var summaryWrapPaddingTop  = $('#page_0 .col-md-6.col-sm-6.col-xs-6').css('paddingTop').replace('px', '');
        var summaryTitleImgHeight = summaryTitle.find('img').first().height();

        var sndImgHeight = $('#sound_play_btn img').height();
        var summaryVMiddleVal =  parseFloat(summaryWrapPaddingTop) + parseFloat(summaryTitleMargintop)+parseFloat(summaryTitleImgHeight)/2;
        $('#sound_play_btn').css({top:summaryVMiddleVal-parseFloat(sndImgHeight)/2});
    }else{
        var sLeftVal = sndArea.css('left').replace('px', '');
        var fCharcFtSize = sndArea.find('.dialog_character').first().css('font-size');
        if(fCharcFtSize!==undefined){

            var sectionTitle = sndArea.find('h3');
            if(sectionTitle.length!==0){///Act 1, Act 2....

                var sTopVal = (sndArea.first().position()).top;
                var sectionTitleMTop = sectionTitle.css('marginTop').replace('px', '');
                var sectionTitleFtSize = sectionTitle.css('fontSize').replace('px', '');
                var sndImgHeight = $('#sound_play_btn img').height();
                var sndImgWidth = $('#sound_play_btn img').width();
                var sectionTitleVerticalMiddleValue = parseFloat(sTopVal)+parseFloat(sectionTitleMTop)+parseFloat(sectionTitleFtSize)/2;
                $('#sound_play_btn').css('top',sectionTitleVerticalMiddleValue-parseFloat(sndImgHeight)/2);
                $('#sound_play_btn').css('left',parseFloat(sLeftVal)+parseFloat(sndImgWidth));

            }else{///
                var sTopVal = (sndArea.first().position()).top;
                var sWidthVal = sndArea.first().width();
                var sCharacterTitle = sndArea.find('.dialog_character').first();
                var sCharacterTitleHeight = sCharacterTitle.height();
                var sndImgHeight = $('#sound_play_btn img').height();
                var sectionTitleVerticalMiddleValue = parseFloat(sTopVal)+parseFloat(sCharacterTitleHeight)/2;
                $('#sound_play_btn').css('top',sectionTitleVerticalMiddleValue-parseFloat(sndImgHeight)/2);
                $('#sound_play_btn').css('left',parseFloat(sLeftVal)+parseFloat(sWidthVal)/2);
            }
        }
    }

}
function soundIconLoacte(){
    switch (current_page){
        case 0:
            $('#sound_play_btn').css({left:'39%',top:'9%'});
            break;
    }
    setSndIconPosition();
}





