
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/student/pinyin.css') ?>">

<script>
    var imageDir = baseURL + "assets/images/classroom/";
</script>

<div class="bg"></div>
<div class="classroom_list_container">
    <div class="list_item"></div>
</div>
<a href="<?= base_url('student/work/index/'.$site_id) ?>" class="work-btn"></a>

<script>
    var packageList = JSON.parse('<?php echo json_encode($packageList);?>');
    var loginUserType = '<?= $this->session->userdata('user_type')?>';
    var loginUserId = '<?= $this->session->userdata('loginuserID')?>';
    var site_id = '<?= $site_id ?>';
</script>

<script src="<?= base_url('assets/js/pinyin.js') ?>" type="text/javascript"></script>
