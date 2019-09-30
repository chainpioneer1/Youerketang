<style>
    #ncwInfo_tbl th, td {
        text-align: center;
        vertical-align: middle;
    }

</style>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content" style="min-height: 1305px;">
        <h1 class="page-title"><?php echo $this->lang->line('sub_panel_title_courseware'); ?>
            <small></small>
        </h1>
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bordered">
                    <div class="table-toolbar">
                        <!-------Table tool parts----------------->
                        <div class="row">
                            <div class="col-md-4 visible-ie8 visible-ie9">
                                <form action="#" class="form-horizontal">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="col-md-5 control-label"><?php echo $this->lang->line('CoursewareName'); ?>
                                                :</label>
                                            <div class="col-md-7">
                                                <input type="text" class="form-control" id="ncw_name_search"
                                                       placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-5">
                                <form action="#" class="form-horizontal">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="col-md-5 control-label"><?php echo $this->lang->line('keyword'); ?>
                                                :</label>
                                            <div class="col-md-7">
                                                <input type="text" class="form-control" id="keyword_ncw_search"
                                                       placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-7">
                                <div class="btn-group right-floated">
                                    <button class=" btn blue" id="add_new_ncw_btn"><i
                                                class="fa fa-plus"></i>&nbsp&nbsp<?php echo $this->lang->line('AddNew'); ?>
                                    </button>
                                </div>
                            </div>
                            <!-------Table tool parts----------------->
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover" id="ncwInfo_tbl">
                            <thead>
                            <tr>
                                <th><?php echo $this->lang->line('SerialNumber'); ?></th>
                                <th><?php echo $this->lang->line('CoursewareName'); ?></th>
                                <th><?php echo $this->lang->line('UnitName'); ?></th>
                                <th><?php echo $this->lang->line('ChildCourseName'); ?></th>
                                <th><?php echo $this->lang->line('CourseName'); ?></th>
                                <th><?php echo $this->lang->line('Operation'); ?></th>
                            </tr>
                            </thead>
                            <tbody><?= $tbl_content ?></tbody>
                        </table>
                        <div id="pageNavPosition"></div>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
<!------->
<style>
    .uploading_backdrop {
        display: none;
        position: absolute;
        width: 100%;
        height: 100%;
        background-color: #000;
        opacity: 0.9;
        z-index: 12000;
    }

    #wait_ajax_loader {
        position: absolute;
        top: 41%;
        left: 50%;
        z-index: 15000
    }

    #progress_percent {
        position: absolute;
        top: 43%;
        left: 56.5%;
        font-size: 18px;
        color: #fff;
        z-index: 17000
    }
</style>
<div class="uploading_backdrop"></div>
<div class="progressing_area" style="display: none">
    <img id="wait_ajax_loader" src='<?php echo base_url('assets/images/frontend/ajax-loader-1.gif'); ?>'/>
    <span style="position: absolute;top: 43%;left: 43%;font-size:18px;color: #fff;z-index: 16000"><?= $this->lang->line('uploading') ?></span>
    <span id="progress_percent">0%</span>
</div>
<div id="ncw_addNew_modal" class="modal fade" tabindex="-1" data-width="750">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $this->lang->line('AddNewCourseWare'); ?></h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" enctype="multipart/form-data" action="" id="ncw_addNew_submit_form" role="form"
              method="post" accept-charset="utf-8">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-2 control-label"><?php echo $this->lang->line('CoursewareName'); ?>:</label>
                    <div class="col-md-4">
                        <input class="form-control input-inline " type="text" name="add_ncw_name" id="add_ncw_name"
                               value="">
                    </div>
                    <label class="col-md-2 control-label"><?php echo $this->lang->line('ParentCourseName'); ?>:
                    </label>
                    <div class="col-md-3">
                        <label class="control-label"><?php echo $this->lang->line('PrimaryCourse'); ?></label>
                        <!--<select class="form-control" id="add_school_type_name" name="add_school_type_name">
                            <option><?php //echo $this->lang->line('PrimarySchool'); ?></option>
                        </select>-->
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label"><?php echo $this->lang->line('UnitName'); ?>:</label>
                    <div class="col-md-3">
                        <select class="form-control " id="add_nunit_name" name="add_nunit_name">
                            <?php $j = 0;
                            foreach ($nunitSets as $nunit):
                                $j++;
                                if ($j > 4) break;
                                ?>
                                <option value="<?= $nunit->nunit_id; ?>"><?= $nunit->nunit_name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <label class="col-md-offset-1 col-md-2 control-label"><?php echo $this->lang->line('ChildCourseName'); ?>
                        :</label>
                    <div class="col-md-3">
                        <select class="form-control" id="add_nccs_name" name="add_nccs_name">
                            <?php foreach ($nccsSets as $nccs): ?>
                                <option value="<?= $nccs->childcourse_id; ?>"><?= $nccs->childcourse_name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="col-md-2 control-label"><?php echo $this->lang->line('CourswareSN'); ?>:</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control input-inline" name="add_ncw_sn" id="add_ncw_sn" value="">
                    </div>
                    <label class="col-md-2 control-label"><?php echo $this->lang->line('IsFree'); ?>:
                    </label>
                    <div class="col-md-4">
                        <div class="mt-radio-inline">
                            <label class="mt-radio mt-radio-outline">
                                <input type="radio" name="free_option" value="1"
                                       id="add_free_yes_option"><?= $this->lang->line('Yes') ?>
                                <span></span>
                            </label>
                            <label class="mt-radio mt-radio-outline">
                                <input type="radio" name="free_option" value="0"
                                       id="add_free_no_option"><?= $this->lang->line('No') ?>
                                <span></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-2 right-aligned">
                        <label for="cwImageUpload"
                               class="control-label"><?php echo $this->lang->line('CoursewareImage'); ?>:
                        </label>
                    </div>
                    <div class="col-md-4">
                        <div class="fileinput fileinput-new" data-provides="fileinput"
                             style="background-color: #e0e1e1;width: 200px;">
                                <span class="btn btn-default btn-file">
                                    <span id="add_btn_upload_img"><?php echo $this->lang->line('Browse'); ?></span>
                                    <input type="file" id="add_ncw_upload_img"
                                           class="form-control" style="display: none"
                                           name="add_file_name"
                                           accept=".jpg,.png,.jpeg,.bmp,.gif"/>
                                </span>
                            <span class="fileinput-filename"></span>
                            <span class="fileinput-new" style="width:100%;word-wrap: break-word;"
                                  id="add_selectedimagefile"><?php echo $this->lang->line('NoFileSelected'); ?>
                                </span>
                        </div>
                        <script>
                            document.getElementById("add_btn_upload_img").onclick = function () {
                                $('#add_ncw_upload_img').val('');
                                $('#add_ncw_upload_img').trigger('click');
                            };
                            document.getElementById("add_ncw_upload_img").onchange = function () {
                                var totalStr = this.files[0].name;
                                var realNameStr = totalStr.split('/');
                                realNameStr = realNameStr[realNameStr.length - 1];
                                var type = realNameStr.split('.');
                                type = type[type.length - 1].toLowerCase();
                                if (type != 'jpg' && type != 'jpeg'
                                    && type != 'png' && type != 'bmp' && type != 'gif') {
                                    alert('图片格式不正确..');
                                    return;
                                }
                                $("#add_selectedimagefile").html(realNameStr);
                                add_upload_image();
                            };
                        </script>
                        <p class="help-block"><?php echo $this->lang->line('ImageUploadDescription'); ?></p>
                    </div>

                </div>
                <div class="form-group">
                    <div class="col-md-2 right-aligned">
                        <label for="ncwPackageUpload"
                               class="control-label"><?php echo $this->lang->line('UploadSubwarePackage'); ?>:
                        </label>
                    </div>
                    <div class="col-md-4">
                        <div class="fileinput fileinput-new" data-provides="fileinput"
                             style="background-color: #e0e1e1;width: 200px;">
                                <span class="btn btn-default btn-file">
                                    <span id="add_btn_pkg_upload_img"><?php echo $this->lang->line('Browse'); ?></span>
                                    <input type="file" id="add_ncw_upload_package"
                                           class="form-control" style="display: none"
                                           name="add_package_file_name"
                                           accept=".zip,.mp4"/>
                                </span>
                            <span class="fileinput-filename"></span>
                            <span class="fileinput-new"
                                  id="add_selectedpackagefile"><?php echo $this->lang->line('NoFileSelected'); ?>
                                </span>
                        </div>
                        <script>
                            document.getElementById("add_ncw_sn").oninput = function () {
                                $('#add_selectedpackagefile').html($(this).val());
                            };
                            document.getElementById("add_nunit_name").onchange = function () {
                                $('#add_nccs_name').trigger('change');
                                $('#add_ncw_sn').trigger('input');
                            };
                            document.getElementById("add_nccs_name").onchange = function () {
                                var nccs_id = FormatNumberLength($('#add_nccs_name').val(), 2);
                                var nunit_id = FormatNumberLength($('#add_nunit_name').val(), 2);
                                var ncw_sn = FormatNumberLength($('#add_ncw_sn').val(), 8);
                                ncw_sn = ncw_sn.substr(ncw_sn.length - 2);
                                ncw_id = 'jq' + nccs_id + nunit_id + ncw_sn;

                                $('#add_ncw_sn').val(ncw_id);
                                $('#add_ncw_sn').trigger('input');
                            };
                            document.getElementById("add_btn_pkg_upload_img").onclick = function () {
                                $('#add_ncw_upload_package').val('');
                                $('#add_ncw_upload_package').trigger('click');
                            };
                            document.getElementById("add_ncw_upload_package").onchange = function () {
                                var totalStr = this.files[0].name;
                                var realNameStr = totalStr.split('/');
                                realNameStr = realNameStr[realNameStr.length - 1];
                                var type = realNameStr.split('.');
                                type = type[type.length - 1].toLowerCase();
                                if (type != 'zip' && type != 'mp4') {
                                    alert('包文件格式不正确..');
                                    return;
                                }
                                if (type == 'zip')
                                    $('#edit_selectedpackagefile').html($('#edit_ncw_sn').val());
                                else
                                    $('#edit_selectedpackagefile').html(realNameStr);
                            };
                        </script>
                    </div>
                    <div style="position: absolute;top: 37%;left: 56%;width: 38%;height: 43%;">
                        <img src="#" class="img-rounded " alt="Image 300x300"
                             id="add_ncw_preview_image"
                             style="width:100%;height: 100%">
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="form-group">
                    <div class="col-md-2" style="padding-bottom: 15px;text-align: -webkit-center;margin-top: 30px;">
                        <button type="submit" class="btn green"
                                id="add_ncw_save"><?php echo $this->lang->line('Save'); ?></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!--   edit modal  -->
<div id="ncw_edit_modal" class="modal fade" tabindex="-1" data-width="750">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $this->lang->line('AddNewCourseWare'); ?></h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" enctype="multipart/form-data" action="" id="ncw_edit_submit_form" role="form"
              method="post" accept-charset="utf-8">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-2 control-label"><?php echo $this->lang->line('CoursewareName'); ?>:</label>
                    <div class="col-md-4">
                        <input class="form-control input-inline " type="text" name="edit_ncw_name" id="edit_ncw_name"
                               value="">
                    </div>
                    <label class="col-md-2 control-label"><?php echo $this->lang->line('ParentCourseName'); ?>:</label>
                    <div class="col-md-3">
                        <label class="control-label"><?php echo $this->lang->line('PrimaryCourse'); ?></label>
                        <!--   <select class="form-control" id="edit_school_type_name" name="edit_school_type_name">
                            <option><?php //echo $this->lang->line('PrimaryCourse'); ?></option>
                        </select>-->
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label"><?php echo $this->lang->line('UnitName'); ?>:</label>
                    <div class="col-md-3">
                        <select class="form-control " id="edit_nunit_name" name="edit_nunit_name">
                            <?php $j = 0;
                            foreach ($nunitSets as $nunit):
                                $j++;
                                if ($j > 4) break;
                                ?>
                                <option value="<?= $nunit->nunit_id; ?>"><?= $nunit->nunit_name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <label class="col-md-offset-1 col-md-2 control-label"><?php echo $this->lang->line('ChildCourseName'); ?>
                        :</label>
                    <div class="col-md-3">
                        <select class="form-control" id="edit_nccs_name" name="edit_nccs_name">
                            <?php foreach ($nccsSets as $nccs): ?>
                                <option value="<?= $nccs->childcourse_id; ?>"><?= $nccs->childcourse_name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="col-md-2 control-label"><?php echo $this->lang->line('CourswareSN'); ?>:</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control input-inline" name="edit_ncw_sn" id="edit_ncw_sn"
                               value="">
                    </div>
                    <label class="col-md-2 control-label"><?php echo $this->lang->line('IsFree'); ?>:</label>
                    <div class="col-md-4">
                        <div class="mt-radio-inline">
                            <label class="mt-radio mt-radio-outline">
                                <input type="radio" name="free_option" value="1" id="free_yes_option"
                                       checked><?= $this->lang->line('Yes') ?>
                                <span></span>
                            </label>
                            <label class="mt-radio mt-radio-outline">
                                <input type="radio" name="free_option" id="free_no_option"
                                       value="0"><?= $this->lang->line('No') ?>
                                <span></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-2 right-aligned">
                        <label for="cwImageUpload"
                               class="control-label"><?php echo $this->lang->line('CoursewareImage'); ?>:
                        </label>
                    </div>
                    <div class="col-md-4">
                        <div class="fileinput fileinput-new" data-provides="fileinput"
                             style="background-color: #e0e1e1;width: 200px;">
                                <span class="btn btn-default btn-file">
                                    <span id="edit_btn_upload_img"><?php echo $this->lang->line('Browse'); ?></span>
                                    <input type="file" id="edit_ncw_upload_img"
                                           class="form-control" style="display: none"
                                           name="edit_file_name"
                                           accept=".jpg,.png,.jpeg,.bmp,.gif"/>
                                </span>
                            <span class="fileinput-filename"></span>
                            <span class="fileinput-new" style="width:100%;word-wrap: break-word;"
                                  id="edit_selectedimagefile"><?php echo $this->lang->line('NoFileSelected'); ?>
                                </span>
                        </div>
                        <script>
                            document.getElementById("edit_btn_upload_img").onclick = function () {
                                $('#edit_ncw_upload_img').val('');
                                $('#edit_ncw_upload_img').trigger('click');
                            };
                            document.getElementById("edit_ncw_upload_img").onchange = function () {
                                var totalStr = this.files[0].name;
                                var realNameStr = totalStr.split('/');
                                realNameStr = realNameStr[realNameStr.length - 1];
                                var type = realNameStr.split('.');
                                type = type[type.length - 1].toLowerCase();
                                if (type != 'jpg' && type != 'jpeg'
                                    && type != 'png' && type != 'bmp' && type != 'gif') {
                                    alert('图片格式不正确..');
                                    return;
                                }
                                $("#edit_selectedimagefile").html(realNameStr);
                                edit_upload_image();
                            };
                        </script>
                        <p class="help-block"><?php echo $this->lang->line('ImageUploadDescription'); ?></p>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-2 right-aligned">
                        <label for="ncwPackageUpload"
                               class="control-label"><?php echo $this->lang->line('UploadSubwarePackage'); ?>:
                        </label>
                    </div>
                    <div class="col-md-4">
                        <div class="fileinput fileinput-new" data-provides="fileinput"
                             style="background-color: #e0e1e1;width: 200px;">
                                <span class="btn btn-default btn-file">
                                    <span id="edit_btn_pkg_upload_img"><?php echo $this->lang->line('Browse'); ?></span>
                                    <input type="file" id="edit_ncw_upload_package"
                                           class="form-control" style="display: none"
                                           name="edit_package_file_name"
                                           accept=".zip,.mp4"/>
                                </span>
                            <span class="fileinput-filename"></span>
                            <span class="fileinput-new"
                                  id="edit_selectedpackagefile"><?php echo $this->lang->line('NoFileSelected'); ?>
                                </span>
                        </div>
                        <script>
                            document.getElementById("edit_ncw_sn").oninput = function () {
                                $('#edit_selectedpackagefile').html($(this).val());
                            };
                            document.getElementById("edit_nunit_name").onchange = function () {
                                $('#edit_nccs_name').trigger('change');
                                $('#edit_ncw_sn').trigger('input');
                            };
                            document.getElementById("edit_nccs_name").onchange = function () {
                                var nccs_id = FormatNumberLength($('#edit_nccs_name').val(), 2);
                                var nunit_id = FormatNumberLength($('#edit_nunit_name').val(), 2);
                                var ncw_sn = FormatNumberLength($('#edit_ncw_sn').val(), 8);
                                ncw_sn = ncw_sn.substr(ncw_sn.length - 2);
                                ncw_id = 'jq' + nccs_id + nunit_id + ncw_sn;

                                $('#edit_ncw_sn').val(ncw_id);
                                $('#edit_ncw_sn').trigger('input');
                            };
                            document.getElementById("edit_btn_pkg_upload_img").onclick = function () {
                                $('#edit_ncw_upload_package').val('');
                                $('#edit_ncw_upload_package').trigger('click');
                            };
                            document.getElementById("edit_ncw_upload_package").onchange = function () {
                                var totalStr = this.files[0].name;
                                var realNameStr = totalStr.split('/');
                                realNameStr = realNameStr[realNameStr.length - 1];
                                var type = realNameStr.split('.');
                                type = type[type.length - 1].toLowerCase();
                                if (type != 'zip' && type != 'mp4') {
                                    alert('包文件格式不正确..');
                                    return;
                                }
                                if (type == 'zip')
                                    $('#edit_selectedpackagefile').html($('#edit_ncw_sn').val());
                                else
                                    $('#edit_selectedpackagefile').html(realNameStr);
                            };
                        </script>
                    </div>
                    <div style="position: absolute;top: 37%;left: 56%;width: 38%;height: 43%;">
                        <img src="#" class="img-rounded " alt="Image 300x300" id="edit_ncw_preview_image"
                             style="width:100%;height: 100%">
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="form-group">
                    <div class="col-md-2" style="padding-bottom: 15px;text-align: -webkit-center;margin-top: 30px;">
                        <button type="submit" class="btn green"
                                id="edit_ncw_save"><?php echo $this->lang->line('Save'); ?></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!----delete modal-->
<div id="ncw_delete_modal" class="modal fade" tabindex="-1" data-width="300">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $this->lang->line('Message'); ?></h4>
    </div>
    <div class="modal-body" style="text-align:center;">
        <h4 class="modal-title"><?php echo $this->lang->line('DeleteConfirmMessage'); ?></h4>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn green"
                id="delete_ncw_item_btn"><?php echo $this->lang->line('Yes'); ?></button>
        <button type="button" data-dismiss="modal"
                class="btn btn-outline dark"><?php echo $this->lang->line('No'); ?></button>
    </div>
</div>
<!----------pagenation-------->
<script type="text/javascript">
    $('#newcourseware_menu').addClass('menu-selected');
    var prevstr = "<?php echo $this->lang->line('PrevPage');?>";
    var nextstr = "<?php echo $this->lang->line('NextPage');?>";
    var currentShowedPage = 1;
    var showedItems = 6;

    function Pager(tableName, itemsPerPage) {
        this.tableName = tableName;
        this.itemsPerPage = itemsPerPage;
        this.currentPage = 1;
        this.pages = 0;
        this.inited = false;

        this.showRecords = function (from, to) {
            var rows = document.getElementById(tableName).rows;
            // i starts from 1 to skip table header row
            for (var i = 1; i < rows.length; i++) {
                if (i < from || i > to)
                    rows[i].style.display = 'none';
                else
                    rows[i].style.display = '';
            }
        }

        this.showPage = function (pageNumber) {
            if (!this.inited) {
                alert("not inited");
                return;
            }
            var oldPageAnchor = document.getElementById('pg' + this.currentPage);
            if (oldPageAnchor) {
                oldPageAnchor.className = 'pg-normal';

                this.currentPage = pageNumber;
                var newPageAnchor = document.getElementById('pg' + this.currentPage);
                newPageAnchor.className = 'pg-selected';

                var from = (pageNumber - 1) * itemsPerPage + 1;
                var to = from + itemsPerPage - 1;
                this.showRecords(from, to);
            } else {

                return;
            }

        }

        this.prev = function () {
            if (this.currentPage > 1) {

                currentShowedPage = this.currentPage - 1;
                this.showPage(this.currentPage - 1);
            }

        }

        this.next = function () {
            if (this.currentPage < this.pages) {
                currentShowedPage = this.currentPage + 1;
                this.showPage(this.currentPage + 1);
            }
        }

        this.init = function () {
            var rows = document.getElementById(tableName).rows;
            var records = (rows.length - 1);
            this.pages = Math.ceil(records / itemsPerPage);
            this.inited = true;
        }
        this.showPageNav = function (pagerName, positionId) {
            if (!this.inited) {
                alert("not inited");
                return;
            }
            var element = document.getElementById(positionId);

            var pagerHtml = '<button class = "btn btn blue" onclick="' + pagerName + '.prev();" class="pg-normal">' + prevstr + '</button>  ';
            for (var page = 1; page <= this.pages; page++)
                pagerHtml += '<button hidden id="pg' + page + '" class="pg-normal" onclick="' + pagerName + '.showPage(' + page + ');">' + page + '</button>  ';
            pagerHtml += '<button  class = "btn btn blue" onclick="' + pagerName + '.next();" class="pg-normal">' + nextstr + '</button>';

            element.innerHTML = pagerHtml;
        }
    }

    var pager = new Pager('ncwInfo_tbl', showedItems);
    pager.init();
    pager.showPageNav('pager', 'pageNavPosition');
    pager.showPage(1);
    //-->
</script>
<!---------pagenation module--------->
<script>
    function executionPageNation() {
        var pager = new Pager('ncwInfo_tbl', showedItems);
        pager.init();
        pager.showPageNav('pager', 'pageNavPosition');
        pager.showPage(currentShowedPage);
    }

    function edit_ncw(self) {
        var ncw_id = self.getAttribute("ncw_id");
        var isFree = self.getAttribute("ncw-free");
        var ncw_photo = self.getAttribute("ncw_photo");
        var ncw_file = self.getAttribute("ncw_file");
        var tdtag = self.parentNode;
        var trtag = tdtag.parentNode;
        var ncw_sn = trtag.cells[0].innerHTML;
        var ncw_name = trtag.cells[1].innerHTML;

        var nunit_name = trtag.cells[2].innerHTML;
        var nccs_name = trtag.cells[3].innerHTML;

        $('#edit_nunit_name').find('option').filter(function () {
            return ( ($(this).val() == nunit_name) || ($(this).text() == nunit_name) )
        }).prop('selected', true);
        $('#edit_nccs_name').find('option').filter(function () {
            return ( ($(this).val() == nccs_name) || ($(this).text() == nccs_name) )
        }).prop('selected', true);

        if (isFree == '0') {
            $('#free_no_option').prop('checked', true);
        } else {
            $('#free_yes_option').prop('checked', true);
        }
        $('#free_no_option').attr('disabled', 'true');
        $('#free_yes_option').attr('disabled', 'true');

        jQuery("#edit_ncw_save").attr('ncw_id', ncw_id);
        jQuery("#edit_ncw_name").val(ncw_name);
        jQuery("#edit_ncw_sn").val(ncw_sn);
        jQuery("#edit_ncw_preview_image").attr('src', baseURL + (ncw_photo));
        ncw_photo = ncw_photo.split('/');
        ncw_photo = ncw_photo[ncw_photo.length - 1];
        ncw_file = ncw_file.split('/');
        ncw_file = ncw_file[ncw_file.length - 1];
        jQuery("#edit_selectedimagefile").html(ncw_photo);
        jQuery("#edit_selectedpackagefile").html(ncw_file);

        jQuery("#ncw_edit_modal").modal({
            backdrop: 'static',
            keyboard: false
        });
    }

    function edit_upload_image() {
        var preview = document.getElementById('edit_ncw_preview_image');
        var file = document.getElementById('edit_ncw_upload_img').files[0];
        var reader = new FileReader();
        reader.onloadend = function () {
            preview.src = reader.result;
        };
        if (file) {
            reader.readAsDataURL(file);//reads the data as a URL
        } else {
            preview.src = "";
        }
    }

    function add_upload_image() {
        var preview = document.getElementById('add_ncw_preview_image');
        var file = document.getElementById('add_ncw_upload_img').files[0];
        var reader = new FileReader();
        reader.onloadend = function () {
            preview.src = reader.result;
        };
        if (file) {
            reader.readAsDataURL(file);//reads the data as a URL
        } else {
            preview.src = "";
        }
    }

    function delete_ncw(self) {
        var ncw_id = self.getAttribute("ncw_id");
        $("#delete_ncw_item_btn").attr("delete_ncw_id", ncw_id);
        $("#ncw_delete_modal").modal({
            backdrop: 'static',
            keyboard: false
        });
    }

    function publish_ncw(self) {
        var ncw_id = self.getAttribute("ncw_id");
        var publish = "<?php echo $this->lang->line('Enable');?>";
        var unpublish = "<?php echo $this->lang->line('Disable');?>";
        var curBtnText = self.innerHTML.trim();
        var pub_st = '1';
        if (publish == curBtnText) {
//            self.innerHTML = unpublish;
        }
        else {
//            self.innerHTML = publish;
            pub_st = '0';
        }
        ///ajax process for publish/unpublish
        $.ajax({
            type: "post",
            url: baseURL + "admin/ncoursewares/publish",
            dataType: "json",
            data: {ncw_id: ncw_id, publish_state: pub_st},
            success: function (res) {
                if (res.status == 'success') {
                    var table = document.getElementById("ncwInfo_tbl");
                    var tbody = table.getElementsByTagName("tbody")[0];
                    tbody.innerHTML = res.data;
                    executionPageNation();
                    console.log('courseware publish has been successed!')
                }
                else//failed
                {
                    alert("Cannot delete CourseWare Item.");
                }
            }
        });
    }

    //  add_new_cw_btn
    jQuery("#add_new_ncw_btn").click(function () {

        $('#add_ncw_name').val('');
        $('#add_ncw_sn').val('');
        $('#add_ncw_preview_image').attr('src', baseURL + 'assets/images/no_image.jpg');
        $('#add_ncw_upload_img').val('');
        $('#add_ncw_upload_package').val('');
        $('#add_selectedimagefile').html('<?=$this->lang->line('NoFileSelected');?>');
        $('#add_selectedpackagefile').html('<?=$this->lang->line('NoFileSelected');?>');

        $('#add_nunit_name').trigger('change');

        $('#add_free_no_option').prop('checked', 'true');
        $('#add_free_no_option').attr('disabled', 'true');
        $('#add_free_yes_option').attr('disabled', 'true');

        jQuery("#ncw_addNew_modal").modal({
            backdrop: 'static',
            keyboard: false
        });
    });
    jQuery("#ncw_name_search").keyup(function () {

        var input, filter, table, tr, td, i;
        input = document.getElementById("ncw_name_search");
        filter = input.value.toUpperCase();
        table = document.getElementById("ncwInfo_tbl");
        tr = table.getElementsByTagName("tr");
        // Loop through all table rows, and hide those who don't match the search query
        if (tr.length < 2) return;
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    });
    jQuery("#keyword_ncw_search").keyup(function () {///search for keyword
        var input, filter, table, tr, td, i, tdCnt;
        input = document.getElementById("keyword_ncw_search");
        filter = input.value.toUpperCase();
        table = document.getElementById("ncwInfo_tbl");
        tr = table.getElementsByTagName("tr");
        // Loop through all table rows, and hide those who don't match the search query
        if (tr.length < 2) return;
        for (i = 1; i < tr.length; i++) {

            var cmpst = 0;
            for (j = 0; j < 5; j++)//5 is search field count
            {
                td = tr[i].getElementsByTagName("td")[j];
                if (td) {
                    if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                        cmpst++;
                    }
                }
            }
            if (cmpst > 0) {
                tr[i].style.display = "";
            }
            else tr[i].style.display = "none";

        }
//        executionPageNation();
    });
</script>
<script src="<?= base_url('assets/js/my_custom_ncw.js') ?>"></script>



