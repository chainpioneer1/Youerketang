<style>
    #nunitsInfo_tbl th, td {
        text-align: center;
        vertical-align: middle;
    }

</style>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content" style="min-height: 1305px;">
        <h1 class="page-title"><?php echo $this->lang->line('sub_panel_title_unit'); ?>
            <small></small>
        </h1>
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bordered">
                    <div class="table-toolbar">
                        <!------Tool bar parts (add button and search function------>
                        <div class="row">
                            <div class="col-md-4 visible-ie8 visible-ie9">
                                <form action="#" class="form-horizontal">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="col-md-5 control-label"><?php echo $this->lang->line('UnitName'); ?>
                                                :</label>
                                            <div class="col-md-7">
                                                <input type="text" class="form-control" id="nunit_name_search"
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
                                                <input type="text" class="form-control" id="nunit_keyword_search"
                                                       placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-7 visible-ie8 visible-ie9">
                                <div class="btn-group right-floated">
                                    <button class=" btn sbold green" id="add_new_nunit_btn"><i class="fa fa-plus"></i>&nbsp<?php echo $this->lang->line('AddNew'); ?>
                                    </button>
                                </div>
                            </div>
                            <!-------Table tool parts----------------->
                        </div>
                        <!------Tool bar parts (add button and search function------>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover" id="nunitsInfo_tbl">
                            <thead>
                            <tr>
                                <th><?php echo $this->lang->line('SerialNumber'); ?></th>
                                <th><?php echo $this->lang->line('UnitName'); ?></th>
                                <th><?php echo $this->lang->line('ChildCourseName'); ?></th>
                                <th><?php echo $this->lang->line('CourseName'); ?></th>
                                <!--<th><?php// echo $this->lang->line('ApplicationUnit'); ?></th>-->
                                <th><?php echo $this->lang->line('Operation'); ?></th>
                            </tr>
                            </thead>
                            <tbody><?=$tbl_content?></tbody>
                        </table>
                        <div id="nunitpageNavPos"></div>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
<!---nunit is new child course ---->
<div id="add_nunit_modal" class="modal fade" tabindex="-1" data-width="680">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $this->lang->line('AddNewCourseWare'); ?></h4>
    </div>
    <div class="modal-body" style="padding-bottom:0">
        <form class="form-horizontal" enctype="multipart/form-data" action="" id="add_nunit_submit_form" role="form"
              method="post" accept-charset="utf-8">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-2 control-label"><?php echo $this->lang->line('UnitName'); ?>:</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control input-inline" name="add_nunit_name" id="add_nunit_name"
                               value="">
                    </div>
                    <label class="col-md-2 control-label"><?php echo $this->lang->line('UnitSn'); ?>:</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control input-inline" name="add_nunit_sn" id="add_nunit_sn"
                               value="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label"><?php echo $this->lang->line('ChildCourseName'); ?>:</label>
                    <div class="col-md-3">
                        <select class="form-control" id="add_nchild_name" name="add_nchild_name">
                            <?php foreach ($nccsSets as $nccs): ?>
                                <option value="<?= $nccs->childcourse_id; ?>"><?= $nccs->childcourse_name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <label class="col-md-offset-1 col-md-2 control-label"><?php echo $this->lang->line('ApplicationUnit'); ?>
                        :</label>
                    <div class="col-md-3">
                        <select class="form-control" id="add_school_type_name" name="add_school_type_name">
                            <option><?php echo $this->lang->line('PrimarySchool'); ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label"><?php echo $this->lang->line('CoursewareName'); ?>:</label>
                    <div class="col-md-3">
                        <select class="form-control" id="add_cs_name" name="add_cs_name">
                            <?php foreach ($courses as $cs): ?>
                                <option value="<?= $cs->course_id; ?>"><?= $this->lang->line('sandapian'); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="cwImageUpload"
                           class="col-md-2 control-label"><?php echo $this->lang->line('CoursewareImage'); ?></label>
                    <div class="col-md-3">
                        <input type="file" id="add_nunit_upload_img" name="add_file_name"
                               onchange="add_upload_image();">
                        <p class="help-block"><?php echo $this->lang->line('ImageUploadDescription'); ?></p>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-4">
                        <img width="240" height="200" src="#" class="img-rounded " alt="Image 300x300"
                             id="add_nunit_preview_image">
                    </div>
                </div>
            </div>
    </div>
    <div class="form-actions">
        <div class="form-group">
            <div class="row">
                <div class="col-md-offset-1 col-md-2" style="text-align: left;margin-left: 3%;">
                    <button type="submit" class="btn green"
                            style="width:80px"><?php echo $this->lang->line('Save'); ?></button>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>
<div id="edit_nunit_modal" class="modal fade" tabindex="-1" data-width="680">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $this->lang->line('AddNewCourseWare'); ?></h4>
    </div>
    <div class="modal-body" style="padding-bottom:0">
        <form class="form-horizontal" enctype="multipart/form-data" action="" id="edit_nunit_submit_form" role="form"
              method="post" accept-charset="utf-8">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-2 control-label"><?php echo $this->lang->line('UnitName'); ?>:</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control input-inline" name="edit_nunit_name" id="edit_nunit_name"
                               value="">
                    </div>
                    <label class="col-md-2 control-label"><?php echo $this->lang->line('UnitSn'); ?>:</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control input-inline" name="edit_nunit_sn" id="edit_nunit_sn"
                               value="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label"><?php echo $this->lang->line('ChildCourseName'); ?>:</label>
                    <div class="col-md-3">
                        <select class="form-control" id="edit_nchild_name" name="edit_nchild_name">
                            <?php foreach ($nccsSets as $nccs): ?>
                                <option value="<?= $nccs->childcourse_id; ?>"><?= $nccs->childcourse_name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <label class="col-md-offset-1 col-md-2 control-label"><?php echo $this->lang->line('ApplicationUnit'); ?>
                        :</label>
                    <div class="col-md-3">
                        <select class="form-control" id="edit_school_type_name" name="edit_school_type_name">
                            <option><?php echo $this->lang->line('PrimarySchool'); ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label"><?php echo $this->lang->line('CoursewareName'); ?>:</label>
                    <div class="col-md-3">
                        <select class="form-control" id="edit_cs_name" name="edit_cs_name">
                            <?php foreach ($courses as $cs): ?>
                                <option value="<?= $cs->course_id; ?>"><?= $this->lang->line('sandapian'); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="cwImageUpload"
                           class="col-md-2 control-label"><?php echo $this->lang->line('CoursewareImage'); ?></label>
                    <div class="col-md-3">
                        <input type="file" id="edit_nunit_upload_img" name="edit_file_name"
                               onchange="edit_upload_image();">
                        <p class="help-block"><?php echo $this->lang->line('ImageUploadDescription'); ?></p>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-4">
                        <img width="240" height="200" src="#" class="img-rounded " alt="Image 300x300"
                             id="edit_nunit_preview_image">
                    </div>
                </div>
            </div>
    </div>
    <div class="form-actions">
        <div class="form-group">
            <div class="row">
                <div class="col-md-offset-1 col-md-2" style="text-align: left;margin-left: 3%;">
                    <button type="submit" class="btn green" id="edit_nunit_save"
                            style="width:80px"><?php echo $this->lang->line('Save'); ?></button>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>
<div id="delete_nunit_modal" class="modal fade" tabindex="-1" data-width="300">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $this->lang->line('Message'); ?></h4>
    </div>
    <div class="modal-body" style="text-align:center;">
        <h4 class="modal-title"><?php echo $this->lang->line('DeleteConfirmMessage'); ?></h4>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn green" id="delete_nunit_btn"><?php echo $this->lang->line('Yes'); ?></button>
        <button type="button" data-dismiss="modal"
                class="btn btn-outline dark"><?php echo $this->lang->line('No'); ?></button>
    </div>
</div>
<script>

    $('#newunit_menu').addClass('menu-selected');
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

    var pager = new Pager('nunitsInfo_tbl', showedItems);
    pager.init();
    pager.showPageNav('pager', 'nunitpageNavPos');
    pager.showPage(1);

    function executionPageNation() {
        var pager = new Pager('nunitsInfo_tbl', showedItems);
        pager.init();
        pager.showPageNav('pager', 'nunitpageNavPos');
        pager.showPage(currentShowedPage);
    }

    $('#add_new_nunit_btn').click(function () {
        $('#add_nunit_name').val('');
        $('#add_nunit_sn').val('');
        $('#add_nunit_preview_image').attr('src', baseURL + 'assets/images/no_image.jpg');
        $('#add_nunit_modal').modal({
            backdrop: 'static',
            keyboard: false
        });
    });

    function delete_nunit(self) {

        var nunitid = self.getAttribute('nunit_id');
        $("#delete_nunit_btn").attr("nunit_id", nunitid);
        $("#delete_nunit_modal").modal({
            backdrop: 'static',
            keyboard: false
        });
    }

    jQuery("#delete_nunit_btn").click(function () {
        var nunit_id = $(this).attr("nunit_id");
        jQuery.ajax({
            type: "post",
            url: baseURL + "admin/nunits/delete",
            dataType: "json",
            data: {nunit_id: nunit_id},
            success: function (res) {
                if (res.status == 'success') {
                    var table = document.getElementById("nunitsInfo_tbl");
                    var tbody = table.getElementsByTagName("tbody")[0];
                    tbody.innerHTML = res.data;
                    executionPageNation();
                }
                else//failed
                {
                    alert("Cannot delete unit Item.");
                }
            }
        });
        jQuery('#delete_nunit_modal').modal('toggle');
    });
    $('#add_nunit_submit_form').submit(function (e) {
        e.preventDefault();
        jQuery.ajax({
            url: baseURL + "admin/nunits/add",
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false,
            success: function (res) {
                var ret = JSON.parse(res);
                if (ret.status == 'success') {
                    var table = document.getElementById("nunitsInfo_tbl");
                    var tbody = table.getElementsByTagName("tbody")[0];
                    tbody.innerHTML = ret.data;
                    executionPageNation();
                }
                else//failed
                {
                    alert(ret.data);
                    console.log('Image uploading has been failed!')
                }
            }
        });
        jQuery('#add_nunit_modal').modal('toggle');
    });
    $('#edit_nunit_submit_form').submit(function (e) {

        var nunitId = $('#edit_nunit_save').attr('nunit_id');
        var fdata = new FormData(this);
        fdata.append('nunit_id', nunitId);
        e.preventDefault();
        jQuery.ajax({
            url: baseURL + "admin/nunits/edit",
            type: "post",
            data: fdata,
            processData: false,
            contentType: false,
            cache: false,
            async: false,
            success: function (res) {
                var ret = JSON.parse(res);
                if (ret.status == 'success') {
                    var table = document.getElementById("nunitsInfo_tbl");
                    var tbody = table.getElementsByTagName("tbody")[0];
                    tbody.innerHTML = ret.data;
                    executionPageNation();
                }
                else//failed
                {
                    alert(ret.data);
                    console.log('Image uploading has been failed!')
                }
            }
        });
        jQuery('#edit_nunit_modal').modal('toggle');
    });

    function add_upload_image() {
        var preview = document.getElementById('add_nunit_preview_image');
        var file = document.getElementById('add_nunit_upload_img').files[0];
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

    function edit_upload_image() {
        var preview = document.getElementById('edit_nunit_preview_image');
        var file = document.getElementById('edit_nunit_upload_img').files[0];
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

    function edit_nunit(self) {
        var nunitId = self.getAttribute('nunit_id');
        var nunit_photo = self.getAttribute('nunit_photo');
        var tdtag = self.parentNode;
        var trtag = tdtag.parentNode;
        var nunit_sn = trtag.cells[0].innerHTML;
        var nunit_name = trtag.cells[1].innerHTML;
        var nchild_name = trtag.cells[2].innerHTML;

        $('#edit_nunit_save').attr('nunit_id', nunitId);
        $('#edit_nunit_name').val(nunit_name);
        $('#edit_nunit_sn').val(nunit_sn);

        $('#edit_nchild_name').find('option').filter(function () {
            return ( ($(this).val() == nchild_name) || ($(this).text() == nchild_name) )
        }).prop('selected', true);

        $('#edit_nunit_preview_image').attr('src', baseURL + nunit_photo);
        $('#edit_nunit_modal').modal({
            backdrop: 'static',
            keyboard: false
        });
    }

    function publish_nunit(self) {
//        e.preventDefault();
        var nunit_id = self.getAttribute("nunit_id");
        var enableStr = "<?php echo $this->lang->line('Enable');?>";
        var disableStr = "<?php echo $this->lang->line('Disable');?>";
        var curBtnText = self.innerHTML.trim();
        var pub_st = '1';
        if (enableStr == curBtnText) {
//            self.innerHTML = disableStr;
        }
        else {
//            self.innerHTML = enableStr;
            pub_st = '0';
        }
        ///ajax process for publish/unpublish
        $.ajax({
            type: "post",
            url: baseURL + "admin/nunits/publish",
            dataType: "json",
            data: {nunit_id: nunit_id, publish_state: pub_st},
            success: function (res) {
                if (res.status == 'success') {
                    var table = document.getElementById("nunitsInfo_tbl");
                    var tbody = table.getElementsByTagName("tbody")[0];
                    tbody.innerHTML = res.data;
                    executionPageNation();
                    console.log('Unit publish has been successed!')
                }
                else//failed
                {
                    alert("Cannot delete CourseWare Item.");
                }
            }
        });
    }

    jQuery("#nunit_name_search").keyup(function () {

        var input, filter, table, tr, td, i;
        input = document.getElementById("nunit_name_search");
        filter = input.value.toUpperCase();
        table = document.getElementById("nunitsInfo_tbl");
        tr = table.getElementsByTagName("tr");
        // Loop through all table rows, and hide those who don't match the search query
        if (tr.length < 2) return;
        for (i = 1; i < tr.length; i++) {
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
    jQuery("#nunit_keyword_search").keyup(function () {///search for keyword
        var input, filter, table, tr, td, i, tdCnt;
        input = document.getElementById("nunit_keyword_search");
        filter = input.value.toUpperCase();
        table = document.getElementById("nunitsInfo_tbl");
        tr = table.getElementsByTagName("tr");
        // Loop through all table rows, and hide those who don't match the search query
        if (tr.length < 2) return;
        for (i = 1; i < tr.length; i++) {

            var cmpst = 0;
            for (j = 0; j < 5; j++)//5 is search filed count
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
    });
</script>
