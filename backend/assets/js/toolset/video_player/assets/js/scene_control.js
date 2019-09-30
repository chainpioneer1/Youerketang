var vplayer;

var videoWrapper = $('.sf-video-wrapper');

var video_isplaying = true;

$(document).ready(function () {

    var options = {};
    var sceneH = window.innerHeight;
    var sceneW = window.innerWidth;

    if (!isMobile) {

    }
    $('body').css({
        'width': sceneW,
        'height': sceneH,
        left: 0
    });
    $('video').css({
        'width': sceneW,
        'width': sceneH
    });
    //
    // setTimeout(function () {
    //     $('.start-video-page').hide();
    // }, 3000);
    //
    $('.start-video-page').hide();

    vplayer = videojs('video-player', {
        controls: true,
        preload: 'auto',
        width: sceneW,
        height: sceneH,
        loop: false,
        autoplay: true
    }, function () {
        vplayer.on('play', function () {

            $('.loading-img-wrapper').hide();
            // video_isplaying=true;
        });
        vplayer.on("pause", function () {

        });
        vplayer.on("ended", function () {
            video_isplaying = false;
        });
    });
    // resizeWindow();

    if(start_play_status!=''){
        $('.loading-img-wrapper').hide();
        video_isplaying=true;
        play_pause();
    }

    $('.loading-img-wrapper').hide();


});

function switchVideo(st) {

    if (st) {//True then show video and hide content page area
        videoWrapper.show();
        verticalWrapper.hide();
        if (initStatus === 0) {
            $('.prev-page-btn-1').css('display', 'none');
        } else {
            $('.prev-page-btn-1').css('display', 'block');
        }

    } else {//False then video hide and show content page
        videoWrapper.hide();
        verticalWrapper.show();
        $('.prev-page-btn-1').css('display', 'none');
    }
}

function showVideo(videoFile) {

    vplayer.src({type: 'video/mp4', src: videoFile});
    resizeWindow();

}

function play_pause() {
    if (video_isplaying) {
        video_isplaying = false;
        vplayer.pause();
    } else {
        video_isplaying = true;
        vplayer.play();
    }
}

$(window).resize(function () {
    resizeWindow();

})

function resizeWindow(rate) {
    var sceneH = window.innerHeight;
    var sceneW = window.innerWidth;

    if (rate == undefined) rate = sceneH / sceneW;

    var width = sceneW;
    var height = sceneW * rate;
    var top = (sceneH - height) / 2;
    var left = 0;
    if (sceneH < sceneW * rate) {
        width = sceneH / rate;
        height = sceneH;
        top = 0;
        left = (sceneW - width) / 2;
    }
    $('body').css({
        width: width,
        height: height,
        top: top,
        left: left,
        background: 'transparent'
    });
    $('video').css({
        width: width,
        height: height,
        top: top,
        left: left
    });
    $('.sf-video-wrapper .video-js .custom-video-contain').css({
        width: width,
        height: height,
        top: 0,
        left: 0
    })
    $('.sf-video-wrapper .video-js').css({
        width: width,
        height: height,
        top: 0,
        left: 0
    })

}