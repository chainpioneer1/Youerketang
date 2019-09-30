<?php
$teacher = $student;

?>
<style>
    .bg_signup0 {
        width: 85%;
        left: 7.5%;
        top: 1.5%;
        height: 96.5%;
    }
</style>
<div class="bg"></div>
<div class="bg_signup0"></div>
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
        <div class="user-icon"></div>
        <?php
        $refDate = date("Y-m-d", strtotime('+1 months'));
        if ($refDate > $teacher->expire_time) {
            echo '<div class="expire_time">Vip年费会员 (' .
                date_format(date_create($teacher->expire_time), "Y-m-d") .
                '到期)</div>';
        }
        ?>

        <div class="frame-bg">
            <input type="text" name="user_account" id="user_account" disabled="disabled"
                   value="<?= $teacher->user_account ?>" item_type="1">
            <input type="text" name="user_name" id="user_name" value="<?= $teacher->user_name ?>">
            <input type="text" name="user_city" hidden id="user_city" value="<?= $teacher->user_city ?>">
            <input type="text" name="user_address" hidden id="user_address" value="<?= $teacher->user_address ?>">
            <input type="number" name="user_phone" hidden id="user_phone" max="99999999999"
                   value="<?= $teacher->user_phone ?>">
            <input type="email" name="user_email" hidden id="user_email" value="<?= $teacher->user_email ?>">

            <input type="text" name="user_nickname" hidden id="user_nickname" value="<?= $teacher->user_nickname ?>">
            <input type="text" name="user_class" id="user_class" value="<?= $teacher->user_class ?>" item_type="1">
            <input type="text" name="user_school" id="user_school" value="<?= $teacher->user_school ?>" item_type="1">
        </div>
        <div class="changepassword-btn"></div>
        <a href="<?= base_url('/student/signin/signout'); ?>" class="logout-btn"></a>
    </div>
    <div class="frame" item_type="3">
        <div class="create-class-btn"></div>
    </div>
    <div class="frame" item_type="4">
        <input type="text" maxlength="10" id="classname">
    </div>
    <div class="frame" item_type="5">
        <div class="class-list-container">
            <table>
                <tbody></tbody>
            </table>
        </div>
        <div class="addclass-txt"></div>
    </div>
</form>

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

<div class="updateclass-modal">
    <div class="modal-bg">
        <div style="top: 15%;padding-right: 40%;color: #fd665f;font-size: calc(2vw);font-weight: 600;">请输入班级邀请码</div>
        <input type="number" name="classcode" maxlength="8">
        <div class="modal-btn">
            <a class="btn-cancel" onclick="$(this).parent().parent().parent().fadeOut('fast')">取消</a>
            <a class="btn-confirm">确定</a>
        </div>
    </div>
</div>

<script>
    $('.bg').css({background: 'url(' + baseURL + 'assets/images/student/signin/bg_profile.png)'});
    var reg_step = 1;
    $(function () {

        $('.changepassword-btn').on('click', function (object) {
            var inputs = $('.frame-bg input');
            inputs.attr('disabled', 'disabled');
            inputs.css('background', 'transparent');
//            $('.edit-profile-btn').removeClass('save-btn');
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
//                        alert('Password is changed successfully.');
                        $('.changepass-modal').fadeOut('fast');
                    } else//failed
                    {
                        alert(res.data);
                    }
                }
            })
        });

        $('.update-class-btn').on('click', function (object) {
            var inputs = $('.frame-bg input');
            inputs.attr('disabled', 'disabled');
            inputs.css('background', 'transparent');
//            $('.edit-profile-btn').removeClass('save-btn');
            var gender = $('.gender .checkText[item_val="1"]');
            $('.gender div').hide('fast');
            gender.fadeIn('fast');
            $('.updateclass-modal').fadeIn('fast');
        });
        $('.updateclass-modal .btn-confirm').on('click', function (object) {
            var classcode = $('input[name="classcode"]').val();
            if (isNaN(classcode)) {
                alert('邀请码应该只包含数字');
                return;
            }
            if (classcode.length != 8) {
                alert('邀请码应该8个数字');
                return;
            }
            $.ajax({
                type: "post",
                url: baseURL + "users/change_class",
                dataType: "json",
                data: {user_id: userId, classcode: classcode},
                success: function (res) {
                    console.log(res);
//                        res = JSON.parse(res);
                    if (res.status == 'success') {
//                        alert('Password is changed successfully.');
                        $('.changepass-modal').fadeOut('fast');
                        location.reload();
                    } else//failed
                    {
                        alert(res.data);
                    }
                }
            })
        });

        $('.go2home-btn').on('click', function (object) {
            location.href = baseURL + "/student/home";
        });

        $('.gender div').on('click', function (object) {
            var gender = $(this).attr('item_type');
            $('.gender div').removeAttr('item_val');
            $('.gender div[item_type=' + gender + ']').attr('item_val', '1');
            $('#gender').val(gender);
        });

        showInterface()
    });

    function showInterface() {
        var fdata = new FormData();

        $('.frame-bg input').attr('disabled', 'disabled');
        $('.frame-bg input').css('background', 'transparent');
        var gender = $('.gender .checkText[item_val="1"]');
        $('.gender div').hide();
        gender.show();

        $('.frame').fadeOut('fast');
        $('.frame[item_type=' + (reg_step + 1) + ']').fadeIn('fast');
    }

    function checkValidation() {

    }
</script>
