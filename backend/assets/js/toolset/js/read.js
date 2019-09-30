var read_arr;
var is_play = false;
var is_recording = false;
var current_page = 0;
var pos = {left:0, top:0};
/***********************************/
//Key 1: 306b0f61e8274c859d96b4660c4edad8
//Key 2: fefdae7ca1704b018328219aadb6ee7e
/************************************/
window.AudioContext = window.AudioContext || window.webkitAudioContext;
var audioContext = new AudioContext();
var audioInput = null,
    realAudioInput = null,
    inputPoint = null,
    audioRecorder = null;
var newSource;

var originalReadText = '';

document.addEventListener("DOMContentLoaded", function () {
    Initialize(function (speechSdk) {
        SDK = speechSdk;
    });
});

window.addEventListener('load',function(){

    getPagesData();
    initAudio();
    displayPage(0);

    var param = window.location.search.substr(1);
    if( param.length > 0 ){
        var page = param.split('=');
        current_page = parseInt(page[1]);
        displayPage(current_page);
    }

    $('#read-play-btn').attr('disabled', true);
    $('#read-play-btn').css('opacity', 0.3);

    $('#language_status_btn').click(function () {

        if(cur_language=='_en'){
            $(this).attr('data-language','western');
            $(this).find('img').attr('src', 'images/btn-euro.png');
            $('.page_en').hide();
            $('.page_cn').show();
            cur_language = '_cn';
        }else {

            $(this).attr('data-language','china');
            $(this).find('img').attr('src', 'images/btn-chinese.png');
            $('.page_en').show();
            $('.page_cn').hide();
            cur_language = '_en';
        }
    });

    $('.read_text').hover(function () {

        if(cur_language=='_cn')
        {
            $(this).css('background-color','rgba(255,255,255,0)');
            $(this).css('color','#000');
        }
    });

    $('#read-play-btn').mouseenter(function(){
        $('.play-tooltip').show();
    });
    $('#read-play-btn').mouseleave(function(){
        $('.play-tooltip').hide();
    });
    $('#read-record-btn').mouseenter(function(){
        $('.record-tooltip').show();
    });
    $('#read-record-btn').mouseleave(function(){
        $('.record-tooltip').hide();
    });
});
/*********************************************Compare text***************************************************************/
function getIndicesOf(searchStr, str, caseSensitive) {
    var searchStrLen = searchStr.length;
    if (searchStrLen == 0) {
        return [];
    }
    var startIndex = 0, index, indices = [];
    if (!caseSensitive) {
        str = str.toLowerCase();
        searchStr = searchStr.toLowerCase();
    }
    while ((index = str.indexOf(searchStr, startIndex)) > -1) {
        indices.push(index);
        startIndex = index + searchStrLen;
    }
    return indices;
}
function dziemba_levenshtein(a, b){
    var tmp;
    if (a.length === 0) { return b.length; }
    if (b.length === 0) { return a.length; }
    if (a.length > b.length) { tmp = a; a = b; b = tmp; }

    var i, j, res, alen = a.length, blen = b.length, row = Array(alen);
    for (i = 0; i <= alen; i++) { row[i] = i; }

    for (i = 1; i <= blen; i++) {
        res = i;
        for (j = 1; j <= alen; j++) {
            tmp = row[j - 1];
            row[j - 1] = res;
            res = b[i - 1] === a[j - 1] ? tmp : Math.min(tmp + 1, Math.min(res + 1, row[j] + 1));
        }
    }
    return res;
}

var isSimilarity = function(word1,word2) {

    if(word2==undefined) return false;
    if(word1.length===0||word2.length===0) return false;
    var word1S = word1.split(/[,]+/);
    word1 = word1S[0];
    var distOfWords = dziemba_levenshtein(word1,word2);
    var compareLength  = Math.max(word1.length,word2.length);
    console.log('('+word1+','+word2+')');
    console.log('Dist is '+distOfWords+' and max is '+compareLength);
    console.log('rating'+(distOfWords/compareLength));
    if(distOfWords/compareLength<0.6)
    {

        return true;
    }
    return false;
};

function compareSpeechText(){

    if(is_recording) return;

    //tranText = 'This play telsslddds the story of a monkey';
    console.log('This is translated text*************************:'+typeof tranText);
    var returnHtml = '';
    var jsonData = '';
    var originalText = $('#src-read-text').text();
    //var srcText = originalText.split('.').join("");///delete dot of text
    //var srcWords = originalText.split(/[ ,]+/);
    var srcWords = originalText.split(/[ ]+/);
    try {
        //alert(tranText.replace(/\s/g,''));
        jsonData = JSON.parse(tranText);
        if(jsonData.RecognitionStatus=='Success')
        {
            tranText = jsonData.DisplayText;

            console.log(tranText);

            var tranWords = tranText.split(' ');
            console.log('trans words-------------------:'+tranWords);
            if(tranWords.length===0)
            {
                returnHtml = '<span style="color:red">'+originalText+'</span>';
            }else{
                for (var i=0;i<srcWords.length;i++)
                {

                    if(isSimilarity(srcWords[i],tranWords[0]))
                    {
                        returnHtml += ' <span style="color:#5fc900">'+srcWords[i]+'</span>';

                    }else{
                        returnHtml += ' <span style="color:red">'+srcWords[i]+'</span>';
                    }
                    if(tranWords.length>0) tranWords.splice(0, 1);
                }

            }
        }else {
            returnHtml = '<span style="color:red">'+originalText+'</span>';
        }

    }catch (err)
    {
       returnHtml = '<span style="color:red">'+originalText+'</span>';
    }
    $('#src-read-text').html(returnHtml);
}
/***********************************************************Compare text*************************************************/
function getPagesData(){
    read_arr = new Array();

    var page_elems = $('.page');

    for( var i=0; i<page_elems.length; i++ ){
        var s_arr = new Array();

        var page_id = $(page_elems[i]).attr('id');
        var read_elems = $(page_elems[i]).find('.read_text');

        for( var j=0; j<read_elems.length; j++ ){
            var read_id = $(read_elems[j]).attr('id');
            var sound =  $(read_elems[j]).data('sound');
            s_arr.push({
                id: read_id,
                sound: sound
            })
        }

        read_arr.push({
            id: page_id,
            dialog: s_arr
        })
    }
}
function getDialogData( s_id ){
    s_id = s_id+cur_language;
    if( read_arr[current_page] === undefined || read_arr[current_page] === null )
        return false;
    var dialogs = read_arr[current_page].dialog;
    for( var i=0; i<dialogs.length; i++ ){
        if(dialogs[i].id == s_id){
            return dialogs[i];
        }
    }
    return false;
}
function highlightText(s_id){
    $('.read_text').removeClass('sel');
    $('#'+s_id).addClass('sel');
}
function prevPage(){
    audio.pause();
    if( current_page-1 < 0 )
        return ;
    current_page--;
    displayPage(current_page);
}

function nextPage(){
    audio.pause();
    if( current_page+1 >= read_arr.length )
        return ;
    current_page++;
    displayPage(current_page);
}


function displayPage(i){
    var pages = $('.page');
    if( i >= pages.length )
        return;
    $('.page').hide();
    $(pages[i]).show();
    displayBackVideo();
}

function showReadModal(){
    $('#read_modal').show();
}

function hideReadModal(){
    $('#read_modal').hide();
    $('.read_text').removeClass('sel');
}

function getModalPos( pos_x, pos_y ){
    var left=0, top=0;
    if(pos_x < 150)
        left = 0;
    else
        left = pos_x-150;

    if( pos_y > 720-200 )
        top = pos_y-230
    else
        top = pos_y+30

    return {left:left, top:top}
}

function togglePlay(){
    if(is_play == true){

        console.log('toggle Play Event Disabled');

        if( newSource != undefined && newSource != null && newSource.buffer != null ){
            newSource.stop(0);
        }
        $('#read-play-btn img').attr('src', 'images/read-play.png');
        is_play = false;
        $('#read-record-btn').attr('disabled', false);
        $('#read-record-btn').css('opacity', 1);
    } else {

        console.log('toggle Play Event Enabled');

        audioRecorder.getBuffers( playGotBuffers );

        $('#read-play-btn img').attr('src', 'images/read-playstop.png');
        is_play = true;
        $('#read-record-btn').attr('disabled', true);
        $('#read-record-btn').css('opacity', 0.3);
    }
}


function playGotBuffers( buffers ){
    newSource = audioContext.createBufferSource();

    if( buffers[0].length == 0 ) {
        // $('#read-play-btn').attr('disabled', true);
        // $('#read-play-btn').css('opacity', 0.3);
        return;
    }
    var newBuffer = audioContext.createBuffer( 2, buffers[0].length, audioContext.sampleRate );
    newBuffer.getChannelData(0).set(buffers[0]);
    newBuffer.getChannelData(1).set(buffers[1]);
    newSource.buffer = newBuffer;

    newSource.connect( audioContext.destination );
    newSource.onended = onPlayEnded;
    newSource.start(0);

    console.log('Toggle Callback End Event connected!');
}

function onPlayEnded(){

    console.log('Play End Event Occured !!!!!!!!!!!!!!!!');

    if(is_play == true)
        $('#read-play-btn').trigger('click');
}
function gotBuffers( buffers ) {
    console.log('--------------------------');
    console.log(buffers);
    console.log('--------------------------');

    audioRecorder.exportWAV( doneEncoding );
}

function doneEncoding( blob ) {
    //Recorder.setupDownload( blob, "myRecording" + ((recIndex<10)?"0":"") + recIndex + ".wav" );
    //recIndex++;
}


function toggleRecording( e ) {///////////audio recording -pms(2)
    if (e.classList.contains("recording")) {

        is_recording = false;

        ///Speech2Text disable!
        RecognizerStop(SDK, recognizer);

        //compareSpeechText();

        ///Speech2Text disable!
        // stop recording
        audioRecorder.stop();
        e.classList.remove("recording");
        audioRecorder.getBuffers( gotBuffers );///get audio binary data from audio
        $('#read-record-btn img').attr('src', 'images/read-record.png');
        $('#read-record-btn').css({left: '40.15%', top: '42.47%', width: '5.93%', height: '15.58%'});
        $('#read-play-btn').attr('disabled', false);
        $('#read-play-btn').css('opacity', 1);
        $('.recording-tooltip').hide();
    } else {
        // start recording
        if (!audioRecorder)
            return;
        if(originalReadText!=='')
        {
            $('#src-read-text').text(originalReadText);
        }
        SetupS2T();///init speech to text module
        ////Speech to text module
        RecognizerStart(SDK, recognizer);

        e.classList.add("recording");

        audioRecorder.clear();
        audioRecorder.record();

        $('#read-record-btn img').attr('src', 'images/read-recordstop.gif');
        $('#read-record-btn').css({left:'41.51%',top:'39.77%',width:'3.38%',height:'13.5%'});
        $('#read-play-btn').attr('disabled', true);
        $('#read-play-btn').css('opacity', 0.3);
        $('.recording-tooltip').show();

        is_recording = true;

    }
}


function convertToMono( input ) {
    var splitter = audioContext.createChannelSplitter(2);
    var merger = audioContext.createChannelMerger(2);

    input.connect( splitter );
    splitter.connect( merger, 0, 0 );
    splitter.connect( merger, 0, 1 );
    return merger;
}

function toggleMono() {

    if (audioInput != realAudioInput) {
        audioInput.disconnect();
        realAudioInput.disconnect();
        audioInput = realAudioInput;
    } else {
        realAudioInput.disconnect();
        audioInput = convertToMono( realAudioInput );
    }

    audioInput.connect(inputPoint);
}


function gotStream(stream) {
    inputPoint = audioContext.createGain();

    // Create an AudioNode from the stream.
    realAudioInput = audioContext.createMediaStreamSource(stream);
    audioInput = realAudioInput;
    audioInput.connect(inputPoint);

//    audioInput = convertToMono( input );
    audioRecorder = new Recorder( inputPoint );

}


function initAudio() {
    if (!navigator.getUserMedia)
        navigator.getUserMedia = navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
    if (!navigator.cancelAnimationFrame)
        navigator.cancelAnimationFrame = navigator.webkitCancelAnimationFrame || navigator.mozCancelAnimationFrame;
    if (!navigator.requestAnimationFrame)
        navigator.requestAnimationFrame = navigator.webkitRequestAnimationFrame || navigator.mozRequestAnimationFrame;

    navigator.getUserMedia(
        {
            "audio": {
                "mandatory": {
                    "googEchoCancellation": "false",
                    "googAutoGainControl": "false",
                    "googNoiseSuppression": "false",
                    "googHighpassFilter": "false"
                },
                "optional": []
            }
        }, gotStream, function(e) {
            alert('Error getting audio');
            console.log(e);
        });
}


$('.boxclose').click(function(){
    close_box();
});
var introVideo = document.getElementById('scriptread_video');
introVideo.onended = function(){
    close_box();
};

function showIntroVideo()
{
    $('.backdrop_scriptread, .box').animate({'opacity':'.8'}, 300, 'linear');
    $('.box').animate({'opacity':'1.00'}, 300, 'linear');
    $('.backdrop_scriptread, .box').css('display', 'block');

    introVideo.play();
}
function close_box()
{
    $('.backdrop_scriptread, .box').animate({'opacity':'0'}, 300, 'linear', function(){
        $('.backdrop_scriptread, .box').css('display', 'none');
    });
    introVideo.pause();
}
showIntroVideo();



