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
        <h1 class="page-title">授权码信息
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
                            <div class="col-md-3" style="display:none;">
                                <form action="#" class="form-horizontal">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <select class="form-control" id="sel1_search">
                                                    <option value=""><?php echo $this->lang->line('search_site'); ?></option>
                                                    <?php
                                                    $j = 0;
                                                    foreach ($sites as $unit):
                                                        $j++;
                                                        echo '<option value="' . $unit->site_name . '">' . $unit->site_name . '</option>';
                                                    endforeach
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-4">
                                <form action="#" class="form-horizontal">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label class="col-md-5 control-label"><?php echo $this->lang->line('activation_status'); ?>
                                                    :</label>
                                                <div class="col-md-7">
                                                    <select class="form-control" id="sel2_search">
                                                        <option value=""><?php echo $this->lang->line('search_activation'); ?></option>
                                                        <?php
                                                        foreach ($status_act as $unit):
                                                            echo '<option value="' . $unit . '">' . $unit . '</option>';
                                                        endforeach
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-2" style="display: none">
                                <form action="#" class="form-horizontal">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <select class="form-control" id="sel3_search">
                                                    <option value=""><?php echo $this->lang->line('search_usage'); ?></option>
                                                    <?php
                                                    foreach ($status_use as $unit):
                                                        echo '<option value="' . $unit . '">' . $unit . '</option>';
                                                    endforeach
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <form action="#" class="form-horizontal">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label right"><?php echo $this->lang->line('create_time'); ?>
                                                :</label>
                                            <div class="col-md-8">
                                                <input class="form-control form-control-inline input-small date-picker left-aligned"
                                                       size="20" data-date-format="yyyy-mm-dd"
                                                       type="text" id="date1_search" value="">
                                                <label class="control-label left-aligned"
                                                       style="margin:0 10px;"><?php echo $this->lang->line('To'); ?></label>
                                                <input class="form-control form-control-inline input-small date-picker left-aligned"
                                                       size="20" data-date-format="yyyy-mm-dd"
                                                       type="text" id="date2_search" value="">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <form action="#" class="form-horizontal">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label right"><?php echo $this->lang->line('activation_time'); ?>
                                                :</label>
                                            <div class="col-md-8">
                                                <input class="form-control form-control-inline input-small date-picker left-aligned"
                                                       size="20" data-date-format="yyyy-mm-dd"
                                                       type="text" id="date3_search" value="">
                                                <label class="control-label left-aligned"
                                                       style="margin:0 10px;"><?php echo $this->lang->line('To'); ?></label>
                                                <input class="form-control form-control-inline input-small date-picker left-aligned"
                                                       size="20" data-date-format="yyyy-mm-dd"
                                                       type="text" id="date4_search" value="">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-------Table tool parts----------------->
                        <div class="col-md-12">
                            <div class="btn-group right-floated">
                                <button class=" btn blue" onclick="create_code(1)">
                                    <i class="fa fa-plus"></i>&nbsp&nbsp授权码生成
                                </button>
                            </div>
                            <div class="btn-group right-floated" style="margin-left:10px;margin-right:10px;">
                                <button class=" btn blue" onclick="export_table('ActivationCodes')">
                                    <i class="fa fa-download"></i>&nbsp&nbsp<?php echo $this->lang->line('download'); ?>
                                </button>
                            </div>
                            <div class="btn-group right-floated">
                                <button class=" btn blue" onclick="search_action()">
                                    <i class="fa fa-search"></i>&nbsp&nbsp<?php echo $this->lang->line('apply_search'); ?>
                                </button>
                            </div>
                        </div>
                        <!------Tool bar parts (add button and search function------>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover" id="main_tbl">
                            <thead>
                            <tr>
                                <th><?php echo $this->lang->line('order_number'); ?></th>
                                <th>授权码</th>
                                <th><?php echo $this->lang->line('project'); ?></th>
                                <th><?php echo $this->lang->line('create_time'); ?></th>
                                <th><?php echo $this->lang->line('activation_status'); ?></th>
                                <th><?php echo $this->lang->line('activation_account'); ?></th>
                                <th>用户类型</th>
                                <th><?php echo $this->lang->line('activation_time'); ?></th>
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

<!--   edit modal  -->
<div id="item_update_modal" class="modal fade" tabindex="-1" data-width="600">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $this->lang->line('create_activation_code'); ?></h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" enctype="multipart/form-data" action="" id="item_edit_submit_form" role="form"
              method="post" accept-charset="utf-8">
            <div class="form-group" dlg_step="1">
                <label class="col-md-2 control-label"><?php echo $this->lang->line('amount'); ?>:</label>
                <div class="col-md-4">
                    <input class="form-control input-inline " type="number"
                           name="item_amount" value="">
                </div>
                <label class="col-md-3 control-label">用户类型:</label>
                <div class="col-md-3">
                    <select class="form-control input-inline" name="user_type">
                        <option value="1">教师</option>
                        <option value="2">学生</option>
                    </select>
                </div>
            </div>
            <div class="form-group" dlg_step="2">
                <h4 class="modal-title"
                    style="text-align: center"><?php echo $this->lang->line('create_code_confirm'); ?></h4>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn green" onclick="create_code(2);" dlg_step="1"
                id="advance_step"><?php echo $this->lang->line('next_step'); ?></button>
        <button type="button" class="btn green" onclick="update_perform(this);" dlg_step="2"
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
        <h4 class="modal-title"><?php echo $this->lang->line('delete_code'); ?></h4>
    </div>
    <div class="modal-body" style="text-align:center;">
        <h4 class="modal-title"><?php echo $this->lang->line('delete_code_confirm'); ?></h4>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn green" onclick="delete_perform(this);"
                id="delete_perform"><?php echo $this->lang->line('ok'); ?></button>
        <button type="button" class="btn green" onclick="$('#item_delete_modal').modal('toggle');">
            <?php echo $this->lang->line('cancel'); ?></button>
    </div>
</div>

<script>

    $('a.nav-link[menu_id=10]').addClass('menu-selected');

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
    pager.showPage(1);

    function executionPageNation() {
        pager = new Pager('main_tbl', showedItems);
        pager.init();
        pager.showPage(currentShowedPage);
    }
</script>
<script>

    function create_code(dlg_step) {
        var item_amount = $('#item_update_modal').find('.modal-body form input[name="item_amount"]');
        var user_type = $('#item_update_modal').find('.modal-body form select[name="user_type"]');
        switch (dlg_step) {
            case 1:
                item_amount.val('0');
                break;
            case 2:
                var amount = item_amount.val();
                user_type = user_type.val();
                if (amount == '' || (amount != '' && parseInt(amount) <= 0)) {
                    alert('激活码的计数无效.');
                    return;
                }
                $("#update_perform").attr("item_amount", amount);
                $("#update_perform").attr("user_type", user_type);
                $("#update_perform").attr("onclick", 'update_perform(this);');
                break;
        }

        $('div[dlg_step=' + (3 - dlg_step) + ']').hide();
        $('button[dlg_step=' + (3 - dlg_step) + ']').hide();
        $('div[dlg_step=' + dlg_step + ']').show();
        $('button[dlg_step=' + dlg_step + ']').show();

        $("#item_update_modal").modal({
            backdrop: 'static',
            keyboard: false
        });
    }

    function update_perform(self) {
//        $(self).attr("onclick", '');
        var item_amount = $(self).attr('item_amount');
        var user_type = $(self).attr('user_type');
        $.ajax({
            type: "post",
            url: baseURL + "admin/sitemanage/create_activation_codes",
            dataType: "json",
            data: {item_amount: item_amount, user_type:user_type},
            success: function (res) {
                if (res.status == 'success') {
                    var table = document.getElementById("main_tbl");
                    var tbody = table.getElementsByTagName("tbody")[0];
                    tbody.innerHTML = res.data;
                    executionPageNation();
                    $('#item_update_modal').modal('toggle');
                    console.log('publish has been successed!')
                }
                else//failed
                {
                    alert("Cannot change publish status.");
                }
            }
        });
    }

    function publish_item(self) {
        var item_id = self.getAttribute("item_id");
        var site_id = self.getAttribute("item_site");
        var item_status = self.getAttribute("item_status");
        var msg_body = $('#item_publish_modal').find('.modal-body h4');
        if (item_status == '0')
            msg_body.html('<?= $this->lang->line('publish_code_confirm'); ?>');
        else
            msg_body.html('<?= $this->lang->line('unpublish_code_confirm'); ?>');
        $("#publish_perform").attr("item_id", item_id);
        $("#publish_perform").attr("site_id", site_id);
        $("#publish_perform").attr("item_status", self.innerHTML.trim());
        $("#publish_perform").attr("onclick", 'publish_perform(this)');
        $("#item_publish_modal").modal({
            backdrop: 'static',
            keyboard: false
        });
    }

    function publish_perform(self) {

        var item_id = self.getAttribute("item_id");
        var site_id = self.getAttribute("site_id");
        var publish = "<?php echo $this->lang->line('enable');?>";
        var curBtnText = self.getAttribute("item_status");
        var pub_st = '1';
        if (publish != curBtnText) pub_st = '0';

        ///ajax process for publish/unpublish
        $.ajax({
            type: "post",
            url: baseURL + "admin/sitemanage/publish",
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
            url: baseURL + "admin/sitemanage/delete_code",
            dataType: "json",
            data: {item_id: item_id},
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
                    alert("Cannot delete this code.");
                }
            }
        });
    }
//
//    $("#keyword_search").keyup(function () {///search for keyword
//        search_action();
//    });
//
//    $("#sel1_search").on('change', function () {///search for area
//        search_action();
//    });
//
//    $("#sel2_search").on('change', function () {///search for area
//        search_action();
//    });
//
//    $("#sel3_search").on('change', function () {
//        search_action();
//    });
//
//    $("#date1_search").on('change', function () {
//        search_action();
//    });
//    $("#date2_search").on('change', function () {
//        search_action();
//    });
//    $("#date3_search").on('change', function () {
//        search_action();
//    });
//    $("#date4_search").on('change', function () {
//        search_action();
//    });

    function search_action() {

        var keyword = $('#keyword_search').val();

        var txt1 = '';//$('#sel1_search').val();
        var txt2 = $('#sel2_search').val();
        var txt3 = '';//$('#sel3_search').val();

        var create_ds = $('#date1_search').val();
        var create_de = $('#date2_search').val();
        var act_ds = $('#date3_search').val();
        var act_de = $('#date4_search').val();

        if (keyword != '') keyword = keyword.toUpperCase();

        if (txt1 != '') txt1 = txt1.toUpperCase();
        if (txt2 != '') txt2 = txt2.toUpperCase();
        if (txt3 != '') txt3 = txt3.toUpperCase();

        if (create_ds != '') create_ds = Date.parse(create_ds);
        if (create_de != '') create_de = Date.parse((new Date(create_de)).addDays(1).toLocaleString());
        if (act_ds != '') act_ds = Date.parse(act_ds);
        if (act_de != '') act_de = Date.parse((new Date(act_de)).addDays(1).toLocaleString());

        var table = document.getElementById("main_tbl");
        var tr = table.getElementsByTagName("tr");
        // Loop through all table rows, and hide those who don't match the search query
        if (tr.length < 2) return;
        for (var i = 1; i < tr.length; i++) {

            var cmpst = 0;
            for (var j = 0; j < 7; j++)//5 is search filed count
            {
                var td = tr[i].getElementsByTagName("td")[j];
                if (td) {
                    var txt = td.innerHTML.toUpperCase();
                    if (txt != '' && txt.indexOf(keyword) > -1) cmpst++;
                }
            }
            var create_d = tr[i].getElementsByTagName("td")[3].innerHTML;
            var act_d = tr[i].getElementsByTagName("td")[6].innerHTML;
            if (act_d == '') act_d = '3000-01-01';
            create_d = Date.parse(create_d);
            act_d = Date.parse(act_d);
            if (cmpst > 0) {
                if (txt1 != '' && tr[i].getElementsByTagName("td")[2].innerHTML.toUpperCase() != txt1)
                    tr[i].style.display = "none";
                else if (txt2 != '' && tr[i].getElementsByTagName("td")[4].innerHTML.toUpperCase() != txt2)
                    tr[i].style.display = "none";
                else if (txt3 != '' && tr[i].getElementsByTagName("td")[6].innerHTML.toUpperCase() != txt3)
                    tr[i].style.display = "none";
                else if (create_ds != '' && create_d < create_ds)
                    tr[i].style.display = "none";
                else if (create_de != '' && create_d > create_de)
                    tr[i].style.display = "none";
                else if (act_ds != '' && act_d < act_ds)
                    tr[i].style.display = "none";
                else if (act_de != '' && act_d > act_de)
                    tr[i].style.display = "none";
                else
                    tr[i].style.display = "";
//                console.log(act_d);
            }
            else tr[i].style.display = "none";
        }

        if (keyword == '' && txt1 == '' && txt2 == '' && txt3 == '' &&
            create_ds == '' && create_de == '' && act_ds == '' && act_de == '')
            executionPageNation();
    }

    Date.prototype.addDays = function (days) {
        this.setDate(this.getDate() + parseInt(days));
        return this;
    };
</script>