<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content" style="min-height: 1305px;">
        <h1 class="page-title"><?php echo $this->lang->line('sub_panel_title_user'); ?>
            <small></small>
        </h1>
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bordered">
                    <div class="table-toolbar">
                        <!-------Table tool parts----------------->
                        <form action="userinfo_download" method="post" class="form-horizontal">
                            <div class="form-group">
                                <label class="col-md-1 control-label"><?php echo $this->lang->line('Account'); ?>
                                    :</label>
                                <div class="col-md-1" style="    padding-left: 0;padding-right: 0;">
                                    <input type="text" class="form-control" id="username_search" placeholder="">
                                </div>
                                <label class="col-md-1 control-label"><?php echo $this->lang->line('Name'); ?>:</label>
                                <div class="col-md-1" style="padding-left: 0;padding-right: 0">
                                    <input type="text" class="form-control" id="fullname_search" placeholder="">
                                </div>
                                <label class="col-md-1 control-label"><?php echo $this->lang->line('Gender'); ?>
                                    :</label>
                                <div class="col-md-1" style="padding-left:0px;padding-right:0px;">
                                    <select class="form-control" id="sex_search" name="sex_search">
                                        <option><?php echo $this->lang->line('PlaceChoose'); ?></option>
                                        <option><?php echo $this->lang->line('Male'); ?></option>
                                        <option><?php echo $this->lang->line('Female'); ?></option>
                                    </select>
                                </div>
                                <label class="col-md-2 control-label right"><?php echo $this->lang->line('GenerationTime'); ?>
                                    :</label>
                                <div class="col-md-4">
                                    <input class="form-control form-control-inline input-small date-picker left-aligned"
                                           size="20" data-date-format="yyyy-mm-dd"
                                           type="text" id="startTime_search" value="">
                                    <label class="control-label left-aligned"
                                           style="margin:0 10px;"><?php echo $this->lang->line('To'); ?></label>
                                    <input class="form-control form-control-inline input-small date-picker left-aligned"
                                           size="20" data-date-format="yyyy-mm-dd"
                                           type="text" id="endTime_search" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-1 control-label"><?php echo $this->lang->line('UserType'); ?>
                                    :</label>
                                <div class="col-md-1" style="padding-left:0;padding-right:0;">
                                    <select class="form-control" id="user_type_search" name="user_type_search">
                                        <option><?php echo $this->lang->line('PlaceChoose'); ?></option>
                                        <option><?php echo $this->lang->line('Student'); ?></option>
                                        <option><?php echo $this->lang->line('Teacher'); ?></option>
                                    </select>
                                </div>
                                <label class="col-md-1 control-label"><?php echo $this->lang->line('Grade'); ?>:</label>
                                <div class="col-md-1" style="padding-left: 0;padding-right: 0;">
                                    <select class="form-control" id="grade_search" name="grade_search">
                                        <option><?php echo $this->lang->line('PlaceChoose'); ?></option>
                                        <option><?php echo $this->lang->line('FirstGrade'); ?></option>
                                        <option><?php echo $this->lang->line('SecondGrade'); ?></option>
                                        <option><?php echo $this->lang->line('ThirdGrade'); ?></option>
                                        <option><?php echo $this->lang->line('FourthGrade'); ?></option>
                                        <option><?php echo $this->lang->line('FifthGrade'); ?></option>
                                    </select>
                                </div>
                                <label class="col-md-1 control-label"
                                       style="text-align:center;"><?php echo $this->lang->line('SchoolName'); ?>
                                    :</label>
                                <div class="col-md-1" style="padding-left: 0;padding-right: 0;">
                                    <select class="form-control" id="school_search" name="school_search">
                                        <option><?php echo $this->lang->line('PlaceChoose'); ?></option>
                                        <?php foreach ($schools as $school):
                                            echo '<option>' . $school->school_name . '</option>';
                                        endforeach; ?>
                                    </select>
                                </div>
                                <!--<label class="col-md-1 control-label" style="text-align:center;"><?php echo $this->lang->line('BuyCourse'); ?>:</label>
                                <div class="col-md-1" style="padding-left: 0;padding-right: 0;">
                                    <select class="form-control" id="buycourse_search" name="buycourse_search" value="">
                                        <option value="<?= $this->lang->line('PlaceChoose'); ?>"><?php // echo $this->lang->line('PlaceChoose');?></option>
                                        <?php //foreach($courses as $cs):
                                //                                            echo '<option value="'.$cs->course_slug.'">'.$this->lang->line($cs->course_slug).'</option>';
                                //                                        endforeach;?>
                                    </select>
                                </div>-->
                                <div class="col-md-3">
                                    <div class="btn-group" style="margin-right:5px;margin-left:11px">
                                        <button type="button" class="btn blue" id="search_info_btn"
                                                onclick="search_user_info_click();"><i
                                                    class="fa fa-search"></i>&nbsp<?php echo $this->lang->line('Inquire'); ?>
                                        </button>
                                    </div>
                                    <div class="btn-group" style="margin-right:8px">
                                        <button class="btn  blue" id="download_info_btn"><i
                                                    class="fa fa-download"></i><?php echo $this->lang->line('Download'); ?>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-3 right-aligned">
                                    <div class="btn-group">
                                        <button type="button" class="btn blue"
                                                id="add_user_btn" style="margin-right:5px;"
                                                onclick="add_user_click();">
                                            <i class="fa fa-user-plus"></i>
                                            <?php echo $this->lang->line('AddNewUser'); ?>
                                        </button>
                                    </div>
                                    <div class="btn-group ">
                                        <button type="button" class="btn blue" id="add_bulk_user_btn"
                                                onclick="add_bulk_user_click();"><?php echo $this->lang->line('GenerateBulkUser'); ?>
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </form>
                        <!-------Table tool parts----------------->
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover" id="userInfo_tbl">
                            <thead>
                            <tr>
                                <th onclick="selectAllItem();"><a
                                            style="text-decoration: none;"><?php echo $this->lang->line('SelectAll'); ?></a>
                                </th>
                                <th onclick="deleteSelectedItem();"><a
                                            style="text-decoration: none;color: #ffafed"><?php echo $this->lang->line('SelectDelete'); ?></a>
                                </th>
                                <th><?php echo $this->lang->line('SerialNumber'); ?></th>
                                <th><?php echo $this->lang->line('Account'); ?></th>
                                <th><?php echo $this->lang->line('Name'); ?></th>
                                <th><?php echo $this->lang->line('Gender'); ?></th>
                                <th><?php echo $this->lang->line('Grade/Class'); ?></th>
                                <th><?php echo $this->lang->line('School'); ?></th>
                                <th><?php echo $this->lang->line('UserType'); ?></th>
                                <th width="15%"><?php echo $this->lang->line('GenerationTime'); ?></th>
                                <!--<th>
                                <?php //echo $this->lang->line('BuyCourse');?></th>-->
                                <th><?php echo $this->lang->line('Operation'); ?></th>
                            </tr>
                            </thead>
                            <tbody><?= $tbl_content ?></tbody>
                        </table>
                        <div id="userpageNavPosition"></div>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
<!-------Add New User Modal----------->
<div id="add_user_modal" class="modal fade" tabindex="-1" data-width="750">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $this->lang->line('AddNewUser'); ?></h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" enctype="multipart/form-data" action="" id="add_user_submit_form" role="form"
              method="post" accept-charset="utf-8">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-offset-0 col-md-2 control-label"><?php echo $this->lang->line('Name'); ?>
                        :</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="add_fullname" id="add_fullname" value="">
                    </div>
                    <label class="col-md-offset-1 col-md-2 control-label"><?php echo $this->lang->line('Gender'); ?>
                        :</label>
                    <div class="col-md-3">
                        <select class="form-control" id="add_user_sex" name="add_user_sex">
                            <option><?php echo $this->lang->line('Male'); ?></option>
                            <option><?php echo $this->lang->line('Female'); ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-offset-0 col-md-2 control-label"><?php echo $this->lang->line('Account'); ?>
                        :</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="add_username" id="add_username" value="">
                    </div>
                    <label class="col-md-offset-1 col-md-2 control-label"><?php echo $this->lang->line('School'); ?>
                        :</label>
                    <div class="col-md-3">
                        <select class="form-control" id="add_user_school_name" name="add_user_school_name"
                                onchange="choiceSchool('add')">
                            <?php foreach ($schools as $school):
                                echo '<option>' . $school->school_name . '</option>';
                            endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-offset-0 col-md-2 control-label"><?php echo $this->lang->line('Password'); ?>
                        :</label>
                    <div class="col-md-3">
                        <input type="password" style="font-size:30px;" class="form-control" name="add_userpassword"
                               id="add_userpassword" value="" onkeyup="confirmPassword()">
                    </div>
                    <label class="col-md-offset-1 col-md-2 control-label"><?php echo $this->lang->line('UserType'); ?>
                        :</label>
                    <div class="col-md-3">
                        <select class="form-control" id="add_user_type_id" name="add_user_type_id">
                            <option value="2"><?php echo $this->lang->line('Student'); ?></option>
                            <option value="1"><?php echo $this->lang->line('Teacher'); ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-offset-0 col-md-2 control-label"><?php echo $this->lang->line('RepetPassword'); ?>
                        :</label>
                    <div class="col-md-3">
                        <input type="password" style="font-size:30px;" class="form-control"
                               name="add_userrepeatpassword" id="add_userrepeatpassword" value=""
                               onkeyup="confirmPassword()">
                    </div>
                    <label class="col-md-offset-1 col-md-2 control-label"
                           id="add_grade_class_lbl"><?php echo $this->lang->line('Grade/Class'); ?>:</label>
                    <div class="col-md-3">
                        <select class="form-control" id="add_grade_class" name="add_grade_class">

                        </select>
                        <!----------Below code is to init grade/class select box when page was loaded------------>
                        <?php
                        $sh_html = array();
                        foreach ($schools as $school):
                            $classStr = $this->lang->line('Class');
                            $gradeStr = $this->lang->line('Grade');
                            $output = '';
                            $jsonStr = $school->class_arr;
                            $classArr = json_decode($jsonStr);
                            foreach ($classArr as $class_info):
                                $gradeNo = $class_info->grade;
                                $realStr = $this->lang->line($gradeNo - 1);
                                for ($i = 1; $i <= $class_info->class; $i++) {
                                    $realClassStr = $this->lang->line($i - 1);
                                    $output .= '<option>';
                                    $output .= $realStr . $gradeStr . $realClassStr . $classStr;
                                    $output .= '</option>';
                                }
                            endforeach;
                            $sh_html[$school->school_name] = $output;
                            //echo $output;
                            //break;
                        endforeach; ?>
                        <!----------above code is to init grade/class select box when page was loaded------------>
                        <input id="all_schools" style="display: none;" value='<?= json_encode($sh_html) ?>'>
                    </div>
                </div>
                <div class="form-group visible-ie8 visible-ie9">
                    <label class="col-md-offset-6 col-md-2 control-label"><?php echo $this->lang->line('ChooseCourse'); ?>
                        :</label>
                    <div class="col-md-4">
                        <div class="mt-checkbox-inline">
                            <?php foreach ($courses as $cs): ?>
                                <label class="mt-checkbox mt-checkbox-outline">
                                    <input type="checkbox" class="buycourse_chk"
                                           data-id="<?= $cs->course_id; ?>"
                                           data-slug="<?= $cs->course_slug ?>">
                                    <?php echo $this->lang->line($cs->course_slug); ?>
                                    <span></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-1">
                            <input type="text" hidden id="add_sw_info_id" value=""><!--this is unit_id-->
                            <button type="submit" class="btn green" id="add_user_save_btn"
                                    style="margin-top:30px;"><?php echo $this->lang->line('Generation'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!------- Add New User Modal ----------->
<!------- Edit User Modal -------------->
<div id="edit_user_modal" class="modal fade" tabindex="-1" data-width="700">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $this->lang->line('ModifyUserInfo'); ?></h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" enctype="multipart/form-data" action="" id="edit_user_submit_form" role="form"
              method="post" accept-charset="utf-8">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-offset-0 col-md-2 control-label"><?php echo $this->lang->line('Name'); ?>
                        :</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="edit_fullname" id="edit_fullname" value="">
                    </div>
                    <label class="col-md-offset-1 col-md-2 control-label"><?php echo $this->lang->line('Gender'); ?>
                        :</label>
                    <div class="col-md-3">
                        <select class="form-control" id="edit_user_sex" name="edit_user_sex">
                            <option><?php echo $this->lang->line('Male'); ?></option>
                            <option><?php echo $this->lang->line('Female'); ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-offset-0 col-md-2 control-label"><?php echo $this->lang->line('Account'); ?>
                        :</label>
                    <div class="col-md-3">
                        <label class="col-md-2 control-label" name="edit_username" id="edit_username"
                               style="font-weight:bold;"></label>
                    </div>
                    <label class="col-md-offset-1 col-md-2 control-label"><?php echo $this->lang->line('School'); ?>
                        :</label>
                    <div class="col-md-3">
                        <select class="form-control" id="edit_user_school_name" name="edit_user_school_name"
                                onchange="choiceSchool('edit')">
                            <?php foreach ($schools as $school):
                                echo '<option>' . $school->school_name . '</option>';
                            endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-offset-0 col-md-2 control-label"><?php echo $this->lang->line('Password'); ?>
                        :</label>
                    <div class="col-md-3">
                        <label class="control-label" name="edit_userpassword" id="edit_userpassword">*****<a
                                    onclick="expandPasswordBox()"
                                    style="color:red;font-weight: bold;text-decoration: none;"><?php echo $this->lang->line('RepetPassword'); ?></a></label>
                    </div>
                    <label class="col-md-offset-1 col-md-2 control-label"><?php echo $this->lang->line('UserType'); ?>
                        :</label>
                    <div class="col-md-3">
                        <select class="form-control" id="edit_user_type_id" name="edit_user_type_id" value="">
                            <option value="2"><?php echo $this->lang->line('Student'); ?></option>
                            <option value="1"><?php echo $this->lang->line('Teacher'); ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-offset-0 col-md-2 control-label" id="newPasswordLabel"></label>
                    <div class="col-md-3">
                        <input type="password" style="font-size:30px;display:none" class="form-control"
                               name="edit_usernewpassword" id="edit_usernewpassword" value=""
                               onkeyup="confirmNewPassword()">
                    </div>
                    <label class="col-md-offset-1 col-md-2 control-label"
                           id="edit_grade_class_lbl"><?php echo $this->lang->line('Grade/Class'); ?>:</label>
                    <div class="col-md-3">
                        <select class="form-control" id="edit_grade_class" name="edit_grade_class"></select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-offset-0 col-md-2 control-label" id="confirmPasswordLabel"></label>
                    <div class="col-md-3">
                        <input type="password" style="font-size:30px;display:none" class="form-control"
                               name="edit_userrepeatpassword" id="edit_userrepeatpassword" value=""
                               onkeyup="confirmNewPassword()">
                    </div>
                    <div class="visible-ie8 visible-ie9">
                        <label class="col-md-offset-1 col-md-2 control-label"><?php echo $this->lang->line('ChooseCourse'); ?>
                            :</label>
                        <div class="col-md-4">
                            <div class="mt-checkbox-inline">
                                <?php foreach ($courses as $cs): ?>
                                    <label class="mt-checkbox mt-checkbox-outline">
                                        <input type="checkbox" class="edit_buycourse_chk"
                                               id="<?= $cs->course_slug ?>"
                                               data-slug="<?= $cs->course_slug ?>">
                                        <?php // echo $this->lang->line($cs->course_slug); ?>
                                        <span></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="form-group">
                    <div class="row" style="margin-top:30px;">
                        <div class="col-md-1"></div>
                        <div class="col-md-1">
                            <input type="text" hidden id="user_info_id" value=""><!--this is unit_id-->
                            <button type="submit" class="btn green"
                                    id="edit_user_save_btn"><?php echo $this->lang->line('Save'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!------- Edit User Modal -------------->
<!--------Delete Modal --------------->
<div id="user_delete_modal" class="modal fade" tabindex="-1" data-width="300">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $this->lang->line('Message'); ?></h4>
    </div>
    <div class="modal-body" style="text-align:center;">
        <h4 class="modal-title"><?php echo $this->lang->line('DeleteConfirmMessage'); ?></h4>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn green" id="delete_user_btn"><?php echo $this->lang->line('Yes'); ?></button>
        <button type="button" data-dismiss="modal"
                class="btn btn-outline dark"><?php echo $this->lang->line('No'); ?></button>
    </div>
</div>
<!-------- Delete Modal --------------->

<!--------Modal to Generate Users In Bulk  ------------------>
<div id="add_bulk_user_modal" class="modal fade" tabindex="-1" data-width="700">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $this->lang->line('GenerateBulkUser'); ?></h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" enctype="multipart/form-data" action="bulk_download"
              id="add_bulk_user_submit_form" role="form" method="post" accept-charset="utf-8">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-offset-0 col-md-2 control-label"><?php echo $this->lang->line('School'); ?>
                        :</label>
                    <div class="col-md-3">
                        <select class="form-control" id="add_bulk_school_id" name="add_bulk_school_id" value="">
                            <?php foreach ($schools as $school):
                                echo '<option value ="' . $school->school_id . '">' . $school->school_name . '</option>';
                            endforeach; ?>
                        </select>
                    </div>
                    <label class="col-md-offset-1 col-md-2 control-label"
                           id="bulk_quantity_str"><?php echo $this->lang->line('Quantity'); ?>:</label>
                    <div class="col-md-3">
                        <input type="number" style="font-size:20px;" min="0"
                               class="form-control" name="add_bulk_quantity"
                               id="add_bulk_quantity" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label"><?php echo $this->lang->line('UserType'); ?>:</label>
                    <div class="col-md-3">
                        <select class="form-control" id="add_bulk_user_type" name="add_bulk_user_type">
                            <option value="1"><?php echo $this->lang->line('Teacher'); ?></option>
                            <option value="2"><?php echo $this->lang->line('Student'); ?></option>
                        </select>
                    </div>
                    <div class="visible-ie8 visible-ie9">
                        <label class="col-md-offset-1 col-md-2 control-label"><?php echo $this->lang->line('ChooseCourse'); ?>
                            :</label>
                        <div class="col-md-4">
                            <div class="mt-checkbox-inline">
                                <?php foreach ($courses as $cs): ?>
                                    <label class="mt-checkbox mt-checkbox-outline">
                                        <input type="checkbox" name="<?= $cs->course_slug ?>" class="bulk_buycourse_chk"
                                               data-id="<?= $cs->course_id; ?>"
                                               data-slug="<?= $cs->course_slug ?>">
                                        <?php echo $this->lang->line($cs->course_slug); ?>
                                        <span></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-1">
                            <input type="text" hidden id="sw_info_id" value=""><!--this is unit_id-->
                            <button type="submit" class="btn green"
                                    id="add_bulk_user_save_btn"><?php echo $this->lang->line('Generation'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
<!--------Modal to Generate Users In Bulk ------------------>

<script>
    $('#user_menu').addClass('menu-selected');
    var baseURL = "<?php echo base_url();?>";
    var techcherStr = '<?php echo $this->lang->line("Teacher");?>';
    var showeNewPassBox = 0;
    var bulkAddType = false;//if bulkAddType=true then input for student, else teacher
    //*************************pagenation module
    var prevstr = "<?php echo $this->lang->line('PrevPage');?>";
    var nextstr = "<?php echo $this->lang->line('NextPage');?>";
    var currentShowedPage = 1;
    var showedItems = 6;

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
        }

        this.showPage = function (pageNumber) {
            if (!this.inited) {
                alert("not inited");
                return;
            }
            var oldPageAnchor = document.getElementById('pg' + this.currentPage);
            if (oldPageAnchor) {
                this.currentPage = pageNumber;
                var newPageAnchor = document.getElementById('pg' + this.currentPage);
                newPageAnchor.className = 'pg-selected';

                var from = (pageNumber - 1) * itemsPerPage + 1;
                var to = from + itemsPerPage - 1;
                this.showRecords(from, to);
            } else {
                return;
            }

            oldPageAnchor.className = 'pg-normal';


        }

        this.prev = function () {
            if (this.currentPage > 1) {

                currentShowedPage = this.currentPage - 1;
                this.showPage(this.currentPage - 1);
            }

        }

        this.next = function () {
            if (this.currentPage < this.pages) {

                currentShowedPage = this.currentPage + 1;
                this.showPage(this.currentPage + 1);
            }
        }

        this.init = function () {
            var rows = document.getElementById(tableName).rows;
            var records = (rows.length - 1);
            this.pages = Math.ceil(records / itemsPerPage);
            this.inited = true;
        }
        this.showPageNav = function (pagerName, positionId) {
            if (!this.inited) {
                alert("not inited");
                return;
            }
            var element = document.getElementById(positionId);

            var pagerHtml = '<button class = "btn btn blue" onclick="' + pagerName + '.prev();" class="pg-normal">' + prevstr + '</button>  ';
            for (var page = 1; page <= this.pages; page++)
                pagerHtml += '<button hidden id="pg' + page + '" class="pg-normal" onclick="' + pagerName + '.showPage(' + page + ');">' + page + '</button>  ';
            pagerHtml += '<button  class = "btn btn blue" onclick="' + pagerName + '.next();" class="pg-normal">' + nextstr + '</button>';

            element.innerHTML = pagerHtml;
        }
    }

    var pager = new Pager('userInfo_tbl', showedItems);
    pager.init();
    pager.showPageNav('pager', 'userpageNavPosition');
    pager.showPage(currentShowedPage);

    function executionPageNation() {
        pager.showPageNav('pager', 'userpageNavPosition');
        pager.showPage(currentShowedPage);
    }

    function initEditModal() {
        $("#newPasswordLabel").text('');
        $("#confirmPasswordLabel").text('');
        $("#edit_usernewpassword").hide();
        $("#edit_userrepeatpassword").hide();
    }

    function choiceSchool(sh_type) {
        var gradeClassList = document.getElementById(sh_type + '_grade_class');
        var seltedSchoolName = document.getElementById(sh_type + '_user_school_name').value;
        var all_schools = JSON.parse($('#all_schools').val());
        gradeClassList.innerHTML = (all_schools[seltedSchoolName]);
//        $.ajax({
//            type: "post",
//            url: baseURL + "admin/users/getclass",
//            dataType: "json",
//            data: {school_name: seltedSchoolName, bulk_type: '1'},
//            success: function (res) {
//                if (res.status == 'success') {
//                    gradeClassList.innerHTML = res.data;
//                }
//                else//failed
//                {
//                    alert("Cannot delete CourseWare Item.");
//                }
//            }
//        });
    }

    //    var schoolId = $('#add_bulk_user_school_name').val();
    function edit_user(self) {
        var userId = self.getAttribute('user_id');
        var kebenjust = self.getAttribute('data-kebenju');
        var sandapianst = self.getAttribute('data-sandapian');

        $('.edit_buycourse_chk').prop('checked', false);
        if (kebenjust == '1') $('#kebenju').prop('checked', true);
        if (sandapianst == '1') $('#sandapian').prop('checked', true);

        $('#user_info_id').val(userId);
        var tdtag = self.parentNode;
        var trtag = tdtag.parentNode;
        var username = trtag.cells[2].innerHTML;
        var fullname = trtag.cells[3].innerHTML;
        var genderName = trtag.cells[4].innerHTML;
        var className = trtag.cells[5].innerHTML;
        var schoolName = trtag.cells[6].innerHTML;
        var user_type_name = trtag.cells[7].innerHTML;

        $('#edit_user_type_id').find('option').filter(function () {
            return ( ($(this).val() == user_type_name) || ($(this).text() == user_type_name) )
        }).prop('selected', true);

        $('#edit_fullname').val(fullname);
        $('#edit_username').text(username);
        $('#edit_user_sex').val(genderName);

        initEditModal();
        $('#edit_user_school_name').val(schoolName);
        choiceSchool('edit');
        $('#edit_grade_class').val(className);

        $('#edit_user_modal').modal({backdrop: 'static', keyboard: false})
    }

    function delete_user(self) {
        var user_id = self.getAttribute("user_id");
        jQuery("#delete_user_btn").attr("user_id", user_id);
        jQuery("#user_delete_modal").modal({
            backdrop: 'static',
            keyboard: false
        });
    }

    function expandPasswordBox() {
        var newPassStr = '<?php echo $this->lang->line('NewPassword');?>:';
        var confirmPassStr = '<?php echo $this->lang->line('RepetPassword');?>:';
        var editSaveButton = document.getElementById('edit_user_save_btn');

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

    function confirmPassword() {
        var addSaveButton = document.getElementById('add_user_save_btn');
        var userPassBox = document.getElementById("add_userpassword");
        var userpass = userPassBox.value;
        var userRepeatPassBox = document.getElementById("add_userrepeatpassword");
        var userRepeatPass = userRepeatPassBox.value;
        if (userpass == userRepeatPass) {
            userRepeatPassBox.style.borderColor = '#c2cad8';
            userRepeatPassBox.style.borderWidth = '1px';
            userRepeatPassBox.style.borderStyle = 'solid';
            addSaveButton.disabled = false;
        } else {
            userRepeatPassBox.style.borderColor = '#f00';
            userRepeatPassBox.style.borderWidth = '2px';
            userRepeatPassBox.style.borderStyle = 'solid';
            addSaveButton.disabled = true;
        }
    }

    function confirmNewPassword() {
        var editSaveButton = document.getElementById('edit_user_save_btn');
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

    function add_bulk_user_click() {
        $('#add_bulk_quantity').val('0');
        $('#add_bulk_user_modal').modal({backdrop: 'static', keyboard: false});
    }

    $('#add_bulk_user_submit_form').submit(function (e) {
        var quantity = parseInt($('#add_bulk_quantity').val());
        if (quantity <= 0) {
            e.preventDefault(e);
            alert('Please input correct count of users.');
        }
    });

    function publish_user(self) {
        var publishStr = "<?php echo $this->lang->line('Publish');?>";
        var unPublishStr = "<?php echo $this->lang->line('UnPublish');?>";
        var published_user_id = self.getAttribute("user_id");
        var tdtag = self.parentNode;
        var trtag = tdtag.parentNode;
        var username = trtag.cells[2].innerHTML;
        var fullname = trtag.cells[3].innerHTML;
        var genderName = trtag.cells[4].innerHTML;


        var curBtnText = self.innerHTML.trim();
        var publish_st = '0';

        if (publishStr == curBtnText) publish_st = '1';

        if (publish_st=='1' &&( fullname == '' || genderName == '')) {
            alert('请输入所有用户信息.');
            return;
        }

        ///ajax process for publish/unpublish
        $.ajax({
            type: "post",
            url: baseURL + "admin/users/publish",
            dataType: "json",
            data: {user_id: published_user_id, publish_st: publish_st},
            success: function (res) {
                if (res.status == 'success') {
                    var table = document.getElementById("userInfo_tbl");
                    var tbody = table.getElementsByTagName("tbody")[0];
                    tbody.innerHTML = res.data;
                    executionPageNation();
                    console.log('publication has been successed!');
                }
                else//failed
                {
                    alert("Publish Failed.");
                }
            }
        });
    }

    function search_user_info_click() {
        //get user name
        var username = $('#username_search').val();
        var fullname = $('#fullname_search').val();
        var sex = $('#sex_search').val();
        var startTime = $('#startTime_search').val();
        var endTime = $('#endTime_search').val();
        var usertype = $('#user_type_search').val();
        var grade = $('#grade_search').val();
        var schoolname = $('#school_search').val();
//        alert(startTime);
        var postData = {
            username: username,
            fullname: fullname,
            sex: sex,
            startTime: startTime,
            endTime: endTime,
            usertype: usertype,
            grade: grade,
            schoolname: schoolname,
        };
        jQuery.ajax({
            type: "post",
            url: baseURL + "admin/users/search",
            dataType: "json",
            data: postData,
            success: function (res) {
                if (res.status == 'success') {
                    ///if click publish/unpublish button, don't need to update table
                    var table = document.getElementById("userInfo_tbl");
                    var tbody = table.getElementsByTagName("tbody")[0];
                    tbody.innerHTML = res.data;
                    executionPageNation();
                }
                else//failed
                {
                    alert("Search Failed.");
                }
            },
            error: function (err) {
                alert("Search Failed.")
            }
        });

    }

    $('#add_bulk_user_type').change(function () {
        var valueSelected = this.value;
        if (valueSelected == techcherStr) {
            bulkAddType = 1;
        }
        else {
            bulkAddType = 0;
        }
    });
    $('#edit_user_type_id').change(function () {

        if ($(this).val() == '1')//this is teacher
        {
            $('#edit_grade_class').hide();
            $('#edit_grade_class_lbl').hide();
        } else {

            $('#edit_grade_class').show();
            $('#edit_grade_class_lbl').show();
        }
    });
    $('#add_user_type_id').change(function () {

        if ($(this).val() == '1')//this is teacher
        {
            $('#add_grade_class').hide();
            $('#add_grade_class_lbl').hide();
        } else {

            $('#add_grade_class').show();
            $('#add_grade_class_lbl').show();
        }
    })
</script>
<script src="<?= base_url('assets/js/my_custom_user.js') ?>" type="text/javascript"></script>



