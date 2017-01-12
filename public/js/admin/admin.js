
$(document).ready(function () {
    
$("#adminForm").validate({
    // Specify the validation rules

    rules: {
        first_name: "required",
        email: {required: true, email: true,
            remote: {
                url: admin_url + 'admin/email_exists',
                type: "post",
                data: {Id: ($('#admin_id').val() != '') ? $('#admin_id').val() : '', case: 'admin'}
            }
        },
        old_password: {required: true,
            remote: {
                url: admin_url + 'admin/password_exists',
                type: "POST",
                data: {old_password: ($('#old_password').val() != '') ? $('#old_password').val() : ''}
            }},
        password: {required: true, minlength: 8},
        password2: {required: true, minlength: 8, equalTo: '#password'},
//            status: "required",
        vAddress1: {
            required: true
        },
        vAddress2: {
            required: true
        },
        vCity: {
            required: true
        },
        vState: {
            required: true
        },
        vZipcode: {
            required: true
        },
        vCountry: "required"
    },
    // Specify the validation error messages
    messages: {
        first_name: "Please enter first name",
        last_name: "Please enter last name",
        email: {required: "Please enter email address", email: "Please enter valid email", remote: 'email already exists'},
        old_password: {required: "Please enter old password", remote: 'Old Password does not exist'},
        password: {required: "Please enter password", minlength: "Please enter atleast 8 charracter"},
        password2: {required: "Please enter same password to confirm", minlength: "Please enter atleast 8 charracter", equalTo: 'Password not matching'},
        status: "required",
    },
    errorClass: 'help-block',
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
    },
    submitHandler: function (form) {
//        alert("sdf");
        form.submit();
    }
});


//});

function deleteimg() {
    if (confirm("Are you sure you want to delete?")) {
        $.ajax({
            type: "POST",
            url: admin_url + "admin/image_delete",
            data: {admin_id: $('#admin_id').val(), vImage: ''},
            success: function () {
                $('#profile_image').show();
                $('.imgclass').hide()
                $('#changeimage').hide()
                $('#Deleteimg').hide()
            }
        });
    }
}
});