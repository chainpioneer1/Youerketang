<style>
    .bg_signup0 {
        width: 63%;
        left: 18.5%;
        top: 43.5%;
        height: 11%;
    }
    .bg_signup1 {
        left: 17%;
        top: 39%;
    }
</style>
<div class="bg"></div>
<!--<div class="bg_signup0"></div>-->
<div class="bg_signup1"></div>

<form method="post" class="profile_form" id="profile-form" action="<?= base_url('signin/index') ?>">
    <div class="frame" item_type="1">
        <a class="profile-btn">
            <div class="user-icon"></div>
            <div class="user-account"><?= $this->session->userdata('user_account') ?></div>
            <div class="user-name"><?= $this->session->userdata('user_name') ?></div>
        </a>
        <a class="manageclass-btn"></a>
    </div>
    <div class="frame" item_type="2">
        <?php
        $refDate = date("Y-m-d", strtotime('+1 months'));
        if ($refDate > $teacher->expire_time) {
            echo '<div class="expire_time">Vip年费会员 (' .
                date_format(date_create($teacher->expire_time), "Y-m-d") .
                '到期)</div>';
        }
        ?>
        <div class="frame-bg">
            <input type="text" name="user_account" id="user_account" style="display: none;"
                   value="<?= $teacher->user_account ?>">
            <input type="text" name="user_address" id="user_address" maxlength="10"
                   value="<?= $teacher->user_address ?>">
            <input type="number" name="user_phone" id="user_phone" value="<?= $teacher->user_phone ?>">
            <input type="text" name="user_nickname" id="user_nickname" maxlength="18"
                   value="<?= $teacher->user_nickname ?>">
            <input type="text" name="user_school" id="user_school" maxlength="18" value="<?= $teacher->user_school ?>">
        </div>
        <div class="edit-profile-btn"></div>
        <div class="changepassword-btn"></div>
    </div>
    <div class="frame" item_type="3">
        <div class="create-class-btn"></div>
    </div>
    <div class="frame" item_type="4">
        <input type="text" maxlength="20" id="classname">
    </div>
    <div class="frame" item_type="5">
        <div class="class-list-container">
            <table>
                <tbody></tbody>
            </table>
        </div>
        <div class="addclass-txt"></div>
        <div class="course-list-container">
            <table>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <div class="frame" item_type="6">
        <div class="class-list-head">
            <div style="width:42%;">班级：<span class="class-list-name"></span></div>
            <div style="width:35%;">通过人数：<span class="class-list-count">0</span>人</div>
            <!--            <div class="downloadaccount-btn" onclick="downloadStudents();">账号下载</div>-->
        </div>
        <div class="class-list-container">
            <table id="main_tbl">
                <thead style="display: none;">
                <tr>
                    <th colspan="4"><?= $this->lang->line('student_class') ?> : <span class="class-list-name"></span>
                    </th>
                </tr>
                <tr>
                    <th><?= $this->lang->line('account') ?></th>
                    <th><?= $this->lang->line('name') ?></th>
                    <th><?= $this->lang->line('account_create_time') ?></th>
                    <th><?= $this->lang->line('status') ?></th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</form>
<div class="warning-msg"></div>
<div class="next-btn"></div>

<div class="addclass-modal">
    <div class="modal-bg">
        <input type="text" class="addclass-name">
        <div class="modal-btn">
            <a class="btn-confirm"></a>
            <a class="btn-cancel" onclick="$(this).parent().parent().parent().fadeOut('fast')"></a>
        </div>
    </div>
</div>
<div class="classinfo-modal">
    <div class="modal-bg">
        <div class="classinfo-content">
            &nbsp;&nbsp;<span class="classinfo-name">一年级一班</span>
            已经建立成功, 你可以下载下方卡片信息, 分享到班级微信群或QQ群中, 让学生扫描二维码下载App, 井注册进入班级.
        </div>
        <div class="classinfo-detail">
            <img src="<?= base_url('assets/images/frontend/signin/download_info.png') ?>"
                 style="width:100%;height:100%;">
            <div class="classinfo-code"></div>
            <canvas id="result_canvas" width="464" height="269" style="display: none"></canvas>
        </div>
        <a class="btn-download" onclick="downloadClass()"></a>
        <a class="btn-close" onclick="$(this).parent().parent().fadeOut('fast')"></a>
    </div>
</div>
<div class="changepass-modal">
    <div class="modal-bg">
        <input type="password" class="opassword" name="opassword">
        <input type="password" class="npassword" name="npassword">
        <input type="password" class="cpassword" name="cpassword">
        <div class="modal-btn">
            <a class="btn-confirm"></a>
            <a class="btn-cancel" onclick="$(this).parent().parent().parent().fadeOut('fast')"></a>
        </div>
    </div>
</div>
<div class="deletestudent-modal">
    <div class="modal-bg">
        <div class="modal-content">账号删除后不可恢复，是否删除？</div>
        <div class="modal-btn">
            <a class="btn-confirm"></a>
            <a class="btn-cancel" onclick="$(this).parent().parent().parent().fadeOut('fast')"></a>
        </div>
    </div>
</div>

<script>
    var bg_step0 = ['blank', 'blank', 'txt_register3', 'txt_register3', 'txt_register5', 'txt_register6'];
    var bg_step1 = ['blank', 'blank', 'blank', 'txt_register4', 'blank', 'blank'];
    $('.bg').css({background: 'url(' + baseURL + 'assets/images/frontend/profile/bg.png)'});

    var userClass = '<?= $userClass;?>';

    var reg_step = 1;
    var studentClassName = '';
    $(function () {

        $('.top-back').show();
        $('.next-btn').on('click', function (object) {
            if (reg_step == 3) {
                if (chkValidation()) addClass($('#classname').val());
            } else {
                showInterface();
            }
        });

        $('.profile-btn').on('click', function (object) {
            reg_step = 0;
            showInterface()
        });

        $('.create-class-btn').on('click', function (object) {
            reg_step = 2;
            showInterface()
        });

        $('.manageclass-btn').on('click', function (object) {
            reg_step = 1;
            showInterface()
        });

        $('.edit-profile-btn').on('click', function (object) {
            var inputs = $('.frame-bg input');
            var that = this;
            if (inputs[1].getAttribute('disabled') != undefined) { // edit action
                inputs.removeAttr('disabled');
                inputs.css('border', '1px solid #454545');
                // $('.gender div').fadeIn('fast');
                $(this).addClass('save-btn');
            }
            else { // save action
                $('#user_account').removeAttr('disabled');
                // var gender = $('.gender .checkText[item_val="1"]');
                // $('.gender div').hide('fast');
                // gender.fadeIn('fast');
                var fdata = new FormData(document.getElementById('profile-form'));
                fdata.append('user_id', userId);
                // fdata.append('gender', gender.attr('item_type'));
                $.ajax({
                    url: baseURL + "users/update_profile",
                    type: "POST",
                    data: fdata,
                    contentType: false,
                    cache: false,
                    processData: false,
                    async: true,
                    mimeType: "multipart/form-data"
                }).done(function (res) { //
                    var ret = JSON.parse(res);
                    if (ret.status == 'success') {
                        inputs.attr('disabled', 'disabled');
                        inputs.css('border', 'none');
                        $(that).removeClass('save-btn');

                        $('.frame-bg input#user_account').attr('disabled', 'disabled');
                        $('.frame-bg input#user_account').css('background', 'transparent');
                    }
                    else//failed
                    {
                        alert(ret.data);
                    }
                });

            }
            $('.frame-bg input#user_account').attr('disabled', 'disabled');
            $('.frame-bg input#user_account').css('background', 'transparent');
        });

        $('.changepassword-btn').on('click', function (object) {
            var inputs = $('.frame-bg input');
            inputs.attr('disabled', 'disabled');
            inputs.css('background', 'transparent');
            $('.edit-profile-btn').removeClass('save-btn');
            var gender = $('.gender .checkText[item_val="1"]');
            $('.gender div').hide('fast');
            gender.fadeIn('fast');
            $('.changepass-modal').fadeIn('fast');
        });

        $('.changepass-modal .btn-confirm').on('click', function (object) {
            var opassword = $('.opassword').val();
            var npassword = $('.npassword').val();
            var cpassword = $('.cpassword').val();
            if (isNaN(opassword) || isNaN(npassword) || isNaN(cpassword)) {
                alert('Password should include number only.');
                return;
            }
            if (opassword.length < 3 || npassword.length < 3 || cpassword.length < 3
                || opassword.length > 6 || npassword.length > 6 || cpassword.length > 6
            ) {
                alert('Password should include 3 ~ 6 digit of number.');
                return;
            }
            if (opassword == npassword || opassword == cpassword) {
                alert('Password is not changed.');
                return;
            }
            if (npassword != cpassword) {
                alert('New passwords are not equal.');
                return;
            }
            $.ajax({
                type: "post",
                url: baseURL + "users/update_password",
                dataType: "json",
                data: {user_id: userId, opassword: opassword, npassword: npassword},
                success: function (res) {
                    console.log(res);
//                        res = JSON.parse(res);
                    if (res.status == 'success') {
                        alert('Password is changed successfully.');
                        $('.changepass-modal').fadeOut('fast');
                    }
                    else//failed
                    {
                        alert(res.data);
                    }
                }
            })
        });

        $('.go2home-btn').on('click', function (object) {
            location.href = baseURL + "home/index";
        });

        $('.gender div').on('click', function (object) {
            var gender = $(this).attr('item_type');
            $('.gender div').removeAttr('item_val');
            $('.gender div[item_type=' + gender + ']').attr('item_val', '1');
            $('#gender').val(gender);
        });

        $('.addclass-txt').on('click', function (object) {
            $('.addclass-modal').fadeIn('fast');
        });

        $('.addclass-modal .btn-confirm').on('click', function (object) {
            var className = $('.addclass-modal .addclass-name').val();
            if (className == '') return;
            addClass(className);
        });

        $('.deletestudent-modal .btn-confirm').on('click', function (object) {
            var id = $(this).attr('itemid');
            deleteStudent(id);
        });

        showInterface();
    });

    function goParent() {
        if(reg_step == 2 || reg_step == 4){
            goPreviousPage(-1);
            return;
        }else if (reg_step == 5) {
            reg_step = 3;
        }else {
            reg_step = 1;
        }
        $('.addclass-modal').fadeOut('fast');
        $('.changepass-modal').fadeOut('fast');
        $('.classinfo-modal').fadeOut('fast');
        $('.deletestudent-modal').fadeOut('fast');
        showInterface();
    }

    function showInterface() {
        var that = $('.next-btn');
        if (that.length > 0) that = that[0];
        else that = $('.finish-btn')[0];
        reg_step++;
        if (reg_step > bg_step0.length - 1) reg_step = 0;

        $('.top-back').attr('onclick', 'goParent()');
        var fdata = new FormData();
        switch (reg_step) {
            case 0: // 1
                $('.top-back').attr('onclick', 'goPreviousPage(-1)');
                $(that).hide();
                break;
            case 1: // 2
                $(that).hide();

                $('.frame-bg input').attr('disabled', 'disabled');
                $('.frame-bg input').css('border', 'none');
                var gender = $('.gender .checkText[item_val="1"]');
                $('.gender div').hide();
                gender.show();
                break;
            case 2: // 3
                if (userClass != '') {
                    reg_step = 3;
                    showInterface();
                    return;
                }

                $(that).hide();
                $('.frame-bg input').attr('disabled', 'disabled');
                $('.frame-bg input').css('border', 'none');
                var gender = $('.gender .checkText[item_val="1"]');
                $('.gender div').hide();
                gender.show();
                break;
            case 3: // 4
                $('#classname').val('');
                $(that).fadeIn('fast');

                $('.frame-bg input').attr('disabled', 'disabled');
                $('.frame-bg input').css('border', 'none');
                var gender = $('.gender .checkText[item_val="1"]');
                $('.gender div').hide();
                gender.show();
                break;
            case 4: // 5
                $.ajax({
                    type: "post",
                    url: baseURL + "users/get_class",
                    dataType: "json",
                    data: {user_id: userId, user_class: userClass},
                    success: function (res) {
                        console.log(res);
//                        res = JSON.parse(res);
                        if (res.status == 'success') {
                            makeClassList(res.data);
                            makeCourseList(res.data1);
                            $(that).attr('class', 'finish-btn');
                            $(that).hide('fast');
                            $('.frame').fadeOut('fast');
                            $('.frame[item_type="2"]').fadeIn('fast');
                            $('.frame[item_type="' + (reg_step + 1) + '"]').fadeIn('fast');
                            $('.bg_signup0').css({background: 'url(' + baseURL + 'assets/images/frontend/profile/' + bg_step0[reg_step] + '.png)'});
                            $('.bg_signup1').css({background: 'url(' + baseURL + 'assets/images/frontend/profile/' + bg_step1[reg_step] + '.png)'});

                            $('.frame-bg input').attr('disabled', 'disabled');
                            $('.frame-bg input').css('border', 'none');
                            var gender = $('.gender .checkText[item_val="1"]');
                            $('.gender div').hide();
                            gender.show();
                        }
                        else//failed
                        {
                            alert(res.data);
                        }
                    }
                });
                return;
                break;
            case 5: // 6
                $('.frame[item_type="6"] .class-list-name').html(studentClassName);
                $.ajax({
                    type: "post",
                    url: baseURL + "users/get_students",
                    dataType: "json",
                    data: {class_id: studentClassName},
                    success: function (res) {
                        console.log(res);
//                        res = JSON.parse(res);
                        if (res.status == 'success') {
                            makeStudentList(res.data);
                            $(that).attr('class', 'finish-btn');
                            $(that).hide('fast');
                            $('.frame').fadeOut('fast');
                            $('.frame[item_type=' + (reg_step + 1) + ']').fadeIn('fast');
                            $('.bg_signup0').css({background: 'url(' + baseURL + 'assets/images/frontend/profile/' + bg_step0[reg_step] + '.png)'});
                            $('.bg_signup1').css({background: 'url(' + baseURL + 'assets/images/frontend/profile/' + bg_step1[reg_step] + '.png)'});
                        }
                        else//failed
                        {
                            alert(res.data);
                        }
                    }
                });
                return;
                break;
        }
        $('.frame').fadeOut('fast');
        $('.frame[item_type="2"]').fadeIn('fast');
        $('.frame[item_type=' + (reg_step + 1) + ']').fadeIn('fast');
        $('.bg_signup0').css({background: 'url(' + baseURL + 'assets/images/frontend/profile/' + bg_step0[reg_step] + '.png)'});
        $('.bg_signup1').css({background: 'url(' + baseURL + 'assets/images/frontend/profile/' + bg_step1[reg_step] + '.png)'});

    }

    function addClass(className) {
        $.ajax({
            type: "post",
            url: baseURL + "users/add_class",
            dataType: "json",
            data: {user_id: userId, user_class: className},
            success: function (res) {
                if (res.status == 'success') {
                    makeClassList(res.data);
                    userClass = res.user_class;
                    reg_step = 3;
                    showInterface();
                    $('.addclass-modal').fadeOut('fast');
                    setTimeout(function () {
                        var item = $('.frame .class-list-container table tbody tr');
                        $(item[item.length - 1]).find('td .view-detail').trigger('click');
                    },1000);
                }
                else//failed
                {
                    alert(res.data);
                }
            }
        });
    }

    function makeClassList(data) {
        var item = $('.frame[item_type=5] .class-list-container table tbody');

        item.html('');
        item.html(data);

        if (false && item.find('tr').length >= 2) {
            $('.frame .addclass-txt').fadeOut('fast');
        } else {
            $('.frame .addclass-txt').fadeIn('fast');
        }

        $('.view-detail').on('click', function (object) {
            var classname = $(this).parent().parent().find('td .classitem-title').val();
            var classcode = $(this).parent().parent().find('td .classitem-title').attr('item_code');
            $('.classinfo-modal .classinfo-name').html(classname);
            $('.classinfo-modal .classinfo-code').html(classcode);
            $('.classinfo-modal').fadeIn('fast');
        });

        $('.editclass-btn').on('click', function (object) {
            var tag0 = $(this).parent().parent().parent().find('.classitem-title');
            var tag = $(this).parent().parent().find('.classitem-title');
            var status = tag.attr('disabled');
            tag0.css({'background': 'transparent'});
            tag0.attr('disabled', 'disabled');
            $('.class-list-container .classitem-btn').css('pointer-events', 'none');
            if (status != undefined) {
                tag.removeAttr('disabled');
                tag.css({'background': 'white'});
                tag.focus();
            }
        });

        $('.class-list-container .classitem-title').on('blur', function (object) {
            var tag = $(this);
            var className = tag.val();
            var classId = tag.attr('itemid');
            updateClass(classId, className);
            tag.css({'background': 'transparent'});
            tag.attr('disabled', 'disabled');
            $('.class-list-container .classitem-btn').css('pointer-events', 'all');
        });

        $('.class-list-container .classitem-btn').on('click', function (object) {
            studentClassName = $(this).parent().find('input').val();
            reg_step = 4;
            showInterface();
        });
    }

    function makeCourseList(data) {
        var item = $('.frame[item_type=5] .course-list-container table tbody');

        item.html('');
        item.html(data);

    }

    function makeStudentList(data) {
        var item = $('.frame[item_type="6"] .class-list-container table tbody');

        item.html('');
        item.html(data);

        var cnt = $('.class-list-container .publish-txt[item_status="1"]').length;
        $('.frame[item_type="6"] .class-list-count').html(cnt);

        $('.editclass-btn').on('click', function (object) {
            var tag0 = $(this).parent().parent().parent().find('.classitem-title');
            var tag = $(this).parent().parent().find('.classitem-title');
            var status = tag.attr('disabled');
//            if (status == undefined) { // complete edit
//                var className = tag.val();
//                var classId = tag.attr('itemid');
//                updateClass(classId, className);
//            }
//            tag0.blur();
            tag0.css({'background': 'transparent'});
            tag0.attr('disabled', 'disabled');
            if (status != undefined) {
                tag.removeAttr('disabled');
                tag.css({'background': 'white'});
                tag.focus();
            }
        });

        $('.class-list-container .classitem-title').on('blur', function (object) {
            var tag = $(this);
            var userName = tag.val();
            var id = tag.attr('itemid');
            updateStudent(id, userName);
            tag.css({'background': 'transparent'});
            tag.attr('disabled', 'disabled');
        });

        $('.class-list-container .publish-txt[item_status=0]').on('click', function (object) {
            var id = $(this).attr('itemid');
            $.ajax({
                type: "post",
                url: baseURL + "users/publish_student",
                dataType: "json",
                data: {user_id: id, user_status: '1'},
                success: function (res) {
                    console.log(res);
//                        res = JSON.parse(res);
                    if (res.status == 'success') {
                        makeStudentList(res.data);
                    }
                    else//failed
                    {
                        alert(res.data);
                    }
                }
            })
        });

        $('.class-list-container .delete-txt').on('click', function (object) {
            var id = $(this).attr('itemid');
            $('.deletestudent-modal .btn-confirm').attr('itemid', id);
            $('.deletestudent-modal').fadeIn('fast');
        });
    }

    function deleteStudent(id) {
        $.ajax({
            type: "post",
            url: baseURL + "users/delete_student",
            dataType: "json",
            data: {user_id: id},
            success: function (res) {
                console.log(res);
//                        res = JSON.parse(res);
                if (res.status == 'success') {
                    makeStudentList(res.data);
                    $('.deletestudent-modal').fadeOut('fast');
                }
                else//failed
                {
                    alert(res.data);
                }
            }
        })
    }

    function updateClass(classId, className) {
        $.ajax({
            type: "post",
            url: baseURL + "users/update_class",
            dataType: "json",
            data: {user_id: userId, class_id: classId, class_name: className},
            success: function (res) {
                console.log(res);
//                        res = JSON.parse(res);
                if (res.status == 'success') {
                    makeClassList(res.data);
                }
                else//failed
                {
                    alert(res.data);
                }
            }
        })
    }

    function updateStudent(id, userName) {
        $.ajax({
            type: "post",
            url: baseURL + "users/update_student",
            dataType: "json",
            data: {user_id: id, user_name: userName},
            success: function (res) {
                console.log(res);
//                        res = JSON.parse(res);
                if (res.status == 'success') {
                    makeStudentList(res.data);
                }
                else//failed
                {
                    alert(res.data);
                }
            }
        })
    }

    var mTmr = 0;

    function chkValidation() {
        var classname = $('#classname').val();
        $('.frame input').css({'border': 'none'});
        var errStyle = '1px solid red';
        var errCtrl = '';
        var ret = true;
        switch (reg_step) {
            case 3:
                if (classname == '') errCtrl = '#classname';
                break;
        }
        if ($(errCtrl).val() == '')
            $('.warning-msg').css({'background': 'url(' + baseURL + 'assets/images/frontend/signin/txt_warning.png)'});
        else
            $('.warning-msg').css({'background': 'url(' + baseURL + 'assets/images/frontend/signin/txt_warning1.png)'});
        if (errCtrl != '') {
            $(errCtrl).css({'border': '2px solid red'});
            ret = false;
        }

        var st = false;
        if (reg_step != -1) st = true;
        if (!ret && st) {
            $('.warning-msg').fadeIn('fast');
            clearTimeout(mTmr);
            mTmr = setTimeout(function () {
                $('.warning-msg').fadeOut('fast');
                $('.frame input').css({'border': 'none'});
            }, 2500);
        }
        return ret;
    }

    $('#user_phone').on('input', function (object) {
        var str = $(this).val();
        if (str.length > 11) {
            str = str.substr(0, 11);
        }
        $(this).val(str);
    })

    function downloadClass() {
        setTimeout(function () {
            save_panel_perform();
        }, 500);
    }

    function downloadStudents() {
        export_table('students');
    }

</script>
