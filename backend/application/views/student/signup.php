<div class="bg"></div>

<form method="post" class="register_form" id="frm_reg" action="<?= base_url('signin/signin') ?>">
    <div class="frame" item_type="1">
        <input type="number" name="user_account" id="userphone" placeholder="请输入手机号">
        <input type="number" name="verifycode" id="verifycode" placeholder="请输入验证码">
        <input type="password" name="password" maxlength="6" id="password" placeholder="请输入密码">
        <input type="text" name="user_name" maxlength="18" id="username" placeholder="请输入真实姓名">
        <div class="submit-verify"></div>
    </div>
</form>
<div class="warning-msg"></div>
<div class="next-btn"></div>
<div class="success-modal">
    <div class="success-btn"></div>
</div>

<script>
    var mTmr = 0;
    $('.bg').css({background: 'url(' + baseURL + 'assets/images/student/signin/bg_signup.png)'});
    var reg_step = 0;
    // 0:register info, 1:detailed info, 2:create class, 3:input classname, 4:manage class
    $(function () {
        showInterface();
    });

    $('.next-btn').on('click', function (object) {
        if (chkValidation()) {
            var frm = document.getElementById('frm_reg');
            var fdata = new FormData(frm);
            fdata.append("user_type", "2"); // teacher add
            $.ajax({
                url: baseURL + "users/add_student",
                type: "POST",
                data: fdata,
                contentType: false,
                cache: false,
                processData: false,
                async: true,
                mimeType: "multipart/form-data"
            }).done(function (res) { //
                console.log(res);
                var ret = JSON.parse(res);
                if (ret.status == 'success') {
                    location.href = baseURL +'student';
                    $('.success-modal').fadeIn('fast');
                }
                else//failed
                {
                    alert(ret.data);
                    reg_step = 0;
                }
            });
        }
    });

    $('.success-btn').on('click', function (object) {
        goPreviousPage(-1);
    })

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

    function showInterface() {
        $('.warning-msg').fadeOut('fast');
        $('.frame[item_type=' + (reg_step + 1) + ']').fadeIn('fast');
    }


    var mTmr = 0;

    function chkValidation(type) {
        if (type == undefined) type = '';
        var user_phone = $('#userphone').val();
        var verifycode = $('#verifycode').val();
        var user_name = $('#username').val();
        var password = $('#password').val();
        // var code = $('#activationcode').val();
        var status = '0';//$('.submit-verify').attr('item_status');
        if (verifycode == mobileVerificationCode) status = '1';

        $('.frame input').css({'border': 'none'});
        var errCtrl = '';
        var ret = true;
        if (type == '') {
            if (status != '1') errCtrl = '#verifycode';
            // if (code.length != 8) errCtrl = '#activationcode';
            if (user_name == '') errCtrl = '#username';
            if (password.length < 3) errCtrl = '#password';
            if (verifycode.length != 6) errCtrl = '#verifycode';
            if (user_phone.length != 11) errCtrl = '#userphone';
        } else {
            if (user_phone.length != 11) errCtrl = '#userphone';
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
</script>
