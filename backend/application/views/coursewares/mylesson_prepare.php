<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/frontend/mylesson_prepare.css') ?>">


<div id="courseview-content">
    <div class="courseview-nav">
        <?php
        for ($i = 0; $i < 4; $i++) {
            echo '<div class="mainnav-item"></div>';
        }
        ?>
    </div>

    <div class="mylesson-staticmedia" item_id="1" style="opacity:1;z-index: 1;">
        <div class="media-item" item_type="1">
            <div class="item-checked"></div>
            <div class="media-submenu">
                <a class="btn-view"></a>
                <a class="btn-select"></a>
            </div>
        </div>
    </div>

    <div class="mylesson-tmpmedia" item_id="1" style="opacity: 1;z-index: 1;">
        <div class="media-item" item_type="2">
            <div class="media-submenu">
                <a class="btn-delete"></a>
            </div>
        </div>
    </div>

    <form class="form-horizontal" enctype="multipart/form-data"
          action="" id="upload_ncw_submit_form" role="form" style="display: none"
          method="post" accept-charset="utf-8">
        <input type="file" id="upload_ncw_courseware"
               class="form-control"
               name="add_file_name" accept=".zip,.mp4,.bmp,.png,.jpg,.gif,.pdf,.doc,.docx">
        <input id="upload_ncw_name" name="upload_ncw_name">
        <input id="upload_lesson_id" name="upload_lesson_id">
        <input id="upload_ncw_type" name="upload_ncw_type">
        <input id="upload_userId" name="upload_userId">
        <input id="upload_lessonItem" name="upload_lessonItem">
    </form>
    <a class="media-upload"></a>

    <input id="courseId" value="" style="display: none;">
</div>
<a href="#" class="media-ok" onclick="mylesson_prepare_done();"></a>
<a href="#" class="media-cancel" onclick="mylesson_prepare_cancel();"></a>

<div class="uploading_backdrop"></div>
<div class="progressing_area" style="display: none">
    <img id="wait_ajax_loader" src='<?php echo base_url('assets/images/frontend/ajax-loader-1.gif'); ?>'/>
    <span style="position: absolute;top: 43%;left: 43%;font-size:18px;color: #fff;z-index: 16000"><?= $this->lang->line('uploading') ?></span>
    <span id="progress_percent">0%</span>
</div>

<script>
    $('.bg').css({background: 'url(' + imageDir + 'mylesson_prepare/bg.png) no-repeat'});
</script>
<script src="<?= base_url('assets/js/mylesson.js') ?>"></script>
