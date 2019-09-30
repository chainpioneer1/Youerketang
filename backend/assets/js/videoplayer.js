$('.bg').css({background: 'url(' + baseURL + '/assets/images/resource/learning/bg1.png) no-repeat'});
$('.frame').css({background: 'url(' + baseURL + '/assets/images/resource/learning/frame1.png) no-repeat'});
$('.tree').css({background: 'url(' + baseURL + '/assets/images/resource/learning/tree.png) no-repeat'});

var vplayer;
$(function () {
    if (isVideo == true) {
        // vplayer = videojs('videoPlayer', {
        //     controls: true,
        //     width: 1280,
        //     height: 720,
        //     preload: 'auto',
        //     autoplay: true,
        //     loop: false,
        // }, function () {
        //     vplayer.on('play', function () {
        //
        //     });
        //     vplayer.on("pause", function () {
        //
        //     });
        // });
        // $('.vjs-control').css({height: '3em'});
        // $('.vjs-control-bar').css({height: '3em', bottom: 10});

        $('.title').html(titleId);
        // $('.title').css({background: 'url(' + baseURL + '/assets/images/resource/learning/alphabet/' + (titleId + 1) + '.png) no-repeat'});
    } else {
        $('.title').css({
            width: '30%',
            'text-align': 'center',
            transform: 'translateX(-45%)',
            color: 'white',
            'font-size': 'calc(2.5vw)'
        });
        $('.title').html(titleId);
    }
});