
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/frontend/learning.css') ?>">
<script>
    var imageDir = baseURL + "assets/images/resource/";
</script>
<div class="bg" id="main-background-full"></div>
<div class="learning_list_container">
    <div class="list_item"></div>
</div>
<script>
    var learningList = JSON.parse('<?php echo json_encode($learningList);?>');
    var selectedIndex = <?php echo $selectedIndex?>
</script>
<script src="<?= base_url('assets/js/learning.js') ?>" type="text/javascript"></script>