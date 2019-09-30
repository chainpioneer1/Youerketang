<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/frontend/videoplayer.css') ?>">
<script>
    var isVideo = false;
</script>
<div class="bg" id="main-background-full"></div>
<div class="title"></div>
<style>.video-js video {
        object-fit: fill
    }</style>
<div class="videoContent">
    <a href="<?= base_url($class_id) ?>" id="doc"></a>
</div>
<div class="frame"></div>
<div class="tree"></div>
<script src="<?= base_url('assets/js/videoplayer.js') ?>" type="text/javascript"></script>
<script>
    var titleId = "<?=$title_id?>";
    var path = "<?=$class_id?>";
    var ext = path.split('.');
    $('#doc')[0].download = "document." + ext[ext.length - 1];
    $('#doc')[0].click();
    $(function () {
        setTimeout(function () {
            if (history.length == 1) {
                $('.top-bar').hide();
            }
        }, 100);
        setTimeout(function () {
            history.back();
        }, 100)
    })
</script>
