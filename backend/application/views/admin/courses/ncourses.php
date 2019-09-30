<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content" style="min-height: 1305px;">
        <h1 class="page-title"><?php echo $this->lang->line('sub_panel_title_newcourse');?>
            <small></small>
        </h1>
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bordered">
                    <div class="table-toolbar">
                        <!------Tool bar parts (add button and search function------>
                        <div class="row">
                            <div class="col-md-4">
                                <form action="#" class="form-horizontal">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="col-md-5 control-label"><?php echo $this->lang->line('keyword');?>:</label>
                                            <div class="col-md-7">
                                                <input type="text" class="form-control" id = "newcourse_search" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-5">
                                <div class="btn-group right-floated">
                                    <button  class=" btn blue" id = "add_new_cs_btn"> <i class="fa fa-plus"></i>&nbsp<?php echo $this->lang->line('AddNew');?>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!------Tool bar parts (add button and search function------>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover" id="courseInfo_tbl">
                            <thead>
                            <tr>
                                <th style="text-align:center"><?php echo $this->lang->line('CourseName');?></th>
                                <th style="text-align:center"><?php echo $this->lang->line('CourseDescription');?></th>
                                <th style="text-align:center"><?php echo $this->lang->line('ApplicationUnit');?></th>
                                <th style="text-align:center"><?php echo $this->lang->line('Operation');?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($courses as $course):?>
                            <tr>
                                <td align="center"><?php echo $course->course_name; ?></td>
                                <td align="center"><?php echo $course->course_desc; ?></td>
                                <td align="center"><?php echo $course->school_type_name; ?></td>
                                <td>
                                    <button style="width:70px;" class="btn btn-sm btn-success" course_id = "<?php echo $course->course_id;?>" onclick="edit_course(this)"><?php echo $this->lang->line('Modify');?></button>
                                </td>
                            <tr>
                                <?php endforeach;?>
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
<!--Modify Modal --->
<div id="course_add_modal" class="modal fade" tabindex="-1" data-width="730">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $this->lang->line('AddNewCourse');?></h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal">
            <div class="form-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-2">
                            <label class="control-label"><?php echo $this->lang->line('CourseName');?>:</label>
                        </div>
                        <div class="col-md-3">
                            <input class="control-label" id="cs_add_name" value="" style="text-align: left">
                        </div>
                        <div class="col-md-1"></div>
                        <div class="col-md-2">
                            <label class="control-label"><?php echo $this->lang->line('ApplicationUnit');?>:</label>
                        </div>
                        <div class="col-md-2">
                            <select class="form-control" id="cs_add_school_type_name" value="1">
                                <option value="1"><?php echo $this->lang->line('PrimarySchool');?></option>
                            </select>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-2">
                        <label class="control-label"><?php echo $this->lang->line('CourseDescription');?>:</label>
                    </div>
                    <div class="col-md-8">
                        <textarea class="form-control" rows="3" id="cs_add_desc"></textarea>
                    </div>
                    <div class="col-md-1"></div>
                </div>
            </div>
    </div>
    <div class="form-actions">
        <div class="form-group">
            <div class="row">
                <div class="col-md-offset-1 col-md-9">
                    <button type="button"  class="btn green" onclick="add_course();"><?php echo $this->lang->line('Save');?></button>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>
<div id="course_modify_modal" class="modal fade" tabindex="-1" data-width="730">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $this->lang->line('CourseInfoModify');?></h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal">
            <div class="form-body">
                <div class="form-group">
                    <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-2">
                                <label class="control-label"><?php echo $this->lang->line('CourseName');?>:</label>
                            </div>
                            <div class="col-md-3">
                                <label class="control-label" id="cs_modify_name"></label>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-2">
                                <label class="control-label"><?php echo $this->lang->line('ApplicationUnit');?>:</label>
                            </div>
                            <div class="col-md-2">
                                <select class="form-control" id="cs_modify_school_type_name">
                                    <option><?php echo $this->lang->line('PrimarySchool');?></option>
                                </select>
                            </div>
                            <div class="col-md-1"></div>
                    </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-2">
                            <label class="control-label"><?php echo $this->lang->line('CourseDescription');?>:</label>
                        </div>
                        <div class="col-md-8">
                            <textarea class="form-control" rows="3" id="cs_info_desc"></textarea>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="form-group">
                <div class="row">
                    <div class="col-md-offset-1 col-md-9">
                        <input type="text" hidden id="cs_info_id" value="">
                        <button type="button"  class="btn green" onclick="modify_course();"><?php echo $this->lang->line('Save');?></button>
                    </div>
                </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    var baseURL = "<?php echo base_url();?>";
    $('#newcourse_menu').addClass('menu-selected');
    function edit_course(self)
    {
        var course_id = self.getAttribute('course_id');
        $("#cs_info_id").val(course_id);
        var tdtag = self.parentNode;
        var trtag = tdtag.parentNode;

        var course_name = trtag.cells[0].innerHTML;
        var course_desc = trtag.cells[1].innerHTML;
        var app_unit = trtag.cells[2].innerHTML;

        jQuery("#cs_modify_name").html(course_name);
        jQuery("#cs_info_desc").html(course_desc);
        jQuery("#cs_info_id").val(course_id);
        jQuery("#course_modify_modal").modal({
            backdrop: 'static',
            keyboard: false
        });
    }
    function modify_course()
    {
        var cs_id = jQuery("#cs_info_id").val();
        var cs_desc = jQuery("#cs_info_desc").val();
        var cs_school_type_name = jQuery("select#cs_modify_school_type_name").val();
        ///ajax into php
        jQuery.ajax({
            type: "post",
            url: baseURL+"admin/ncourses/edit",
            dataType: "json",
            data: {course_id: cs_id,course_desc: cs_desc,course_school_type_name:cs_school_type_name},
            success: function(res) {
                if(res.status=='success') {
                    var table = document.getElementById("courseInfo_tbl");
                    var tbody = table.getElementsByTagName("tbody")[0];
                    tbody.innerHTML = res.data;
                }
                else//failed
                {
                    alert("Cannot modify Course Data.");
                }
            }
        });
        jQuery('#course_modify_modal').modal('toggle');
    }
    $('#add_new_cs_btn').click(function(){
        $('#cs_add_name').val('');
        $('#cs_add_desc').val('');
        $("#course_add_modal").modal({
            backdrop: 'static',
            keyboard: false
        });
    });
    function add_course()
    {
        var cs_name = jQuery('#cs_add_name').val();
        var cs_desc = jQuery('#cs_add_desc').val();
        var cs_school_type_id = jQuery('#cs_add_school_type_name').val();
        jQuery.ajax({
            type: "post",
            url: baseURL+"admin/ncourses/add",
            dataType: "json",
            data: {course_name: cs_name,course_desc: cs_desc,cs_school_type_id:cs_school_type_id},
            success: function(res) {
                if(res.status=='success') {
                    var table = document.getElementById("courseInfo_tbl");
                    var tbody = table.getElementsByTagName("tbody")[0];
                    tbody.innerHTML = res.data;
                    jQuery('#course_add_modal').modal('toggle');
                }
                else//failed
                {
                    alert("Cannot modify Course Data.");
                    jQuery('#course_add_modal').modal('toggle');
                }
            }
        });
    }
    jQuery("#newcourse_search").keyup(function () {
        var input, filter, table, tr, td, i;
        input = document.getElementById("newcourse_search");
        filter = input.value.toUpperCase();
        table = document.getElementById("courseInfo_tbl");
        tr = table.getElementsByTagName("tr");
        // Loop through all table rows, and hide those who don't match the search query
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
</script>


