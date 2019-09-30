///role management

menu10_chk.click(function (e) {
    if (this.checked) menu10_st = '1';
    else menu10_st = '0';
});
menu20_chk.click(function (e) {
    if (this.checked) menu20_st = '1';
    else menu20_st = '0';
});
menu30_chk.click(function (e) {
    if (this.checked) menu30_st = '1';
    else menu30_st = '0';
});
menu40_chk.click(function (e) {
    if (this.checked) menu40_st = '1';
    else menu40_st = '0';
});
menu50_chk.click(function (e) {
    if (this.checked) menu50_st = '1';
    else menu50_st = '0';
});

add_menu10_chk.click(function (e) {
    if (this.checked) menu10_st = '1';
    else menu10_st = '0';
});
add_menu20_chk.click(function (e) {
    if (this.checked) menu20_st = '1';
    else menu20_st = '0';
});
add_menu30_chk.click(function (e) {
    if (this.checked) menu30_st = '1';
    else menu30_st = '0';
});
add_menu40_chk.click(function (e) {
    if (this.checked) menu40_st = '1';
    else menu40_st = '0';
});
add_menu50_chk.click(function (e) {
    if (this.checked) menu50_st = '1';
    else menu50_st = '0';
});

function makeArrayFromChkSt() {

    var jsonArray = {
        menu_10: menu10_st,
        menu_20: menu20_st,
        menu_30: menu30_st,
        menu_40: menu40_st,
        menu_50: menu50_st
    };
    return jsonArray;
}

$('#assign_admin_submit_form').submit(function (e) {
    var admin_id = $('#assign_admin_saveBtn').attr('admin_id');
    role_info = makeArrayFromChkSt();
    e.preventDefault();
    jQuery.ajax({
        url: baseURL + "admin/admins/assign",
        type: "post",
        data: {admin_id: admin_id, role_info: role_info},
        success: function (res) {
            var ret = JSON.parse(res);
            if (ret.status == 'success') {
                location.href = baseURL + "admin/signin/index";
            }
            else//failed
            {
                alert("Cannot modify Unit Data.");
            }
        }
    });
    jQuery('#assign_admin_modal').modal('toggle');


});


