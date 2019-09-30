<?php
$admin_id = $this->session->userdata("admin_loginuserID");
$admin = '';
if( !empty( $admin_id ) ){
    $admin = $this->admins_m->get_single_admin( $admin_id );
}
?>
<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="<?=base_url('/admin')?>">
                <img src="<?= base_url('assets/images/backend-logo.png') ?>" alt="logo" class="logo-default"> </a>
            <div class="menu-toggler sidebar-toggler">
                <span></span>
            </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
            <span></span>
        </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <div class="page-title-string"><?php echo $this->lang->line('backend_top_title'); ?></div>
        <!-- BEGIN TOP NAVIGATION MENU -->
        <div class="top-menu">
            <?php if( !empty( $admin_id ) ) : ?>
            <ul class="nav navbar-nav pull-right">
                <!-- BEGIN USER LOGIN DROPDOWN -->
                <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                <li class="dropdown dropdown-user">
                    <a href="javascript:;"
                       onclick="window.location.href='<?=base_url('admin/admins/index')?>';"
                       class="dropdown-toggle" data-toggle="dropdown"
                       data-hover="dropdown" data-close-others="true">
                        <img alt="" class="img-circle" src="<?= base_url('assets/images/user-profile.png') ?>">
                        <span class="username username-hide-on-mobile"> <?php echo $admin->admin_label ?> </span>
<!--                        <i class="fa fa-angle-down"></i>-->
                    </a>
<!--                    <ul class="dropdown-menu dropdown-menu-default">-->
<!--                        <li>-->
<!--                            <a href="--><?//= base_url('users/view/' . $admin_id) ?><!--">-->
<!--                                <i class="icon-user"></i> My Profile </a>-->
<!--                        </li>-->
<!--                        <li class="divider"> </li>-->
<!---->
<!--                    </ul>-->
                </li>
                <li class="dropdown dropdown-user">
                    <a href="#" style="color: black" onclick="change_user_passwd();">
                        <i class="icon-key"></i>更改密码</a>
                </li>
                <li class="dropdown dropdown-user">
                    <a href="<?= base_url('admin/signin/signout') ?>" style="color: black">
                        <i class="icon-logout"></i>  退出系统</a>
                </li>
                <!-- END USER LOGIN DROPDOWN -->
                <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
<!--                <li class="dropdown dropdown-quick-sidebar-toggler">-->
<!--                    <a href="javascript:;" class="dropdown-toggle">-->
<!--                        <i class="icon-logout"></i>-->
<!--                    </a>-->
<!--                </li>-->
                <!-- END QUICK SIDEBAR TOGGLER -->
            </ul>
            <?php endif; ?>
        </div>
        <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END HEADER INNER -->
</div>
<!-- END HEADER -->

<div id="edit_current_passwd_modal" class="modal fade" tabindex="-1" data-width="400">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $this->lang->line('update_account'); ?></h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" enctype="multipart/form-data" action="" id="edit_current_passwd_submit_form" role="form"
              method="post" accept-charset="utf-8">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-4 control-label"
                           style="text-align:center;"><?php echo $this->lang->line('account'); ?>:</label>
                    <label class="col-md-7 control-label" id="edit_current_passwd_fullname"
                           style="text-align:left;font-weight:bold;"><?php echo $this->lang->line('account'); ?></label>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label"
                           style="text-align:center;"><?php echo $this->lang->line('username'); ?>:</label>
                    <div class="col-md-7" style="pediting-left: 0">
                        <input type="text" class="form-control" name="edit_admin_label" id="edit_current_passwd_label" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label"
                           style="text-align:center;"><?php echo $this->lang->line('password'); ?>:</label>
                    <div class="col-md-7" style="pediting-left: 0">
                        <input type="password" class="form-control" name="edit_admin_password" id="edit_current_passwd_password"
                               value="" onkeyup="confirmEditPassword();">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label"
                           style="text-align:center;"><?php echo $this->lang->line('repeat_password'); ?>:</label>
                    <div class="col-md-7" style="pediting-left: 0">
                        <input type="password" class="form-control" name="item_repeat_password"
                               id="edit_current_passwd_repeatpassword" value="" onkeyup="confirmEditPassword();">
                    </div>
                </div>
            </div>
            <div class="modal-footer form-actions">
                <button type="submit" class="btn green"
                        id="edit_current_passwd_saveBtn"><?php echo $this->lang->line('save'); ?></button>
                <button type="button" class="btn green"
                        onclick="$('#edit_current_passwd_modal').modal('toggle');">
                    <?php echo $this->lang->line('cancel'); ?></button>
            </div>
        </form>
    </div>
</div>
<script>

    function change_user_passwd(self) {

        var admin_id = "<?=$admin->admin_id?>";
        var username = '<?=$admin->admin_name?>';
        var admin_label='<?=$admin->admin_label?>';
        $("#edit_current_passwd_saveBtn").attr("admin_id", admin_id);
        $('#edit_current_passwd_fullname').text(username);
        $('#edit_current_passwd_password').val('1');///old pass

        $('#edit_current_passwd_repeatpassword').val('1');///confirm pass

        $('#edit_current_passwd_label').val(admin_label);

        $('#edit_current_passwd_modal').modal({
            backdrop: 'static',
            keyboard: false
        });
    }

    $("#edit_current_passwd_submit_form").submit(function (e) {

        e.preventDefault();
        var admin_id = $("#edit_current_passwd_saveBtn").attr('admin_id');
        var fdata = new FormData(this);
        fdata.append("admin_id", admin_id);
        jQuery.ajax({
            url: baseURL + "admin/admins/edit",
            type: "post",
            data: fdata,
            processData: false,
            contentType: false,
            cache: false,
            async: false,
            success: function (res) {
                var ret = JSON.parse(res);
                if (ret.status == 'success') {
                    location.href = "<?= base_url('admin/signin/index') ?>";
//                var table = document.getElementById("main_tbl");
//                var tbody = table.getElementsByTagName("tbody")[0];
//                tbody.innerHTML = ret.data;
//                executionPageNation();

                }
                else//failed
                {
                    alert("Cannot modify Unit Data.");
                }
            }
        });
        jQuery('#edit_current_passwd_modal').modal('toggle');
    });
</script>