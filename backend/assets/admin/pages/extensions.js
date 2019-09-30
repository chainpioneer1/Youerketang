var FormDropzone = function () {

    return {
        //main function to initiate the module
        init: function () {
            Dropzone.options.iconDropzone = {
                maxFiles: 1,
                dictDefaultMessage: "",
                init: function() {
                    iconDropzone = this;

                    $.get(upload_icon_url, function(data) {
                        console.log('upload_icon_url');
                        console.log(data);
                        <!-- 5 -->
                        $.each(data, function(key,value){

                            var mockFile = { name: value.name, size: value.size };
                            //thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                            //thisDropzone.options.thumbnail.call(thisDropzone, mockFile, value.path);
                            iconDropzone.files.push( mockFile );
                            iconDropzone.emit('addedfile', mockFile);
                            iconDropzone.emit("complete", mockFile);
                            iconDropzone.emit('thumbnail', mockFile, value.path)

                        });

                    });

                    this.on("addedfile", function(file) {
                        // Create the remove button
                        var removeButton = Dropzone.createElement("<a href='javascript:;'' class='btn red btn-sm btn-block'>Remove</a>");

                        // Capture the Dropzone instance as closure.
                        var _this = this;

                        // Listen to the click event
                        removeButton.addEventListener("click", function(e) {
                            // Make sure the button click doesn't submit the form:
                            e.preventDefault();
                            e.stopPropagation();

                            // Remove the file preview.
                            _this.removeFile(file);
                            // If you want to the delete the file on the server as well,
                            // you can do the AJAX request here.
                        });

                        // Add the button to the file preview element.
                        file.previewElement.appendChild(removeButton);

                        if (this.files[1]!=null){
                            this.removeFile(this.files[0]);
                            //iconDropzone.emit('removedfile', this.files[0]);
                        }

                    });

                    this.on("removedfile", function(file) {
                        console.log(file);

                        $.post(
                            delete_icon_url,
                            {
                                filename: file.name
                            },
                            function( data, status ){
                                if( status == 'success' && data == 'success' ){
                                    console.log('success delete icon')
                                } else {
                                    console.log('fail delete icon')
                                }
                            }
                        );
                    });
                }
            }


            Dropzone.options.featureDropzone = {
                maxFiles: 1,
                dictDefaultMessage: "",
                init: function() {
                    featureDropzone = this;

                    $.get(upload_feature_url, function(data) {
                        console.log('upload_feature_url');
                        console.log(data);
                        <!-- 5 -->
                        $.each(data, function(key,value){

                            var mockFile = { name: value.name, size: value.size };
                            //thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                            //thisDropzone.options.thumbnail.call(thisDropzone, mockFile, value.path);
                            featureDropzone.files.push( mockFile )
                            featureDropzone.emit('addedfile', mockFile);
                            featureDropzone.emit("complete", mockFile);
                            featureDropzone.emit('thumbnail', mockFile, value.path)

                        });

                    });

                    this.on("addedfile", function(file) {
                        // Create the remove button
                        var removeButton = Dropzone.createElement("<a href='javascript:;'' class='btn red btn-sm btn-block'>Remove</a>");

                        // Capture the Dropzone instance as closure.
                        var _this = this;

                        // Listen to the click event
                        removeButton.addEventListener("click", function(e) {
                            // Make sure the button click doesn't submit the form:
                            e.preventDefault();
                            e.stopPropagation();

                            // Remove the file preview.
                            _this.removeFile(file);
                            // If you want to the delete the file on the server as well,
                            // you can do the AJAX request here.
                        });

                        // Add the button to the file preview element.
                        file.previewElement.appendChild(removeButton);

                        if (this.files[1]!=null){
                            this.removeFile(this.files[0]);
                        }
                    });

                    this.on("removedfile", function(file) {
                        console.log(file);

                        $.post(
                            delete_feature_url,
                            {
                                filename: file.name
                            },
                            function( data, status ){
                                if( status == 'success' && data == 'success' ){
                                    console.log('success delete feature')
                                } else {
                                    console.log('fail delete feature')
                                }
                            }
                        );
                    });
                }
            }


            Dropzone.options.screenshotDropzone = {
                dictDefaultMessage: "",
                init: function() {
                    screenshotDropzone = this;

                    $.get(upload_screenshot_url, function(data) {
                        console.log('upload_screenshot_url');
                        console.log(data);
                        <!-- 5 -->
                        $.each(data, function(key,value){

                            var mockFile = { name: value.name, size: value.size };
                            //thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                            //thisDropzone.options.thumbnail.call(thisDropzone, mockFile, value.path);
                            screenshotDropzone.files.push( mockFile )
                            screenshotDropzone.emit('addedfile', mockFile);
                            screenshotDropzone.emit("complete", mockFile);
                            screenshotDropzone.emit('thumbnail', mockFile, value.path)

                        });

                    });

                    this.on("addedfile", function(file) {
                        // Create the remove button
                        var removeButton = Dropzone.createElement("<a href='javascript:;'' class='btn red btn-sm btn-block'>Remove</a>");

                        // Capture the Dropzone instance as closure.
                        var _this = this;

                        // Listen to the click event
                        removeButton.addEventListener("click", function(e) {
                            // Make sure the button click doesn't submit the form:
                            e.preventDefault();
                            e.stopPropagation();

                            // Remove the file preview.
                            _this.removeFile(file);
                            // If you want to the delete the file on the server as well,
                            // you can do the AJAX request here.
                        });

                        // Add the button to the file preview element.
                        file.previewElement.appendChild(removeButton);
                    });

                    this.on("removedfile", function(file) {
                        console.log(file);

                        $.post(
                            delete_screenshot_url,
                            {
                                filename: file.name
                            },
                            function( data, status ){
                                if( status == 'success' && data == 'success' ){
                                    console.log('success delete screenshot')
                                } else {
                                    console.log('fail delete screenshot')
                                }
                            }
                        );
                    });
                }
            }
        }
    };
}();

var ExtensionDatatablesManaged = function () {

    var initPickers = function () {
        //init date pickers
        $('.date-picker').datepicker({
            rtl: App.isRTL(),
            autoclose: true
        });
    }

    var initTable = function () {

        var grid = new Datatable();

        grid.init({
            src: $("#extension_table"),
            onSuccess: function (grid, response) {
                // grid:        grid object
                // response:    json object of server side ajax response
                // execute some code after table records loaded
            },
            onError: function (grid) {
                // execute some code on network or other general error
            },
            onDataLoad: function (grid) {
                // execute some code on ajax data load
            },
            loadingMessage: 'Loading...',
            dataTable: { // here you can define a typical datatable settings from http://datatables.net/usage/options

                // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
                // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/scripts/datatable.js).
                // So when dropdowns used the scrollable div should be removed.
                //"dom": "<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'<'table-group-actions pull-right'>>r>t<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'>>",

                // save datatable state(pagination, sort, etc) in cookie.
                "bStateSave": true,

                // save custom filters to the state
                "fnStateSaveParams": function (oSettings, sValue) {
                    $("#extension_table tr.filter .form-control").each(function () {
                        sValue[$(this).attr('name')] = $(this).val();
                    });

                    return sValue;
                },

                // read the custom filters from saved state and populate the filter inputs
                "fnStateLoadParams": function (oSettings, oData) {
                    //Load custom filters
                    $("#extension_table tr.filter .form-control").each(function () {
                        var element = $(this);
                        if (oData[element.attr('name')]) {
                            element.val(oData[element.attr('name')]);
                        }
                    });

                    return true;
                },

                "lengthMenu": [
                    [10, 20, 50, 100, 150, -1],
                    [10, 20, 50, 100, 150, "All"] // change per page values here
                ],
                "pageLength": 50, // default record count per page
                "ajax": {
                    "url": ajax_url + '/get_extensions', // ajax source
                },
                "ordering": false,
                "order": [
                    [1, "asc"]
                ]// set first column as a default sort by asc
            }
        });

        // handle group actionsubmit button click
        grid.getTableWrapper().on('click', '.table-group-action-submit', function (e) {
            e.preventDefault();
            var action = $(".table-group-action-input", grid.getTableWrapper());
            if (action.val() != "" && grid.getSelectedRowsCount() > 0) {
                grid.setAjaxParam("customActionType", "group_action");
                grid.setAjaxParam("customActionName", action.val());
                grid.setAjaxParam("id", grid.getSelectedRows());
                grid.getDataTable().ajax.reload();
                grid.clearAjaxParams();
            } else if (action.val() == "") {
                App.alert({
                    type: 'danger',
                    icon: 'warning',
                    message: 'Please select an action',
                    container: grid.getTableWrapper(),
                    place: 'prepend'
                });
            } else if (grid.getSelectedRowsCount() === 0) {
                App.alert({
                    type: 'danger',
                    icon: 'warning',
                    message: 'No record selected',
                    container: grid.getTableWrapper(),
                    place: 'prepend'
                });
            }
        });

        //grid.setAjaxParam("customActionType", "group_action");
        //grid.getDataTable().ajax.reload();
        //grid.clearAjaxParams();
    }

    return {

        //main function to initiate the module
        init: function () {
            if (!jQuery().dataTable) {
                return;
            }

            var extension_tbl = $("#extension_table");
            if( extension_tbl.length > 0 ){
                initPickers();
                initTable();
            }

        }

    };

}();


jQuery(document).ready(function() {
    var dz = $('.dropzone');
    if( dz.length > 0  )
        FormDropzone.init();

    ExtensionDatatablesManaged.init();


    $('#bulk_action_btn').click(function(){
        var url = ajax_url + '/bulk_action';

        var i = 0;
        var bulk_act_ids = [];
        $('.bulk_act_ids:checked').each(function () {
            bulk_act_ids[i++] = $(this).val();
        });

        var bulk_action = $('#bulk_action').val();

        console.log(bulk_act_ids);
        console.log(bulk_action);

        $.post(
            url,
            {
                bulk_act_ids: bulk_act_ids,
                bulk_action: bulk_action
            },
            function( data, status ){
                if( status == 'success' ){
                    App.alert({
                        container: "",
                        place: 'append', // append or prepent in container
                        type: 'success',  // alert's type
                        message: 'save success!',  // alert's message
                        close: true, // make alert closable
                        reset: true, // close all previouse alerts first
                        focus: true, // auto scroll to the alert after shown
                        closeInSeconds: 3, // auto close after defined seconds
                        icon: ""
                    });
                    console.log('success bulk action');
                } else {
                    console.log('fail bulk action')
                }
            }
        );
    });

    function check_parent( elem ){
        var slug = $(elem).data('slug');
        var parent_slug = $(elem).data('parent');

        var parent_elem = $('input[data-slug="' + parent_slug + '"]');
        if( parent_elem.length > 0 ){
            parent_elem = parent_elem[0];

            if( $(parent_elem).is(':checked') ){
                return;
            }

            $(parent_elem).prop('checked', true);
            check_parent(parent_elem);
        }
    }

    function check_child( elem ){
        var slug = $(elem).data('slug');
        var parent_slug = $(elem).data('parent');

        var child_elems = $('input[data-parent="' + slug + '"]');
        if( child_elems.length > 0 ){
            for( var i=0; i<child_elems.length; i++ ){
                var child_elem = child_elems[i];

                if( $(child_elem).is(':checked') ){
                    $(child_elem).prop('checked', false);
                    check_child(child_elem);
                }
            }
        }
    }

    $('.categories').change(function(){
        if($(this).is(':checked')){
            check_parent( $(this) );
        } else {
            check_child( $(this) );
        }
    });

    $('.fileinput').fileinput({name:'extfile'});

    $('#extfile').on('change', function() {
        alert('change');
        $('#input_version').show();
    });


    //$('#description').data("wysihtml5").editor.setValue(description);
    //$('#full_desc').data("wysihtml5").editor.setValue(full_desc);
});
