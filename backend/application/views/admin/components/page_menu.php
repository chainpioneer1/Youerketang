<?php
//$usertype = $this->session->userdata("user_type");
?>
<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu  page-header-fixed" data-keep-expanded="true" data-auto-scroll="true"
            data-slide-speed="200" style="padding-top: 20px">
            <li class="sidebar-toggler-wrapper hide">
                <div class="sidebar-toggler">
                    <span></span>
                </div>
            </li>
            <!----------Course Manage Side Menu------------>
            <li class="nav-item">
                <a class="nav-link menu-title">
                    <i class="icon-home"></i>
                    <span class="title">上传介绍视频</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('admin/banner') ?>" class="nav-link" menu_id="00">
                    <i class="icon-picture"></i>
                    <span class="title">上传介绍视频</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link menu-title">
                    <i class="icon-home"></i>
                    <span class="title">激活码管理</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('admin/activation') ?>" class="nav-link" menu_id="10">
                    <i class="icon-picture"></i>
                    <span class="title">激活码管理</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link menu-title">
                    <i class="icon-home"></i>
                    <span class="title">分类管理</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('admin/sites') ?>" class="nav-link" menu_id="20">
                    <i class="icon-picture"></i>
                    <span class="title">课程管理</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('admin/packages') ?>" class="nav-link" menu_id="21">
                    <i class="icon-picture"></i>
                    <span class="title">课次管理</span>
                </a>
            </li>
            <!----------New course manage-------------------->
            <li class="nav-item">
                <a class="nav-link menu-title" id="newcourse_menu">
                    <i class="icon-docs"></i>
                    <span class="title"><?php echo $this->lang->line('panel_title_30'); ?></span>
                </a>
            </li>
            <li class="nav-item  ">
                <a href="<?= base_url('admin/courses') ?>" class="nav-link " menu_id="30">
                    <i class="icon-layers"></i>
                    <span class="title"><?php echo $this->lang->line('panel_title_34'); ?></span>
                </a>
            </li>
            </li>
            <li class="nav-item  ">
                <a href="<?= base_url('admin/courses/index/1') ?>" class="nav-link " menu_id="31">
                    <i class="icon-layers"></i>
                    <span class="title">课件管理</span>
                </a>
            </li>
            </li>
            <li class="nav-item  ">
                <a href="<?= base_url('admin/reference') ?>" class="nav-link " menu_id="32">
                    <i class="icon-layers"></i>
                    <span class="title">参考资料管理</span>
                </a>
            </li>
            <li class="nav-item  ">
                <a href="<?= base_url('admin/questions') ?>" class="nav-link " menu_id="33">
                    <i class="icon-layers"></i>
                    <span class="title"><?php echo $this->lang->line('panel_title_35'); ?></span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link menu-title" id="course_menu">
                    <i class="icon-docs"></i>
                    <span class="title"><?php echo $this->lang->line('panel_title_20'); ?></span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('admin/usermanage/index') ?>" class="nav-link " menu_id="40">
                    <i class="icon-briefcase"></i>
                    <span class="title">教师<?php echo $this->lang->line('panel_title_21'); ?></span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('admin/usermanage/index') ?>" class="nav-link " menu_id="41">
                    <i class="icon-briefcase"></i>
                    <span class="title">学生<?php echo $this->lang->line('panel_title_21'); ?></span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link menu-title" id="course_menu">
                    <i class="icon-docs"></i>
                    <span class="title">统计管理</span>
                </a>
            </li>
            <li class="nav-item ">
                <a href="<?= base_url('admin/usermanage/register_status') ?>" class="nav-link" menu_id="50">
                    <i class="icon-folder-alt"></i>
                    <span class="title"><?php echo $this->lang->line('panel_title_22'); ?></span>
                </a>
            </li>
            <li class="nav-item ">
                <a href="<?= base_url('admin/usermanage/register_status') ?>" class="nav-link" menu_id="51">
                    <i class="icon-folder-alt"></i>
                    <span class="title">用户购买统计</span>
                </a>
            </li>
            <li class="nav-item  ">
                <a href="<?= base_url('admin/admins/login_history') ?>" class="nav-link " menu_id="52">
                    <i class="icon-notebook"></i>
                    <span class="title">更多统计</span>
                </a>
            </li>
            <!--<li class="nav-item  ">
                <a href="<?= base_url('admin/usermanage/course_status') ?>" class="nav-link" menu_id="23">
                    <i class="icon-layers"></i>
                    <span class="title"><?php echo $this->lang->line('panel_title_23'); ?></span>
                </a>
            </li>-->
            <!----------Account Manage Menu---------------->
            <!--<li class="nav-item  ">
                <a href="javascript:;" class="nav-link menu-title">
                    <i class="icon-user"></i>
                    <span class="title"><?php echo $this->lang->line('panel_title_40'); ?></span>
                </a>
            </li>
            <li class="nav-item  ">
                <a href="<?= base_url('admin/educourse/school/2') ?>" class="nav-link " menu_id="41">
                    <i class="fa fa-university"></i>
                    <span class="title"><?php echo $this->lang->line('panel_title_41'); ?></span>
                </a>
            </li>
            <li class="nav-item  ">
                <a href="<?= base_url('admin/educourse/course') ?>" class="nav-link " menu_id="42">
                    <i class="icon-users"></i>
                    <span class="title"><?php echo $this->lang->line('panel_title_42'); ?></span>
                </a>
            </li>
            <li class="nav-item  ">
                <a href="<?= base_url('admin/educourse/category') ?>" class="nav-link " menu_id="43">
                    <i class="icon-user"></i>
                    <span class="title"><?php echo $this->lang->line('panel_title_43'); ?></span>
                </a>
            </li>-->
            <!----------Community Manage------------------->
            <li class="nav-item  ">
                <a href="javascript:;" class="nav-link menu-title">
                    <i class="icon-user"></i>
                    <span class="title"><?php echo $this->lang->line('panel_title_50'); ?></span>
                </a>
            </li>
            <li class="nav-item  ">
                <a href="<?= base_url('admin/admins/index') ?>" class="nav-link " menu_id="60">
                    <i class="icon-notebook"></i>
                    <span class="title"><?php echo $this->lang->line('panel_title_51'); ?></span>
                </a>
            </li>
            <li class="nav-item  " style="display: none">
                <a href="<?= base_url('admin') ?>" class="nav-link " menu_id="60">
                    <i class="icon-notebook"></i>
                    <span class="title"><?php echo $this->lang->line('panel_title_52'); ?></span>
                </a>
            </li>
        </ul>
        <!-- END SIDEBAR MENU -->
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>
<!-- END SIDEBAR -->


