$(document).ready(function () {
    
    $("#StateForm").validate({
        rules: {
            state_name: "required"            
        },
        messages: {
            state_name: "Please enter State Name"            
        },
        submitHandler: function (form) {
            $(':button[type="submit"]').html('<i class="fa fa-ban"></i> Please Wait...');
//	    $(':button[type="submit"]').attr('disabled', true);
            form.submit();
        },
        rrorClass: 'help-block',
        errorElement: 'span',
        errorPlacement: function (error, e) {
            e.parents('.form-group > div').append(error);
        },
        highlight: function (e) {
            $(e).closest('.validate').removeClass('has-success has-error').addClass('has-error');
            $(e).closest('.help-block').remove();
        },
        success: function (element) {
            element.text('').addClass('valid').closest('.control-group').removeClass('error').addClass('success');
        }
    });
    
    if (typeof $.fn.select2 != 'undefined')
    {
        // Placeholders                
        $("#iCountryId").select2({
            placeholder: "Select Country",
            allowClear: true,
            width: '100%'
        });
    }
});
