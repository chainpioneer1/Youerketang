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
                                <th><?php echo $this->lang->line('Grade/Class'); ?></th>
                                <!--<th><?php // echo $this->lang->line('BuyCourse');?></th>-->
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
                                    <td><?php echo $user['fullname']; ?></td>
                                    <td><?php echo $user['sex']; ?></td>
                                    <?php if ($user['user_type_id'] == '2') { ?>
                                        <td><?php echo $user['class']; ?></td>
                                    <?php } else { ?>
                                        <td></td>
                                    <?php } ?>
                                    <!--<td><?php //$buycourseStr ?></td>-->
                                    <td><?php echo $user['school_name']; ?></td>
                                    <td><?php echo $user['user_type_name']; ?></td>
                                    <td><?php echo $user['reg_time']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-12" id="downloadpageNavPosition"></div>
<!--                            <div class="col-md-offset-9 col-md-1">-->
                                <!--                            <div class="btn-group">-->
                                <!--                                <button  class="btn blue" onclick="userTableDownLoad()"> <i class="fa fa-download"></i>&nbsp--><?php //echo $this->lang->line('Download');?>
                                <!--                                </button>-->
                                <!---->
                                <!--                            </div>-->
<!--                            </div>-->
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
    $('#user_menu').addClass('menu-selected');
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
        }

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

    var pager = new Pager('userDownLoadInfo_tbl', showedItems);
    pager.init();
    pager.showPageNav('pager', 'downloadpageNavPosition');
    pager.showPage(currentShowedPage);

    function downloadCSV(csv, filename) {
        var csvFile;
        var downloadLink;

        // CSV file
        csvFile = new Blob([csv], {type: "text/csv"});

        // Download link
        downloadLink = document.createElement("a");

        // File name
        downloadLink.download = filename;

        // Create a link to the file
        downloadLink.href = window.URL.createObjectURL(csvFile);

        // Hide download link
        downloadLink.style.display = "none";

        // Add the link to DOM
        document.body.appendChild(downloadLink);

        // Click download link
        downloadLink.click();
    }

    function exportTableToCSV(filename) {
        var csv = [];
        var rows = document.querySelectorAll("table tr");

        for (var i = 0; i < rows.length; i++) {
            var row = [], cols = rows[i].querySelectorAll("td, th");

            for (var j = 0; j < cols.length; j++) {
                row.push((cols[j].innerText));
            }


            csv.push(row.join(","));
        }

        // Download CSV file
        downloadCSV(csv.join("\n"), filename);
    }

    function fnExcelReport() {
        var tab_text = "<table><tr>";
        var textRange;
        var j = 0;
        tab = document.getElementById('userDownLoadInfo_tbl'); // id of table

        for (j = 0; j < tab.rows.length; j++) {
            tab_text = tab_text + tab.rows[j].innerHTML + "</tr>";
            //tab_text=tab_text+"</tr>";
        }

        tab_text = tab_text + "</table>";
        tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
        tab_text = tab_text.replace(/<img[^>]*>/gi, ""); // remove if u want images in your table
        tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

        var ua = window.navigator.userAgent;
        var msie = ua.indexOf("MSIE ");

        if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
        {
            txtArea1.document.open("txt/html", "replace");
            txtArea1.document.write(tab_text);
            txtArea1.document.close();
            txtArea1.focus();
            sa = txtArea1.document.execCommand("SaveAs", true, "Say Thanks to Sumit.xls");
        }
        else                 //other browser not tested on IE 11
            sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));

        return (sa);
    }

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

    $(document).ready(function () {

        userTableDownLoad();

    })
</script>




