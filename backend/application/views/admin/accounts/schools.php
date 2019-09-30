<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content" style="min-height: 1305px;">
        <h1 class="page-title"><?php echo $this->lang->line('sub_panel_title_school');?>
            <small></small>
        </h1>
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bordered">
                    <div class="table-toolbar">
                        <!-------Table tool parts----------------->
                        <div class="row">
                            <div class="col-md-5">
                                <form action="#" class="form-horizontal">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="col-md-5 control-label"><?php echo $this->lang->line('SchoolName');?>:</label>
                                            <div class="col-md-7">
                                                <input type="text" class="form-control" id = "school_name_search" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-7">
                                <div class="btn-group right-floated">
                                    <button  class=" btn sbold green" id="add_new_school_btn"> <i class="fa fa-plus"></i><?php echo $this->lang->line('AddNew');?>
                                    </button>
                                </div>
                            </div>
                            <!-------Table tool parts----------------->
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover" id="schoolInfo_tbl">
                            <thead>
                            <tr>
                                <th><?php echo $this->lang->line('SerialNumber');?></th>
                                <th><?php echo $this->lang->line('SchoolName');?></th>
                                <th><?php echo $this->lang->line('Grade/Class');?></th>
                                <th><?php echo $this->lang->line('Operation');?></th>
                            </tr>
                            </thead>
                            <tbody><?=$tbl_content?></tbody>
                        </table>
                        <div id="schoolpageNavPosition"></div>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
<!----Begin Add New Dialog Box  ----->
<div id="school_addNew_modal" class="modal fade" tabindex="-1" data-width="850">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $this->lang->line('AddNewSchool');?></h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal">
            <div class="form-group">
                <label class="col-md-2 control-label"><?php echo $this->lang->line('SchoolName');?>:</label>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="add_school_name" id="add_school_name" value="" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label"><?php echo $this->lang->line('Grade/Class');?>:</label>
                <div class="col-md-9">
                    <table class="table custom_tbl_borderless">
                        <tr>
                            <td>
                                <label class="mt-checkbox mt-checkbox-outline">
                                    <input type="checkbox" id="add_first_chk"><?php echo $this->lang->line('One')."&nbsp".$this->lang->line('Grade');?>
                                    <span></span>
                                </label>
                            </td>
                            <td>
                                <label class="mt-checkbox mt-checkbox-outline">
                                    <input type="checkbox" id="add_second_chk"><?php echo $this->lang->line('Two')."&nbsp".$this->lang->line('Grade');?>
                                    <span></span>

                                </label>
                            </td>
                            <td>
                                <label class="mt-checkbox mt-checkbox-outline">
                                    <input type="checkbox" id="add_third_chk"><?php echo $this->lang->line('Three')."&nbsp".$this->lang->line('Grade');?>
                                    <span></span>
                                </label>
                            </td>
                            <td>
                                <label class="mt-checkbox mt-checkbox-outline">
                                    <input type="checkbox" id="add_fourth_chk"><?php echo $this->lang->line('Four')."&nbsp".$this->lang->line('Grade');?>
                                    <span></span>
                                </label>
                            </td>
                            <td>
                                <label class="mt-checkbox mt-checkbox-outline">
                                    <input type="checkbox" id="add_fifth_chk"><?php echo $this->lang->line('Five')."&nbsp".$this->lang->line('Grade');?>
                                    <span></span>
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td id = "first_grade_col">
                                <label class = "custom_grade_label" id = "add_first_grade_classCnt">1</label>
                                <label><?php echo $this->lang->line('Ge').$this->lang->line('Class');?></label>
                                <button type="button" id = "add_plus_first_grade_btn">&#43</button>
                                <button type="button" id = "add_minus_first_grade_btn">&#8211</button>
                            </td>
                            <td id = "second_grade_col">
                                <label class = "custom_grade_label" id = "add_second_grade_classCnt">1</label>
                                <label><?php echo $this->lang->line('Ge').$this->lang->line('Class');?></label>
                                <button type="button" id = "add_plus_second_grade_btn">&#43</button>
                                <button type="button" id = "add_minus_second_grade_btn">&#8211</button>
                            </td>
                            <td id = "third_grade_col">
                                <label class = "custom_grade_label" id = "add_third_grade_classCnt">1</label>
                                <label><?php echo $this->lang->line('Ge').$this->lang->line('Class');?></label>
                                <button type="button" id = "add_plus_third_grade_btn">&#43</button>
                                <button  type="button" id = "add_minus_third_grade_btn">&#8211</button>
                            </td>
                            <td id = "fourth_grade_col">
                                <label class = "custom_grade_label" id = "add_fourth_grade_classCnt">1</label>
                                <label><?php echo $this->lang->line('Ge').$this->lang->line('Class');?></label>
                                <button type="button" id = "add_plus_fourth_grade_btn">&#43</button>
                                <button  type="button" id = "add_minus_fourth_grade_btn">&#8211</button>
                            </td>
                            <td id = "fifth_grade_col">
                                <label class = "custom_grade_label" id = "add_fifth_grade_classCnt">1</label>
                                <label><?php echo $this->lang->line('Ge').$this->lang->line('Class');?></label>
                                <button  type="button" type="button"id = "add_plus_fifth_grade_btn">&#43</button>
                                <button type="button" id = "add_minus_fifth_grade_btn">&#8211</button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="form-actions">
                <div class="form-group">
                    <div class="col-md-offset-1 col-md-1">
                        <button type = "button" class="btn green" id="add_school_save_btn" ><?php echo $this->lang->line('Save');?></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!----End Add New Dialog Box  ----->
<!----Edit Dialog Box------>
<div id="school_edit_modal" class="modal fade" tabindex="-1" data-width="850">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $this->lang->line('EditSchool');?></h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal">
            <div class="form-group">
                <label class="col-md-2 control-label"><?php echo $this->lang->line('SchoolName');?>:</label>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="edit_school_name" id="edit_school_name" value="">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label"><?php echo $this->lang->line('Grade/Class');?>:</label>
                <div class="col-md-9">
                    <table class="table custom_tbl_borderless">
                        <tr>
                            <td>
                                <label class="mt-checkbox mt-checkbox-outline">
                                    <input type="checkbox" id="edit_chk_1"><?php echo $this->lang->line('One')."&nbsp".$this->lang->line('Grade');?>
                                    <span></span>
                                </label>
                            </td>
                            <td>
                                <label class="mt-checkbox mt-checkbox-outline">
                                    <input type="checkbox" id="edit_chk_2"><?php echo $this->lang->line('Two')."&nbsp".$this->lang->line('Grade');?>
                                    <span></span>

                                </label>
                            </td>
                            <td>
                                <label class="mt-checkbox mt-checkbox-outline">
                                    <input type="checkbox" id="edit_chk_3"><?php echo $this->lang->line('Three')."&nbsp".$this->lang->line('Grade');?>
                                    <span></span>
                                </label>
                            </td>
                            <td>
                                <label class="mt-checkbox mt-checkbox-outline">
                                    <input type="checkbox" id="edit_chk_4"><?php echo $this->lang->line('Four')."&nbsp".$this->lang->line('Grade');?>
                                    <span></span>
                                </label>
                            </td>
                            <td>
                                <label class="mt-checkbox mt-checkbox-outline">
                                    <input type="checkbox" id="edit_chk_5"><?php echo $this->lang->line('Five')."&nbsp".$this->lang->line('Grade');?>
                                    <span></span>
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td id = "edit_grade_col_1">
                                <label class = "custom_grade_label" id = "edit_grade_num_1">1</label>
                                <label><?php echo $this->lang->line('Ge').$this->lang->line('Class');?></label>
                                <button type="button" id = "edit_plus_first_grade_btn">&#43</button>
                                <button type="button" id = "edit_minus_first_grade_btn">&#8211</button>
                            </td>
                            <td id = "edit_grade_col_2">
                                <label class = "custom_grade_label" id = "edit_grade_num_2">1</label>
                                <label><?php echo $this->lang->line('Ge').$this->lang->line('Class');?></label>
                                <button type="button" id = "edit_plus_second_grade_btn">&#43</button>
                                <button type="button" id = "edit_minus_second_grade_btn">&#8211</button>
                            </td>
                            <td id = "edit_grade_col_3">
                                <label class = "custom_grade_label" id = "edit_grade_num_3">1</label>
                                <label><?php echo $this->lang->line('Ge').$this->lang->line('Class');?></label>
                                <button type="button" id = "edit_plus_third_grade_btn">&#43</button>
                                <button  type="button" id = "edit_minus_third_grade_btn">&#8211</button>
                            </td>
                            <td id = "edit_grade_col_4">
                                <label class = "custom_grade_label" id = "edit_grade_num_4">1</label>
                                <label><?php echo $this->lang->line('Ge').$this->lang->line('Class');?></label>
                                <button type="button" id = "edit_plus_fourth_grade_btn">&#43</button>
                                <button  type="button" id = "edit_minus_fourth_grade_btn">&#8211</button>
                            </td>
                            <td id = "edit_grade_col_5">
                                <label class = "custom_grade_label" id = "edit_grade_num_5">1</label>
                                <label><?php echo $this->lang->line('Ge').$this->lang->line('Class');?></label>
                                <button  type="button" type="button" id = "edit_plus_fifth_grade_btn">&#43</button>
                                <button type="button" id = "edit_minus_fifth_grade_btn">&#8211</button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="form-actions">
                <div class="form-group">
                    <div class="col-md-offset-1 col-md-1">
                        <input type="text" hidden  value="" id = "edit_school_info_id">
                        <button type = "button" class="btn green" id="edit_school_save_btn" ><?php echo $this->lang->line('Save');?></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!---Edit Dialog Box--->
<!-----Delete Dialog Box------------>
<div id="school_delete_modal" class="modal fade" tabindex="-1" data-width="300">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $this->lang->line('Message');?></h4>
    </div>
    <div class="modal-body" style="text-align:center;">
        <h4 class="modal-title"><?php echo $this->lang->line('DeleteConfirmMessage');?></h4>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn green" id="delete_school_btn"><?php echo $this->lang->line('Yes');?></button>
        <button type="button" data-dismiss="modal"  class="btn btn-outline dark"><?php echo $this->lang->line('No');?></button>
    </div>
</div>
<!-----Delete Dialog Box------------>
<style>
    .custom_grade_label
    {
        border-top-style: none;border-right-style: none;
        border-left-style: none;
        border-bottom-style: solid;
        border-bottom-color: black;
        border-bottom-width: 2px;
    }
    .custom_tbl_borderless th, .custom_tbl_borderless td {
        border-top: none !important;
    }
</style>
<script>

    $('#school_menu').addClass('menu-selected');
    var baseURL = "<?php echo base_url();?>";
    var gradeStr = "<?php echo $this->lang->line('Grade');?>";
    var classStr = "<?php echo $this->lang->line('Class');?>";
    var oneStr = "<?php echo $this->lang->line('One');?>";
    var twoStr = "<?php echo $this->lang->line('Two');?>";
    var threeStr = "<?php echo $this->lang->line('Three');?>";
    var fourStr = "<?php echo $this->lang->line('Four');?>";
    var fiveStr = "<?php echo $this->lang->line('Five');?>";
    var enabledStr = "<?php echo $this->lang->line('Enabled');?>";
    var disabledStr = "<?php echo $this->lang->line('Disabled');?>";
    var prevstr = "<?php echo $this->lang->line('PrevPage');?>";
    var nextstr = "<?php echo $this->lang->line('NextPage');?>";
    var currentShowedPage = 1;
    var showedItems = 5;

    function Pager(tableName, itemsPerPage) {

        this.tableName = tableName;
        this.itemsPerPage = itemsPerPage;
        this.currentPage = 1;
        this.pages = 0;
        this.inited = false;

        this.showRecords = function(from, to) {
            var rows = document.getElementById(tableName).rows;
            // i starts from 1 to skip table header row
            for (var i = 1; i < rows.length; i++) {
                if (i < from || i > to)
                    rows[i].style.display = 'none';
                else
                    rows[i].style.display = '';
            }
        }

        this.showPage = function(pageNumber) {
            if (! this.inited) {
                alert("not inited");
                return;
            }
            var oldPageAnchor = document.getElementById('pg'+this.currentPage);
            if(oldPageAnchor)
            {
                oldPageAnchor.className = 'pg-normal';

                this.currentPage = pageNumber;
                var newPageAnchor = document.getElementById('pg'+this.currentPage);
                newPageAnchor.className = 'pg-selected';

                var from = (pageNumber - 1) * itemsPerPage + 1;
                var to = from + itemsPerPage - 1;
                this.showRecords(from, to);
            }else{
                return;
            }

        };

        this.prev = function() {
            if (this.currentPage > 1){

                currentShowedPage = this.currentPage - 1;
                this.showPage(this.currentPage - 1);
            }

        }

        this.next = function() {
            if (this.currentPage < this.pages) {

                currentShowedPage = this.currentPage + 1;
                this.showPage(this.currentPage + 1);
            }
        }

        this.init = function() {
            var rows = document.getElementById(tableName).rows;
            var records = (rows.length - 1);
            this.pages = Math.ceil(records / itemsPerPage);
            this.inited = true;
        }
        this.showPageNav = function(pagerName, positionId) {
            if (! this.inited) {
                alert("not inited");
                return;
            }
            var element = document.getElementById(positionId);

            var pagerHtml = '<button class = "btn btn blue" onclick="' + pagerName + '.prev();" class="pg-normal">'+prevstr+ '</button>  ';
            for (var page = 1; page <= this.pages; page++)
                pagerHtml += '<button hidden id="pg' + page + '" class="pg-normal" onclick="' + pagerName + '.showPage(' + page + ');">' + page + '</button>  ';
            pagerHtml += '<button  class = "btn btn blue" onclick="'+pagerName+'.next();" class="pg-normal">'+nextstr+'</button>';

            element.innerHTML = pagerHtml;
        }
    }
</script>
<script src="<?= base_url('assets/js/my_custom_school.js') ?>" type="text/javascript"></script>