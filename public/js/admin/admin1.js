jQuery(document).ready(function($) {
    $("#admin-form").validate({
        // Specify the validation rules
        rules: {
            vFirstname: "required",
            vLastname: "required",
            vUserName: "required",
            iCountryId: "required",
            vContactNo: {
                required: true,
                minlength: 10,
                number: true
            },
            eStatus: "required",
            vEmail: {
                required: true,
                email: true
            },
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
        // Specify the validation error messages
        messages: {
            vFirstname: "Please enter First Name",
            vLastname: "Please enter Last Name",
            vUserName: "Please enter Username",
            iCountryId: "Please select Country",
            vContactNo: {
                required: "Please enter Contact No",
                minlength: "Please enter atleast 10 digits"
            },
            eStatus: "Please select status",
            vEmail: {
                required: "Please enter Email address",
                email: "Please enter a valid email address"
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
        }, validClass: function(element) {
            $('#' + $(element).attr('id') + 'div').removeClass('has-error');
            $('#' + $(element).attr('id') + 'div').addClass('has-success');
        },
        errorPlacement: function(error, element) {
            //  $('#'+$(element).attr('id')+'div').addClass('has-error');
            error.appendTo("#" + $(element).attr('id') + "Err");

        },
         submitHandler: function(form) {

            if ($('#iAdminId').val() == '' ){
                $.ajax({
                    type: 'POST',
                    url: site_url + 'admin/admin/checkUser',
                    data: {UserName: $('#vUserName').val(), tablename: $(form).data('form')},
                    success: function(data) {
                        if (data == false) {
                            $('#vUserName').closest('.control-group').removeClass('success').addClass('error');
                            $("#vUserNameErr").html('<label for="vUserName" generated="true" class="error">Username already exists</label>');
                        } else {
                            $.ajax({
                                type: 'POST',
                                url: site_url + 'admin/admin/checkEmail',
                                data: {Email: $('#vEmail').val(), tablename: $(form).data('form')},
                                success: function(data) {
                                    if (data == false) {
                                        $('#vEmail').closest('.control-group').removeClass('success').addClass('error');
                                        $("#vEmailErr").html('<label for="vEmail" generated="true" class="error">Email already exists</label>');
                                    } else {
                                        form.submit();
                                    }
                                }
                            });
                        }
                    }
                });    
        }else{
            form.submit();
        }
    
//
//
//            } else {
//                form.submit();
//
//            }

        },
        highlight: function(element) {
            $(element).closest('.control-group').removeClass('success').addClass('error');
        },
        success: function(element) {
            element.text('OK!').addClass('valid').closest('.control-group').removeClass('error').addClass('success');
        }
    });
});


function changerole(obj) {
    $.ajax({
        type: "POST",
        url: "admin/chnge_role_admin",
        data: {
            iAdminId: $("#" + obj.id).data('admin'),
            iRoleId: obj.value
        },
        success: function(result) {
            location.reload(true);
        }
    });

}

