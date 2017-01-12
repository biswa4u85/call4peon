$(document).ready(function () {

    $.validator.addMethod("notEqualTo", function (value, element, param) {
        var target = $(param);
        if (value)
            return value !== target.val();
        else
            return this.optional(element);
    }, "Old password and new password must not be same");

    $.validator.addMethod("vPasswordRule", function (value, element) {
        return this.optional(element) || /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{6,20}$/.test(value);
    }, "Password between 6 and 20 characters; must contain at least one lowercase letter, one uppercase letter, one numeric digit, and one special character, but cannot contain whitespace.");

    $("#myAccountForm").validate({
        rules: {
            vName: "required",
            vUserName: "required",
            vEmail: {required: true, email: true,
                remote: {
                    url: admin_url + 'admin/email_exists',
                    type: "post",
                    data: {Id: ($('#admin_id').val() != '') ? $('#admin_id').val() : '', case: 'admin'}
                }
            }
        },
        // Specify the validation error messages
        messages: {
            vName: "Please enter name",
            vUserName: "Please enter user name",
            vEmail: {required: "Please enter email address", email: "Please enter valid email", remote: 'email already exists'},
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    $("#password-form").validate({
        // Specify the validation rules
        rules: {
            voldPassword: {
                required: true,
                remote: {
                    type: "post",
                    url: admin_url + "admin/checkPassword"
                }
            },
            vPassword: {
                required: true,
                minlength: 6,
                vPasswordRule: true,
                notEqualTo: "#voldPassword"
            },
            vPassword2: {
                required: true,
                minlength: 6,
                equalTo: "#vPassword"
            }
        },
        messages: {
            voldPassword: {
                required: "Please provide your old password",
                remote: "Your password doesn't match old one"
            },
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
        submitHandler: function (form) {
            $(':button[type="submit"]').html('<i class="fa fa-ban"></i> Please Wait...');
            $(':button[type="submit"]').attr('disabled', true);
            form.submit();
        }
    });
});

function deleteimg() {
    if (confirm("Are you sure you want to delete?")) {
        $.ajax({
            type: "POST",
            url: admin_url + "admin/image_delete",
            data: {admin_id: $('#admin_id').val(), vImage: ''},
            success: function () {
                $('#vImage').show();
                $('#vProfileImg').hide()
                $('#changeimg').hide()
                $('#Deleteimg').hide()
            }
        });
    }
}