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
        <h1 class="page-title"><?php echo $this->lang->line('panel_title_21'); ?>
            <small></small>
        </h1>
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bordered">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-3">
                                <form action="#" class="form-horizontal">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="col-md-5 control-label"><?php echo $this->lang->line('account_number'); ?>
                                                :</label>
                                            <div class="col-md-7">
                                                <input type="text" class="form-control" id="account_number"
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
                                            <label class="col-md-5 control-label"><?php echo $this->lang->line('account_name'); ?>
                                                :</label>
                                            <div class="col-md-7">
                                                <input type="text" class="form-control" id="account_name"
                                                       placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <form action="#" class="form-horizontal">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label"><?php echo $this->lang->line('production_time'); ?>
                                                :</label>
                                            <div class="col-md-9">
                                                <input class="form-control form-control-inline input-small date-picker left-aligned"
                                                       size="20" data-date-format="yyyy-mm-dd"
                                                       type="text" id="production_time" value="">
                                                <label class="control-label left-aligned"
                                                       style="margin:0 10px;"><?php echo $this->lang->line('To'); ?></label>
                                                <input class="form-control form-control-inline input-small date-picker left-aligned"
                                                       size="20" data-date-format="yyyy-mm-dd"
                                                       type="text" id="end_time" value="">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <form action="#" class="form-horizontal">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="col-md-5 control-label"><?php echo $this->lang->line('account_gender'); ?>
                                                :</label>
                                            <div class="col-md-7">
                                                <select class="form-control" id="gender_search"
                                                        onchange="changeGender(this);">
                                                    <option value=""><?php echo $this->lang->line('please_select'); ?></option>
                                                    <option value="男"><?php echo $this->lang->line('account_male'); ?></option>
                                                    <option value="女"><?php echo $this->lang->line('account_female'); ?></option>
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
                                            <label class="col-md-5 control-label"><?php echo $this->lang->line('account_type'); ?>
                                                :</label>
                                            <div class="col-md-7">
                                                <select class="form-control" id="area_search"
                                                        onchange="changeArea(this)">
                                                    <option value=""><?php echo $this->lang->line('please_select'); ?></option>
                                                    <option value="教师"><?php echo $this->lang->line('teacher'); ?></option>
                                                    <option value="学生"><?php echo $this->lang->line('student'); ?></option>
                                                    <option value="其他"><?php echo $this->lang->line('other'); ?></option>
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
                                            <label class="col-md-5 control-label"><?php echo $this->lang->line('school_name'); ?>
                                                :</label>
                                            <div class="col-md-7">
                                                <select class="form-control" id="school_search"
                                                        onchange="changeSchool(this)">
                                                    <option value=""><?php echo $this->lang->line('please_select'); ?></option>
                                                    <?php
                                                    $j = 0;
                                                    foreach ($user_class as $unit):
                                                        $j++;
                                                        if (empty($unit->user_school)) continue;
                                                        echo '<option value="' . $unit->user_school . '">' . $unit->user_school . '</option>';
                                                    endforeach
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-2">
                                <div class="btn-group right-floated" style="margin-left:10px;margin-right:10px;">
                                    <button class=" btn blue" onclick="search_action(this)">
                                        <i class="fa fa-search"></i>&nbsp&nbsp<?php echo $this->lang->line('search'); ?>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="btn-group right-floated" style="margin-left:10px;margin-right:10px;">
                                    <button class=" btn blue" onclick="export_table('UserInformation')">
                                        <i class="fa fa-download"></i>&nbsp&nbsp<?php echo $this->lang->line('download'); ?>
                                    </button>
                                </div>
                            </div>
                            <!-------Table tool parts----------------->
                        </div>
                        <!------Tool bar parts (add button and search function------>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover" id="main_tbl">
                            <thead>
                            <tr>
                                <th><?php echo $this->lang->line('account'); ?></th>
                                <th><?php echo $this->lang->line('activation_code'); ?></th>
                                <th><?php echo $this->lang->line('name'); ?></th>
                                <th><?php echo $this->lang->line('gender'); ?></th>
                                <th><?php echo $this->lang->line('class'); ?></th>
                                <th><?php echo $this->lang->line('area'); ?></th>
                                <th><?php echo $this->lang->line('school_name'); ?></th>
                                <th><?php echo $this->lang->line('user_type'); ?></th>
                                <th><?php echo $this->lang->line('contact_info'); ?></th>
                                <th><?php echo $this->lang->line('create_time'); ?></th>
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

<!------- Edit User Modal -------------->
<div id="item_update_modal" class="modal fade" tabindex="-1" data-width="700">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $this->lang->line('update_user'); ?></h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" enctype="multipart/form-data"
              action="" id="item_edit_submit_form" role="form"
              method="post" accept-charset="utf-8">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-offset-0 col-md-2 control-label"><?php echo $this->lang->line('name'); ?>
                        :</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="user_name" value="">
                    </div>
                    <label class="col-md-offset-1 col-md-2 control-label"><?php echo $this->lang->line('gender'); ?>
                        :</label>
                    <div class="col-md-3">
                        <select class="form-control" name="gender">
                            <option value="1"><?php echo $this->lang->line('male'); ?></option>
                            <option value="2"><?php echo $this->lang->line('female'); ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-offset-0 col-md-2 control-label"><?php echo $this->lang->line('user_type'); ?>
                        :</label>
                    <div class="col-md-3">
                        <label class="control-label" name="user_type" value="">werwer</label>
                    </div>
                    <label class="col-md-offset-1 col-md-2 control-label user-code" ><?php echo $this->lang->line('user_code'); ?>
                        :</label>
                    <div class="col-md-3">
                        <label class="control-label" name="code" value="">werwer</label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-offset-0 col-md-2 control-label"><?php echo $this->lang->line('account'); ?>
                        :</label>
                    <div class="col-md-3">
                        <label class="control-label" name="user_account"
                               style="font-weight:bold;">34563456</label>
                    </div>
                    <label class="col-md-offset-1 col-md-2 control-label"><?php echo $this->lang->line('school'); ?>
                        :</label>
                    <div class="col-md-3">
                        <label class=" control-label" name="user_school"
                               onchange="choiceSchool('edit')">asdfasdf</label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-offset-0 col-md-2 control-label"><?php echo $this->lang->line('password'); ?>
                        :</label>
                    <div class="col-md-3">
                        <label class="control-label" name="user_password">*****<a
                                    onclick="expandPasswordBox()"
                                    style="color:red;font-weight: bold;text-decoration: none;">
                                <?php echo $this->lang->line('update_password'); ?></a></label>
                    </div>
                    <label class="col-md-offset-1 col-md-2 control-label"><?php echo $this->lang->line('class'); ?>:</label>
                    <div class="col-md-3">
                        <label class="control-label" name="user_class">34563456</label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-offset-0 col-md-2 control-label" id="newPasswordLabel"></label>
                    <div class="col-md-3">
                        <input type="password" style="font-size:30px;display:none" class="form-control"
                               name="password" id="edit_usernewpassword" value=""
                               onkeyup="confirmNewPassword()">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-offset-0 col-md-2 control-label" id="confirmPasswordLabel"></label>
                    <div class="col-md-3">
                        <input type="password" style="font-size:30px;display:none" class="form-control"
                               name="cpassword" id="edit_userrepeatpassword" value=""
                               onkeyup="confirmNewPassword()">
                    </div>
                </div>
            </div>
        </form>
            <div class="form-group">
                <div class="form-group">
                    <div class="row" style="margin-top:30px;">
                        <div class="col-md-10"></div>
                        <div class="col-md-1">
                            <input type="text" hidden name="user_id" value=""><!--this is unit_id-->
                            <button class="btn green"
                                    id="update_perform"><?php echo $this->lang->line('save'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
<!------- Edit User Modal -------------->

<!----delete modal-->
<div id="item_delete_modal" class="modal fade" tabindex="-1" data-width="300">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $this->lang->line('delete_user'); ?></h4>
    </div>
    <div class="modal-body" style="text-align:center;">
        <h4 class="modal-title"><?php echo $this->lang->line('delete_confirm'); ?></h4>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn green" onclick="delete_perform(this);"
                id="delete_perform"><?php echo $this->lang->line('ok'); ?></button>
        <button type="button" class="btn green" onclick="$('#item_delete_modal').modal('toggle');">
            <?php echo $this->lang->line('cancel'); ?></button>
    </div>
</div>

<script>

    $('a.nav-link[menu_id="40"]').addClass('menu-selected');

    var prevstr = "<?php echo $this->lang->line('PrevPage');?>";
    var nextstr = "<?php echo $this->lang->line('NextPage');?>";
    var currentShowedPage = 1;
    var showeNewPassBox = 0;
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
        var pager = new Pager('main_tbl', showedItems);
        pager.init();
        pager.showPage(currentShowedPage);
    }

    function update_item(self) {
        var item_id = self.getAttribute("item_id");
        var item = JSON.parse(self.getAttribute('item_info'));

        $('#item_update_modal').find('form input[name="user_id"]').val(item_id);
        $('#item_update_modal').find('form input[name="user_name"]').val(item.user_name);
        $('#item_update_modal').find('form select[name="gender"]').val(item.gender);
        $('#item_update_modal').find('form label[name="user_type"]').html((item.user_type==1)?'教师':'学生');
        $('#item_update_modal').find('form label[name="code"]').html(item.code);
        $('#item_update_modal').find('form label[name="user_account"]').html(item.user_account);
        $('#item_update_modal').find('form label[name="user_school"]').html(item.user_school);
        $('#item_update_modal').find('form label[name="user_class"]').html(item.user_class);

        if(item.code==''){
            $('#item_update_modal').find('form label.user-code').hide();
        }else{
            $('#item_update_modal').find('form label.user-code').show();
        }

        $("#update_perform").attr("item_id", item_id);
        $("#update_perform").attr("onclick", 'update_perform(this);');

        var msg_title = $('#item_update_modal').find('.modal-header h3');
        msg_title.html('<?= $this->lang->line('update_user'); ?>');

        $("#item_update_modal").modal({
            backdrop: 'static',
            keyboard: false
        });
    }

    function update_perform(self) {
        var item_id = self.getAttribute("item_id");
        $(this).attr("onclick", '');

        var submit_form = document.getElementById('item_edit_submit_form');
        var fdata = new FormData(submit_form);
        fdata.append("user_id", item_id);
        $.ajax({
            url: baseURL + "admin/usermanage/update_user",
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
                alert('Operation failed : ' + e);
                console.log(e);
                return;
            }
            console.log(ret);
            if (ret.status == 'success') {
                var table = document.getElementById("main_tbl");
                var tbody = table.getElementsByTagName("tbody")[0];
                tbody.innerHTML = ret.data;
                executionPageNation();
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

    function expandPasswordBox() {
        var newPassStr = '<?php echo $this->lang->line('new_password');?>:';
        var confirmPassStr = '<?php echo $this->lang->line('repeat_password');?>:';
        var editSaveButton = document.getElementById('update_perform');

        if (!showeNewPassBox) {
            $("#newPasswordLabel").text(newPassStr);
            $("#confirmPasswordLabel").text(confirmPassStr);
            $("#edit_usernewpassword").show();
            $("#edit_userrepeatpassword").show();
            showeNewPassBox = true;
        } else {
            $("#newPasswordLabel").text('');
            $("#confirmPasswordLabel").text('');
            $("#edit_usernewpassword").hide();
            $("#edit_userrepeatpassword").hide();
            showeNewPassBox = false;
            editSaveButton.disabled = false;
        }
    }

    function confirmNewPassword() {
        var editSaveButton = document.getElementById('update_perform');
        var userNewPassBox = document.getElementById("edit_usernewpassword");
        var userNewPass = userNewPassBox.value;
        var userNewRepeatPassBox = document.getElementById("edit_userrepeatpassword");
        var userNewRepeatPass = userNewRepeatPassBox.value;
        if (userNewPass == userNewRepeatPass) {
            userNewRepeatPassBox.style.borderColor = '#c2cad8';
            userNewRepeatPassBox.style.borderWidth = '1px';
            userNewRepeatPassBox.style.borderStyle = 'solid';
            editSaveButton.disabled = false;


        } else {
            userNewRepeatPassBox.style.borderColor = '#f00';
            userNewRepeatPassBox.style.borderWidth = '2px';
            userNewRepeatPassBox.style.borderStyle = 'solid';
            editSaveButton.disabled = true;
        }
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
            url: baseURL + "admin/usermanage/delete_user",
            dataType: "json",
            data: {user_id: item_id, site_id: '1'},
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
                    alert("Cannot delete user.");
                }
            }
        });
    }

    /*jQuery("#keyword_search").keyup(function () {///search for keyword
        var filter, area_txt;
        filter = this.value.toUpperCase();
        area_txt = $("#area_search").val().toUpperCase();
        search_action(filter, area_txt);
    });

    $("#area_search").on('change', function () {///search for area
        var filter, area_txt;
        filter = $('#keyword_search').val().toUpperCase();
        area_txt = $(this).val().toUpperCase();
        search_action(filter, area_txt);
    });*/
    var genderTxt;

    function changeGender(self) {
        genderTxt = self.value;
    }

    var areaTxt;

    function changeArea(self) {
        areaTxt = self.value;
    }

    var schoolNametxt;

    function changeSchool(self) {
        schoolNametxt = self.value;
    }


    function search_action() {

        var keyword = $('#account_number').val();

        var txt1 = $('#account_name').val();
        var txt2 = $('#gender_search').val();
        var txt3 = $('#area_search').val();
        var txt4 = $('#school_search').val();

        var create_ds = $('#production_time').val();
        var create_de = $('#end_time').val();
        var act_ds = '';//$('#date3_search').val();
        var act_de = '';//$('#date4_search').val();

        if (keyword != '') keyword = keyword.toUpperCase();

        if (txt1 != '') txt1 = txt1.toUpperCase();
        if (txt2 != '') txt2 = txt2.toUpperCase();
//        if (txt3 != '') txt3 = txt3.toUpperCase();
//        if (txt4 != '') txt4 = txt4.toUpperCase();

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
            for (var j = 0; j < 1; j++)//5 is search filed count
            {
                var td = tr[i].getElementsByTagName("td")[j];
                if (td) {
                    var txt = td.innerHTML.toUpperCase();
                    if (txt != '' && txt.indexOf(keyword) > -1) cmpst++;
                }
            }
            var create_d = tr[i].getElementsByTagName("td")[9].innerHTML;
            var act_d = tr[i].getElementsByTagName("td")[9].innerHTML;
            if (act_d == '') act_d = '3000-01-01';
            create_d = Date.parse(create_d);
            act_d = Date.parse(act_d);
            if (cmpst > 0) {
                if (txt1 != '' && tr[i].getElementsByTagName("td")[2].innerHTML.toUpperCase() != txt1)
                    tr[i].style.display = "none";
                else if (txt2 != '' && tr[i].getElementsByTagName("td")[3].innerHTML.toUpperCase() != txt2)
                    tr[i].style.display = "none";
                else if (txt3 != '' && tr[i].getElementsByTagName("td")[7].innerHTML != txt3)
                    tr[i].style.display = "none";
                else if (txt4 != '' && tr[i].getElementsByTagName("td")[6].innerHTML != txt4)
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

        if (keyword == '' && txt1 == '' && txt2 == '' && txt3 == '' && txt4 == '' &&
            create_ds == '' && create_de == '' && act_ds == '' && act_de == '')
            executionPageNation();
    }

    Date.prototype.addDays = function (days) {
        this.setDate(this.getDate() + parseInt(days));
        return this;
    };

</script>
