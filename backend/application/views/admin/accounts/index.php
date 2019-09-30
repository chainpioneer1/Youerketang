<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content" style="min-height: 1305px;">

        <h1 class="page-title"> View Users
            <small></small>
        </h1>

        <?php $success = $this->session->flashdata("success");?>
        <?php if( !empty( $success ) ) : ?>
            <div class="custom-alerts alert alert-success fade in">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <?= $success ?>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bordered">
                    
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="btn-group">
                                        <a href="<?= base_url('admin/users/add') ?>" class="btn sbold green"> Add New
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-6" style="display: none;">
                                    <div class="btn-group pull-right">
                                        <button class="btn green  btn-outline dropdown-toggle" data-toggle="dropdown">Tools
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu pull-right">
                                            <li>
                                                <a href="javascript:;">
                                                    <i class="fa fa-print"></i> Print </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <i class="fa fa-file-pdf-o"></i> Save as PDF </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <i class="fa fa-file-excel-o"></i> Export to Excel </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table table-striped table-bordered table-hover" id="categaories_tbl">
                            <thead>
                                <tr>
<!--                                    <th>-->
<!--                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">-->
<!--                                            <input type="checkbox" class="group-checkable" data-set="#categaories_tbl .checkboxes" />-->
<!--                                            <span></span>-->
<!--                                        </label>-->
<!--                                    </th>-->
                                    <th> Full Name </th>
                                    <th> Username </th>
                                    <th> Type </th>
                                    <th> Email </th>
                                    <th> Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach( $users as $user ) : ?>
                                <?php $role = $this->roles_m->get_roles( $user->user_type ); ?>
                                <tr>
                                    <td><?= $user->fullname ?></td>
                                    <td><?= $user->username ?></td>
                                    <td><?= $role->name ?></td>
                                    <td><?= $user->email ?></td>
                                    <td>
                                        <a class="btn btn-sm btn-success" href="<?= base_url('admin/users/edit/' . $user->user_id) ?>">Edit</a>
                                        <a class="btn btn-sm btn-danger" href="<?= base_url('admin/users/delete/' . $user->user_id) ?>">Delete</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->


