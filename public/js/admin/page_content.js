 jQuery(document).ready(function($) {
    $('#page-form').validate({
       rules: {
            'vPageTitle': {
                required: true
            },
            'vPageCode': {
                required: true
            },
            'vUrl': {
                required: true
            },
            'tMetaTitle': {
                required: true
            },
            'tMetaKeyword':{
                required: true
            },
            'tMetaDesc':{
                required: true
            }
        },
        messages: {
            'vPageTitle': {
                required: 'Please enter a page title'
            },
            'vPageCode': {
                required: 'Please enter a page code'
            },
            'vUrl': {
                required: 'Please enter a url'
            },
            'tMetaTitle': {
                required: 'Please enter a Meta Title'
            },
            'tMetaKeyword': {
                required: 'Please enter a Meta Keyword'
            },
            'tMetaDesc': {
                required: 'Please enter a Meta Desc'
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