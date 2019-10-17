<?php
$ctrlRoot = 'admin/lessons';
$category = '课件';
$mainModel = 'tbl_yekt_lessons';
?>
<link href="<?= base_url('assets/admin/layouts/layout/css/lessons.css') ?>" rel="stylesheet" type="text/css">

<style>
    #main_tbl th, td {
        text-align: center;
        vertical-align: middle;
    }

</style>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <h1 class="page-title"><?= $title; ?>
            <small></small>
        </h1>
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bordered">
                    <div class="table-toolbar">
                        <!------Tool bar parts (add button and search function------>
                        <div class="row">
                            <form class="form-horizontal col-md-8" action="<?= base_url($ctrlRoot . '/index') ?>"
                                  id="searchForm" role="form" method="post" enctype="multipart/form-data"
                                  accept-charset="utf-8">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-md-5 control-label">关键字:</label>
                                            <div class="col-md-7">
                                                <input type="text" class="form-control" name="search_title">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-5 control-label">所属课程:</label>
                                            <div class="col-md-7">
                                                <select type="text" class="form-control"
                                                        name="search_site"></select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-5 control-label">所属册次:</label>
                                            <div class="col-md-7">
                                                <select type="text" class="form-control"
                                                        name="search_package"></select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="btn-group right-floated">
                                        <button class=" btn btn-default" onclick="publishItem(this)" data-id="-1"
                                                data-status="0">
                                            <i class="fa fa-save"></i>&nbsp全部启用
                                        </button>
                                    </div>
                                    <div class="btn-group right-floated" style="margin-right: 30px;">
                                        <button class=" btn btn-warning" onclick="publishItem(this)" data-id="-2"
                                                data-status="1">
                                            <i class="fa fa-save"></i>&nbsp全部禁用
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="btn-group right-floated" style="margin-top: 10px;">
                                        <button class=" btn blue" onclick="addItem(this)">
                                            <i class="fa fa-plus"></i>&nbsp新增<?= $category; ?>
                                        </button>
                                    </div>
                                    <div class="btn-group right-floated" style="margin-right: 30px;margin-top: 10px;">
                                        <button class=" btn btn-default" onclick="searchItems(this)">
                                            <i class="fa fa-search"></i>&nbsp查询
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!------Tool bar parts (add button and search function------>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover" id="main_tbl">
                            <thead>
                            <tr>
                                <th><?= $category; ?>编码</th>
                                <th><?= $category; ?>名称</th>
                                <th>所属课程</th>
                                <th>所属课次</th>
                                <th>封面图</th>
                                <th width="100px">创建时间</th>
                                <th width="170px"><?php echo $this->lang->line('role_operate'); ?></th>
                            </tr>
                            </thead>
                            <tbody><?= $tbl_content ?></tbody>
                        </table>

                        <div class="pagination-bar">
                            <?php echo $this->pagination->create_links(); ?>
                            <script>
                                appendPagination('<?= $curPage; ?>', '<?= $perPage; ?>', '<?= $cntPage; ?>', '<?= $ctrlRoot; ?>');
                            </script>
                        </div>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->

<!-- Upload Progressing part -->
<div class="uploading_backdrop"></div>
<div class="progressing_area" style="display: none">
    <img id="wait_ajax_loader" src='<?php echo base_url('assets/images/ajax-loader.gif'); ?>'/>
    <span style="position: absolute;top: 43%;left: 43%;font-size:18px;color: #fff;z-index: 16000"><?= $this->lang->line('uploading') ?></span>
    <span id="progress_percent">0%</span>
</div>

<!---add new modal--->
<div id="edit-modal" class="modal fade" tabindex="-1" data-width="1000">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">新增<?= $category; ?></h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" action="" id="add-submit-form" role="form"
              method="post" enctype="multipart/form-data" accept-charset="utf-8">
            <div class="form-body">
                <div class="row" style="border-bottom: 1px solid #f0f0f0;">
                    <div class="form-group col-md-5">
                        <label class="col-md-4 control-label"
                               style="text-align:center;">所属课程:</label>
                        <div class="col-md-7" style="padding-left: 0">
                            <select class="form-control" name="site_id" value="">
                                <?php
                                foreach ($siteList as $item) {
                                    //                                    if ($item->status == '0') continue;
                                    echo '<option value="' . $item->id . '">' . $item->title . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-5">
                        <label class="col-md-4 control-label"
                               style="text-align:center;">所属课次:</label>
                        <div class="col-md-7" style="padding-left: 0">
                            <select class="form-control" name="package_id" value=""></select>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 10px;">
                    <div class="form-group col-md-5">
                        <label class="col-md-4 control-label"
                               style="text-align:center;padding: 7px 0;"><span>新建</span><?= $category; ?>名称:</label>
                        <div class="col-md-7" style="padding-left: 0">
                            <div class="item-select form-control" data-name="title"></div>
                            <input type="text" hidden class="item-select form-control" name="title" style="display: none!important;">
                        </div>
                    </div>
                    <div class="form-group col-md-5">
                        <label class="col-md-4 control-label"
                               style="text-align:center;padding: 7px 0;"><span>新建</span><?= $category; ?>编码:</label>
                        <div class="col-md-7" style="padding-left: 0">
                            <div class="item-select form-control" data-name="lesson_number"></div>
                            <input type="text" hidden class="item-select form-control" name="lesson_number" style="display: none!important;">
                        </div>
                    </div>
                    <div class="form-group col-md-2">
                        <label class="col-md-12 control-label"
                               style="text-align:left;padding: 7px 0;">缩略图:</label>
                        <div>
                            <div class="img_preview" item_type="4" style="left: 80%;"></div>
                        </div>
                    </div>

                    <div class="form-group col-md-12"
                         style="padding: 10px 0;border-top: 1px solid #ddd; border-bottom: 1px solid #ddd;">
                        <div class="col-md-12">
                            <label class="col-md-2 control-label" for="cwImageUpload" style="text-align: center;"><b>包上传:</b></label>
                            <div class="col-md-1 right-aligned">
                                <label for="cwImageUpload" class="control-label">课件包:</label>
                            </div>
                            <div class="col-md-6">
                                <div class="fileinput fileinput-new" data-provides="fileinput"
                                     style="background-color: #e0e1e1;width: 470px;position: relative">
                                <span class="btn btn-default btn-file">
                                    <span class="btn_browse_item"
                                          item_type="5"><?php echo $this->lang->line('Browse'); ?></span>
                                    <input type="file"
                                           class="form-control"
                                           name="item_icon_file5"
                                           item_type="5"
                                           accept=".zip,.mp4"/>
                                </span>
                                    <div class="fileinput-new" item_name="nameview5">
                                        <?php echo $this->lang->line('NoFileSelected'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="col-md-4 control-label"
                               style="text-align:center;"><b>组课件上传:</b></label>
                        <div class="col-md-7" style="padding-left:0;">
                            <label class="col-md-12 control-label"
                                   style="text-align:center;">本课素材列表:</label>
                            <div class="content-items" data-type="contents" style="height: 275px;"></div>
                            <div class="content-titleinfo" data-type="contents"></div>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="col-md-3 control-label"
                               style="text-align:left;font-size: 40px;line-height: 160px;color:#999;">
                            <i class="fa fa-arrow-right"></i> </label>
                        <div class="col-md-9" style="padding-left:0;">
                            <div class="list-container edit-area">
                                <div class="list-title">
                                    <div class="edit-btns" data-type="moveLeft">前移</div>
                                    <div class="edit-btns" data-type="moveRight">后移</div>
                                    <div class="edit-btns" data-type="delete">删除</div>
                                    <div class="edit-btns" data-type="play">查看</div>
                                </div>
                                <div class="content-items" data-type="lesson" style="height: 265px;"></div>
                                <div class="content-titleinfo" data-type="lesson"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group" style="display: none;">
                        <div class="col-md-2 right-aligned">
                            <label for="cwImageUpload" class="control-label">封面图:</label>
                        </div>
                        <div class="col-md-3">
                            <div class="fileinput fileinput-new" data-provides="fileinput"
                                 style="background-color: #e0e1e1;width: 270px;position: relative">
                                <span class="btn btn-default btn-file">
                                    <span class="btn_browse_item"
                                          item_type="4"><?php echo $this->lang->line('Browse'); ?></span>
                                    <input type="file"
                                           class="form-control"
                                           name="item_icon_file4"
                                           item_type="4"
                                           accept=".png,.jpg,.bmp,.gif,.jpeg"/>
                                </span>
                                <div class="fileinput-new" item_name="nameview4">
                                    <?php echo $this->lang->line('NoFileSelected'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer form-actions">
                <a class="btn green edit-btns" data-type="preview"><i class="fa fa-image"></i>&nbsp;预览</a>
                <button class="btn green edit-btns" data-type="save"><i class="fa fa-save"></i>&nbsp;保存</button>
                <a class="btn green edit-btns" data-type="cancel"><i class="fa fa-close"></i>&nbsp;取消</a>
            </div>
        </form>
    </div>
</div>
<div id="preview-modal" class="modal fade" tabindex="-1" data-width="850">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                onclick="$('iframe').attr('src','')"></button>
        <h4 class="modal-title">资源阅览器</h4>
    </div>
    <div class="modal-body" style="text-align:center;height:480px;">
        <div class="preview-player">
            <iframe class="preview-player" width="600" height="400"></iframe>
            <!--            <div onclick="closePlayer();"><i class="fa fa-close"></i></div>-->
        </div>
    </div>
</div>
<!----publish modal-->
<div id="publish-modal" class="modal fade" tabindex="-1" data-width="400">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $this->lang->line('message'); ?></h4>
    </div>
    <div class="modal-body" style="text-align:center;">
        <h4 class="modal-title"></h4>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn green" onclick="publishPerform(this);"
                data-type="yes"><?php echo $this->lang->line('ok'); ?></button>
    </div>
</div>

<!----delete modal-->
<div id="delete-modal" class="modal fade" tabindex="-1" data-width="300">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">确定</h4>
    </div>
    <div class="modal-body" style="text-align:center;">
        <h4 class="modal-title">是否删除？</h4>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn green" data-type="yes" onclick="deletePerform(this);">是</button>
        <button type="button" class="btn green" onclick="$('#delete-modal').modal('toggle');">否</button>
    </div>
</div>

<div class="scripts" hidden style="display: none;">
    <input hidden class="siteList" value='<?= json_encode($siteList) ?>'>
    <input hidden class="packageList" value='<?= json_encode($packageList) ?>'>
    <input hidden class="filterInfo"
           value='<?= json_encode($this->session->userdata('filter') ? $this->session->userdata('filter') : array()) ?>'>
    <script>
        $(function () {
            $('a.nav-link[menu_id="<?= $roleName; ?>"]').addClass('menu-selected');
            searchConfig();
            controlConfig();
        });

        var siteList = JSON.parse($('.siteList').val());
        var packageList = JSON.parse($('.packageList').val());
        var filterInfo = JSON.parse($('.filterInfo').val());
        var contentList = [];
        var lessonInfoList = [];
        var _lessonContents = [];
        var _mainObj = '<?=$mainModel?>';

        function searchConfig() {
            var content_html = '<option value="">全部</option>';
            $('select[name="search_package"]').html(content_html);
            $('select[name="search_course_type"]').html(content_html);
            $('select[name="search_content_type"]').html(content_html);

            // make subject List
            for (var i = 0; i < siteList.length; i++) {
                var item = siteList[i];
//                if (item.status == '0') continue;
                content_html += '<option value="' + item.id + '">' + item.title + '</option>';
            }
            $('select[name="search_site"]').html(content_html);

            $('select[name="search_site"]').off('change input')
            $('select[name="search_site"]').on('change input', function (e) {
                // make term list
                var subjectId = $(this).val();
                content_html = '<option value="">全部</option>';
                for (var i = 0; i < packageList.length; i++) {
                    var item = packageList[i];
//                    if (item.status == '0') continue;
                    if (item.subject_id != subjectId) continue;
                    content_html += '<option value="' + item.id + '">' + item.title + '</option>';
                }
                $('select[name="search_package"]').html(content_html);
            });

            if (filterInfo[_mainObj + '.title']) $('input[name="search_title"]').val(filterInfo[_mainObj + '.title']);

            if (filterInfo['tbl_sites.id']) {
                $('select[name="search_site"]').val(filterInfo['tbl_sites.id']);
                $('select[name="search_site"]').trigger('change');
            }

            if (filterInfo['tbl_package.id']) {
                $('select[name="search_package"]').val(filterInfo['tbl_package.id']);
                $('select[name="search_package"]').trigger('change');
            }

            console.log(filterInfo);
        }

        function searchItems(self) {
            $('#searchForm').submit();
        }

        function deleteItem(self) {
            var id = self.getAttribute("data-id");
            $('#delete-modal button[data-type="yes"]').attr("data-id", id);
            $("#delete-modal").modal({
                backdrop: 'static',
                keyboard: false
            });
        }

        function deletePerform(self) {

            var id = self.getAttribute("data-id");

            ///ajax process for delete item
            $.ajax({
                type: "post",
                url: baseURL + "<?=$ctrlRoot?>/deleteItem",
                dataType: "json",
                data: {id: id},
                success: function (res) {
                    if (res.status == 'success') {
                        var table = document.getElementById("main_tbl");
                        var tbody = table.getElementsByTagName("tbody")[0];
//                    tbody.innerHTML = res.data;
                        $('#delete-modal').modal('toggle');
                        location.reload();
                    } else//failed{
                        alert(res.data);
                }
            });
        }

        function publishItem(self) {
            var id = self.getAttribute("data-id");
            var status = self.getAttribute("data-status");

            var msg_body = $('#publish-modal').find('.modal-body h4');
            msg_body.html('是否启用？');
            if (status == '1') msg_body.html('是否禁用？');

            $('#publish-modal button[data-type="yes"]').attr("data-id", id);
            $('#publish-modal button[data-type="yes"]').attr("data-status", status);
            $('#publish-modal button[data-type="yes"]').attr("onclick", 'publishPerform(this)');
            $("#publish-modal").modal({
                backdrop: 'static',
                keyboard: false
            });
        }

        function publishPerform(self) {

            var id = self.getAttribute("data-id");
            var status = 1 - 1 * self.getAttribute("data-status");

            ///ajax process for publish/unpublish
            $.ajax({
                type: "post",
                url: baseURL + "<?=$ctrlRoot?>/publishItem",
                dataType: "json",
                data: {id: id, status: status, pageId: '<?= $curPage;?>'},
                success: function (res) {
                    if (res.status == 'success') {
                        var table = document.getElementById("main_tbl");
                        var tbody = table.getElementsByTagName("tbody")[0];
//                    tbody.innerHTML = res.data;
                        $('#publish-modal').modal('toggle');
                        location.reload();
                    } else//failed
                    {
                        alert(res.data);
                    }
                }
            });
        }

        function addItem(self) {
            var id = 0;
            $('#edit-modal button[data-type="save"]').attr("data-id", id);

            $('#edit-modal .modal-title').html('新增<?=$category;?>');
            $('#edit-modal label > span').html('新建');

            $('select[name="package_id"]').off('change');
            $('select[name="package_id"]').on('change', function (object) {
                var that = $(this);
                var packageId = that.val();
                var curPackage = packageList.filter(function(a){return a.id == packageId; });
                console.log('----- current package: ',curPackage);
                $('div[data-name="title"]').html(curPackage[0].title);
                $('div[data-name="lesson_number"]').html(curPackage[0].no);

                $('input[name="title"]').val(curPackage[0].title);
                $('input[name="lesson_number"]').val(curPackage[0].no);

                makeContentList(packageId, 'contents');
            });

            $('select[name="site_id"]').off('change');
            $('select[name="site_id"]').on('change', function (object) {
                var siteId = $(this).val();
                var content_html = '';
                for (var i = 0; i < packageList.length; i++) {
                    var item = packageList[i];
//                    if (item.status == '0') continue;
                    if (item.site_id != siteId) continue;
                    content_html += '<option value="' + item.id + '">' + item.title + '</option>';
                }
                $('select[name="package_id"]').html(content_html);
                var value2 = '';
                if ($('#edit-modal select[name="package_id"]').find('option')[0])
                    value2 = $('#edit-modal select[name="package_id"]').find('option')[0].getAttribute('value');
                $('select[name="package_id"]').val(value2);
                $('select[name="package_id"]').trigger('change');
            });
            $('select[name="site_id"]').trigger('change');
            var value6 = '';
            $('#edit-modal input[name="title"]').val(value6);
            var image_icon = '';
            var information = '';
            $('input[type="file"]').val('');

            $('div .img_preview[item_type="4"]').css({background: 'transparent'});

            if (image_icon == '') image_icon = '<?=$this->lang->line('NoFileSelected')?>';
            $('div[item_name="nameview4"]').html(getFilenameFromURL(image_icon));

            if (!information) information = '<?=$this->lang->line('NoFileSelected')?>';
            var name5 = getFilenameFromURL(information);
            $('div[item_name="nameview5"]').html(name5);

            makeLessonContents('[]');

            $('#edit-modal').modal({
                backdrop: 'static',
                keyboard: false
            });
        }

        function editItem(self) {
            var id = self.getAttribute('data-id');
            $('#edit-modal button[data-type="save"]').attr("data-id", id);

            var trtag = self.parentNode.parentNode;
            var value1 = self.getAttribute('data-site');
            var value2 = self.getAttribute('data-package');
            var value5 = trtag.cells[0].innerHTML;
            var value6 = trtag.cells[1].innerHTML;
            var image_icon = self.getAttribute('data-icon_path');
            var lessonInfo = self.getAttribute('data-lessons');
            var information = self.getAttribute('data-content');


            $('#edit-modal .modal-title').html('编辑<?=$category;?>');
            $('#edit-modal label > span').html('');


            $('select[name="package_id"]').off('change');
            $('select[name="package_id"]').on('change', function (object) {
                var that = $(this);
                var packageId = that.val();
                var curPackage = packageList.filter(function(a){return a.id == packageId; });
                console.log('----- current package: ',curPackage);
                $('div[data-name="title"]').html(curPackage[0].title);
                $('div[data-name="lesson_number"]').html(curPackage[0].no);

                $('input[name="title"]').val(curPackage[0].title);
                $('input[name="lesson_number"]').val(curPackage[0].no);

                makeContentList(packageId, 'contents');
            });

            $('select[name="site_id"]').off('change');
            $('select[name="site_id"]').on('change', function (object) {
                var siteId = $(this).val();
                var content_html = '';
                for (var i = 0; i < packageList.length; i++) {
                    var item = packageList[i];
//                    if (item.status == '0') continue;
                    if (item.site_id != siteId) continue;
                    content_html += '<option value="' + item.id + '">' + item.title + '</option>';
                }
                $('select[name="package_id"]').html(content_html);
                var value2 = '';
                if ($('#edit-modal select[name="package_id"]').find('option')[0])
                    value2 = $('#edit-modal select[name="package_id"]').find('option')[0].getAttribute('value');
                $('select[name="package_id"]').val(value2);
                $('select[name="package_id"]').trigger('change');
            });

            $('#edit-modal input[name="title"]').val(value6);
            $('div[data-name="title"]').html(value6);
            $('input[name="title"]').val(value6);

            $('div[data-name="lesson_number"]').html(value5);
            $('input[name="lesson_number"]').val(value5);

            $('#edit-modal select[name="site_id"]').val(value1);
            $('select[name="site_id"]').trigger('change');

            $('select[name="package_id"]').val(value2);
            $('select[name="package_id"]').trigger('change');

            $('input[type="file"]').val('');

            $('div .img_preview[item_type=4]').css({background: 'url(' + image_icon + ')'});

            if (image_icon == '') image_icon = '<?=$this->lang->line('NoFileSelected')?>';
            var name4 = getFilenameFromURL(image_icon);
            if (name4.length > 23) name4 = name4.substr(0, 8) + '...' + name4.substr(-14);
            $('div[item_name="nameview4"]').html(name4);

            if (!information) information = '<?=$this->lang->line('NoFileSelected')?>';
            var name5 = getFilenameFromURL(information);
            $('div[item_name="nameview5"]').html(name5);

            makeLessonContents(lessonInfo);

            $('#edit-modal').modal({
                backdrop: 'static',
                keyboard: false
            });
        }

        function controlConfig() {
            $('.edit-btns').on('click', function (e) {
                var type = $(this).attr('data-type');
                var parentTag = $('.content-items[data-type="lesson"]');
                switch (type) {
                    case 'moveLeft':
                        var contents = parentTag.find('.list-item[data-sel="1"]');

                        for (var i = 0; i < contents.length; i++) {
                            var contentId = parseInt(contents[i].getAttribute('data-id'));
                            for (var j = 1; j < lessonInfoList.length; j++) {
                                if (lessonInfoList[j] == contentId) {
                                    var a = lessonInfoList[j] + '';
                                    lessonInfoList[j] = lessonInfoList[j - 1] + '';
                                    lessonInfoList[j - 1] = a;
                                }
                            }
                        }
                        var newContentTag = document.createElement('div');
                        for (var i = 0; i < lessonInfoList.length; i++) {
                            var contentItem = parentTag.find('.list-item[data-id="' + lessonInfoList[i] + '"]');
                            newContentTag.appendChild(contentItem[0]);
                        }
                        parentTag.html(newContentTag.innerHTML);
                        refreshLessonInfo();
                        break;
                    case 'moveRight':
                        var contents = parentTag.find('.list-item[data-sel="1"]');

                        for (var i = contents.length - 1; i >= 0; i--) {
                            var contentId = contents[i].getAttribute('data-id');
                            for (var j = lessonInfoList.length - 2; j >= 0; j--) {
                                if (lessonInfoList[j] == contentId) {
                                    var a = lessonInfoList[j] + '';
                                    lessonInfoList[j] = lessonInfoList[j + 1] + '';
                                    lessonInfoList[j + 1] = a;
                                }
                            }
                        }
                        var newContentTag = document.createElement('div');
                        for (var i = 0; i < lessonInfoList.length; i++) {
                            var contentItem = parentTag.find('.list-item[data-id="' + lessonInfoList[i] + '"]');
                            newContentTag.appendChild(contentItem[0]);
                        }
                        parentTag.html(newContentTag.innerHTML);
                        refreshLessonInfo();
                        break;
                    case 'play':
                        var contentId = parentTag.find('.list-item[data-last="1"]').attr('data-id');
                        // launch contentItem
                        if (contentId)
                            showContentPlayer(contentId, 1);
                        break;
                    case 'delete':
                        parentTag.find('.list-item[data-sel="1"]').fadeOut();
                        setTimeout(function () {
                            parentTag.find('.list-item[data-sel="1"]').remove();
                            refreshLessonInfo();
                        }, 500);
                        break;
                    case 'upload':
                        e.preventDefault();
                        $('#upload_lw_courseware').val("");
                        $('#upload_lw_courseware').trigger("click");
                        break;
                    case 'cancel':
                        closePlayer();
                        $('#edit-modal').modal('toggle')
                        break;
                    case 'save':
                        break;
                        preparePreview();
                        $("#add-submit-form").submit();
                        var packageId = $('select-item[name="package_id"]').val();
                        var title = $('input.item-select').val();
                        if (!title) {
                            alert('请输入新建课件名称');
                            break;
                        }
                        if (lessonInfoList.length == 0) {
                            alert('请添加课件资源');
                            break;
                        }
                        var uploadData = {
                            id: 0,
                            title: title,
                            package_id: packageId,
                            lesson_info: JSON.stringify(lessonInfoList),
                            user_id: 0,
                        };
                        if ($(this).attr('data-id')) uploadData.id = $(this).attr('data-id');


                        $.ajax({
                            type: "post",
                            url: baseURL + "resource/updateLessonInfo",
                            dataType: "json",
                            data: uploadData,
                            success: function (res) {
                                if (res.status == 'success') {
                                    console.log('课件保存成功!');
                                    closePlayer();
                                    $('#edit-modal').modal('toggle');
                                    location.reload();
                                } else { //failed
                                    alert("上传失败");
                                }
                            }
                        });
                        break;
                    case 'preview':
                        preparePreview();
                        showLessonPlayer(0, 1);
                        break;
                }
            })

        }

        function makeLessonContents(lessonInfo) {
            var type = 'lesson';
            var tag = $('.content-items[data-type="' + type + '"]');
            tag.hide();
            $.ajax({
                type: "post",
                url: baseURL + "admin/lessons/getContentsFromLessonInfo",
                dataType: "json",
                data: {
                    lesson_info: lessonInfo
                },
                success: function (res) {
                    if (res.status == 'success') {
                        var results = res.data;
                        _lessonContents = results;
                        var allList = _lessonContents;
                        var content_html = '';
                        for (var i = 0; i < allList.length; i++) {
                            var contentItem = allList[i];
                            content_html += '<div class="list-item" ' +
                                'data-id="' + contentItem.id + '" ' +
                                'data-title="' + contentItem.title + '" ' +
                                'data-content-type="' + contentItem.content_type_id + '" ' +
                                'data-src="' + contentItem.content_path + '" ' +
                                'data-type="lesson" style="position: relative;">' +
                                '<img class="item-icon" src="' + baseURL + contentItem.icon_path + '">' +
                                '<img class="item-icon" src="' + baseURL + contentItem.icon_corner + '" style="position: absolute;right:13%;width:76%;top:3px;">' +
                                '<div class="item-desc"><div>' + contentItem.title + '</div></div>' +
                                '</div>';
                        }
                        tag.html(content_html);
                        tag.fadeIn('fast');
                        refreshLessonInfo();
                    } else//failed
                    {
                        alert("课件信息取得错误");
                    }
                }
            });
        }

        function makeContentList(package_id, type) {
            if (!package_id) package_id = 1;
            if (!type) type = 'contents';
            $.ajax({
                type: "post",
                url: baseURL + "resource/getContents",
                dataType: "json",
                data: {
                    user_id: 0,
                    package_id: package_id
                },
                success: function (res) {
                    if (res.status == true) {
                        var results = res.data;
                        contentList = results;
                        var content_html = '';
                        for (var i = 0; i < results.length; i++) {
                            var item = results[i];
                            content_html += '<div class="list-item" ' +
                                'data-id="' + item.id + '" data-type="coursetype">'
                                + item.course_name + '</div>';
                        }
                        var tag = $('.content-items[data-type="' + type + '"]');
                        var titleInfoTag = $('.content-titleinfo[data-type="' + type + '"]');
                        tag.hide();
                        tag.html(content_html);
                        tag.fadeIn('fast');

                        tag.find('.list-item').off('click');
                        tag.find('.list-item').off('mouseover');
                        tag.find('.list-item').off('mouseout');
                        tag.find('.list-item').on('click', function (e) {
                            var status = $(this).attr('data-sel');
                            tag.find('.list-item').removeAttr('data-sel');
                            if (status != '1') {
                                $(this).attr('data-sel', 1);
                                var contentId = $(this).attr('data-id');
                                addContentToLesson(contentId);
                            }
                        }).on('mouseover', function (e) {
                            var title = $(this).html();
                            // console.log(title);
                            if (title.length < 13) return;
                            titleInfoTag.html(title);
                            titleInfoTag.show();
                            titleInfoTag.css({
                                top: this.offsetTop + this.offsetHeight,
                                left: this.offsetLeft + 2
                            })
                        }).on('mouseout', function (e) {
                            titleInfoTag.hide();
                        })
                    } else//failed
                    {
                        alert("Cannot update lesson Item.");
                    }
                }
            });
        }

        function addContentToLesson(contentId, type) {
            if (!contentId) contentId = contentList[0].id;
            if (!type) type = 'lesson';

            var contentItem = contentList.filter(function (a) {
                return a.id == contentId;
            })[0];
            if (!contentItem) return;
            if (lessonInfoList.length > 0) {
                var oldId = lessonInfoList.filter(function (a) {
                    return a == contentId;
                })[0];
                if (oldId) return;
            }

            var tag = $('.content-items[data-type="' + type + '"]');
            var content_html = '';
            content_html += '<div class="list-item" ' +
                'data-id="' + contentItem.id + '" ' +
                'data-title="' + contentItem.course_name + '" ' +
                'data-content-type="' + contentItem.course_type + '" ' +
                'data-src="' + contentItem.course_path + '" ' +
                'data-type="lesson" style="position: relative;">' +
                '<img class="item-icon" src="' + baseURL + contentItem.image_path + '">' +
                '<div class="item-desc"><div>' + contentItem.course_name + '</div></div>' +
                '</div>';
            tag.append(content_html);
            refreshLessonInfo();

        }

        function refreshLessonInfo() {
            var type = 'lesson';
            var tag = $('.content-items[data-type="' + type + '"]');
            var titleInfoTag = $('.content-titleinfo[data-type="' + type + '"]');
            lessonInfoList = [];
            for (var i = 0; i < tag.find('.list-item').length; i++) {
                var itemId = parseInt(tag.find('.list-item')[i].getAttribute('data-id'));
                lessonInfoList.push(itemId);
            }
            tag.find('.list-item').off('click');
            tag.find('.list-item').off('mouseover');
            tag.find('.list-item').off('mouseout');
            tag.find('.list-item').on('click', function (e) {
                tag.find('.list-item').removeAttr('data-sel');
                var status = $(this).attr('data-sel');
                tag.find('.list-item').removeAttr('data-last');
                $(this).attr('data-last', 1);
                if (status) {
                    $(this).removeAttr('data-sel');
                } else {
                    $(this).attr('data-sel', 1);
                    var contentId = $(this).attr('data-id');
                }
            }).on('mouseover', function (e) {
                var title = $(this).find('.item-desc > div').html();
                // console.log(title);
                if (title.length < 5) return;
                titleInfoTag.html(title);
                titleInfoTag.show();
                titleInfoTag.css({
                    top: this.offsetTop + this.offsetHeight,
                    left: this.offsetLeft + 2
                })
            }).on('mouseout', function (e) {
                titleInfoTag.hide();
            });
            // console.log(lessonInfoList);
        }

        function preparePreview() {
            var previewContentList = [];
            var parentTag = $('.content-items[data-type="lesson"]');
            var contents = parentTag.find('.list-item');
            for (var i = 0; i < contents.length; i++) {
                var item = $(contents[i]);
                previewContentList.push({
                    id: item.attr('data-id'),
                    title: item.attr('data-title'),
                    content_type_id: item.attr('data-content-type'),
                    content_path: item.attr('data-src')
                });
            }
            refreshLessonInfo();
            console.log(previewContentList);
            localStorage.setItem('preview-content', JSON.stringify(previewContentList));
            localStorage.setItem('__id', $('input.item-select').val());
        }

        function showContentPlayer(id, isPopup) {
            id = parseInt(id);
            $('iframe').attr('src', baseURL + "resource/warePreviewPlayer/" + id);
            $('#preview-modal').find('.modal-header .modal-title').html('资源阅览器');
            $('#preview-modal').modal({
                backdrop: 'static',
                keyboard: false
            });
        }

        function showLessonPlayer(id, isPopup) {
            id = parseInt(id);
            $('iframe').attr('src', baseURL + "resource/previewPlayer/" + id);
            $('#preview-modal').find('.modal-header .modal-title').html('课件阅览器');
            $('#preview-modal').modal({
                backdrop: 'static',
                keyboard: false
            });
        }

        function closePlayer() {
            $('#preview-modal').modal('hide');
            $('iframe').attr('src', '');
        }

        $("#add-submit-form").submit(function (e) {
            e.preventDefault();
            preparePreview();
            var packageId = $('select[name="package_id"]').val();
            var title = $('input.item-select').val();
            // if (!title) {
            //     alert('请输入新建课件名称');
            //     return;
            // }
            var uploadData = {
                id: 0,
                lesson_name: title,
                package_id: packageId,
                lesson_info: JSON.stringify(lessonInfoList),
                user_id: 0
            };
            if ($('#edit-modal .edit-btns[data-type="save"]').attr('data-id'))
                uploadData.id = $('.edit-btns[data-type="save"]').attr('data-id');

            var that = this;
            $(that).find('button[type="submit"]').attr('disabled', 'disabled');

            var icon_format = getFiletypeFromURL($('div[item_name="nameview4"]').html());
            if (icon_format == '<?=$this->lang->line('NoFileSelected')?>') icon_format = '';
            icon_format = getFiletypeFromURL(icon_format);

            var content_format = getFiletypeFromURL($('div[item_name="nameview5"]').html());
            if (content_format == '<?=$this->lang->line('NoFileSelected')?>') content_format = '';
            content_format = getFiletypeFromURL(content_format);
            if (lessonInfoList.length == 0 && content_format=='') {
                alert('请添加上传包或者本课素材');
                return;
            }

            $(".uploading_backdrop").show();
            $(".progressing_area").show();

            var fdata = new FormData(this);
            fdata.append("id", uploadData.id);
            fdata.append("lesson_info", uploadData.lesson_info);
            fdata.append("user_id", uploadData.user_id);
            fdata.append("icon_format", icon_format);
            fdata.append("content_format", content_format);
            $.ajax({
                url: baseURL + "<?=$ctrlRoot?>/updateItem",
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
                $(".uploading_backdrop").hide();
                $(".progressing_area").hide();
                $(that).find('button[type="submit"]').removeAttr('disabled');
                try {
                    ret = JSON.parse(res);
                } catch (e) {
                    alert('操作失败 : ' + JSON.stringify(e));
                    console.log(e);
                    return;
                }
                if (ret.status == 'success') {
                    var table = document.getElementById("main_tbl");
                    var tbody = table.getElementsByTagName("tbody")[0];
//                    tbody.innerHTML = ret.data;
                    $('#edit-modal').modal('toggle');
                    location.reload();
                } else//failed
                {
                    alert('操作失败 : ' + ret.data);
                    // jQuery('#ncw_edit_modal').modal('toggle');
                    // alert(ret.data);
                }
            });
        });

        $('.btn_browse_item').on('click', function () {
            var item_type = $(this).attr('item_type');
            $('input[name="item_icon_file' + item_type + '"]').val('');
            $('input[name="item_icon_file' + item_type + '"]').trigger('click');
        });

        $('div .img_preview[item_type="4"]').on('click', function () {
            var item_type = $(this).attr('item_type');
            $('input[name="item_icon_file' + item_type + '"]').val('');
            $('input[name="item_icon_file' + item_type + '"]').trigger('click');
        })

        $('input[type="file"]').on('click', function (object) {
            $(this).val('');
        });

        $('input[type="file"]').on('change', function () {
            var item_type = $(this).attr('item_type');
            var totalStr = this.files[0].name;
            var realNameStr = getFilenameFromURL(totalStr);
            var type = getFiletypeFromURL(realNameStr);
            if (item_type == '4') {
                if (type != 'jpg' && type != 'jpeg'
                    && type != 'png' && type != 'bmp' && type != 'gif') {
                    alert('图片格式不正确..');
                    return;
                }
            } else {
                if (type != 'jpg' && type != 'jpeg'
                    && type != 'png' && type != 'bmp' && type != 'gif'
                    && type != 'docx' && type != 'pdf' && type != 'html'
                    && type != 'mp4'
                    && type != 'zip') {
                    alert('课程内容格式不正确..');
                    return;
                }
            }
            $('div[item_name="nameview' + item_type + '"]').html(realNameStr);
            preview_image(item_type, this.files[0]);
        });

        function preview_image(item_type, file) {
            if (item_type == '5') return;
            var previewer = $('div .img_preview[item_type="' + item_type + '"]');
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

        $('.scripts').remove();
    </script>
</div>




