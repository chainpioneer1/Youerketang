<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <title><?= $this->lang->line('frontend_title')?></title>
    <link rel="shortcut icon" href="<?= base_url('assets/images/logo.png') ?>" type="image/x-icon"/>

    <script type="text/javascript" src="/assets/js/toolset/video_player/assets/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="/assets/js/toolset/video_player/assets/js/bootstrap.js"></script>
    <script type="text/javascript" src="/assets/js/toolset/video_player/assets/plugin/videojs/video.js"></script>

    <script type="text/javascript" src="/assets/js/toolset/video_player/assets/js/my-lib.js"></script>

    <link rel="stylesheet" href="/assets/js/toolset/video_player/assets/css/bootstrap.css">
    <link rel="stylesheet" href="/assets/js/toolset/video_player/assets/plugin/videojs/video-js.css">
    <link rel="stylesheet" href="/assets/js/toolset/video_player/assets/css/style.css">

</head>

<?php
if (isset($_GET['status']))
    $status = 'stop';
else
    $status = '';
?>
<body>

<!--------------Starting Video------------->
<!--<div class="start-video-page">-->
<!--<img src="assets/images/start.gif">-->
<!--</div>-->
<!--------------Starting Video------------->

<div class="loading-img-wrapper">
    <img id="loading-gif-file" src="/assets/js/toolset/video_player/assets/images/loading.gif">
</div>
<style>
    video::-webkit-media-controls {
        display: none;
    }
    video::-webkit-media-controls-start-playback-button {
        display: none;
    }
    video {
        pointer-events: none;
    }
    #playpause{
        height:calc(100vh);
    }
</style>
<div class="sf-video-wrapper">
    <video id="video-player" class="video-js vjs-big-play-centered" preload="auto" autoplay>
        <source src="<?= base_url('uploads/preload.mp4'); ?>" type="video/mp4">
        <p class="vjs-no-js"></p>
    </video>
</div>
<a id="playpause" href="#" onclick=""></a>
<div class="timecount-txt">动画播完时间还剩 &nbsp;<span class="timecount-digit"></span>秒</div>
<div class="btn-skip"></div>
<script>
    var base_url = "<?= base_url() ?>";
    var baseURL = "<?= base_url() ?>";
    var start_play_status = '<?=$status?>';
</script>
<script type="text/javascript" src="/assets/js/toolset/video_player/assets/js/jqueryMobile.js"></script>
<script type="text/javascript" src="/assets/js/toolset/video_player/assets/js/scene_control_preload.js"></script>
<script>
    function goToMain() {
        clearInterval(tmrID);
        video_isplaying = true;
        play_pause();
        location.href = baseURL + 'student/signin';
    }
</script>
</body>
</html>