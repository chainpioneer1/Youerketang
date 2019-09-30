<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/frontend/mylesson.css') ?>">


<input id="all_lessons" value='<?= json_encode($lessons)?>' style="display: none;">
<input id="all_coursewares" value='<?= json_encode($coursewares)?>' style="display: none;">
<script>

    setSessionLessons(JSON.parse($('#all_lessons').val()));
    setSessionCoursewares(JSON.parse($('#all_coursewares').val()));

</script>
<div id="mylesson-content">
    <div class="mylesson-title">
        <div class="title-add"></div>
        <div class="title-panel">
            <div class="title-item" item_id="1">
                <input class="title-edit" disabled value="春之声"/>
                <a class="btn-update" item_id="1"></a>
                <a class="btn-delete" item_id="1"></a>
            </div>
        </div>
        <div class="title-bottom">
            <a class="arrow-up" item_id="1"></a>
            <a class="arrow-down" item_id="2"></a>
        </div>
    </div>
    <div class="edit-area">
        <div class="mylesson-media">
            <div class="media-item" item_type="1">
                <div class="media-title"></div>
                <div class="media-submenu">
                    <a class="btn-prev"></a>
                    <a class="btn-next"></a>
                    <a class="btn-delete"></a>
                </div>
            </div>
        </div>
        <div class="media-edit"></div>
        <div class="media-add"></div>
        <div class="media-done"></div>
    </div>
</div>
<script>
    $(function () {
        $('.bg').css({'background': 'url(' + imageDir + 'mylesson/bg.png) no-repeat'});
    });
</script>
<script src="<?= base_url('assets/js/mylesson.js') ?>"></script>
