

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/frontend/videoplayer.css') ?>">
<script type="text/javascript" src="<?=base_url()?>/assets/js/toolset/video_player/assets/plugin/videojs/video.js"></script>
<script>
    var isVideo = true;
</script>
<div class="bg" id="main-background-full"></div>
<div class="title"></div>
<style>.video-js video{ object-fit: fill }</style>
<div class="videoContent">
    <iframe src="<?=base_url('assets/js/toolset/video_player/vplayer.php?ncw_file='.base_url($class_id))?>"
            style="position:absolute;top:0;left:0;width: 100%;height:100%;"></iframe>
<!--    <video id="videoPlayer" class="video-js vjs-default-skin vjs-big-play-centered" loop>
        <source src="<?/*=base_url($class_id)*/?>">
        <p class="vjs-no-js"></p>
    </video>
-->
</div>
<div class="frame"></div>
<div class="tree"></div>
<script src="<?= base_url('assets/js/videoplayer.js') ?>" type="text/javascript"></script>
<script>
    var titleId = "<?=$title_id?>"
    $(function () {
        setTimeout(function () {
            if(history.length==1){
                $('.top-bar').hide();
            }
        },100);
    })
</script>
