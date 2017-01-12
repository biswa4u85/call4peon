$(document).ready(function() {
    
    initSocialPopup();
    
    $("#user-form").validate({
        // Specify the validation rules
        rules: {
            vFirstName: "required",
            vLastName: "required",
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
//            vInterestCategory:{
//                required: true
//            }
        },
        // Specify the validation error messages
        messages: {
            vFirstName: "Please enter First Name",
            vLastName: "Please enter Last Name",
//            vUserName: "Please enter Username",
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
//            vInterestCategory:{
//                required: "Please select your interest of category"
//            }
            
        }, validClass: function(element) {
            $('#' + $(element).attr('id') + 'div').removeClass('has-error');
            $('#' + $(element).attr('id') + 'div').addClass('has-success');
        },
        errorPlacement: function(error, element) {
            //  $('#'+$(element).attr('id')+'div').addClass('has-error');
            error.appendTo("#" + $(element).attr('id') + "Err");

        },
        submitHandler: function(form) {
            
                if ($('#iUserId').val() == '' ){
                $.ajax({
                    type: 'POST',
                    url: site_url + 'user/user/checkUser',
                    data: {UserName: $('#vUserName').val(), tablename: $(form).data('form')},
                    success: function(data) {
                        if (data == false) {
                            $('#vUserName').closest('.control-group').removeClass('success').addClass('error');
                            $("#vUserNameErr").html('<label for="vUserName" generated="true" class="error">Username already exists</label>');
                        } else {
                            $.ajax({
                                type: 'POST',
                                url: site_url + 'user/user/checkEmail',
                                data: {vEmail: $('#vEmail').val(), tablename: $(form).data('form')},
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

        },
        highlight: function(element) {
            $(element).closest('.control-group').removeClass('success').addClass('error');
        },
        success: function(element) {
            element.text('OK!').addClass('valid').closest('.control-group').removeClass('error').addClass('success');
        }
    });
});

function initSocialPopup(){
     $('.twitterpopup').click(function (event) {
        var width = 575,
                height = 400,
                left = ($(window).width() - width) / 2,
                top = ($(window).height() - height) / 2,
                url = rootPath + "social/socialConnect/?page=sm&social=Twitter",
//                url = this.href,
                opts = 'status=1' +
                ',width=' + width +
                ',height=' + height +
                ',top=' + top +
                ',left=' + left;

        window.open(url, 'twitter', opts);
        return true;
    });
    $('.linkedinpopup').click(function (event) {
        var width = 575,
                height = 400,
                left = ($(window).width() - width) / 2,
                top = ($(window).height() - height) / 2,
                url = rootPath + "social/socialConnect/?page=sm&social=LinkedIn",
//                url = this.href,
                opts = 'status=1' +
                ',width=' + width +
                ',height=' + height +
                ',top=' + top +
                ',left=' + left;

        window.open(url, 'linkedin', opts);
        return true;
    });
    $('.facebookpopup').click(function (event) {
        var width = 575,
                height = 400,
                left = ($(window).width() - width) / 2,
                top = ($(window).height() - height) / 2,
                url = rootPath + "social/socialConnect/?page=sm&social=Facebook",
//                url = this.href,
                opts = 'status=1' +
                ',width=' + width +
                ',height=' + height +
                ',top=' + top +
                ',left=' + left;

        window.open(url, 'facebook', opts);
        return true;
    });

}
