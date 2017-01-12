$(document).ready(function() {
    $("#admin-form").validate({
        // Specify the validation rules
        rules: {
            vFirstname: "required",
            vLastname: "required",
            iCountryId: "required",
            vContactNo: {
                required: true,
                minlength: 10,
                number: true
            }
        },
        // Specify the validation error messages
        messages: {
            vFirstname: "Please enter First Name",
            vLastname: "Please enter Last Name",
            iCountryId: "Please select Country",
            vContactNo: {
                required: "Please enter Contact No",
                minlength: "Please enter atleast 10 digits"
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
            element.text('OK!').addClass('valid').closest('.control-group').removeClass('error').addClass('success');
        }
    });

    $("#password-form").validate({
        // Specify the validation rules
        rules: {
            vPassword: {
                required: true,
                minlength: 6
            },
            vPassword2: {
                required: true,
                minlength: 6,
                equalTo: "#vPassword"
            }
        },
        messages: {
            vPassword: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long"
            },
            vPassword2: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long",
                equalTo: "Please enter same password to confirm"
            }
        },
        submitHandler: function(form) {

            $.ajax({
                type: 'POST',
                url: site_url + 'my_profile/my_profile/checkPassword',
                data: {iAdminId: $('#iAdminId').val(), Password: $('#voldPassword').val()},
                success: function(data) {
                    if (data) {
                          form.submit();
                        //HTMLFormElement.prototype.submit.call($('#monitor-form')[0]);
                    } else {
                        $('#voldPassword').closest('.control-group').removeClass('success').addClass('error');
                        $("#voldPasswordErr").html('<label for="voldPassword" generated="true" class="error">Your Old Password doesnt match</label>');                        
                    }
                }
            });

        },
        highlight: function(element) {
            $(element).closest('.control-group').removeClass('success').addClass('error');
        },
        success: function(element) {
            element.text('OK!').addClass('valid').closest('.control-group').removeClass('error').addClass('success');
        }
    });
});
