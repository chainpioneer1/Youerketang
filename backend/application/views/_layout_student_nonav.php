<?php

$this->load->view("components/page_header_student");

$userType = $this->session->userdata('user_type');
$returnPrefix = '';
if($userType == '2')
    $returnPrefix = 'student/';

?>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/student/custom.css') ?>">
<script>
    var imageDir = baseURL + "";
    var loginUserType = '<?=$userType?>';
</script>


<?php $this->load->view($subview); ?>

<div class="top-bar">
    <a onclick="goPreviousPage(-1)" class="top-back"></a>
</div>
<?php $this->load->view("components/page_footer"); ?>