/**
 * Created by Administrator on 7/18/2017.
 */
jQuery("#delete_cw_item_btn").click(function () {
    var delete_cw_id = jQuery("#delete_cw_item_btn").attr("delete_cw_id");
    jQuery.ajax({
        type: "post",
        url: baseURL+"admin/coursewares/delete",
        dataType: "json",
        data: {delete_cw_id: delete_cw_id},
        success: function(res) {
            if(res.status=='success') {
                var table = document.getElementById("cwInfo_tbl");
                var tbody = table.getElementsByTagName("tbody")[0];
                tbody.innerHTML = res.data;
                executionPageNation();
            }
            else//failed
            {
                alert("Cannot delete CourseWare Item.");
            }
        }
    });
    jQuery('#cw_delete_modal').modal('toggle');
});
jQuery("#cw_addNew_submit_form").submit(function (e) {
    e.preventDefault();
    jQuery.ajax({
        url:baseURL+"admin/coursewares/add",
        type:"post",
        data:new  FormData(this),
        processData:false,
        contentType:false,
        cache:false,
        async:false,
        success: function(res){
            var ret = JSON.parse(res);
            if(ret.status=='success') {
                var table = document.getElementById("cwInfo_tbl");
                var tbody = table.getElementsByTagName("tbody")[0];
                tbody.innerHTML = ret.data;
                executionPageNation();
            }
            else//failed
            {
                alert("Cannot modify Unit Data.");
            }
        }
    });
    jQuery('#cw_addNew_modal').modal('toggle');
});
jQuery("#cw_edit_submit").submit(function (e) {

    e.preventDefault();
    var cw_id = jQuery("#cw_info_id").val();
    var fdata = new  FormData(this);
    fdata.append("cw_id",cw_id);
    jQuery.ajax({
        url:baseURL+"admin/coursewares/edit",
        type:"post",
        data:fdata,
        processData:false,
        contentType:false,
        cache:false,
        async:false,
        success: function(res){
            var ret = JSON.parse(res);
            if(ret.status=='success') {
                var table = document.getElementById("cwInfo_tbl");
                var tbody = table.getElementsByTagName("tbody")[0];
                tbody.innerHTML = ret.data;
                executionPageNation();
            }
            else//failed
            {
                alert("Cannot modify Unit Data.");
            }
        }
    });
    jQuery('#cw_modify_modal').modal('toggle');
});