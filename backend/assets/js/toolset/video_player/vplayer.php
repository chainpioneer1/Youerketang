<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
<!--    <meta name="viewport"-->
<!--          content="width=device-width,initial-scale=1,minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>-->
<!--    <meta name="apple-touch-fullscreen" content="yes">-->
<!--    <meta name="apple-mobile-web-app-capable" content="yes">-->
<!--    <meta name="apple-mobile-web-app-status-bar-style" content="black">-->
    <meta name="format-detection" content="telephone=no">
    <title>视频</title>

    <script type="text/javascript" src="assets/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.js"></script>
    <script type="text/javascript" src="assets/plugin/videojs/video.js"></script>

    <script type="text/javascript" src="assets/js/my-lib.js"></script>

    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/plugin/videojs/video-js.css">
    <link rel="stylesheet" href="assets/css/style.css">

</head>

<?php
    if(isset($_GET['status']))
        $status='stop';
    else
        $status='';
?>
<body>

<!--------------Starting Video------------->
<!--<div class="start-video-page">-->
<!--<img src="assets/images/start.gif">-->
<!--</div>-->
<!--------------Starting Video------------->

<div class="loading-img-wrapper">
    <img id="loading-gif-file" src="assets/images/loading.gif">
</div>

<div class="sf-video-wrapper">
    <video id="video-player" class="video-js vjs-big-play-centered" preload="auto">
        <source src="<?= $_GET['ncw_file']; ?>" type="video/mp4">
        <p class="vjs-no-js"></p>
    </video>
</div>
<a href="#" onclick="play_pause();"></a>
<script>
    var start_play_status = '<?=$status?>';
</script>
<script type="text/javascript" src="assets/js/jqueryMobile.js"></script>
<script type="text/javascript" src="assets/js/scene_control.js"></script>

</body>
</html>