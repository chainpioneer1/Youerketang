$(window).load(function(){

    if( window.addEventListener ){
        window.addEventListener( 'message', receiveMessage, false );
    } else {
        window.attachEvent( 'onmessage', receiveMessage );
    }
    function receiveMessage(event){
        var message = event.data; //this is the message
        message = JSON.parse(message);

        if( message.type == 'get-ncourseware-id' ){
            var iframe = document.getElementById('new_courseware_iframe_text').contentWindow;

            var response = {
                type: 'ncourseware-id',
                value: ncourseware_id,
                login_status:login_status,
                login_username:login_username,
                base_URL:base_url
            };
            iframe.postMessage(JSON.stringify(response), '*');
        } else if( message.type == 'get-ncourseware-video-id' ){
            var iframe = $('#new_courseware_iframe').contents().find('iframe');
            iframe = iframe[0].contentWindow;
            var response = {
                type: 'ncourseware-id',
                value: ncourseware_id,
                login_status:login_status,
                login_username:login_username,
                base_URL:base_url
            };
            iframe.postMessage(JSON.stringify(response), '*');
        }
    }

    /**********************************************************************/
    $('#leftarrow_btn').mouseover(function(){
        $(this).css({"background":"url("+imageDir+"sidepad/cnClose_r.png) no-repeat",'background-size' :'100% 100%'});
    });
    $('#leftarrow_btn').click(function(){
        $('.side_pad_btn_wrapper').hide();
        $('#rightarrow_btn').show();
    });
    $('.side_lang_btn').click(function(){

        $('#'+curLang+'_btn').css({"background":"url("+imageDir+"sidepad/"+curLang+".png) no-repeat",'background-size' :'100% 100%'});
        curLang = $(this).attr('lang');
        $(this).css({"background":"url("+imageDir+"sidepad/"+curLang+"_r.png) no-repeat",'background-size' :'100% 100%'});
        if(curLang=='cnCH')
        {
            if($('#new_courseware_iframe').contents().find('iframe').contents().find('video').prop("outerHTML").toString().indexOf("lang_") == -1)
                return;
            var curTime = $('#new_courseware_iframe').contents().find('iframe').contents().find('video').get(0).currentTime;
            //var video_num = $('#main').contents().find('iframe').get(0).contentWindow.info;
            var video_num = $('#new_courseware_iframe').contents().find('iframe').get(0).contentWindow.playing_video;

            $('#new_courseware_iframe').contents().find('iframe').contents().find('video').get(0).pause();
            $('#new_courseware_iframe').contents().find('iframe').contents().find('video').find('source').get(0).setAttribute('src',"./sco/videos/lang_ch/"+ video_num + ".mp4")
            $('#new_courseware_iframe').contents().find('iframe').contents().find('video').get(0).load();
            $('#new_courseware_iframe').contents().find('iframe').contents().find('video').get(0).play();
            $('#new_courseware_iframe').contents().find('iframe').contents().find('video').get(0).currentTime = curTime;

        }else if(curLang=='cnEN'){

            if($('#new_courseware_iframe').contents().find('iframe').contents().find('video').prop("outerHTML").toString().indexOf("lang_") == -1)
                return;
            var curTime = $('#new_courseware_iframe').contents().find('iframe').contents().find('video').get(0).currentTime;
            var video_num = $('#new_courseware_iframe').contents().find('iframe').get(0).contentWindow.playing_video;
            $('#new_courseware_iframe').contents().find('iframe').contents().find('video').get(0).pause();
            $('#new_courseware_iframe').contents().find('iframe').contents().find('video').find('source').get(0).setAttribute('src',"./sco/videos/lang_en/"+ video_num + ".mp4")
            $('#new_courseware_iframe').contents().find('iframe').contents().find('video').get(0).load();
            $('#new_courseware_iframe').contents().find('iframe').contents().find('video').get(0).play();
            $('#new_courseware_iframe').contents().find('iframe').contents().find('video').get(0).currentTime = curTime;

        }else if(curLang=='cnCHEN'){
            if($('#new_courseware_iframe').contents().find('iframe').contents().find('video').prop("outerHTML").toString().indexOf("lang_") == -1)
                return;
            var curTime = $('#new_courseware_iframe').contents().find('iframe').contents().find('video').get(0).currentTime;
            var video_num = $('#new_courseware_iframe').contents().find('iframe').get(0).contentWindow.playing_video;
            $('#new_courseware_iframe').contents().find('iframe').contents().find('video').get(0).pause();
            $('#new_courseware_iframe').contents().find('iframe').contents().find('video').find('source').get(0).setAttribute('src',"./sco/videos/lang_ch_en/"+ video_num + ".mp4")
            $('#new_courseware_iframe').contents().find('iframe').contents().find('video').get(0).load();
            $('#new_courseware_iframe').contents().find('iframe').contents().find('video').get(0).play();
            $('#new_courseware_iframe').contents().find('iframe').contents().find('video').get(0).currentTime = curTime;
        }else if(curLang=='cnNONE'){
            if($('#new_courseware_iframe').contents().find('iframe').contents().find('video').prop("outerHTML").toString().indexOf("lang_") == -1)
                return;
            var curTime = $('#new_courseware_iframe').contents().find('iframe').contents().find('video').get(0).currentTime;
            var video_num = $('#new_courseware_iframe').contents().find('iframe').get(0).contentWindow.playing_video;
            $('#new_courseware_iframe').contents().find('iframe').contents().find('video').get(0).pause();
            $('#new_courseware_iframe').contents().find('iframe').contents().find('video').find('source').get(0).setAttribute('src',"./sco/videos/lang_no/"+ video_num + ".mp4")
            $('#new_courseware_iframe').contents().find('iframe').contents().find('video').get(0).load();
            $('#new_courseware_iframe').contents().find('iframe').contents().find('video').get(0).play();
            $('#new_courseware_iframe').contents().find('iframe').contents().find('video').get(0).currentTime = curTime;
        }

    });
    $('#rightarrow_btn').click(function () {
        $('.side_pad_btn_wrapper').show();

        $(this).hide();
    });
});
