<style>
    #main_tbl th, td {
        text-align: center;
        vertical-align: middle;
    }

</style>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content" style="min-height: 1305px;">
        <h1 class="page-title"><?php echo $this->lang->line('panel_title_32'); ?>
            <small></small>
        </h1>
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bordered">
                    <div class="table-toolbar">
                        <!-------Table tool parts----------------->
                        <div class="row">
                            <div class="col-md-4 visible-ie8 visible-ie9" style="display: none">
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
                                                <input type="text" class="form-control" id="keyword_search"
                                                       placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-7">
                                <div class="btn-group right-floated">
                                    <button class=" btn blue" onclick="add_item()">
                                        <i class="fa fa-plus"></i>&nbsp&nbsp<?php echo $this->lang->line('add_category'); ?>
                                    </button>
                                </div>
                            </div>
                            <!-------Table tool parts----------------->
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover" id="main_tbl">
                            <thead>
                            <tr>
                                <th><?php echo $this->lang->line('order_number'); ?></th>
                                <th><?php echo $this->lang->line('category'); ?></th>
                                <th><?php echo $this->lang->line('school'); ?></th>
                                <th><?php echo $this->lang->line('corner_icon'); ?></th>
                                <th><?php echo $this->lang->line('icon'); ?></th>
                                <th><?php echo $this->lang->line('hover_effect'); ?></th>
                                <th><?php echo $this->lang->line('usage_status'); ?></th>
                                <th><?php echo $this->lang->line('edit'); ?></th>
                            </tr>
                            </thead>
                            <tbody><?= $tbl_content ?></tbody>
                        </table>
                        <div id="pageNavPos"></div>
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
    <img id="wait_ajax_loader" src='<?php echo base_url('assets/images/ajax-loader.gif'); ?>'/>
    <span style="position: absolute;top: 43%;left: 43%;font-size:18px;color: #fff;z-index: 16000"><?= $this->lang->line('uploading') ?></span>
    <span id="progress_percent">0%</span>
</div>
<!--   edit modal  -->
<div id="item_update_modal" class="modal fade" tabindex="-1" data-width="600">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $this->lang->line('update_category_information'); ?></h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" enctype="multipart/form-data" action="" id="item_edit_submit_form" role="form"
              method="post" accept-charset="utf-8">
            <div class="form-group">
                <label class="col-md-4 control-label"><?php echo $this->lang->line('category_name'); ?>:</label>
                <div class="col-md-8">
                    <input class="form-control input-inline " type="text"
                           name="item_name" value="">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label"><?php echo $this->lang->line('parent_school'); ?>:</label>
                <div class="col-md-8">
                    <select class="form-control input-inline " type="text"
                            name="school_id" value="">
                        <?php
                        $j = 0;
                        foreach ($schools as $unit):
                            echo '<option value="' . $unit->id . '">' . $unit->school_name . '</option>';
                        endforeach
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-3 right-aligned">
                    <label for="cwImageUpload"
                           class="control-label"><?php echo $this->lang->line('upload_corner'); ?>:
                    </label>
                </div>
                <div class="col-md-4">
                    <div class="fileinput fileinput-new" data-provides="fileinput"
                         style="background-color: #e0e1e1;width: 200px;">
                                <span class="btn btn-default btn-file">
                                    <span class="btn_browse_item"
                                          item_type="1"><?php echo $this->lang->line('Browse'); ?></span>
                                    <input type="file"
                                           class="form-control" style="display: none"
                                           name="item_icon_file1"
                                           item_type="1"
                                           accept=".png"/>
                                </span>
                        <div class="fileinput-new" item_name="nameview1">
                            <?php echo $this->lang->line('NoFileSelected'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-5" style="text-align: center;">
                    <div class="img_preview" item_type="1"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-3 right-aligned">
                    <label for="cwImageUpload"
                           class="control-label"><?php echo $this->lang->line('upload_icon'); ?>:
                    </label>
                </div>
                <div class="col-md-4">
                    <div class="fileinput fileinput-new" data-provides="fileinput"
                         style="background-color: #e0e1e1;width: 200px;">
                                <span class="btn btn-default btn-file">
                                    <span class="btn_browse_item"
                                          item_type="2"><?php echo $this->lang->line('Browse'); ?></span>
                                    <input type="file"
                                           class="form-control" style="display: none"
                                           name="item_icon_file2"
                                           item_type="2"
                                           accept=".png"/>
                                </span>
                        <div class="fileinput-new" item_name="nameview2">
                            <?php echo $this->lang->line('NoFileSelected'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-5" style="text-align: center;">
                    <div class="img_preview" item_type="2"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-3 right-aligned">
                    <label for="cwImageUpload"
                           class="control-label"><?php echo $this->lang->line('hover_effect'); ?>:
                    </label>
                </div>
                <div class="col-md-4">
                    <div class="fileinput fileinput-new" data-provides="fileinput"
                         style="background-color: #e0e1e1;width: 200px;">
                                <span class="btn btn-default btn-file">
                                    <span class="btn_browse_item"
                                          item_type="3"><?php echo $this->lang->line('Browse'); ?></span>
                                    <input type="file"
                                           class="form-control" style="display: none"
                                           name="item_icon_file3"
                                           item_type="3"
                                           accept=".png"/>
                                </span>
                        <div class="fileinput-new" item_name="nameview3">
                            <?php echo $this->lang->line('NoFileSelected'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-5" style="text-align: center;">
                    <div class="img_preview" item_type="3"></div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn green" onclick="update_perform(this);"
                id="update_perform"><?php echo $this->lang->line('save'); ?></button>
    </div>
</div>
<!----publish modal-->
<div id="item_publish_modal" class="modal fade" tabindex="-1" data-width="300">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $this->lang->line('message'); ?></h4>
    </div>
    <div class="modal-body" style="text-align:center;">
        <h4 class="modal-title"></h4>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn green" onclick="publish_perform(this);"
                id="publish_perform"><?php echo $this->lang->line('ok'); ?></button>
    </div>
</div>
<!----------pagenation-------->
<script type="text/javascript">
    var site_id = 1;
    var menu_id = "32";
    $('a.nav-link[menu_id=' + menu_id + ']').addClass('menu-selected');

    var prevstr = "<?php echo $this->lang->line('PrevPage');?>";
    var nextstr = "<?php echo $this->lang->line('NextPage');?>";
    var currentShowedPage = 1;
    var showedItems = <?=$this->lang->line('records_per_page')?>;

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

        };

        this.showPage = function (pageNumber) {
            if (!this.inited) {
                alert("not inited");
                return;
            }
            this.showPageNav('pager', 'pageNavPos');
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
        };

        this.prev = function () {
            if (this.currentPage > 1) {

                currentShowedPage = this.currentPage - 1;
                this.showPage(this.currentPage - 1);
            }
        };

        this.next = function () {
            if (this.currentPage < this.pages) {
                currentShowedPage = this.currentPage + 1;
                this.showPage(this.currentPage + 1);
            }
        };

        this.init = function () {
            var rows = document.getElementById(tableName).rows;
            var records = (rows.length - 1);
            this.pages = Math.ceil(records / itemsPerPage);
            this.inited = true;
        };

        this.showPageNav = function (pagerName, positionId) {
            if (!this.inited) {
                alert("not inited");
                return;
            }
            var element = document.getElementById(positionId);

            var pagerHtml = '<button class = "btn btn blue pg-normal" onclick="' + pagerName + '.prev();">' + prevstr + '</button>  ';
            pagerHtml += '<span class="pagination-num">第' + currentShowedPage + '页  ( 共' + this.pages + '页 )</span>';
            for (var page = 1; page <= this.pages; page++)
                pagerHtml += '<button hidden id="pg' + page + '" class="pg-normal" onclick="' + pagerName + '.showPage(' + page + ');">' + page + '</button>  ';
            pagerHtml += '<button  class = "btn btn blue pg-normal" onclick="' + pagerName + '.next();">' + nextstr + '</button>';

            element.innerHTML = pagerHtml;
        };
    }

    var pager = new Pager('main_tbl', showedItems);
    pager.init();
    pager.showPage(currentShowedPage);

    function executionPageNation() {
        var pager = new Pager('main_tbl', showedItems);
        pager.init();
        pager.showPage(currentShowedPage);
    }

    //-->
</script>
<!---------pagenation module--------->
<script>

    function add_item() {
        var item_id = '';
        var item_name = '';
        var school_id = '1';
        var image_corner = '<?php echo $this->lang->line('NoFileSelected'); ?>';
        var image_icon = '<?php echo $this->lang->line('NoFileSelected'); ?>';
        var image_icon_hover = '<?php echo $this->lang->line('NoFileSelected'); ?>';

        $('input[type=file]').val('');

        $('#item_update_modal').find('select[name=school_id]').val(school_id);
        $('#item_update_modal').find('.modal-body form input[name=item_name]').val(item_name);

        $('div .img_preview[item_type=1]').css({background: 'url(' + image_corner + ')'});
        $('div .img_preview[item_type=2]').css({background: 'url(' + image_icon + ')'});
        $('div .img_preview[item_type=3]').css({background: 'url(' + image_icon_hover + ')'});

        $('div[item_name=nameview1]').html(getFilenameFromURL(image_corner));
        $('div[item_name=nameview2]').html(getFilenameFromURL(image_icon));
        $('div[item_name=nameview3]').html(getFilenameFromURL(image_icon_hover));

        $("#update_perform").attr("item_id", item_id);
        $("#update_perform").attr("onclick", 'update_perform(this);');

        var msg_title = $('#item_update_modal').find('.modal-header h4');
        msg_title.html('<?= $this->lang->line('add_category'); ?>');

        $("#item_update_modal").modal({
            backdrop: 'static',
            keyboard: false
        });
    }

    function update_item(self) {
        var item_id = self.getAttribute("item_id");
        var item_name = self.getAttribute("item_name");
        var school_id = self.getAttribute('item_school');
        var image_corner = $('.image_corner[item_id=' + item_id + ']').attr('src');
        var image_icon = $('.image_icon[item_id=' + item_id + ']').attr('src');
        var image_icon_hover = $('.image_icon_hover[item_id=' + item_id + ']').attr('src');

        $('input[type=file]').val('');

        $('#item_update_modal').find('select[name=school_id]').val(school_id);
        $('#item_update_modal').find('.modal-body form input[name=item_name]').val(item_name);

        $('div .img_preview[item_type=1]').css({background: 'url(' + image_corner + ')'});
        $('div .img_preview[item_type=2]').css({background: 'url(' + image_icon + ')'});
        $('div .img_preview[item_type=3]').css({background: 'url(' + image_icon_hover + ')'});

        if (image_corner == '') image_corner = '<?=$this->lang->line('NoFileSelected')?>';
        if (image_icon == '') image_icon = '<?=$this->lang->line('NoFileSelected')?>';
        if (image_icon_hover == '') image_icon_hover = '<?=$this->lang->line('NoFileSelected')?>';

        $('div[item_name=nameview1]').html(getFilenameFromURL(image_corner));
        $('div[item_name=nameview2]').html(getFilenameFromURL(image_icon));
        $('div[item_name=nameview3]').html(getFilenameFromURL(image_icon_hover));

        $("#update_perform").attr("item_id", item_id);
        $("#update_perform").attr("onclick", 'update_perform(this);');

        var msg_title = $('#item_update_modal').find('.modal-header h4');
        msg_title.html('<?= $this->lang->line('update_category_information'); ?>');

        $("#item_update_modal").modal({
            backdrop: 'static',
            keyboard: false
        });
    }

    function update_perform(self) {
        var item_id = self.getAttribute("item_id");
        $(this).attr("onclick", '');

        $(".uploading_backdrop").show();
        $(".progressing_area").show();
        var submit_form = document.getElementById('item_edit_submit_form');
        var fdata = new FormData(submit_form);
        fdata.append("item_id", item_id);
        $.ajax({
            url: baseURL + "admin/contents/update_category",
            type: "POST",
            data: fdata,
            contentType: false,
            cache: false,
            processData: false,
            async: true,
            xhr: function () {
                //upload Progress
                var xhr = $.ajaxSettings.xhr();
                if (xhr.upload) {
                    xhr.upload.addEventListener('progress', function (event) {
                        var percent = 0;
                        var position = event.loaded || event.position;
                        var total = event.total;
                        if (event.lengthComputable) {
                            percent = Math.ceil(position / total * 100);
                        }
                        $("#progress_percent").text(percent + '%');

                    }, true);
                }
                return xhr;
            },
            mimeType: "multipart/form-data"
        }).done(function (res) { //
            var ret;
            try {
                ret = JSON.parse(res);
            } catch (e) {
                $(".uploading_backdrop").hide();
                $(".progressing_area").hide();
                alert('Operation failed : ' + e);
                console.log(e);
                return;
            }
            if (ret.status == 'success') {
                var table = document.getElementById("main_tbl");
                var tbody = table.getElementsByTagName("tbody")[0];
                tbody.innerHTML = ret.data;
                executionPageNation();
                $(".uploading_backdrop").hide();
                $(".progressing_area").hide();
                $('#item_update_modal').modal('toggle');
            }
            else//failed
            {
                alert('Operation failed : ' + ret.data);
                $(".uploading_backdrop").hide();
                $(".progressing_area").hide();
                // jQuery('#ncw_edit_modal').modal('toggle');
                // alert(ret.data);
            }
        });
    }

    function publish_item(self) {
        var item_id = self.getAttribute("item_id");
        var item_status = self.getAttribute("item_status");
        var msg_body = $('#item_publish_modal').find('.modal-body h4');
        if (item_status == '0')
            msg_body.html('<?= $this->lang->line('publish_category_confirm'); ?>');
        else
            msg_body.html('<?= $this->lang->line('unpublish_category_confirm'); ?>');
        $("#publish_perform").attr("item_id", item_id);
        $("#publish_perform").attr("item_status", self.innerHTML.trim());
        $("#item_publish_modal").modal({
            backdrop: 'static',
            keyboard: false
        });
    }

    function publish_perform(self) {

        var item_id = self.getAttribute("item_id");
        var publish = "<?php echo $this->lang->line('enable');?>";
        var curBtnText = self.getAttribute("item_status");
        var pub_st = '1';
        if (publish != curBtnText) pub_st = '0';

        ///ajax process for publish/unpublish
        $.ajax({
            type: "post",
            url: baseURL + "admin/contents/publish_category",
            dataType: "json",
            data: {item_id: item_id, publish_state: pub_st, site_id:site_id},
            success: function (res) {
                if (res.status == 'success') {
                    var table = document.getElementById("main_tbl");
                    var tbody = table.getElementsByTagName("tbody")[0];
                    tbody.innerHTML = res.data;
                    executionPageNation();
                    $('#item_publish_modal').modal('toggle');
                    console.log('category publish has been successed!')
                }
                else//failed
                {
                    alert("Cannot change category status.");
                }
            }
        });
    }

    jQuery("#keyword_search").keyup(function () {///search for keyword
        var filter;
        filter = this.value.toUpperCase();
        search_action(filter);
    });

    $("#area_search").on('change', function () {///search for area
        var input, filter, area_txt;
        input = document.getElementById('keyword_search');
        filter = input.value.toUpperCase();
        area_txt = $(this).val().toUpperCase();
        search_action(filter, area_txt);
    });

    function search_action(keyword, txt1, txt2, txt3) {
        if (txt1 == undefined) txt1 = '';
        if (txt2 == undefined) txt2 = '';
        if (txt3 == undefined) txt3 = '';

        var table = document.getElementById("main_tbl");
        var tr = table.getElementsByTagName("tr");
        // Loop through all table rows, and hide those who don't match the search query
        if (tr.length < 2) return;
        for (i = 1; i < tr.length; i++) {

            var cmpst = 0;
            for (j = 0; j < 2; j++)//5 is search filed count
            {
                var td = tr[i].getElementsByTagName("td")[j];
                if (td) {
                    var txt = td.innerHTML.toUpperCase();
                    if (txt != '' && txt.indexOf(keyword) > -1) cmpst++;
                }
            }
            if (cmpst > 0) {
                if (txt1 != '' && tr[i].getElementsByTagName("td")[4].innerHTML.toUpperCase() != txt1)
                    tr[i].style.display = "none";
                else if (txt2 != '' && tr[i].getElementsByTagName("td")[3].innerHTML.toUpperCase() != txt2)
                    tr[i].style.display = "none";
                else if (txt3 != '' && tr[i].getElementsByTagName("td")[6].innerHTML.toUpperCase() != txt3)
                    tr[i].style.display = "none";
                else
                    tr[i].style.display = "";
            }
            else tr[i].style.display = "none";
        }
        if (keyword == '' && txt1 == '' && txt2 == '' && txt3 == '')
            executionPageNation();
    }

    $('.btn_browse_item').on('click', function () {
        var item_type = $(this).attr('item_type');
        $('input[name=item_icon_file' + item_type + ']').val('');
        $('input[name=item_icon_file' + item_type + ']').trigger('click');
    });

    $('input[type=file]').on('change', function () {
        var item_type = $(this).attr('item_type');
        var totalStr = this.files[0].name;
        var realNameStr = getFilenameFromURL(totalStr);
        type = getFiletypeFromURL(realNameStr);
        if (type != 'jpg' && type != 'jpeg'
            && type != 'png' && type != 'bmp' && type != 'gif') {
            alert('图片格式不正确..');
            return;
        }
        $('div[item_name=nameview' + item_type + ']').html(realNameStr);
        preview_image(item_type, this.files[0]);
    });

    function preview_image(item_type, file) {
        var previewer = $('div .img_preview[item_type=' + item_type + ']');
        var reader = new FileReader();
        reader.onloadend = function () {
            previewer.css({
                background: 'url(' + reader.result + ')'
            })
        };
        if (file) {
            reader.readAsDataURL(file);//reads the data as a URL
        } else {
            previewer.css({
                background: '#f0f0f0'
            })
        }
    }

</script>



