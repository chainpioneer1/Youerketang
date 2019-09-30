<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content" style="min-height: 1305px;">
        <h1 class="page-title"><?php echo $this->lang->line('sub_panel_title_subware');?>
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
                                            <label class="col-md-5 control-label"><?php echo $this->lang->line('SubwareName');?>:</label>
                                            <div class="col-md-7">
                                                <input type="text" class="form-control" id = "sw_name_search" placeholder="">
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
                                                <input type="text" class="form-control" id = "keyword_sw_search" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-4">
                                <div class="btn-group right-floated">
                                    <button  class=" btn sbold green" id="add_new_sw_btn"> <i class="fa fa-plus"></i><?php echo $this->lang->line('AddNew');?>
                                    </button>
                                </div>
                            </div>
                            <!-------Table tool parts----------------->
                        </div>
                        <!------Tool bar parts (add button and search function------>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover" id="swInfo_tbl">
                            <thead>
                            <tr>
                                <th style=""><?php echo $this->lang->line('SerialNumber');?></th>
                                <th style=""><?php echo $this->lang->line('SubwareName');?></th>
                                <th style=""><?php echo $this->lang->line('CourseName');?></th>
                                <th style=""><?php echo $this->lang->line('UnitName');?></th>
                                <th style=""><?php echo $this->lang->line('CoursewareName');?></th>
                                <th style=""><?php echo $this->lang->line('ApplicationUnit');?></th>
                                <th style=""><?php echo $this->lang->line('Operation');?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($subwares as $subware):
                                $pub = '';
                                if($subware->publish=='1')  $pub = $this->lang->line('UnPublish');
                                else   $pub = $this->lang->line('Publish');
                                ?>
                                <tr>
                                    <td align="center"><?php echo $subware->courseware_num;?></td>
                                    <td align="center"><?php echo $subware->subware_type_name;?></td>
                                    <td align="center"><?php echo $subware->course_name;?></td>
                                    <td align="center"><?php echo $subware->unit_type_name;?></td>
                                    <td align="center"><?php echo $subware->courseware_name;?></td>
                                    <td align="center"><?php echo $subware->school_type_name;?></td>
                                    <td align="center">
                                        <button class="btn btn-sm btn-success" onclick="edit_sw(this);"    sw_id = <?php echo $subware->subware_id;?>><?php echo $this->lang->line('Modify');?></button>
                                        <button class="btn btn-sm btn-warning" onclick="delete_sw(this);"  sw_id = <?php echo $subware->subware_id;?>><?php echo $this->lang->line('Delete');?></button>
                                        <button style="width:70px;" class="btn btn-sm btn-danger"  onclick="publish_sw(this);" sw_id = <?php echo $subware->subware_id;?>><?php echo $pub;?></button>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                            </tbody>
                        </table>
                        <div id="swpageNavPosition"></div>
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
    .uploading_backdrop
    {
        display: none;
        position: absolute;
        width: 100%;
        height: 100%;
        background-color: #000;
        opacity: 0.9;
        z-index: 12000;
    }
    #wait_ajax_loader
    {
        position: absolute;
        top: 41%;
        left: 50%;
        z-index:15000
    }
    #progress_percent
    {
        position: absolute;
        top:43%;
        left: 56.5%;
        font-size:18px;
        color: #fff;
        z-index: 17000
    }
</style>
<div class="uploading_backdrop"></div>
<div class="progressing_area" style="display: none">
  <img id="wait_ajax_loader" src='<?php echo base_url('assets/images/frontend/ajax-loader-1.gif');?>'/>
  <span style="position: absolute;top: 43%;left: 53.5%;font-size:18px;color: #fff;z-index: 16000"><?= $this->lang->line('uploading')?></span>
  <span id="progress_percent">0%</span>
</div>
<div id="sw_addNew_modal" class="modal fade" tabindex="-1" data-width="750">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $this->lang->line('AddNewSubWare');?></h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" enctype="multipart/form-data" action=""  id="sw_addNew_submit_form" role="form" method="post" accept-charset="utf-8">
            <div class="form-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-2">
                            <label class="control-label"><?php echo $this->lang->line('SubwareName');?>:</label>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" id="add_sw_type_name" name="add_sw_type_name">
                                <option><?php echo $this->lang->line('ScriptLeanrning');?></option>
                                <option><?php echo $this->lang->line('DemonstrationShow');?></option>
                                <option><?php echo $this->lang->line('VoiceDubbing');?></option>
                                <option><?php echo $this->lang->line('FunShooting');?></option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="control-label"><?php echo $this->lang->line('CoursewareName');?>:</label>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" id="add_sw_cw_name" name="add_sw_cw_name">
                                <!------OUTPUT COURSEWARES INORMATION------>
                                <?php foreach($cwsets as $cw):
                                    echo '<option>'.$cw->courseware_name.'</option>';
                                endforeach;?>
                                <!------OUTPUT COURSEWARES INORMATION------>
                            </select>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-2">
                            <label class="control-label"><?php echo $this->lang->line('UnitName');?>:</label>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" id="add_sw_unit_type_name" name="add_sw_unit_type_name">
                                <option><?php echo $this->lang->line('China');?></option>
                                <option><?php echo $this->lang->line('Western');?></option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="control-label"><?php echo $this->lang->line('CourseName');?>:</label>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" id="add_sw_course_name" name="add_sw_course_name">
                                <option><?php echo $this->lang->line('ChinaAndWestern');?></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-2">
                            <label class="control-label"><?php echo $this->lang->line('ApplicationUnit');?>:</label>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" id="add_sw_school_type_name" name="add_sw_school_type_name">
                                <option><?php echo $this->lang->line('PrimarySchool');?></option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="swFileUpload" class="control-label"><?php echo $this->lang->line('UploadSubwarePackage');?>:</label>
                        </div>
                        <div class="col-md-3">
                            <input type="file" id="add_cw_upload_img" name = "file_name">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-1">
                            <input type="text" hidden id="sw_info_id" value="" ><!--this is unit_id-->
                            <button type = "submit" class="btn green" id="add_sw_modify_save_btn" ><?php echo $this->lang->line('Save');?></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-------->
<!----------------------------EDIT MODAL------------------->
<div id="sw_modify_modal" class="modal fade" tabindex="-1" data-width="800">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $this->lang->line('ModifyUnitInfo');?></h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" enctype="multipart/form-data" action=""  id="sw_edit_submit_form" role="form" method="post" accept-charset="utf-8">
            <div class="form-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-2">
                            <label class="control-label"><?php echo $this->lang->line('SubwareName');?>:</label>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" id="sw_type_name" name="sw_type_name">
                                <?php foreach($subware_type_names as $sw_type_name):?>
                                    <option><?= $sw_type_name->subware_type_name;?>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="control-label"><?php echo $this->lang->line('CoursewareName');?>:</label>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" id="sw_cw_name" name="sw_cw_name">
                                <!------OUTPUT COURSEWARES INORMATION------>
                                <?php foreach($cwsets as $cw):
                                 echo '<option>'.$cw->courseware_name.'</option>';
                                endforeach;?>
                                <!------OUTPUT COURSEWARES INORMATION------>
                            </select>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-2">
                            <label class="control-label"><?php echo $this->lang->line('UnitName');?>:</label>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" id="sw_unit_type_name" name="sw_unit_type_name">
                                <option><?php echo $this->lang->line('China');?></option>
                                <option><?php echo $this->lang->line('Western');?></option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="control-label"><?php echo $this->lang->line('CourseName');?>:</label>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" id="sw_course_name" name="sw_course_name">
                                <option><?php echo $this->lang->line('ChinaAndWestern');?></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-2">
                            <label class="control-label"><?php echo $this->lang->line('ApplicationUnit');?>:</label>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" id="sw_school_type_name" name="sw_school_type_name">
                                <option><?php echo $this->lang->line('PrimarySchool');?></option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="swFileUpload" class="control-label"><?php echo $this->lang->line('UploadSubwarePackage');?>:</label>
                        </div>
                        <div class="col-md-3">
                            <input type="file" id="edit_cw_upload_file" name = "file_name">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-1">
                            <input type="text" hidden id="sw_info_id" value="" ><!--this is unit_id-->
                            <button type = "submit" class="btn green" id="sw_modify_save_btn" ><?php echo $this->lang->line('Save');?></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!----------------------------EDIT MODAL------------------->
<!----delete modal-->
<div id="sw_delete_modal" class="modal fade" tabindex="-1" data-width="300">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $this->lang->line('Message');?></h4>
    </div>
    <div class="modal-body" style="text-align:center;">
        <h4 class="modal-title"><?php echo $this->lang->line('DeleteConfirmMessage');?></h4>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn green" id="delete_sw_item_btn"><?php echo $this->lang->line('Yes');?></button>
        <button type="button" data-dismiss="modal"  class="btn btn-outline dark"><?php echo $this->lang->line('No');?></button>
    </div>
</div>
<!-------------------------------------------------->
<!----------pagenation-------->
<script type="text/javascript">
    var prevstr = "<?php echo $this->lang->line('PrevPage');?>";
    var nextstr = "<?php echo $this->lang->line('NextPage');?>";
    var baseURL = "<?php echo base_url();?>";
    var currentShowedPage = 1;
    var showedItems = 20;

    $('#subware_menu').addClass('menu-selected');

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
    var pager = new Pager('swInfo_tbl', showedItems);
    pager.init();
    pager.showPageNav('pager', 'swpageNavPosition');
    pager.showPage(1);
    //-->
</script>
<!---------pagenation module--------->
<script>

  function executionPageNation()
  {
      var pager = new Pager('swInfo_tbl', showedItems);
      pager.init();
      pager.showPageNav('pager', 'swpageNavPosition');
      pager.showPage(currentShowedPage);
  }
  function edit_sw(self)
  {
      var sw_id = self.getAttribute("sw_id");
      var tdtag = self.parentNode;
      var trtag = tdtag.parentNode;
      ///current i did not use below parameters
      var cw_sn = trtag.cells[0].innerHTML;
      var subware_type_name = trtag.cells[1].innerHTML;//(环节名称, exam:剧本学习,示范表演,趣拍摄,趣配音
      var course_name = trtag.cells[2].innerHTML;//(课程名称)
      var unit_type_name = trtag.cells[3].innerHTML;///china and western option
      var cw_name = trtag.cells[4].innerHTML;///courseware name
      var school_type_name = trtag.cells[5].innerHTML;///school type name is application unit:   适用学段 : 小学
      ///current i did not use above parameters

      $('#sw_type_name').find('option').filter(function (){
          return ( ($(this).val() == subware_type_name) || ($(this).text() == subware_type_name) )
      }).prop('selected',true);

      $('#sw_cw_name').find('option').filter(function (){
          return ( ($(this).val() == cw_name) || ($(this).text() == cw_name) )
      }).prop('selected',true);

      $('#sw_unit_type_name').find('option').filter(function (){
          return ( ($(this).val() == unit_type_name) || ($(this).text() == unit_type_name) )
      }).prop('selected',true);


      $("#sw_info_id").val(sw_id);

      var edit_fileTag = $('#edit_cw_upload_file');
      edit_fileTag.wrap('<form>').closest('form').get(0).reset();
      edit_fileTag.unwrap();

      jQuery("#sw_modify_modal").modal({
          backdrop: 'static',
          keyboard: false
      });
  }
  function delete_sw(self)
  {
      var sw_id = self.getAttribute("sw_id");
      jQuery("#sw_info_id").val(sw_id);
      jQuery("#delete_sw_item_btn").attr("delete_sw_id",sw_id);
      jQuery("#sw_delete_modal").modal({
          backdrop: 'static',
          keyboard: false
      });
  }
  function publish_sw(self)
  {
      var publish_sw_id = self.getAttribute("sw_id");
      var publish = "<?php echo $this->lang->line('Publish');?>";
      var unpublish = "<?php echo $this->lang->line('UnPublish');?>";
      var curBtnText = self.innerHTML;
      var pub_st = '1';
      if(unpublish==curBtnText)
      {
          self.innerHTML = publish;
          pub_st = '0';
      }
      else{
          self.innerHTML = unpublish;

      }
      ///ajax process for publish/unpublish
      jQuery.ajax({
          type: "post",
          url: baseURL+"admin/subwares/publish",
          dataType: "json",
          data: {publish_sw_id: publish_sw_id,publish_state:pub_st},
          success: function(res) {
              if(res.status=='success') {
                console.log('Subware Publishing has been success!..');}
              else//failed
              {
                  alert("Cannot delete CourseWare Item.");
              }
          }
      });
  }
//  add_new_sw_btn
  jQuery("#add_new_sw_btn").click(function () {

      jQuery("#sw_addNew_modal").modal({
          backdrop: 'static',
          keyboard: false
      });
  });
  jQuery("#sw_addNew_submit_form").submit(function (e) {
      ////////////////////////////////////////////////////////////////////////
      $(".uploading_backdrop").show();
      $(".progressing_area").show();
      e.preventDefault();
      $.ajax({
          url : baseURL+"admin/subwares/add",
          type: "POST",
          data :new  FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          async:true,
          xhr: function(){
              //upload Progress
              var xhr = $.ajaxSettings.xhr();
              if (xhr.upload) {
                  xhr.upload.addEventListener('progress', function(event) {
                      var percent = 0;
                      var position = event.loaded || event.position;
                      var total = event.total;
                      if (event.lengthComputable) {
                          percent = Math.ceil(position / total * 100);
                      }
                      $("#progress_percent").text(percent+'%');

                  }, true);
              }
              return xhr;
          },
          mimeType:"multipart/form-data"
      }).done(function(res){ //
          var ret;
          try{
              ret = JSON.parse(res);
          }catch(e){
              $(".uploading_backdrop").hide();
              $(".progressing_area").hide();
              alert('File Uploading has been failed');
              //jQuery("#sw_addNew_modal").modal('toggle');
              console.log('file uploading has been failed');
              return;
          }
          if(ret.status=='success') {
              var table = document.getElementById("swInfo_tbl");
              var tbody = table.getElementsByTagName("tbody")[0];
              tbody.innerHTML = ret.data;
              executionPageNation();
              $(".uploading_backdrop").hide();
              $(".progressing_area").hide();
              jQuery("#sw_addNew_modal").modal('toggle');
          }
          else//failed
          {
              alert('File Uploading has been failed. Operation failed');
              $(".uploading_backdrop").hide();
              $(".progressing_area").hide();
              jQuery("#sw_addNew_modal").modal('toggle');
              alert(ret.data);
          }
         });
// .fail(function(res){
//          alert('File Uploading has been failed, Post Error');
//          $(".uploading_backdrop").hide();
//          $(".progressing_area").hide();
//          //jQuery("#sw_addNew_modal").modal('toggle');
//      });
  });
  jQuery("#sw_edit_submit_form").submit(function (e) {

      $(".uploading_backdrop").show();
      $(".progressing_area").show();
      e.preventDefault();
      var sw_id = jQuery("#sw_info_id").val();
      var fdata = new  FormData(this);
      fdata.append("sw_id",sw_id);
      jQuery.ajax({
          url:baseURL+"admin/subwares/edit",
          type:"post",
          data:fdata,
          processData:false,
          contentType:false,
          cache:false,
          async:true,
          xhr: function(){
              //upload Progress
              var xhr = $.ajaxSettings.xhr();
              if (xhr.upload) {
                  xhr.upload.addEventListener('progress', function(event) {
                      var percent = 0;
                      var position = event.loaded || event.position;
                      var total = event.total;
                      if (event.lengthComputable) {
                          percent = Math.ceil(position / total * 100);
                      }
                      $("#progress_percent").text(percent+'%');
                  }, true);
              }
              return xhr;
          },
          mimeType:"multipart/form-data"
      }).done(function(res){
          var ret;
          try{
              ret = JSON.parse(res);
          }catch(e){
              $(".uploading_backdrop").hide();
              $(".progressing_area").hide();
              jQuery('#sw_modify_modal').modal('toggle');
              alert('File uploading has been failed.');
              console.log(res);
              return;
          }
          if(ret.status=='success') {
              var table = document.getElementById("swInfo_tbl");
              var tbody = table.getElementsByTagName("tbody")[0];
              tbody.innerHTML = ret.data;
              executionPageNation();
              $(".uploading_backdrop").hide();
              $(".progressing_area").hide();
              jQuery('#sw_modify_modal').modal('toggle');
          }
          else//failed
          {
              $(".uploading_backdrop").hide();
              $(".progressing_area").hide();
              alert('File uploading has beeb failed');
              console.log(ret.data)
          }
      });

  });
  jQuery("#delete_sw_item_btn").click(function () {

      jQuery('#sw_delete_modal').modal('toggle');
      var delete_sw_id = jQuery("#delete_sw_item_btn").attr("delete_sw_id");
      jQuery.ajax({
          type: "post",
          url: baseURL+"admin/subwares/delete",
          dataType: "json",
          data: {delete_sw_id: delete_sw_id},
          success: function(res) {
             if(res.status=='success') {
                var table = document.getElementById("swInfo_tbl");
                  var tbody = table.getElementsByTagName("tbody")[0];
                  tbody.innerHTML = res.data;
                  executionPageNation();
              }
              else//failed
              {
                  alert(ret.data);
              }
          }
    });

  });
  jQuery("#sw_name_search").keyup(function () {

      var input, filter, table, tr, td, i;
      input = document.getElementById("sw_name_search");
      filter = input.value.toUpperCase();
      table = document.getElementById("swInfo_tbl");
      tr = table.getElementsByTagName("tr");
      // Loop through all table rows, and hide those who don't match the search query
      for (i = 0; i < tr.length; i++) {
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
  jQuery("#keyword_sw_search").keyup(function () {///search for keyword
      var input, filter, table, tr, td, i,tdCnt;
      input = document.getElementById("keyword_sw_search");
      filter = input.value.toUpperCase();
      table = document.getElementById("swInfo_tbl");
      tr = table.getElementsByTagName("tr");
      // Loop through all table rows, and hide those who don't match the search query
      for (i = 0; i < tr.length; i++) {

          var cmpst = 0;
          for(j=0;j<6;j++)//6 is search filed count
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



