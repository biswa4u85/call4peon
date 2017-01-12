$(document).ready(function () {

    var id = $('#iAdminId').val();
    var mode = $('#mode').val();
    $("#changpassbtndiv").hide();
    $("#cancelpassbtn").hide();
    $("#passdiv").hide();

    if (typeof $.fn.select2 != 'undefined')
    {
        // Placeholders
        $("#iCountryId").select2({
            placeholder: "Select Country",
            allowClear: true,
            width: '100%'
        });
        $("#iRoleId").select2({
            placeholder: "Select Role",
            allowClear: true,
            width: '100%'
        });
        $("#eStatus").select2({
            placeholder: "Select Role",
            allowClear: true,
            width: '100%'
        });
    }

    $.validator.addMethod("vPasswordRule", function (value, element) {
        return this.optional(element) || /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{6,20}$/.test(value);
    }, "Password between 6 and 20 characters; must contain at least one lowercase letter, one uppercase letter, one numeric digit, and one special character, but cannot contain whitespace.");

    $("#AdminForm").validate({
        rules: {
            vName: "required",
            vUserName: {
                required: true,
                remote: {
                    type: "post",
                    url: site_url + "admin/checkUser?id=" + id + '&mode=' + mode + '&tablename=admin'
                }
            },
            vPassword: {
                required: true,
                minlength: 6,
                vPasswordRule: true
            },
            vPassword2: {
                required: true,
                minlength: 6,
                equalTo: "#vPassword"
            },
            vEmail: {
                required: true,
                email: true,
                remote: {
                    type: "post",
                    url: site_url + "admin/checkEmail?id=" + id + '&mode=' + mode + '&tablename=admin'
                }
            }
        },
        messages: {
            vName: "Please enter Name",
            vEmail: {
                required: "Please enter Email Address",
                email: "Please enter valid Email",
                remote: "Email already exists"
            },
            vUserName: {
                required: "Please enter UserName",
                remote: "UserName already exists"
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
            $(e).closest('.form-group').removeClass('has-error').addClass('has-error');
            $(e).closest('.help-block').remove();
        },
        success: function (element) {
            element.text('').addClass('valid').closest('.control-group').removeClass('error').addClass('success');
            $(element).closest('.form-group').removeClass('has-error');
        }
    });

    if (mode == 'edit') {
        $("#changpassbtndiv").show();
        $("#passdiv").hide();
    }else{
        $("#changpassbtndiv").hide();
        $("#passdiv").show();
    }
    
    $('#changpassbtn').click(function () {       
        $("#cancelpassbtn").toggle();
        $("#changpassbtn").toggle();
        $("#passdiv").toggle();
        $("#chnagepassval").val("1");
    });
    $('#cancelpassbtn').click(function () {       
        $("#cancelpassbtn").toggle();
        $("#changpassbtn").toggle();
        $("#passdiv").toggle();
        $("#chnagepassval").val("0");
    });

});
