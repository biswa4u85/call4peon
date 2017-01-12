$(document).ready(function () {

    $.validator.addMethod("vPasswordRule", function (value, element) {
        return this.optional(element) || /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{6,20}$/.test(value);
    }, "Password between 6 and 20 characters; must contain at least one lowercase letter, one uppercase letter, one numeric digit, and one special character, but cannot contain whitespace.");

    $("#userForm").validate({
        rules: {
            firstName: "required",
            lastName: "required",
            email: {
                required: true,
                email: true,
//                remote: {
//                    type: "post",
//                    url: site_url + "admin/checkEmail?id=" + id + '&mode=' + mode,
//                }
            },
            password: {
                required: true,
                minlength: 6,
                vPasswordRule: true
            },
            password2: {
                required: true,
                minlength: 6,
                equalTo: "#password"
            },
            contactNo: {
                required: true,
                minlength: 10,
                phoneno: true
            },
            address: {
                required: true,
            },
            vehicleId: {
                required: true,
                min: 1
            },
            number: {
                required: true,
            },
            standingPoint: {
                required: true,
            },
        },
        messages: {
            firstName: "Please enter first name",
            lastName: "Please enter last name",
            email: {
                required: "Please enter email address",
                email: "Please enter valid email",
                remote: "Email already exists"
            },
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long"
            },
            password2: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long",
                equalTo: "Please enter same password to confirm"
            },
            contactNo: {
                required: "Please enter Contact No",
                minlength: "Please enter atleast 10 digits",
                phoneno: "Please enter valid phone number"
            },
            vehicleId: {
                min: "Please select vehicle"
            }
        },
        submitHandler: function (form) {
            $(':button[type="submit"]').html('<i class="fa fa-ban"></i> Please Wait...');
//	    $(':button[type="submit"]').attr('disabled', true);
            form.submit();
        },
        errorClass: 'help-block',
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

    $('#changpassbtn').click(function () {
        $('#change_pass_div').toggle();
//        $('#password').toggle();
//        $('#password2').toggle();
    })

    $('#country').on('change', function () {
        var country = $('#country').val();
        $.ajax({
            type: 'POST',
            url: site_url + "area/getStateData",
            data: {Id: country, tablename: "states"},
            success: function (data) {
                var json = jQuery.parseJSON(data);
                $('#city').empty();
                $('#state').empty();
                for (var i = 0; i < json.length; i++) {
                    var isSelected = (json[i]["iStateId"] == iStateId) ? "selected" : "";
                    $('#state').append("<option value=" + json[i]["iStateId"] + " " + isSelected + "> " + json[i]["vStateName"] + "</option>");
                }
                if (iCityId > 0) {
                    $('#state').trigger('change');
                }
                $('.selectpicker').selectpicker();
            }
        });
    });

    $('#state').on('change', function () {
        var country = $('#country').val();
        var state = $('#state').val();
        $.ajax({
            type: 'POST',
            url: site_url + "area/getCityData",
            data: {Id: country, state_id: state, tablename: "city"},
            success: function (data) {
                var json = jQuery.parseJSON(data);
                $('#city').empty();
                for (var i = 0; i < json.length; i++) {
                    var isSelected = (json[i]["iCityId"] == iCityId) ? "selected" : "";
                    $('#city').append("<option value=" + json[i]["iCityId"] + " " + isSelected + " > " + json[i]["vCityName"] + "</option>");
                }
                $('.selectpicker').selectpicker();
            }
        });
    });
    if ($('#country').val() != 0) {
        $('#country').trigger('change');
    }

    if (typeof $.fn.select2 != 'undefined')
    {
        // Placeholders                
        $("#country").select2({
            placeholder: "Select Country",
            allowClear: true,
            width: '100%'
        });
        $("#state").select2({
            placeholder: "Select State",
            allowClear: true,
            width: '100%'
        });
        $("#city").select2({
            placeholder: "Select City",
            allowClear: true,
            width: '100%'
        });
    }
});
function delete_file(obj)
{
    var file = $(obj).data('bind');
    if (confirm('Are you sure want to delete?')) {
        $.ajax({
            type: 'POST',
            url: rootPath + 'user/deleteVehicleImage',
            data: {file: file},
            success: function (data) {
                location.reload();
            }
        });
    }
}
