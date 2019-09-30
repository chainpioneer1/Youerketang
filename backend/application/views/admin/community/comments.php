<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content" style="min-height: 1305px;">
        <h1 class="page-title"><?php echo $this->lang->line('sub_panel_title_comment');?>
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
                        <table class="table table-striped table-bordered table-hover" id="commentInfo_tbl">
                            <thead>
                            <tr>
                                <th style="width:10%"><?php echo $this->lang->line('SerialNumber');?></th>
                                <th style="width:15%" ><?php echo $this->lang->line('WorkName');?></th>
                                <th style="width:35%"><?php echo $this->lang->line('CommentContent');?></th>
                                <th style="width:15%"><?php echo $this->lang->line('CommentAuthor');?></th>
                                <th style="width:15%"><?php echo $this->lang->line('CommentTime');?></th>
                                <th style="width:10%"><?php echo $this->lang->line('Operation');?></th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach($comments as $comment):?>
                                    <tr>
                                        <td><?php echo $comment->comment_id;?></td>
                                        <td><?php echo $comment->content_title;?></td>
                                        <td><?php echo $comment->comment_desc;?></td>
                                        <td>
                                            <?php echo $comment->username.'<br/>';?>
                                            <span style="color:#f90;"><?php echo $comment->fullname;?></span>
                                        </td>
                                        <td><?php echo $comment->create_time;?></td>
                                        <td>
                                            <button style="width:70px;" class="btn btn-sm btn-warning" onclick="delete_comment(this);"  comment_id = <?php echo $comment->comment_id;?>><?php echo $this->lang->line('Delete');?></button>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                        <div id="commentpageNavPosition"></div>
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
<div id="comment_delete_modal" class="modal fade" tabindex="-1" data-width="300">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $this->lang->line('Message');?></h4>
    </div>
    <div class="modal-body" style="text-align:center;">
        <h4 class="modal-title"><?php echo $this->lang->line('DeleteConfirmMessage');?></h4>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn green" id="delete_comment_btn"><?php echo $this->lang->line('Yes');?></button>
        <button type="button" data-dismiss="modal"  class="btn btn-outline dark"><?php echo $this->lang->line('No');?></button>
    </div>
</div>
<!-------- Delete Modal --------------->
<style>
    #commentInfo_tbl thead tr th,#commentInfo_tbl tbody tr td
    {
        text-align:center;vertical-align: middle;
    }
</style>
<script>
    $('#comment_menu').addClass('menu-selected');
    var baseURL = "<?php echo base_url();?>";
    //*************************pagenation module
    var prevstr = "<?php echo $this->lang->line('PrevPage');?>";
    var nextstr = "<?php echo $this->lang->line('NextPage');?>";
    var currentShowedPage = 1;
    var showedItems = 10;
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
    var pager = new Pager('commentInfo_tbl', showedItems);
    pager.init();
    pager.showPageNav('pager', 'commentpageNavPosition');
    pager.showPage(currentShowedPage);

    function executionPageNation()
    {
        pager.showPageNav('pager', 'commentpageNavPosition');
        pager.showPage(currentShowedPage);
    }
    //pagenation module
    function delete_comment(self){
        var comment_id = self.getAttribute("comment_id");
        $("#delete_comment_btn").attr("comment_id",comment_id);
        $("#comment_delete_modal").modal({
            backdrop: 'static',
            keyboard: false
        });
    }
    $('#delete_comment_btn').click(function () {
        var comment_id = $("#delete_comment_btn").attr("comment_id");
        $.ajax({
            type: "post",
            url: baseURL + "admin/comments/delete",
            dataType: "json",
            data: {comment_id: comment_id},
            success: function (res) {
                if (res.status == 'success') {
                    var table = document.getElementById("commentInfo_tbl");
                    var tbody = table.getElementsByTagName("tbody")[0];
                    tbody.innerHTML = res.data;
                    executionPageNation();
                }
                else//failed
                {
                    alert("Cannot delete CourseWare Item.");
                }
            }
        });
        $('#comment_delete_modal').modal('toggle');
    })
</script>



