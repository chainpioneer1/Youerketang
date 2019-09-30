<link rel="stylesheet" type="text/css"
      href="<?= base_url('assets/css/frontend/teacher_work/teacher_work_report.css') ?>">


<div class="bg"></div>
<div class="student-wrong-container">
    <div class="student-wrong-title">错误学生名单</div>
    <?=$student_list?>
</div>

<script>
    $(function () {
        $('.bg').css({background: 'url(' + baseURL + '/assets/images/teacher_work/report/bg1.png)'});
    });
</script>
