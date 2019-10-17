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
            <li class="nav-item mainmenu" data-id="0">
                <a class="nav-link menu-title">
                    <i class="icon-home"></i>
                    <span class="title">上传介绍视频</span>
                </a>
            </li>
            <li class="nav-item submenu" data-id="0">
                <a href="<?= base_url('admin/banner') ?>" class="nav-link" menu_id="00">
                    <i class="icon-picture"></i>
                    <span class="title">上传介绍视频</span>
                </a>
            </li>
            <li class="nav-item mainmenu" data-id="1">
                <a class="nav-link menu-title">
                    <i class="icon-home"></i>
                    <span class="title">激活码管理</span>
                </a>
            </li>
            <li class="nav-item submenu" data-id="1">
                <a href="<?= base_url('admin/activation') ?>" class="nav-link" menu_id="10">
                    <i class="icon-picture"></i>
                    <span class="title">激活码管理</span>
                </a>
            </li>
            <li class="nav-item mainmenu" data-id="2">
                <a class="nav-link menu-title">
                    <i class="icon-home"></i>
                    <span class="title">分类管理</span>
                </a>
            </li>
            <li class="nav-item submenu" data-id="2">
                <a href="<?= base_url('admin/sites') ?>" class="nav-link" menu_id="20">
                    <i class="icon-picture"></i>
                    <span class="title">课程管理</span>
                </a>
            </li>
            <li class="nav-item submenu" data-id="2">
                <a href="<?= base_url('admin/packages') ?>" class="nav-link" menu_id="21">
                    <i class="icon-picture"></i>
                    <span class="title">课次管理</span>
                </a>
            </li>
            <!----------New course manage-------------------->
            <li class="nav-item mainmenu" data-id="3">
                <a class="nav-link menu-title">
                    <i class="icon-docs"></i>
                    <span class="title"><?php echo $this->lang->line('panel_title_30'); ?></span>
                </a>
            </li>
            <li class="nav-item submenu" data-id="3">
                <a href="<?= base_url('admin/courses') ?>" class="nav-link " menu_id="30">
                    <i class="icon-layers"></i>
                    <span class="title"><?php echo $this->lang->line('panel_title_34'); ?></span>
                </a>
            </li>
            </li>
            <li class="nav-item submenu" data-id="3">
                <a href="<?= base_url('admin/lessons') ?>" class="nav-link " menu_id="31">
                    <i class="icon-layers"></i>
                    <span class="title">课件管理</span>
                </a>
            </li>
            </li>
            <li class="nav-item  submenu" data-id="3">
                <a href="<?= base_url('admin/reference') ?>" class="nav-link " menu_id="32">
                    <i class="icon-layers"></i>
                    <span class="title">参考资料管理</span>
                </a>
            </li>
            <li class="nav-item  submenu" data-id="3">
                <a href="<?= base_url('admin/questions') ?>" class="nav-link " menu_id="33">
                    <i class="icon-layers"></i>
                    <span class="title"><?php echo $this->lang->line('panel_title_35'); ?></span>
                </a>
            </li>
            <li class="nav-item mainmenu" data-id="5">
                <a class="nav-link menu-title">
                    <i class="icon-docs"></i>
                    <span class="title"><?php echo $this->lang->line('panel_title_20'); ?></span>
                </a>
            </li>
            <li class="nav-item submenu" data-id="5">
                <a href="<?= base_url('admin/usermanage/index') ?>" class="nav-link " menu_id="50">
                    <i class="icon-briefcase"></i>
                    <span class="title">教师<?php echo $this->lang->line('panel_title_21'); ?></span>
                </a>
            </li>
            <li class="nav-item submenu" data-id="5">
                <a href="<?= base_url('admin/usermanage/student') ?>" class="nav-link " menu_id="51">
                    <i class="icon-briefcase"></i>
                    <span class="title">学生<?php echo $this->lang->line('panel_title_21'); ?></span>
                </a>
            </li>
            <li class="nav-item mainmenu" data-id="6">
                <a class="nav-link menu-title">
                    <i class="icon-docs"></i>
                    <span class="title">统计管理</span>
                </a>
            </li>
            <li class="nav-item submenu" data-id="6">
                <a href="<?= base_url('admin/usermanage/register_status') ?>" class="nav-link" menu_id="60">
                    <i class="icon-folder-alt"></i>
                    <span class="title"><?php echo $this->lang->line('panel_title_22'); ?></span>
                </a>
            </li>
            <li class="nav-item submenu" data-id="6">
                <a href="<?= base_url('admin/usermanage/paid_status') ?>" class="nav-link" menu_id="61">
                    <i class="icon-folder-alt"></i>
                    <span class="title">用户购买统计</span>
                </a>
            </li>
            <li class="nav-item submenu" data-id="6">
                <a href="<?= base_url('admin/usermanage/coming_soon') ?>" class="nav-link " menu_id="62">
                    <i class="icon-notebook"></i>
                    <span class="title">更多统计</span>
                </a>
            </li>
            <!----------Community Manage------------------->
            <li class="nav-item  mainmenu" data-id="4">
                <a href="javascript:;" class="nav-link menu-title">
                    <i class="icon-user"></i>
                    <span class="title"><?php echo $this->lang->line('panel_title_50'); ?></span>
                </a>
            </li>
            <li class="nav-item  submenu" data-id="4">
                <a href="<?= base_url('admin/admins/index') ?>" class="nav-link " menu_id="40">
                    <i class="icon-notebook"></i>
                    <span class="title"><?php echo $this->lang->line('panel_title_51'); ?></span>
                </a>
            </li>
            <li class="nav-item  submenu" style="display: none">
                <a href="<?= base_url('admin') ?>" class="nav-link " menu_id="40">
                    <i class="icon-notebook"></i>
                    <span class="title"><?php echo $this->lang->line('panel_title_52'); ?></span>
                </a>
            </li>
        </ul>

        <script>
            $('.nav-item.submenu').hide();
            $('.nav-item.mainmenu').on('click', function () {
                var that = $(this);
                var id = that.attr('data-id');
                $('.nav-item.submenu').slideUp(200);
                // $('.nav-item.mainmenu a').attr('style', 'background-color: #009965!important');
                $('.nav-item.submenu[data-id="' + id + '"]').slideDown(200);
                // $('.nav-item.mainmenu[data-id="' + id + '"] a').attr('style', 'background-color: #10652b!important');
            });
            $(function () {
                setTimeout(function () {
                    var id = $('.nav-link.menu-selected').parent().attr('data-id');
                    $('.nav-item[data-id="' + id + '"]').show();
                    $('.nav-item.mainmenu[data-id="' + id + '"] a').attr('style', 'background-color: #10652b!important');
                }, 1)
            });
        </script>
        <!-- END SIDEBAR MENU -->
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>
<!-- END SIDEBAR -->


