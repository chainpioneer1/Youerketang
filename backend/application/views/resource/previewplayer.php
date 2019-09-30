<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/frontend/preview.css') ?>">
<div class="bg"></div>
<div class="frame"></div>
<div class="title"><?= $title ?></div>
<div class="preview_list_container">
</div>
<div class="prev_btn" onclick="prevCourseList(this)"></div>
<div class="next_btn" onclick="nextCourseList(this)"></div>
<div class="pdf_container">
<!--<embed class="pdf_content" src="http://localhost/kuaile/uploads/course_work/eee.pdf" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html" style="width: 100%;height:100%;"/>-->
</div>
<iframe class="course_content_area" style="display: none;" frameborder="0" border="0" scrolling="no"  allowfullscreen="true"
        webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>
<script>
    var courseList = JSON.parse('<?php echo json_encode($courseList);?>');
    var pretitle = "<?= $title?>";
    var title = sessionStorage.getItem("__id");
    $(function () {
        if (pretitle == "_") $('.title').html(title);
        setTimeout(function () {
            if (history.length == 1) {
                $('.top-bar').hide();
            }
        }, 100);
    })
</script>
<script src="<?= base_url('assets/js/preview.js') ?>" type="text/javascript"></script>

