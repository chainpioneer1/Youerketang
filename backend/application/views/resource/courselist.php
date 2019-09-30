<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/frontend/courselist.css') ?>">
<div class="bg" id="main-background-full"></div>
<div class="frame">
    <div class="frame_title"><?= $lessonItem->lesson_name ?></div>
    <a class="frame_download"></a>
    <div class="course_container" id="print_dom">
        <!--<embed class="pdf_embed" width="100%" height="100%" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html">-->
        <div class="course_list_container" item_id="1" style="background: url('<?=base_url('uploads/education/pdftoimage/1/1-1.jpg')?>');">
            <div class="list_item" item_id="1" style="top:10%;"></div>
            <div class="list_item" item_id="2" style="top:30%;"></div>
            <div class="list_item" item_id="3" style="top:50%;"></div>
            <div class="list_item" item_id="4" style="top:70%;"></div>
        </div>
    </div>

</div>
<script>
    var lessonItem = JSON.parse('<?php echo json_encode($lessonItem);?>');
    var selectedIndex = <?php echo $selectedIndex;?>;

</script>

<script src="<?= base_url('assets/js/courselist.js') ?>" type="text/javascript"></script>