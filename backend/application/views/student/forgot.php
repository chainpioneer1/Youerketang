<div class="bg"></div>

<form method="post" class="forgot_form" id="frm_reg" action="<?= base_url('signin/update_pass') ?>">
    <div class="frame" item_type="2">
        <input type="number" name="user_account" maxlength="11" id="userphone" placeholder="请输入手机号">
        <input type="number" name="verifycode" maxlength="6" id="verifycode" placeholder="请输入验证码">
        <input type="password" name="npassword" maxlength="6" id="password" placeholder="请输入六位数密码">
        <div class="submit-verify"></div>
    </div>
</form>
<div class="warning-msg" style="left:50%;top:75%;"></div>
<div class="finish-btn"></div>

<script>
    var mTmr = 0;
    $('.bg').css({background: 'url(' + baseURL + 'assets/images/student/signin/bg_forgot.png)'})
    var reg_step = 1;
    $(function () {
        showInterface();
    })

    $('.finish-btn').on('click', function (object) {
        if (chkValidation()) {
            var frm = document.getElementById('frm_reg');
            var fdata = new FormData(frm);
            fdata.append("user_type", "2"); // teacher add
            $.ajax({
                url: baseURL + "users/update_student_password",
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
                    goPreviousPage(-1);
                }
                else//failed
                {
                    alert(ret.data);
                }
            });
        }
    });

    $('#userphone').on('input', function (object) {
        var str = $(this).val();
        if (str.length > 11) {
            str = str.substr(0, 11);
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

    function chkValidation(type) {
        if (type == undefined) type = '';
        var user_phone = $('#userphone').val();
        var verifycode = $('#verifycode').val();
        var password = $('#password').val();
        var status = '0';//$('.submit-verify').attr('item_status');
        if (verifycode == mobileVerificationCode) status = '1';

        $('.frame input').css({'border': 'none'});
        var errCtrl = '';
        var ret = true;

        if (type == '') {
            if (status != '1') errCtrl = '#verifycode';
            if (password.length < 3) errCtrl = '#password';
            if (verifycode.length != 6) errCtrl = '#verifycode';
            if (user_phone.length != 11) errCtrl = '#userphone';
        }else{
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
