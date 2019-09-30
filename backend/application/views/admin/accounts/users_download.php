<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content" style="min-height: 1305px;">
        <h1 class="page-title"><?php echo $this->lang->line('Download'); ?>
            <small></small>
        </h1>
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bordered">
                    <div class="table-toolbar">
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover" id="userDownLoadInfo_tbl">
                            <thead>
                            <tr>
                                <th><?php echo $this->lang->line('Account'); ?></th>
                                <th><?php echo $this->lang->line('Name'); ?></th>
                                <th><?php echo $this->lang->line('Gender'); ?></th>
                                <?php  if($user_type_id=='2'):?>
                                <th><?php echo $this->lang->line('Grade/Class'); ?></th>
                                <?php  endif;?>
                                <!--<th style="width:8%"><?php // echo $this->lang->line('BuyCourse');?></th>-->
                                <th><?php echo $this->lang->line('School'); ?></th>
                                <th><?php echo $this->lang->line('UserType'); ?></th>
                                <th><?php echo $this->lang->line('GenerationTime'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($users as $user):
//                                $buyList = json_decode($user['buycourse_arr']);
//                                $kebenju = $buyList->kebenju;
//                                $sandapian = $buyList->sandapian;
//                                $buycourseStr = '';
//                                if ($kebenju == '1') {
//                                    $buycourseStr .= $this->lang->line('kebenju');
//                                }
//                                if ($sandapian == '1') {
//                                    if ($kebenju == '1') {
//                                        $buycourseStr .= '<br/>' . $this->lang->line('sandapian');
//                                    } else $buycourseStr .= $this->lang->line('sandapian');
//                                }
                                ?>
                                <tr>
                                    <td><?php echo $user['username']; ?></td>
                                    <td></td>
                                    <td></td>
                                    <?php if ($user_type_id == '2') { ?>
                                        <td></td>
                                    <?php } ?>
                                    <!--<td><?php //$buycourseStr;?></td>-->
                                    <td><?= $school_name; ?></td>
                                    <td><?= $user_type_name; ?></td>
                                    <td><?= $user['reg_time']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-10" id="downloadpageNavPosition"></div>
                            <div class="col-md-2 right-floated">
                                <div class="btn-group">
                                    <button class="btn blue" onclick="userTableDownLoad()"><i
                                                class="fa fa-download"></i>&nbsp<?php echo $this->lang->line('Download'); ?>
                                    </button>

                                </div>
                            </div>
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
<!--------Modal to Generate Users In Bulk ------------------>
<script>
    var currentShowedPage = 1;
    var showedItems = 10;
    var prevstr = "<?php echo $this->lang->line('PrevPage');?>";
    var nextstr = "<?php echo $this->lang->line('NextPage');?>";

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
            var oldPageAnchor = document.getElementById('pg' + this.currentPage);
            if (oldPageAnchor == null || oldPageAnchor == undefined) return;
            oldPageAnchor.className = 'pg-normal';

            this.currentPage = pageNumber;
            var newPageAnchor = document.getElementById('pg' + this.currentPage);
            newPageAnchor.className = 'pg-selected';

            var from = (pageNumber - 1) * itemsPerPage + 1;
            var to = from + itemsPerPage - 1;
            this.showRecords(from, to);
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

            var pagerHtml = '<button class = "btn btn blue" onclick="' + pagerName + '.prev();" class="pg-normal">' + prevstr + '</button>  ';
            for (var page = 1; page <= this.pages; page++)
                pagerHtml += '<button hidden id="pg' + page + '" class="pg-normal" onclick="' + pagerName + '.showPage(' + page + ');">' + page + '</button>  ';
            pagerHtml += '<button  class = "btn btn blue" onclick="' + pagerName + '.next();" class="pg-normal">' + nextstr + '</button>';

            element.innerHTML = pagerHtml;
        }
    }

    var pager = new Pager('userDownLoadInfo_tbl', showedItems);
    pager.init();
    pager.showPageNav('pager', 'downloadpageNavPosition');
    pager.showPage(currentShowedPage);

    function userTableDownLoad() {
        $("#userDownLoadInfo_tbl").table2excel({
            exclude: ".noExl",
            name: "Excel Document Name",
            filename: "users",
            fileext: ".xls",
            exclude_img: true,
            exclude_links: true,
            exclude_inputs: true
        });
    }
</script>




