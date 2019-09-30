<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/frontend/videoplayer.css') ?>">
<script>
    var isVideo = false;
</script>
<script src="<?= base_url('assets/js/frontend/pdfobject.js') ?>"></script>
<div class="bg" id="main-background-full"></div>
<div class="title"></div>
<style>
    .video-js video{ object-fit: fill }
    #pdf_container{left:0;top:0;width:100%;height:100%;}
</style>
<div class="videoContent">
    <div class="pdf_container" id="pdf_container"></div>
</div>
<div class="frame"></div>
<div class="tree"></div>
<script>
    var titleId = "<?=$title_id?>";
    $(function () {
        setTimeout(function () {
            if(history.length==1){
                $('.top-bar').hide();
            }
        },100);
        PDFObject.embed("<?=base_url($class_id)?>", "#pdf_container");
    })
</script>
<script src="<?= base_url('assets/js/videoplayer.js') ?>" type="text/javascript"></script>