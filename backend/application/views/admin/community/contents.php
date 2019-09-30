<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content" style="min-height: 1305px;">
        <h1 class="page-title"><?php echo $this->lang->line('sub_panel_title_content');?>
            <small></small>
        </h1>
        <div class="row">
            <div class="col-md-9">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bordered">
                    <div class="table-toolbar">
                        <!-------Table tool parts----------------->
                        <!-------Table tool parts----------------->
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover" id="contentInfo_tbl">
                            <thead>
                            <tr>
                                <th style="width:8%"><?php echo $this->lang->line('SerialNumber');?></th>
                                <th style="width:12%" ><?php echo $this->lang->line('WorkName');?></th>
                                <th style="width:12%"><?php echo $this->lang->line('WorkType');?></th>
                                <th style="width:8%"><?php echo $this->lang->line('Author');?></th>
                                <th style="width:12%"><?php echo $this->lang->line('School');?></th>
                                <th style="width:15%"><?php echo $this->lang->line('ShareTime');?></th>
                                <th style="width:8%"><?php echo $this->lang->line('VisitNum');?></th>
                                <th style="width:8%"><?php echo $this->lang->line('Operation');?></th>
                            </tr>
                            </thead>
                            <tbody>
                              <?php foreach($contents as $content):?>
                                <tr>
                                    <td><?php echo $content->content_id;?></td>
                                    <td><a  href="#" onclick="show_work_detail(this);" content_id = <?php echo $content->content_id;?> style="text-decoration: none;"><?php echo $content->content_title;?></a></td>
                                    <td><?php echo $content->content_type_name;?></td>
                                    <td><?php echo $content->username;?></td>
                                    <td><?php echo $content->school_name;?></td>
                                    <td><?php echo $content->share_time;?></td>
                                    <td><?php echo $content->view_num;?></td>
                                    <td>
                                        <button style="width:70px;" class="btn btn-sm btn-warning" onclick="delete_content(this);"  content_id = <?php echo $content->content_id;?>><?php echo $this->lang->line('Delete');?></button>
                                    </td>
                                </tr>
                              <?php endforeach;?>
                            </tbody>
                        </table>
                        <div id="contentpageNavPosition"></div>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->

<!--------Delete Modal --------------->
<div id="content_delete_modal" class="modal fade" tabindex="-1" data-width="300">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $this->lang->line('Message');?></h4>
    </div>
    <div class="modal-body" style="text-align:center;">
        <h4 class="modal-title"><?php echo $this->lang->line('DeleteConfirmMessage');?></h4>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn green" id="delete_content_btn"><?php echo $this->lang->line('Yes');?></button>
        <button type="button" data-dismiss="modal"  class="btn btn-outline dark"><?php echo $this->lang->line('No');?></button>
    </div>
</div>
<!-------- Delete Modal --------------->
<style>
    #contentInfo_tbl thead tr th,#contentInfo_tbl tbody tr td
    {
        text-align:center;vertical-align: middle;
    }
</style>
<script>
    $('#content_menu').addClass('menu-selected');
    var prevstr = "<?php echo $this->lang->line('PrevPage');?>";
    var nextstr = "<?php echo $this->lang->line('NextPage');?>";
    var currentShowedPage = 1;
    var showedItems = 15;
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
            oldPageAnchor.className = 'pg-normal';

            this.currentPage = pageNumber;
            var newPageAnchor = document.getElementById('pg'+this.currentPage);
            newPageAnchor.className = 'pg-selected';

            var from = (pageNumber - 1) * itemsPerPage + 1;
            var to = from + itemsPerPage - 1;
            this.showRecords(from, to);
        }

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
        };

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
    var pager = new Pager('contentInfo_tbl', showedItems);
    pager.init();
    pager.showPageNav('pager', 'contentpageNavPosition');
    pager.showPage(currentShowedPage);
    function executionPageNation()
    {
        pager.showPageNav('pager', 'contentpageNavPosition');
        pager.showPage(currentShowedPage);
    }

    function delete_content(self){
        var content_id = self.getAttribute("content_id");
        $("#delete_content_btn").attr("content_id",content_id);
        $("#content_delete_modal").modal({
            backdrop: 'static',
            keyboard: false
        });
    }
    function  show_work_detail(self) {

        var content_id = self.getAttribute('content_id');
//        alert(content_id);
    }
    $('#delete_content_btn').click(function () {
        var content_id = $("#delete_content_btn").attr("content_id");
        $.ajax({
            type: "post",
            url: baseURL + "admin/contents/delete",
            dataType: "json",
            data: {content_id: content_id},
            success: function (res) {
                if (res.status == 'success') {
                    var table = document.getElementById("contentInfo_tbl");
                    var tbody = table.getElementsByTagName("tbody")[0];
                    tbody.innerHTML = res.data;
                    executionPageNation();
                    $('#content_delete_modal').modal('toggle');
                }
                else//failed
                {
                    alert("Cannot delete Content Item.");
                }
            }
        });
    })
</script>



