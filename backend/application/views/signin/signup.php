<div class="bg"></div>
<div class="bg_signup0"></div>
<!--<div class="bg_signup1"></div>-->

<form method="post" class="register_form" id="frm_reg" action="<?= base_url('signin/signin') ?>">
    <div class="frame" item_type="1">
        <input type="text" name="user_name" maxlength="20" id="username" placeholder="请输入用户昵称">
        <input type="number" name="user_account" maxlength="18" id="userphone" placeholder="请输入手机号码">
        <input type="number" name="verifycode" maxlength="18" id="verifycode" placeholder="请输入短信验证码">
        <input type="password" name="password" maxlength="8" id="password" placeholder="设置6到20位登录密码">
        <input type="password" name="verifypassword" maxlength="8" id="verifypassword" placeholder="请再次输入登陆密码">
        <div class="submit-verify">发送验证码</div>
        <a href="<?= base_url('signin/signin'); ?>" class="already-register">已有账号, 立即登录</a>
        <!--        <input type="password" name="cpassword" maxlength="18" id="cpassword">-->
        <!--        <input type="text" name="code" maxlength="8" id="activationcode">-->
    </div>
    <div class="frame" item_type="2">
        <input type="text" name="username" maxlength="18" id="user_name">
        <input type="text" name="user_city" maxlength="10" id="city">
        <input type="text" name="user_address" maxlength="10" id="district">
        <input type="text" name="user_school" maxlength="18" id="school">
        <input type="number" name="user_phone" id="phonenumber">
        <input type="email" name="user_email" maxlength="30" id="email">
    </div>
    <div class="frame" item_type="3">
        <div class="create-class-btn"></div>
        <a class="go2home-btn"></a>
    </div>
    <div class="frame" item_type="4">
        <input type="text" name="classname" maxlength="20" id="classname">
        <a class="go2home-btn"></a>
    </div>
    <div class="frame" item_type="5">
        <div class="class-list-container">
            <table>
                <tbody></tbody>
            </table>
        </div>
        <div class="addclass-txt"></div>
    </div>
    <div class="frame" item_type="6">
        <div class="class-list-head">
            <div style="width:35%;">班级：<span class="class-list-name"></span></div>
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
            <canvas id="result_canvas" width="470" height="221" style="display: none"></canvas>
        </div>
        <a class="btn-download" onclick="downloadClass()"></a>
        <a class="btn-close" onclick="$(this).parent().parent().fadeOut('fast')"></a>
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
    var bg_step1 = ['txt_register1', 'txt_register2', 'blank', 'txt_register4', 'blank', 'blank'];
    $('.bg').css({background: 'url(' + baseURL + 'assets/images/frontend/signin/bg_signup.png)'});
    var reg_step = -1;
    // 0:register info, 1:detailed info, 2:create class, 3:input classname, 4:manage class
    //    reg_step = 0;
    var studentClassName = '';
    $(function () {

        $('.top-bar').remove();
        $('.create-class-btn').on('click', function (object) {
            reg_step = 2;
            showInterface();
        });

        $('.next-btn').on('click', function (object) {
            if (reg_step > 2) {
                return;
            } else if (reg_step == 3) {
                if (chkValidation()) addClass($('#classname').val());
            } else if (reg_step == 4) {
                $(this).fadeOut('fast');
                $('.top-back').attr('onclick', 'location.href=baseURL+"home"');
            } else {
                showInterface();
            }
        });

        $('.editclass-btn').on('click', function (object) {
            var tag0 = $(this).parent().parent().parent().find('.classitem-title');
            var tag = $(this).parent().parent().find('.classitem-title');
            var status = tag.attr('disabled');
            tag0.blur();
            tag0.css({'background': 'transparent'});
            tag0.attr('disabled', 'disabled');
            if (status != undefined) {
                tag.removeAttr('disabled');
                tag.css({'background': 'white'});
                tag.focus();
            }
        });

        $('.go2home-btn').on('click', function (object) {
            location.href = baseURL + "home/index";
        })
        $('.addclass-txt').on('click', function (object) {
            $('.addclass-modal').fadeIn('fast');
        })
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

    $('#userphone').on('input', function (object) {
        var str = $(this).val();
        if (str.length > 11) {
            str = str.substr(0, 11);
        }
        $(this).val(str);
    });
    $('#activationcode').on('input', function (object) {
        var str = $(this).val();
        if (str.length > 8) {
            str = str.substr(0, 8);
        }
        $(this).val(str);
    });
    $('#verifycode').on('input', function (object) {
        var str = $(this).val();
        if (str.length > 6) {
            str = str.substr(0, 6);
        }
        $(this).val(str);
    });
    $('.submit-verify').on('click', function (object) {
        if (!chkValidation('1') || isVerifying) return;
        isVerifying = true;
        sendSMSToServer($('#userphone').val());
    });

    function goParent() {
        if (reg_step == 5)
            reg_step = 3;
        else
            reg_step = -1;
        $('.addclass-modal').fadeOut('fast');
        $('.changepass-modal').fadeOut('fast');
        $('.classinfo-modal').fadeOut('fast');
        $('.deletestudent-modal').fadeOut('fast');
        showInterface();
    }

    function showInterface() {

        console.log('current_id=' + reg_step);
        if (!chkValidation()) return;

        reg_step++;
        $('.warning-msg').fadeOut('fast');
        var that = $('.next-btn');
        if (that.length > 0) that = that[0];
        else that = $('.finish-btn')[0];
        if (reg_step > bg_step0.length - 1) reg_step = 0;

        var frm = document.getElementById('frm_reg');
        var fdata = new FormData(frm)

        $('.top-back').attr('onclick', 'goPreviousPage(-1)');
        switch (reg_step) {
            case 0: // 1 - register information
                $(that).attr('class', 'finish-btn');
                $(that).fadeIn('fast');
                $('.bg_signup1').css({
                    width: '40%',
                    left: '37%',
                    top: '24%',
                    height: '29%'
                });
                break;
            case 1: // 2 - detail register information
                fdata.append("user_type", "1"); // teacher add
                $.ajax({
                    url: baseURL + "users/add",
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
                        location.href = baseURL + "home";
                        // location.href= baseURL + "users/profile/"+ret.data.id;
                        return;
                        userId = ret.data.id;
                        console.log(userId);
                        $('.frame').fadeOut('fast');
                        $(that).fadeOut('fast');
                        $('.frame[item_type=' + (reg_step + 1) + ']').fadeIn('fast');
                        $('.bg_signup0').css({background: 'url(' + baseURL + 'assets/images/frontend/signin/' + bg_step0[reg_step] + '.png)'});
                        $('.bg_signup1').css({background: 'url(' + baseURL + 'assets/images/frontend/signin/' + bg_step1[reg_step] + '.png)'});

                    } else//failed
                    {
                        alert(ret.data);
                        reg_step = 0;
                        return;
                    }
                });
                return;
                $(that).attr('class', 'finish-btn');
                $(that).fadeIn('fast');
                $('.bg_signup1').css({
                    width: '40%',
                    left: '30%',
                    top: '15%',
                    height: '36%'
                });
                break;
            case 2: // 3 - create class button page
                fdata.append("user_type", "1"); // teacher add
                $.ajax({
                    url: baseURL + "users/add",
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
                        location.href = baseURL + "home";
                        // location.href= baseURL + "users/profile/"+ret.data.id;
                        return;
                        userId = ret.data.id;
                        console.log(userId);
                        $('.frame').fadeOut('fast');
                        $(that).fadeOut('fast');
                        $('.frame[item_type=' + (reg_step + 1) + ']').fadeIn('fast');
                        $('.bg_signup0').css({background: 'url(' + baseURL + 'assets/images/frontend/signin/' + bg_step0[reg_step] + '.png)'});
                        $('.bg_signup1').css({background: 'url(' + baseURL + 'assets/images/frontend/signin/' + bg_step1[reg_step] + '.png)'});

                    } else//failed
                    {
                        alert(ret.data);
                        reg_step = 1;
                        return;
                    }
                });
                $(that).attr('class', 'finish-btn');
                return;
                break;
            case 3: // 4 - class name input page
                $('#classname').val('');
                $(that).fadeIn('fast');
                $(that).attr('class', 'next-btn');
                break;
            case 4: // 5 - class list & management page
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
                            $(that).attr('class', 'finish-btn');
                            $(that).fadeIn('fast');
                            $('.frame').fadeOut('fast');
                            $('.frame[item_type=' + (reg_step + 1) + ']').fadeIn('fast');
                            $('.bg_signup0').css({background: 'url(' + baseURL + 'assets/images/frontend/signin/' + bg_step0[reg_step] + '.png)'});
                            $('.bg_signup1').css({background: 'url(' + baseURL + 'assets/images/frontend/signin/' + bg_step1[reg_step] + '.png)'});
                        } else//failed
                        {
                            alert(res.data);
                        }
                    }
                });
                return;
                break;
            case 5: // 6 - class detail page(student view)
                $('.top-back').attr('onclick', 'goParent()');
                $('.frame[item_type=6] .class-list-name').html(studentClassName);
                $.ajax({
                    type: "post",
                    url: baseURL + "users/get_students",
                    dataType: "json",
                    data: {user_class: studentClassName},
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
                        } else//failed
                        {
                            alert(res.data);
                        }
                    }
                });
                return;
                break;
        }
        $('.frame').fadeOut('fast');
        $('.frame[item_type=' + (reg_step + 1) + ']').fadeIn('fast');
        $('.bg_signup0').css({background: 'url(' + baseURL + 'assets/images/frontend/signin/' + bg_step0[reg_step] + '.png)'});
        $('.bg_signup1').css({background: 'url(' + baseURL + 'assets/images/frontend/signin/' + bg_step1[reg_step] + '.png)'});
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
                    }, 1000);
                } else//failed
                {
                    alert(res.data);
                }
            }
        });
    }

    function makeClassList(data) {
        var item = $('.frame[item_type="5"] .class-list-container table tbody');

        item.html('');
        item.html(data);

        if (item.find('tr').length >= 2) {
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
            reg_step = 5;
            showInterface();
        });
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

        $('.class-list-container .publish-txt[item_status="0"]').on('click', function (object) {
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
                    } else//failed
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
                } else//failed
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
                } else//failed
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
                } else//failed
                {
                    alert(res.data);
                }
            }
        })
    }

    var mTmr = 0;

    function chkValidation(type) {
        if (type == undefined) type = '';
        var user_account = $('#account').val();
        var password = $('#password').val();
        var cpassword = $('#cpassword').val();
        var verifycode = $('#verifycode').val();
        // var code = $('#activationcode').val();

        var user_name = $('#username').val();
        var user_city = $('#city').val();
        var user_address = $('#district').val();
        var user_school = $('#school').val();
        // var user_phone = $('#phonenumber').val();
        var user_phone = $('#userphone').val();
        var user_email = $('#email').val();
        var classname = $('#classname').val();
        $('.frame input').css({'border': 'none'});
        var errCtrl = '';
        var ret = true;
        var status = '0';
        if (verifycode == mobileVerificationCode) status = '1';
        switch (reg_step) {
            case 0:
                // if (code.length != 8) errCtrl = '#activationcode';
                // if (password != cpassword) errCtrl = '#password,#cpassword';
                // if (cpassword.length < 3) errCtrl = '#cpassword';
                // if (user_account.length < 3) errCtrl = '#account';
                if(type=='') {
                    if(status!='1') errCtrl = '#verifycode';
                    if (verifycode.length != 6) errCtrl = '#verifycode';
                    if (user_name == '') errCtrl = '#username';
                    if (password.length < 3) errCtrl = '#password';
                    if (user_phone.length != 11) errCtrl = '#userphone';
                }else{
                    if(user_phone.length!=11) errCtrl = '#userphone';
                }
                // if(verifycode!=mobileVerificationCode) errCtrl = '#verifycode';
                break;
            case 1:
                if (user_email == '') errCtrl = '#email';
                if (user_phone.length != 11) errCtrl = '#phonenumber';
                if (user_school == '') errCtrl = '#school';
                if (user_address == '') errCtrl = '#district';
                if (user_city == '') errCtrl = '#city';
                if (user_name == '') errCtrl = '#username';
                break;
            case 3:
                if (classname == '') errCtrl = '#classname';
                break;
        }
        if ($(errCtrl).val() == '')
            $('.warning-msg').css({'background': 'url(' + baseURL + 'assets/images/frontend/signin/txt_warning.png)'});
        else
            $('.warning-msg').css({'background': 'url(' + baseURL + 'assets/images/frontend/signin/txt_warning1.png)'});
        if (errCtrl != '') {
            $(errCtrl).css({'border': '1px solid red'});
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

    $('#phonenumber').on('input', function (object) {
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
