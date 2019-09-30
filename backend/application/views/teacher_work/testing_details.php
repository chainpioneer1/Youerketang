<link rel="stylesheet" type="text/css"
      href="<?= base_url('assets/css/frontend/teacher_work/teacher_work_testing_details.css') ?>">
<div class="bg" id="main-background-full"></div>
<div class="testing_container">
    <div class="title_container class_title"></div>
    <div class="class_container">
        <div class="info_container">
            <div class="people_number">20人</div>
            <input type="text" id="time_input" readonly disabled name="uname" value="<?=$endTime?>"/>
            <div class="control_btn"></div>
        </div>
        <div class="class_list_container">
            <table>
                <thead>
                <tr>
                    <th style="text-align: center;" width="12%">姓名</th>
                    <th style="text-align: center;" width="12%">状态</th>
                    <th style="text-align: center;" width="12%">用时</th>
                    <th style="text-align: center;" width="24%">完成时间</th>
                    <th style="text-align: center;" width="24%">评价</th>
                    <th style="text-align: center;" width="16%">完成情况</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <th style="text-align: center;" width="12%">
                            小米
                            <div style="position: relative">
                                <div class="add_working" style=""></div>
                            </div>
                        </th>
                        <th style="text-align: center;" width="12%">未完成</th>
                        <th style="text-align: center;" width="12%">1分钟</th>
                        <th style="text-align: center;" width="24%">2018-07-01 12:23:00</th>
                        <th style="text-align: center;" width="24%">
                            <div class="comment_container">
                                <div class="comment_stars"></div>
                                <div class="comment_stars"></div>
                                <div class="comment_stars"></div>
                                <div class="comment_stars"></div>
                                <div class="comment_stars"></div>
                            </div>
                        </th>
                        <th style="text-align: center;cursor: pointer;" width="16%" itemid="1">详情</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <input class="check-list" value='<?=json_encode($checkDetailedList);?>' style="display: none">
    <div class="next_container class_next_btn" onclick="updateStatus(this)" isChecked="<?=$isChecked?>"></div>
</div>
<script>
    var checkDetailed_List = JSON.parse($('.check-list').val());
    var testID = ('<?=$test_id?>');
    var isChecked = (<?=$isChecked?>);
    console.log(checkDetailed_List);
</script>
<script src="<?= base_url('assets/js/teacher_work/teacher_work_testing_details.js') ?>" type="text/javascript"></script>