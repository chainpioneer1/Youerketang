
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/frontend/classroom.css') ?>">

<script>
    var imageDir = baseURL + "assets/images/classroom/";
</script>

<div class="bg" id="main-background-full"></div>
<div class="btn-bar">
    <a class="sel-btn" itemid="1" href = "<?= base_url('classroom').'/index/'.$site_id ?>" style="border-bottom: 2px solid black;">课堂教学</a>
    <a class="sel-btn" itemid="2" href = "<?= base_url('resource/lessonware').'/'.$site_id ?>">我的备课</a>
    <a class="sel-btn" itemid="3" href = "<?= base_url('resource/education').'/'.$site_id ?>">参老资料</a>
    <a class="sel-btn" itemid="4" href = "<?= base_url('teacher_work').'/index/'.$site_id ?>">学生作业</a>
</div>
<div class="classroom_list_container">
    <div class="list_item"></div>
</div>

<!--<div id="custom-scroll" container_class="classroom_list_container">-->
<!--    <div class="scroll-read"></div>-->
<!--    <div class="scroll-thumb"></div>-->
<!--    <div class="scroll-up-btn"></div>-->
<!--    <div class="scroll-down-btn"></div>-->
<!--</div>-->

<script>
    var packageList = JSON.parse('<?= json_encode($packageList); ?>');
    var loginUserType = '<?= $this->session->userdata('user_type')?>';
    var loginUserId = '<?= $this->session->userdata('loginuserID')?>';
    var site_id = '<?= $site_id ?>';
</script>

<script src="<?= base_url('assets/js/classroom.js') ?>" type="text/javascript"></script>
