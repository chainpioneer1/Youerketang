var current_course = '';
var current_mode = 'sound';
var cur_language = '_en';
var total_paly_status = true;
var audio = new Audio();
var vplayer;

window.addEventListener('load',function(){
    current_course = $('#course_name').val();

    try {
        vplayer = videojs('videoPlayer',{controls:false,width:1280,height:720,preload:'auto',autoplay:true,loop:true},function(){
            vplayer.on('play', function(){
                console.log('back video play');
            });
            vplayer.on("pause",function(){
                console.log('back video stop');
            });
        });
    } catch(e) {
        console.log(e);
    }

    $('#words_modal').click(function(){
        $(this).hide();
    })

});

function changeMode( mode ){
    initMode();

    current_mode = mode;

    if( current_mode == 'sound' ){
        $('#language_status_btn').show();
        modeSound();
    } else if( current_mode == 'comment' ){
        $('#language_status_btn').hide();
        modeComment();
    } else if( current_mode == 'words' ){
        modeWords();
    } else if( current_mode == 'print' ){
        modePrint();
    }

    $('.translte-elem').remove();
}

function initMode(){
    hideWords();

    if( total_paly_status != undefined && total_paly_status != null && total_paly_status == false )
        $('#sound_play_btn').trigger('click');
    audio.pause();
    $('#sound_play_btn').hide();

    word_modal_status = true;
}

function modeSound(){
    $('.dialog_text').css('user-select', 'none');
    $('.dialog_text').css('cursor', 'pointer');
    $('.dialog_text').mouseenter(function(){
        $(this).css('color', '#ed4431');
    });
    $('.dialog_text').mouseleave(function(){
        $(this).css('color', '#000');
    });
    $('#sound_play_btn').show();
}

function modeComment(){
    $('.dialog_text').removeClass('sel');
    $('.dialog_text').css('user-select', 'text');
    $('.dialog_text').css('cursor', 'text');
    $('.dialog_text').mouseenter(function(){
        $(this).css('color', '#000');
    });

    displayPage( current_page );
}

function modeWords(){
    showWords();
}

function displayBackVideo(){

    if( current_page == 0 ){
        vplayer.hide();
        return;
    } else {
        vplayer.show();
    }

    switch (current_page){
        case 0:
            break;
        case 1:
            vplayer.src({type:'video/mp4',src:'video/tomorrow001.mp4'});
            break;
        case 2:
            vplayer.src({type:'video/mp4',src:'video/tomorrow002.mp4'});
            break;
        case 3:
            vplayer.src({type:'video/mp4',src:'video/tomorrow003.mp4'});
            break;
        case 4:
            vplayer.src({type:'video/mp4',src:'video/tomorrow004.mp4'});
            break;
        case 5:
            vplayer.src({type:'video/mp4',src:'video/tomorrow005.mp4'});
            break;
        case 6:
            vplayer.src({type:'video/mp4',src:'video/tomorrow006.mp4'});
            break;
        case 7:
            vplayer.src({type:'video/mp4',src:'video/tomorrow007.mp4'});
            break;
        case 8:
            vplayer.src({type:'video/mp4',src:'video/tomorrow008.mp4'});
            break;
        case 9:
            vplayer.src({type:'video/mp4',src:'video/tomorrow009.mp4'});
            break;
        case 10:
            vplayer.src({type:'video/mp4',src:'video/tomorrow010.mp4'});
            break;
        case 11:
            vplayer.src({type:'video/mp4',src:'video/tomorrow011.mp4'});
            break;
    }

    var pageId = '#page_' + current_page;
    vplayer.width( $(pageId).width() );
    vplayer.height( $(pageId).width()*8.9/16 );

}

/***************Script print function*********************/
function closePrint () {
    document.body.removeChild(this.__container__);
}
function setPrint () {
    this.contentWindow.__container__ = this;
    this.contentWindow.onbeforeunload = closePrint;
    this.contentWindow.onafterprint = closePrint;
    this.contentWindow.focus(); // Required for IE
    console.log(this.contentWindow);
    this.contentWindow.print();
}
function modePrint(){
    /* This code work on only chrome browser
    var oHiddFrame = document.createElement("iframe");
    oHiddFrame.onload = setPrint;
    oHiddFrame.style.visibility = "hidden";
    oHiddFrame.style.position = "fixed";
    oHiddFrame.style.right = "0";
    oHiddFrame.style.bottom = "0";
    oHiddFrame.src = 'pdf/Tomorrow.pdf';
    document.body.appendChild(oHiddFrame);
    */
    var aTag = document.createElement('a');
    aTag.className = 'script-download';
    aTag.href = base_url+'coursewares/pdfDownLoad/?pdfUrl='+courseware_id+'/script/pdf/Tomorrow.pdf';
    aTag.target = '_blank';
    aTag.style.visibility = 'hidden';
    document.body.appendChild(aTag);
    aTag.click();
    aTag.remove();
}
/*
https://stackoverflow.com/questions/33254679/print-pdf-in-firefox
*/
