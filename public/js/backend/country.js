$(document).ready(function () {
    $("#CountryForm").validate({
        rules: {
            country_name: "required",
            country_code: "required",
            gmt: "required",
            time_zone: "required"
        },
        messages: {
            country_name: "Please enter Country Name",
            country_code: "Please enter Country Code",
            gmt: "Please enter GMT",
            time_zone: "Please enter Time Zone"
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
});
