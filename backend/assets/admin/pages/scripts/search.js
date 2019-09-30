var Search = function () {

    return {
        //main function to initiate the module
        init: function () {
           	$('.date-picker').datepicker({
                rtl: App.isRTL(),
                orientation: "left",
                autoclose: true,
                dateFormat: "yyyy-mm-dd",
            });
        }

    };

}();

jQuery(document).ready(function() {
    Search.init();
})