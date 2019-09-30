jQuery(document).ready(function() {
    $('#extfile').trigger('change')
    $('.fileinput').addClass('fileinput-exists').removeClass('fileinput-new')

    $('.fileinput .remove').on('click', function() {
        $.post(
            remove_addon_url,
            {},
            function( data, status ){
                if( status == 'success'){
                    console.log('success');
                }
            }
        );
    });





});
