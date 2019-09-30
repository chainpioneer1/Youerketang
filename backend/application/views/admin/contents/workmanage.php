<?php
$ctrlRoot = 'admin/questions';
$category = '激活码';
$mainModel = 'tbl_problem_set';
?>
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
        <h1 class="page-title">
            <?php echo $this->lang->line('panel_title_35'); ?>
            <small></small>
        </h1>
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bordered">
                    <div class="table-toolbar">
                        <!-------Table tool parts----------------->
                        <div class="row">
                            <div class="col-md-4">
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

                            <div class="col-md-3">
                                <form action="#" class="form-horizontal">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <select class="form-control" id="package_search"
                                                        onchange="search_action();">
                                                    <option value=""><?php echo $this->lang->line('search_course'); ?></option>
                                                    <?php
                                                    $j = 0;
                                                    foreach ($packages as $unit):
                                                        $j++;
                                                        echo '<option value="' . $unit->name . '" '
                                                            . ' item_id="' . $unit->id . '">'
                                                            . $unit->name . '</option>';
                                                    endforeach
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-3">
                                <form action="#" class="form-horizontal">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <select class="form-control" id="problem_search"
                                                        onchange="search_action();">
                                                    <option value=""><?php echo $this->lang->line('search_problems'); ?></option>
                                                    <?php
                                                    $type_str = [
                                                        $this->lang->line('problem_option'),
                                                        $this->lang->line('problem_yesno'),
                                                        $this->lang->line('problem_norecog'),
                                                        $this->lang->line('problem_recog')
                                                    ];
                                                    for ($j = 0; $j < count($type_str); $j++) {
                                                        echo '<option value="' . $type_str[$j] . '">'
                                                            . $type_str[$j] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-12">
                                <div class="btn-group right-floated">
                                    <button class=" btn blue" onclick="add_item()">
                                        <i class="fa fa-plus"></i>&nbsp&nbsp<?php echo $this->lang->line('add_new'); ?>
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
                                <th><?php echo $this->lang->line('problem_title'); ?></th>
                                <th><?php echo $this->lang->line('problem_type'); ?></th>
                                <th><?php echo $this->lang->line('course'); ?></th>
                                <th><?php echo $this->lang->line('site'); ?></th>
                                <th><?php echo $this->lang->line('operation'); ?></th>
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
        <h3 class="modal-title"></h3>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" enctype="multipart/form-data" action="" id="item_edit_submit_form" role="form"
              method="post" accept-charset="utf-8">
            <div class="form-group">
                <label class="col-md-2 control-label"><?php echo $this->lang->line('problem_title'); ?>:</label>
                <div class="col-md-4">
                    <input class="form-control input-inline" type="text"
                           name="prob_name" value="">
                </div>
                <label class="col-md-2 control-label"><?php echo $this->lang->line('parent_project'); ?>:</label>
                <div class="col-md-4">
                    <label class="form-control"
                           style="border:none;"><?php echo $this->lang->line('frontend_title'); ?></label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label"><?php echo $this->lang->line('parent_lesson'); ?>:</label>
                <div class="col-md-4">
                    <select class="form-control input-inline " type="text"
                            name="package_id" value="">
                        <?php
                        $j = 0;
                        foreach ($packages as $unit):
                            echo '<option value="' . $unit->id . '">'
                                . $unit->name . '</option>';
                        endforeach
                        ?>
                    </select>
                </div>
                <label class="col-md-2 control-label"><?php echo $this->lang->line('order_number'); ?>:</label>
                <div class="col-md-3">
                    <input class="form-control input-inline " type="text" style="width:100%;"
                           name="sort_num" value="">
                </div>
            </div>
            <h4 style="border-bottom:1px solid #e5e5e5;"></h4>
            <div class="form-group">
                <label class="col-md-2 control-label"><?php echo $this->lang->line('problem_type'); ?>:</label>
                <div class="col-md-4">
                    <select class="form-control input-inline " type="text"
                            name="prob_type" value="">
                        <?php
                        $type_str = [
                            $this->lang->line('problem_option'),
                            $this->lang->line('problem_yesno'),
                            $this->lang->line('problem_norecog'),
                            $this->lang->line('problem_recog')
                        ];
                        for ($j = 0; $j < count($type_str); $j++) {
                            echo '<option value="' . ($j+1) . '">'
                                . $type_str[$j] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <label class="col-md-2 control-label" item_type="select"><?php echo $this->lang->line('problem_answer'); ?>:</label>
                <div class="col-md-4" item_type="select">
                    <select class="form-control input-inline " type="text"
                            name="prob_answer" value="">
                        <option value="1" item_type="2">A</option>
                        <option value="2" item_type="2">B</option>
                        <option value="3" item_type="1">C</option>
                        <option value="4" item_type="1">D</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-3 right-aligned">
                    <label for="cwImageUpload"
                           class="col-md-8 control-label"><?php echo $this->lang->line('problem_material'); ?>:
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
                                           name="prob_img"
                                           item_type="1"
                                           accept=".png,.jpg,.bmp,.gif"/>
                                </span>
                        <div class="fileinput-new" item_name="nameview1">
                            <?php echo $this->lang->line('NoFileSelected'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 right-aligned">
                    <label for="cwImageUpload"
                           class="col-md-8 control-label">(图片)
                    </label>
                </div>
            </div> <!-- problem image  -->
            <div class="form-group">
                <div class="col-md-3 right-aligned"><label for="cwImageUpload" class="control-label"></label></div>
                <div class="col-md-4">
                    <div class="fileinput fileinput-new" data-provides="fileinput"
                         style="background-color: #e0e1e1;width: 200px;">
                                <span class="btn btn-default btn-file">
                                    <span class="btn_browse_item"
                                          item_type="2"><?php echo $this->lang->line('Browse'); ?></span>
                                    <input type="file"
                                           class="form-control" style="display: none"
                                           name="prob_sound"
                                           item_type="2"
                                           accept="audio/mp3"/>
                                </span>
                        <div class="fileinput-new" item_name="nameview2">
                            <?php echo $this->lang->line('NoFileSelected'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 right-aligned">
                    <label for="cwImageUpload"
                           class="col-md-8 control-label">(音频)
                    </label>
                </div>
            </div> <!-- problem sound  -->
            <div class="problem_answer" item_type="1" style="display: block;">
                <div class="form-group">
                    <div class="col-md-3 right-aligned">
                        <label for="cwImageUpload"
                               class="col-md-8 control-label"><?php echo $this->lang->line('problem_select'); ?>:
                        </label>
                        <label for="cwImageUpload"
                               class="col-md-4 control-label">A:
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
                                           name="ans_img1"
                                           item_type="3"
                                           accept=".png,.jpg,.bmp,.gif"/>
                                </span>
                            <div class="fileinput-new" item_name="nameview3">
                                <?php echo $this->lang->line('NoFileSelected'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 right-aligned">
                        <label for="cwImageUpload"
                               class="col-md-8 control-label">(图片)
                        </label>
                    </div>
                </div> <!-- answer image1  -->
                <div class="form-group">
                    <div class="col-md-3 right-aligned">
                        <label for="cwImageUpload"
                               class="col-md-8 control-label">
                        </label>
                        <label for="cwImageUpload"
                               class="col-md-4 control-label">B:
                        </label>
                    </div>
                    <div class="col-md-4">
                        <div class="fileinput fileinput-new" data-provides="fileinput"
                             style="background-color: #e0e1e1;width: 200px;">
                                <span class="btn btn-default btn-file">
                                    <span class="btn_browse_item"
                                          item_type="4"><?php echo $this->lang->line('Browse'); ?></span>
                                    <input type="file"
                                           class="form-control" style="display: none"
                                           name="ans_img2"
                                           item_type="4"
                                           accept=".png,.jpg,.bmp,.gif"/>
                                </span>
                            <div class="fileinput-new" item_name="nameview4">
                                <?php echo $this->lang->line('NoFileSelected'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 right-aligned">
                        <label for="cwImageUpload"
                               class="col-md-8 control-label">(图片)
                        </label>
                    </div>
                </div> <!-- answer image2  -->
                <div class="form-group">
                    <div class="col-md-3 right-aligned">
                        <label for="cwImageUpload"
                               class="col-md-8 control-label">
                        </label>
                        <label for="cwImageUpload"
                               class="col-md-4 control-label">C:
                        </label>
                    </div>
                    <div class="col-md-4">
                        <div class="fileinput fileinput-new" data-provides="fileinput"
                             style="background-color: #e0e1e1;width: 200px;">
                                <span class="btn btn-default btn-file">
                                    <span class="btn_browse_item"
                                          item_type="5"><?php echo $this->lang->line('Browse'); ?></span>
                                    <input type="file"
                                           class="form-control" style="display: none"
                                           name="ans_img3"
                                           item_type="5"
                                           accept=".png,.jpg,.bmp,.gif"/>
                                </span>
                            <div class="fileinput-new" item_name="nameview5">
                                <?php echo $this->lang->line('NoFileSelected'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 right-aligned">
                        <label for="cwImageUpload"
                               class="col-md-8 control-label">(图片)
                        </label>
                    </div>
                </div> <!-- answer image3  -->
                <div class="form-group">
                    <div class="col-md-3 right-aligned">
                        <label for="cwImageUpload"
                               class="col-md-8 control-label">
                        </label>
                        <label for="cwImageUpload"
                               class="col-md-4 control-label">D:
                        </label>
                    </div>
                    <div class="col-md-4">
                        <div class="fileinput fileinput-new" data-provides="fileinput"
                             style="background-color: #e0e1e1;width: 200px;">
                                <span class="btn btn-default btn-file">
                                    <span class="btn_browse_item"
                                          item_type="6"><?php echo $this->lang->line('Browse'); ?></span>
                                    <input type="file"
                                           class="form-control" style="display: none"
                                           name="ans_img4"
                                           item_type="6"
                                           accept=".png,.jpg,.bmp,.gif"/>
                                </span>
                            <div class="fileinput-new" item_name="nameview6">
                                <?php echo $this->lang->line('NoFileSelected'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 right-aligned">
                        <label for="cwImageUpload"
                               class="col-md-8 control-label">(图片)
                        </label>
                    </div>
                </div> <!-- answer image4  -->
            </div>
            <div class="problem_answer" item_type="2" style="display: none;">
                <div class="form-group">
                    <div class="col-md-3 right-aligned">
                        <label for="cwImageUpload"
                               class="col-md-8 control-label"><?php echo $this->lang->line('problem_select'); ?>:
                        </label>
                        <label for="cwImageUpload"
                               class="col-md-4 control-label">A:
                        </label>
                    </div>
                    <div class="col-md-3 right-aligned">
                        <label for="cwImageUpload"
                               class="col-md-8 control-label">V
                        </label>
                    </div>
                </div> <!-- answer image1  -->
                <div class="form-group">
                    <div class="col-md-3 right-aligned">
                        <label for="cwImageUpload"
                               class="col-md-8 control-label">
                        </label>
                        <label for="cwImageUpload"
                               class="col-md-4 control-label">B:
                        </label>
                    </div>
                    <div class="col-md-3 right-aligned">
                        <label for="cwImageUpload"
                               class="col-md-8 control-label">X
                        </label>
                    </div>
                </div> <!-- answer image2  -->
            </div>
            <div class="problem_answer" item_type="4" style="display: none;">
                <div class="form-group">
                    <div class="col-md-3 right-aligned">
                        <label for="cwImageUpload"
                               class="col-md-12 control-label"><?php echo $this->lang->line('problem_recognition_content'); ?>:
                        </label>
                    </div>
                    <div class="col-md-8">
                        <textarea name="ans_txt" style="max-width: 100%;min-width: 100%;width:100%; min-height:50px;"></textarea>
                    </div>
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
<!----delete modal-->
<div id="item_delete_modal" class="modal fade" tabindex="-1" data-width="300">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $this->lang->line('message'); ?></h4>
    </div>
    <div class="modal-body" style="text-align:center;">
        <h4 class="modal-title"><?php echo $this->lang->line('delete_confirm'); ?></h4>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn green" onclick="delete_perform(this);"
                id="delete_perform"><?php echo $this->lang->line('yes'); ?></button>
        <button type="button" class="btn green" onclick="$('#item_delete_modal').modal('toggle');">
            <?php echo $this->lang->line('no'); ?></button>
    </div>
</div>
<!----------pagenation-------->
<script type="text/javascript">
    var site_id = 1;
    var menu_id = "33";
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
        var image_icon = '';
        var course_path = '';
        $('input[type="file"]').val('');

        $('#item_update_modal').find('.modal-body form input[name=item_name]').val(item_name);

        $('div .img_preview[item_type=4]').css({background: 'url(' + image_icon + ')'});

        if (image_icon == '') image_icon = '<?=$this->lang->line('NoFileSelected')?>';
        if (course_path == '') course_path = '<?=$this->lang->line('NoFileSelected')?>';

        $('div[item_name=nameview4]').html(getFilenameFromURL(image_icon));
        $('div[item_name=nameview5]').html(getFilenameFromURL(course_path));

        $("#update_perform").attr("item_id", item_id);
        $("#update_perform").attr("onclick", 'update_perform(this);');

        var msg_title = $('#item_update_modal').find('.modal-header h3');
        msg_title.html('<?= $this->lang->line('add_problem'); ?>');
        $('select[name="prob_type"]').val('1');
        $('select[name="prob_type"]').trigger('change');
        $("#item_update_modal").modal({
            backdrop: 'static',
            keyboard: false
        });
    }

    function getFileName(path){
        if(path=='' || path==null || path==undefined)
            return '<?=$this->lang->line('NoFileSelected')?>'
        path = path.split('/');
        return path[path.length-1];
    }

    function update_item(self) {
        var item_id = self.getAttribute("item_id");
        var item_info = JSON.parse(self.getAttribute('item_info'));
        console.log(item_info);
        $('input[type="file"]').val('');

        $('#item_update_modal').find('.modal-body form input[name=prob_name]').val(item_info.prob_name);
        $('#item_update_modal').find('.modal-body form input[name=sort_num]').val(item_info.sort_num);
        $('#item_update_modal').find('.modal-body form select[name=package_id]').val(item_info.package_id);
        $('#item_update_modal').find('.modal-body form select[name=prob_type]').val(item_info.prob_type);
        $('#item_update_modal').find('.modal-body form select[name=prob_answer]').val(item_info.prob_answer);
        $('#item_update_modal').find('.modal-body form div[item_name=nameview1]').html(getFileName(item_info.prob_img));
        $('#item_update_modal').find('.modal-body form div[item_name=nameview2]').html(getFileName(item_info.prob_sound));
        $('#item_update_modal').find('.modal-body form div[item_name=nameview3]').html(getFileName(item_info.ans_img1));
        $('#item_update_modal').find('.modal-body form div[item_name=nameview4]').html(getFileName(item_info.ans_img2));
        $('#item_update_modal').find('.modal-body form div[item_name=nameview5]').html(getFileName(item_info.ans_img3));
        $('#item_update_modal').find('.modal-body form div[item_name=nameview6]').html(getFileName(item_info.ans_img4));
        $('#item_update_modal').find('.modal-body form textarea[name="ans_txt"]').val(item_info.ans_txt);

        $('#item_update_modal').find('.modal-body form select[name=prob_type]').trigger('change');
//        if (image_icon == '') image_icon = '<?//=$this->lang->line('NoFileSelected')?>//';
//        if (course_path == '') course_path = '<?//=$this->lang->line('NoFileSelected')?>//';

        $("#update_perform").attr("item_id", item_id);
        $("#update_perform").attr("onclick", 'update_perform(this);');

        var msg_title = $('#item_update_modal').find('.modal-header h3');
        msg_title.html('<?= $this->lang->line('update_problem'); ?>');

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
        fdata.append("site_id", '1');
        fdata.append("item_id", item_id);
        $.ajax({
            url: baseURL + "admin/questions/update_problem",
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
            console.log(res);
            try {
                ret = JSON.parse(res);
            } catch (e) {
                $(".uploading_backdrop").hide();
                $(".progressing_area").hide();
                alert('Operation failed : ' + e.message);
                console.log(e.message);
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
//        if (!self.parentElement.parentElement.children[2].children[0].children[0].getAttribute('src')
//            || !self.parentElement.parentElement.children[3].innerHTML) {
//            if (item_status == '0') {
//                alert("<?//= $this->lang->line('publish_icon_package'); ?>//");
//                return;
//            }
//        }
        var msg_body = $('#item_publish_modal').find('.modal-body h4');
        if (item_status == '0')
            msg_body.html('<?= $this->lang->line('publish_confirm'); ?>');
        else
            msg_body.html('<?= $this->lang->line('unpublish_confirm'); ?>');
        $("#publish_perform").attr("item_id", item_id);
        $("#publish_perform").attr("item_status", self.innerHTML.trim());
        $("#publish_perform").attr("onclick", 'publish_perform(this)');
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
            url: baseURL + "admin/questions/publish_problem",
            dataType: "json",
            data: {item_id: item_id, publish_state: pub_st, site_id: site_id},
            success: function (res) {
                if (res.status == 'success') {
                    var table = document.getElementById("main_tbl");
                    var tbody = table.getElementsByTagName("tbody")[0];
                    tbody.innerHTML = res.data;
                    executionPageNation();
                    $('#item_publish_modal').modal('toggle');
                    console.log('publish has been successed!')
                }
                else//failed
                {
                    alert("Cannot change publish status.");
                }
            }
        });
    }

    function delete_item(self) {
        var item_id = self.getAttribute("item_id");
        $("#delete_perform").attr("item_id", item_id);
        $("#item_delete_modal").modal({
            backdrop: 'static',
            keyboard: false
        });
    }

    function delete_perform(self) {
        var item_id = $(self).attr("item_id");
        jQuery.ajax({
            type: "post",
            url: baseURL + "admin/questions/delete_problem",
            dataType: "json",
            data: {item_id: item_id, site_id: site_id},
            success: function (res) {
                if (res.status == 'success') {
                    var table = document.getElementById("main_tbl");
                    var tbody = table.getElementsByTagName("tbody")[0];
                    tbody.innerHTML = res.data;
                    executionPageNation();
                    $('#item_delete_modal').modal('toggle');
                }
                else//failed
                {
                    alert("Cannot delete Course Item.");
                }
            }
        });
    }

    function update_order(self, step) {

        var item_id = self.getAttribute("item_id");
        var item_order = self.getAttribute("item_order");


        var table = document.getElementById("main_tbl");
        var tr = table.getElementsByTagName("tr");
        var target_order = parseInt(item_order);
        var btn_target;
        var isExist = false;
        for (var i = 0; i < 10; i++) {
            target_order += step;
            btn_target = $('button.btn_order_control[item_order=' + target_order + ']');
            if (btn_target.length != 0) {
                isExist = true;
                break;
            }
        }
        if (!isExist) return;

        var target_id = btn_target.attr('item_id');

        var write_info = [
            {id: item_id, sort_order: target_order},
            {id: target_id, sort_order: item_order}
        ];

        $.ajax({
            type: "post",
            url: baseURL + "admin/questions/update_expand_order",
            dataType: "json",
            data: {data: write_info, site_id: site_id},
            success: function (res) {
                if (res.status == 'success') {
                    var table = document.getElementById("main_tbl");
                    var tbody = table.getElementsByTagName("tbody")[0];
                    tbody.innerHTML = res.data;
                    executionPageNation();
                    console.log('Changing order has been successed!')
                }
                else//failed
                {
                    alert("Cannot change order status.");
                }
            }
        });
    }

    $("#keyword_search").keyup(function () {///search for keyword
        search_action();
    });

    $("#school_search").on('change', function () {///search for area
        search_action();
    });

    $("#category_search").on('change', function () {///search for area
        search_action();
    });

    $("#lesson_search").on('change', function () {
        search_action();
    });

    function search_action() {

        var keyword = $('#keyword_search').val();
        var txt1 = $('#package_search').val();
        var txt2 = $('#problem_search').val();
        var txt3 = '';//$('#lesson_search').val();

        if (keyword != '') keyword = keyword.toUpperCase();
        if (txt1 != '') txt1 = txt1.toUpperCase();
        if (txt2 != '') txt2 = txt2.toUpperCase();
        if (txt3 != '') txt3 = txt3.toUpperCase();

        var table = document.getElementById("main_tbl");
        var tr = table.getElementsByTagName("tr");
        // Loop through all table rows, and hide those who don't match the search query
        if (tr.length < 2) return;
        for (var i = 1; i < tr.length; i++) {

            var cmpst = 0;
            for (var j = 0; j < 4; j++)//5 is search filed count
            {
                var td = tr[i].getElementsByTagName("td")[j];
                if (td) {
                    var txt = td.innerHTML.toUpperCase();
                    if (txt != '' && txt.indexOf(keyword) > -1) cmpst++;
                }
            }
            if (cmpst > 0) {
                if (txt1 != '' && tr[i].getElementsByTagName("td")[3].innerHTML.toUpperCase() != txt1)
                    tr[i].style.display = "none";
                else if (txt2 != '' && tr[i].getElementsByTagName("td")[2].innerHTML.toUpperCase() != txt2)
                    tr[i].style.display = "none";
                else if (txt3 != '' && tr[i].getElementsByTagName("td")[4].innerHTML.toUpperCase() != txt3)
                    tr[i].style.display = "none";
                else
                    tr[i].style.display = "";
            }
            else tr[i].style.display = "none";
        }
        if (keyword == '' && txt1 == '' && txt2 == '' && txt3 == '')
            executionPageNation();
    }

    $('select[name="prob_type"]').change(function () {
        var type = $(this).val();
        switch(type){
            case '1':
                $('label[item_type="select"]').show();
                $('div[item_type="select"]').show();
                $('option[item_type="1"]').show();
                $('.problem_answer').hide();
                $('.problem_answer[item_type="1"]').show();
                break;
            case '2':
                $('label[item_type="select"]').show();
                $('div[item_type="select"]').show();
                $('option[item_type="1"]').hide();
                $('.problem_answer').hide();
                $('.problem_answer[item_type="2"]').show();
                break;
            case '3':
                $('label[item_type="select"]').hide();
                $('div[item_type="select"]').hide();
                $('.problem_answer').hide();
                break;
            case '4':
                $('label[item_type="select"]').hide();
                $('div[item_type="select"]').hide();
                $('.problem_answer').hide();
                $('.problem_answer[item_type="4"]').show();
                break;
        }
    });

    $('.btn_browse_item').on('click', function () {
        var item_type = $(this).attr('item_type');
        $('input[item_type="' + item_type + '"]').val('');
        $('input[item_type="' + item_type + '"]').trigger('click');
    });

    $('input[type="file"]').on('change', function () {
        var item_type = $(this).attr('item_type');
		if($(this).val()=='') return;
        var totalStr = this.files[0].name;
        var realNameStr = getFilenameFromURL(totalStr);
        var type = getFiletypeFromURL(realNameStr);
        if (item_type != '2') {
            if (type != 'jpg' && type != 'jpeg'
                && type != 'png' && type != 'bmp' && type != 'gif') {
                alert('图片格式不正确.');
                return;
            }
        } else {
            if (type != 'mp3') {
                alert('课程包格式不正确.');
                return;
            }
        }
        $('div[item_name=nameview' + item_type + ']').html(realNameStr);
//        preview_image(item_type, this.files[0]);
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
