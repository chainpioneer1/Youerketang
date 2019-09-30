<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content" style="min-height: 1305px;">
        <h1 class="page-title"><?php echo $this->lang->line('sub_panel_title_course');?>
            <small></small>
        </h1>
        <div class="row">
            <div class="col-md-9">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bordered">
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
    $('#course_menu').addClass('menu-selected');
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
            url: baseURL+"admin/courses/edit",
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
</script>


