$(document).ready(function () {
   
     $.validator.addMethod("vPasswordRule", function (value, element) {
        return this.optional(element) || /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{6,20}$/.test(value);
    }, "Password between 6 and 20 characters; must contain at least one lowercase letter, one uppercase letter, one numeric digit, and one special character, but cannot contain whitespace.");
    $("#contactForm").validate({
        rules: {
            fname: "required",
            lname: "required",
            email: {
                required: true,
                email: true,
            },
            telephone:  {
                required: true,
                number: true,
            }
        },
        messages: {
            firstName: "Please enter first name",
            lastName: "Please enter last name",
            email: {
                required: "Please enter email address",
                email: "Please enter valid email",
                remote: "Email already exists"
            },
            telephone:  {
                required: "Please enter telephone number",
                number:  "Please enter valid telephone number",
            }
        },
        submitHandler: function (form) {
            $(':button[type="submit"]').html('<i class="fa fa-ban"></i> Please Wait...');
            $(':button[type="submit"]').attr('disabled', true);
            $.ajax({
                type: 'POST',
                async: false,
                url: site_url + "content/contact_form",
                data: $("#contactForm").serialize(),
                success: function (data) {
                    $('#contactForm').css({ display: "none" });
                    $('#ContactSuccessMessage').html(data);
                }
             });
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