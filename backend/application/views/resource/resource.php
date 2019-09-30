
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/frontend/resource.css') ?>">
<script>
    var imageDir = baseURL + "assets/images/resource/";
</script>
<div class="bg" id="main-background-full"></div>
<div class="resource_list_container">
    <div class="list_item"></div>
</div>
<script>
    var courseList = JSON.parse('<?php echo json_encode($courseList);?>');
    var selectedIndex = <?php echo $selectedIndex?>
</script>
<script src="<?= base_url('assets/js/resource.js') ?>" type="text/javascript"></script>