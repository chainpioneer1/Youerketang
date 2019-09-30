<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content" style="min-height: 1305px;">
        <h1 class="page-title"><?php echo $this->lang->line('sub_panel_title_unit');?>
            <small></small>
        </h1>
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET -->
                <div class="portlet light bordered">
                    <div class="table-toolbar">
                        <!-------Table tool parts----------------->
                        <div class="row">
                            <div class="col-md-4">
                                <form action="#" class="form-horizontal">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="col-md-5 control-label"><?php echo $this->lang->line('UnitName');?>:</label>
                                            <div class="col-md-7">
                                                <input type="text" class="form-control" id = "unit_name_search" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-4">
                                <form action="#" class="form-horizontal">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="col-md-5 control-label"><?php echo $this->lang->line('keyword');?>:</label>
                                            <div class="col-md-7">
                                                <input type="text" class="form-control" id = "keyword_unit_search" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-------Table tool parts----------------->
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover" id="unitsInfo_tbl">
                            <thead>
                            <tr>
                                <th><?php echo $this->lang->line('SerialNumber');?></th>
                                <th><?php echo $this->lang->line('CourseUnit');?></th>
                                <th><?php echo $this->lang->line('CourseName');?></th>
                                <th><?php echo $this->lang->line('ApplicationUnit');?></th>
                                <th><?php echo $this->lang->line('UnitImage');?></th>
                                <th><?php echo $this->lang->line('Operation');?></th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach($units as $unit):?>
                                <tr>
                                    <td><?php echo $unit->unit_id;?></td>
                                    <td><?php echo $unit->unit_type_name;?></td>
                                    <td><?php echo $unit->course_name;?></td>
                                    <td><?php echo $unit->school_type_name;?></td>
                                    <td><img src='<?php echo base_url().$unit->unit_photo;?>' alt="" style="width:200px; height:100px;"></td>
                                    <td>
                                        <button style="width:70px;" class="btn btn-sm btn-success" unit_id ="<?php echo $unit->unit_id;?>" onclick="edit_unit(this)"><?php echo $this->lang->line('Modify');?></button>
                                    </td>
                                </tr>
                               <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET -->
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
<!--Modify Modal --->
<div id="unit_modify_modal" class="modal fade" tabindex="-1" data-width="730">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $this->lang->line('ModifyUnitInfo');?></h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" enctype="multipart/form-data" action="" id = "unit_edit_submit" role="form" method="post" accept-charset="utf-8">
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
                            <select class="form-control" id="unit_modify_school_type_name">
                                <option><?php echo $this->lang->line('PrimarySchool');?></option>
                            </select>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-2">
                            <label class="control-label"><?php echo $this->lang->line('UnitName');?>:</label>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" id="unit_modify_type_name">
                                <option><?php echo $this->lang->line('China');?></option>
                                <option><?php echo $this->lang->line('Western');?></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-2">
                            <label for="exampleInputFile" class="control-label"><?php echo $this->lang->line('UnitImage');?></label>
                        </div>
                        <div class="col-md-3">
                            <div class="fileinput fileinput-new" data-provides="fileinput" style="background-color: #e0e1e1;width: 200px;">
                                <span class="btn btn-default btn-file"><span><?php echo $this->lang->line('Browse');?></span><input type="file" id="unit_upload_img" name = "file_name"  /></span>
                                <span class="fileinput-filename"></span><span class="fileinput-new" id="seletedimagefile"><?php echo $this->lang->line('NoFileSelected');?></span>
                            </div>
                            <script>
                                document.getElementById("unit_upload_img").onchange = function () {
                                    var totalStr = this.value;
                                    var realNameStr = totalStr.substr(12);
                                    document.getElementById("seletedimagefile").textContent = realNameStr;
                                    upload_image();
                                };
                             </script>
                            <p class="help-block"><?php echo $this->lang->line('ImageUploadDescription');?></p>
                        </div>
                        <div class="col-md-1"></div>
                        <div class="col-md-3">
                            <img width="220" height="220" src="<?php echo base_url().'uploads/product-default-300x300.png'?>"  class="img-rounded " alt="Image 300x300" id="preview_image">
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="form-group">
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-1">
                        <input type="text" hidden id="unit_id" value="" ><!--this is unit_id-->
                        <button type="submit"  class="btn green" id="unit_save_btn"><?php echo $this->lang->line('Save');?></button>
                    </div>
                </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    var baseURL = "<?php echo base_url();?>";

    $('#unit_menu').addClass('menu-selected');

    function edit_unit(self)
    {
        var unit_id = self.getAttribute('unit_id');
        $("#unit_id").val(unit_id);
        var tdtag = self.parentNode;
        var trtag = tdtag.parentNode;

        var unit_type_name = trtag.cells[1].innerHTML;
        var unit_cs_name = trtag.cells[2].innerHTML;
        //var unit_image_path = trtag.cells[4].innerHTML;
        //alert(unit_image_path);

        $("#cs_modify_name").html(unit_cs_name);
        $("#unit_modify_modal").modal({
            backdrop: 'static',
            keyboard: false
        });
    }
    function upload_image()
    {
        var preview = document.getElementById('preview_image');
        var file = document.getElementById('unit_upload_img').files[0];
        var reader  = new FileReader();
        reader.onloadend = function () {
            preview.src = reader.result;
        };
        if (file) {
            reader.readAsDataURL(file);//reads the data as a URL
        } else {
            preview.src = "";
        }
    }
    jQuery("#unit_edit_submit").submit(function(e)
    {
        e.preventDefault();
        var unit_id = jQuery("#unit_id").val();
        var unit_type_name = jQuery("select#unit_modify_type_name").val();
        var unit_school_type_name = jQuery("select#unit_modify_school_type_name").val();
        var unit_type_id = jQuery("#unit_info_type_id").val();

        var fdata = new  FormData(this);
        fdata.append("unit_id",unit_id);
        fdata.append("unit_type_name",unit_type_name);
        fdata.append("unit_school_type_name",unit_school_type_name);

        jQuery.ajax({
            url:baseURL+"admin/units/edit",
            type:"post",
            data:fdata,
            processData:false,
            contentType:false,
            cache:false,
            async:false,
            success: function(res){
                var ret = JSON.parse(res);
                if(ret.status=='success') {
                    var table = document.getElementById("unitsInfo_tbl");
                    var tbody = table.getElementsByTagName("tbody")[0];
                    tbody.innerHTML = ret.data;
                    //executionPageNation();
                }
                else//failed
                {
                    alert("Cannot modify Unit Data.");
                }
            }
        });
        jQuery('#unit_modify_modal').modal('toggle');
        /******************************/
    })
    jQuery("#unit_name_search").keyup(function () {

        var input, filter, table, tr, td, i;
        input = document.getElementById("unit_name_search");
        filter = input.value.toUpperCase();
        table = document.getElementById("unitsInfo_tbl");
        tr = table.getElementsByTagName("tr");
        // Loop through all table rows, and hide those who don't match the search query
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
    jQuery("#keyword_unit_search").keyup(function () {///search for keyword
        var input, filter, table, tr, td, i,tdCnt;
        input = document.getElementById("keyword_unit_search");
        filter = input.value.toUpperCase();
        table = document.getElementById("unitsInfo_tbl");
        tr = table.getElementsByTagName("tr");
        // Loop through all table rows, and hide those who don't match the search query
        for (i = 1; i < tr.length; i++) {

            var cmpst = 0;
            for(j=0;j<4;j++)//5 is search filed count
            {
                td = tr[i].getElementsByTagName("td")[j];
                if (td) {
                    if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                        cmpst++;
                    }
                }
            }
            if(cmpst>0)
            {
                tr[i].style.display = "";
            }
            else tr[i].style.display = "none";

        }
    });

</script>



