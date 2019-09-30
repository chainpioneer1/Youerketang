
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content" style="min-height: 1305px;">
<!--        <h1 class="page-title">--><?php //echo $this->lang->line('sub_panel_title_datastatistics');?>
        <h1 class="page-title">
            <small></small>
        </h1>
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bordered">
                    <div class="table-toolbar" style="margin-bottom: 0;">
                        <div class="form-group">
                            <a class="btn btn-md green" href="<?= base_url('admin/statistics/index') ?>" ><?php echo $this->lang->line('LoginStatistics');?></a>
                            <a class="btn btn-md yellow"  href="<?= base_url('admin/statistics/coursewares') ?>"><?php echo $this->lang->line('CoursewareAccessStatistics');?></a>
                            <a class="btn btn-md green"  href="<?= base_url('admin/statistics/subwares') ?>"><?php echo $this->lang->line('SubwareAccessStatistics');?></a>
                        </div>
                        <form action="coursewares" method="post" class="form-horizontal" id="cw_access_search_form">
                            <div class="form-group">
                                <label class="col-md-2 control-label"><?php echo $this->lang->line('CoursewareName');?>:</label>
                                <div class="col-md-2" style="padding-left: 0;padding-right: 0;">
                                    <input type="text" class="form-control" name = "cw_name_search" placeholder="" value="<?php echo $cw_name_value; ?>">
                                </div>
                                <label class="col-md-offset-1 col-md-1 control-label"><?php echo $this->lang->line('Time');?>:</label>
                                <div class="col-md-1">
                                    <input class="form-control form-control-inline input-small date-picker" size="20" type="text" name = "startTime_search" value="<?php echo $startTime_value; ?>">
                                </div>
                                <label class="col-md-1 control-label" ><?php echo $this->lang->line('To');?></label>
                                <div class="col-md-1" style="padding-left:0;">
                                    <input class="form-control form-control-inline input-small date-picker" size="20" type="text" name = "endTime_search" value="<?php echo $endTime_value; ?>">
                                </div>
                                <div class="col-md-2" style="text-align: right">
                                    <div class="btn-group">
                                        <button  class="btn  blue"> <i class="fa fa-search"></i>&nbsp<?php echo $this->lang->line('Inquire');?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="portlet-body">
                        <div id="cwAccessChart" style="height:630px;border-top-style: solid;border-top-width: 1px;"></div>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
<!-- BEGIN CONTENT -->
<!--------------------------chat function--------------------------------------------->
<script>
    var data = [];
</script>
<?php foreach($cwAccessSets as $cwAccess):?>
    <script>
        var eachItem = {x:'<?php echo $cwAccess['cw_name'];?>',value:<?php echo $cwAccess['visit_num'];?>,fill: "#fcc",stroke: null};
        data.push(eachItem);
    </script>
<?php endforeach;?>
<script src="<?= base_url('assets/admin/anychart/js/anychart-ui.min.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/admin/anychart/js/anychart.min.js') ?>" type="text/javascript"></script>
<script type="text/javascript">

    $('#statistics_menu').addClass('menu-selected');
    var dataset = anychart.data.set(data);
    chart = anychart.bar(dataset);
    var labels = chart.labels();
    chart.grid(1)
        .enabled(true)
        .layout('vertical');

    labels.enabled(true);
    labels.fontColor('#000');
    labels.fontSize(15);
    labels.fontDecoration("underline");
    labels.fontWeight('bold');

    chart.animation(true);
    var interactivity = chart.interactivity();
    interactivity.selectionMode("none");

    ///init x label and y axes label
    var xlabels = chart.xAxis().labels();
    xlabels.fontSize(15);
    xlabels.fontColor("#125393");///x axes
    xlabels.fontWeight("bold");
    var ylabels = chart.yAxis().labels();
    ylabels.fontSize(15);
    //ylabels.fontColor("#125393");
    ylabels.fontWeight("bold");

    ////
    chart.tooltip(false);
    chart.container("cwAccessChart");
    chart.draw();
    $('.anychart-credits-text').css('display','none');
    $('.anychart-credits-logo').css('display','none');
</script>
<!--------------------------chat function--------------------------------------------->



