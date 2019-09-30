<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content" style="min-height: 1305px;">
        <h1 class="page-title">上传介绍视频
            <small></small>
        </h1>
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET -->
                <div class="portlet light bordered">
                    <div class="table-toolbar">
                        <!-------Table tool parts----------------->
                        <div class="row visible-ie8 visible-ie9">
                            <div class="col-md-4">
                                <form action="#" class="form-horizontal">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="col-md-5 control-label"><?php echo $this->lang->line('UnitName'); ?>
                                                :</label>
                                            <div class="col-md-7">
                                                <input type="text" class="form-control" id="unit_name_search"
                                                       placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-4">
                                <form action="#" class="form-horizontal">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="col-md-5 control-label"><?php echo $this->lang->line('keyword'); ?>
                                                :</label>
                                            <div class="col-md-7">
                                                <input type="text" class="form-control" id="keyword_unit_search"
                                                       placeholder="">
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
                                <th><?php echo $this->lang->line('GeneralName'); ?></th>
                                <th><?php echo $this->lang->line('GeneralImage'); ?></th>
                                <th><?php echo $this->lang->line('Operation'); ?></th>
                            </tr>
                            </thead>
                            <tbody><?=$tbl_content?></tbody>
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
<div id="unit_modify_modal" class="modal fade" tabindex="-1" data-width="430">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $this->lang->line('ModifyBannerInfo'); ?></h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" enctype="multipart/form-data" action="" id="unit_edit_submit" role="form"
              method="post" accept-charset="utf-8">
            <div class="form-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-offset-0 col-md-3" style="text-align: right;">
                                <label for="exampleInputFile" id="modal_banner_name"
                                       class="control-label right-aligned">介绍视频
                                    :</label>
                            </div>
                            <div class="col-md-9">
                                <div class="fileinput fileinput-new" data-provides="fileinput"
                                     style="background-color: #e0e1e1;">
                                <span class="btn btn-default btn-file">
                                    <span id="btn_upload_img"><?php echo $this->lang->line('Browse'); ?></span>
                                    <input type="file" id="banner_upload_img"
                                           name="file_name" style="display: none"
                                           accept=".mp4"
                                    />
                                </span>
                                    <span class="fileinput-filename"></span>
                                    <span class="fileinput-new"
                                          id="selectedimagefile"><?php echo $this->lang->line('NoFileSelected'); ?>
                                </span>
                                </div>
                                <script>
                                    document.getElementById("btn_upload_img").onclick = function () {
                                        $('#banner_upload_img').val('');

                                        $('#banner_upload_img').trigger('click');
                                    };
                                    document.getElementById("banner_upload_img").onchange = function () {
                                        var totalStr = this.files[0].name;
                                        var realNameStr = totalStr.split('/');
                                        realNameStr = realNameStr[realNameStr.length - 1];
                                        var type = realNameStr.split('.');
                                        type = type[type.length - 1].toLowerCase();
                                        // if (type != 'jpg' && type != 'jpeg'
                                        //     && type != 'png' && type != 'bmp' && type != 'gif') {
                                        //     alert('图片格式不正确..');
                                        //     return;
                                        // }
                                        if (type != 'mp4') {
                                            alert('视频格式不正确..');
                                            return;
                                        }
                                        $("#selectedimagefile").html(realNameStr);
                                        // upload_image();
                                    };
                                </script>
                                <p class="help-block"><?php echo $this->lang->line('BannerImageUploadDescription'); ?></p>
                            </div>
                        </div>
<!--                        <div class="col-md-7">-->
<!--                            <img style="width:95%;height:auto;"-->
<!--                                 src="--><?php //echo base_url() . 'uploads/' . $items[0]->image ?><!--"-->
<!--                                 class="img-rounded" alt="Image 750x400" id="preview_image">-->
<!--                        </div>-->
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <input type="text" hidden id="unit_id" value=""><!--this is unit_id-->
                            <button type="submit" class="btn green right-floated"
                                    id="unit_save_btn"><?php echo $this->lang->line('Save'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    var baseURL = "<?php echo base_url();?>";

    $('a[menu_id="00"]').addClass('menu-selected');

    function edit_unit(self) {
        var unit_id = self.getAttribute('unit_id');
        $("#unit_id").val(unit_id);
        var nameTag = document.getElementById('itemName' + unit_id);
        var imageTag = document.getElementById('itemImage' + unit_id);

        var banner_name = nameTag.innerHTML;
        var banner_img_name = imageTag.src.split('/');

        $("#modal_banner_name").html(banner_name + ':');
        $("#selectedimagefile").html(banner_img_name[(banner_img_name.length - 1)]);
        $("#preview_image").attr('src', (imageTag.src));
        $("#unit_modify_modal").modal({
            backdrop: 'static',
            keyboard: false
        });
    }

    function upload_image() {
        var preview = document.getElementById('preview_image');
        var file = document.getElementById('banner_upload_img').files[0];
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

    jQuery("#unit_edit_submit").submit(function (e) {
        e.preventDefault();
        var unit_id = jQuery("#unit_id").val();
        var banner_name = jQuery("#modal_banner_name").val();
        var banner_img_name = jQuery("#selectedimagefile").html();
        var banner_desc = banner_name;

        var fdata = new FormData(this);
        fdata.append("unit_id", unit_id);
        fdata.append("banner_name", banner_name);
        fdata.append("banner_img_name", banner_img_name);
        fdata.append("course_id", '0');

        jQuery.ajax({
            url: baseURL + "admin/banner/edit",
            type: "post",
            data: fdata,
            processData: false,
            contentType: false,
            cache: false,
            async: false,
            success: function (res) {
                console.log(res);
                var ret = JSON.parse(res);
                if (ret.status == 'success') {
                    var table = document.getElementById("unitsInfo_tbl");
                    var tbody = table.getElementsByTagName("tbody")[0];
                    tbody.innerHTML = ret.data;
                    //executionPageNation();
                    jQuery('#unit_modify_modal').modal('toggle');
                }
                else//failed
                {
                    alert("请修改介绍视频.");
                }
            },
            error:function(err){
                alert("网络错误:"+JSON.stringify(err));
            }
        });
        /******************************/
    })

</script>



