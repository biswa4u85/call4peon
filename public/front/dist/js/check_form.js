$(document).ready(function () {
    $("#checkForm").validate({
        rules: {
            from: "required",
            to: "required",
        },
        messages: {
            from: "Please enter first name",
            to: "Please enter last name",
        },
        submitHandler: function (form) {
          form.submit();
        },
        errorClass: 'help-block',
        errorElement: 'span',
        errorPlacement: function (error, e) {
            e.parents('.form-group').append(error);
        },
        highlight: function (e) {
            $(e).closest('.validate').removeClass('has-success has-error').addClass('has-error');
            $(e).closest('.form-group').removeClass('has-error').addClass('has-error');
            $(e).closest('.help-block').remove();
        },
        success: function (element) {
            element.text('').addClass('valid').closest('.control-group').removeClass('error').addClass('success');
            $(element).closest('.form-group').removeClass('has-error');
        }
    });
});