 jQuery(document).ready(function($) {
    $('#admin-form').validate({
       rules: {
            'vEmailCode': {
                required: true
            },
            'vEmailTitle': {
                required: true
            },
            'vFromName': {
                required: true
            },
            'vFromEmail': {
                required: true
            },
            'vEmailSubject':{
                required: true
            },
        },
        messages: {
            'vEmailCode': {
                required: 'Please enter a email code'
            },
            'vEmailTitle': {
                required: 'Please enter a email title'
            },
            'vFromName': {
                required: 'Please enter a from name'
            },
            'vFromEmail': {
                required: 'Please enter a from email'
            }
        }, validClass: function(element) {
            $('#' + $(element).attr('id') + 'div').removeClass('has-error');
            $('#' + $(element).attr('id') + 'div').addClass('has-success');
        },
        errorPlacement: function(error, element) {
            //  $('#'+$(element).attr('id')+'div').addClass('has-error');
            error.appendTo("#" + $(element).attr('id') + "Err");

        },
        highlight: function(element) {
            $(element).closest('.control-group').removeClass('success').addClass('error');
        },
        success: function(element) {
            element
                    .text('OK!').addClass('valid')
                    .closest('.control-group').removeClass('error').addClass('success');
        }
    });
 });