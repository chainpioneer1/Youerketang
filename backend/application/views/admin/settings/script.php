
<script src="<?= base_url('assets/admin/global/scripts/datatable.js')?>" type="text/javascript"></script>
<script src="<?= base_url('assets/admin/global/plugins/datatables/datatables.min.js')?>" type="text/javascript"></script>
<script src="<?= base_url('assets/admin/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')?>" type="text/javascript"></script>
<!--<script src="<?//= base_url('assets/admin/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')?>" type="text/javascript"></script>-->

<!--<script src="--><?//= base_url('assets/admin/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js')?><!--" type="text/javascript"></script>-->
<!--<script src="--><?//= base_url('assets/admin/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js')?><!--" type="text/javascript"></script>-->
<script src="<?= base_url('assets/admin/global/plugins/bootstrap-markdown/lib/markdown.js')?>" type="text/javascript"></script>
<script src="<?= base_url('assets/admin/global/plugins/bootstrap-markdown/js/bootstrap-markdown.js')?>" type="text/javascript"></script>
<script src="<?= base_url('assets/admin/global/plugins/bootstrap-summernote/summernote.min.js')?>" type="text/javascript"></script>
<script src="<?= base_url('assets/admin/pages/scripts/components-editors.js')?>" type="text/javascript"></script>

<script src="<?= base_url('assets/admin/global/plugins/bootstrap-select/js/bootstrap-select.min.js')?>" type="text/javascript"></script>
<script src="<?= base_url('assets/admin/pages/scripts/components-bootstrap-select.min.js')?>" type="text/javascript"></script>

<script src="<?= base_url('assets/admin/global/plugins/codemirror/lib/codemirror.js')?>" type="text/javascript"></script>
<script src="<?= base_url('assets/admin/global/plugins/codemirror/mode/javascript/javascript.js')?>" type="text/javascript"></script>
<script src="<?= base_url('assets/admin/global/plugins/codemirror/mode/htmlmixed/htmlmixed.js')?>" type="text/javascript"></script>
<script src="<?= base_url('assets/admin/global/plugins/codemirror/mode/css/css.js')?>" type="text/javascript"></script>
<!--<script src="<?//= base_url('assets/admin/pages/scripts/ui-alerts-api.min.js')?>" type="text/javascript"></script>-->

<!--itbh-pms-code-->
<script src="<?= base_url('assets/admin/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/admin/global/plugins/bootstrap-modal/js/bootstrap-modal.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/admin/pages/scripts/ui-extended-modals.min.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/jquery.table2excel.js') ?>" type="text/javascript"></script>

<!--<script src="--><?//= base_url('assets/admin/global/plugins/moment.min.js') ?><!--" type="text/javascript"></script>-->
<!--<script src="--><?//= base_url('assets/admin/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') ?><!--" type="text/javascript"></script>-->
<script src="<?= base_url('assets/admin/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') ?>" type="text/javascript"></script>
<!--<script src="--><?//= base_url('assets/admin/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') ?><!--" type="text/javascript"></script>-->
<script src="<?= base_url('assets/admin/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') ?>" type="text/javascript"></script>

<script src="<?= base_url('assets/admin/pages/scripts/components-date-time-pickers.min.js') ?>" type="text/javascript"></script>

<script>
    function export_table(filename) {
        $("#main_tbl").table2excel({
            exclude: ".noExl",
            name: "Excel Document Name",
            filename: filename,
            fileext: ".xls",
            exclude_img: true,
            exclude_links: true,
            exclude_inputs: true
        });
    }

//    function export_table_xlsx(filename) {
//        var date = new Date();
//        filename = filename + ".xlsx";
//        var elt = document.getElementById("main_tbl");
//        var wb = XLSX.utils.table_to_book(elt, { sheet: "Sheet JS" });
//        XLSX.writeFile(wb, filename);
//    }
</script>
