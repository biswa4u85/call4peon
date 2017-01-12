$(document).ready(function () {
     $.validator.addMethod("vPasswordRule", function (value, element) {
        return this.optional(element) || /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{6,20}$/.test(value);
    }, "Password between 6 and 20 characters; must contain at least one lowercase letter, one uppercase letter, one numeric digit, and one special character, but cannot contain whitespace.");
    $("#userForm").validate({
        rules: {
            firstName: "required",
            lastName: "required",
            contactNo: {
                required: true,
                number: true
            },
            vehicle: {
                min: 1
            },
            number: {
                required: true,
            },
            address: {
                required: true,
            },
            country: {
                min: 1
            },
            state: {
                min: 1
            },
            city: {
                min: 1
            },
            area: {
                required: true,
            },
            landmark: {
                required: true,
            },
        },
        messages: {
            firstName: "Please enter first name",
            lastName: "Please enter last name",
            contactNo: {
                required: "Please enter Contact No",
                number: "Please enter number only"
            },
            vehicle: {
                min: "Please select vehicle"
            },
            number: "Please enter number",
            address:"Please enter address",
            country: {
                min: "Please select country"
            },
            state: {
                min: "Please select state"
            },
            city: "Please enter city",
            area:"Please enter area",
            landmark: "Please enter landmark"
        },
        submitHandler: function (form) {
            $(':button[type="submit"]').html('<i class="fa fa-ban"></i> Please Wait...');
            $(':button[type="submit"]').attr('disabled', true);
            $.ajax({
                type: 'POST',
                async: false,
                url: site_url + "content/user_add",
                data: $("#userForm").serialize(),
                success: function (data) {
                    $('#userForm').css({ display: "none" });
                    $('#UserSuccessMessage').html(data);
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
            $(e).closest('.help-block').remove();
        },
        success: function (element) {
            element.text('').addClass('valid').closest('.control-group').removeClass('error').addClass('success');
        }
    });

    $('.country').on('change', function () {
        var country = $(this).val();
        var id = $(this).attr('id');
        var stateId = (id == 'pickupCountry') ? iPickupStateId : iDropStateId;
        var cityId = (id == 'pickupCountry') ? iPickupCityId : iDropCityId;
        var parent = $(this).closest('div.rootdiv');
        console.log(parent);
        $.ajax({
            type: 'POST',
            url: site_url + "content/getStateData",
            data: {Id: country, tablename: "states"},
            success: function (data) {
                var json = jQuery.parseJSON(data);
                $(parent).find('.state').empty();
                $(parent).find('.state').append("<option value ='0'>Select State </option>;");
                for (var i = 0; i < json.length; i++) {
                    var isSelected = (json[i]["iStateId"] == stateId) ? "selected" : "";
                    $(parent).find('.state').append("<option value=" + json[i]["iStateId"] + " " + isSelected + "> " + json[i]["vStateName"] + "</option>");
                }
                if (cityId > 0) {
                    $(parent).find('.state').trigger('change');
                }
                //$('.selectpicker').selectpicker();
            }
        });
    });
    
    $('.state').on('change', function () {
        var parent = $(this).closest('div.rootdiv');
        var id = $(this).attr('id');
        var country = $(parent).find('.country').val();
        var cityId = (id == 'pickupState') ? iPickupCityId : iDropCityId;
        var state = $(this).val();
        $.ajax({
            type: 'POST',
            url: site_url + "content/getCityData",
            data: {Id: country, state_id: state, tablename: "city"},
            success: function (data) {
                var json = jQuery.parseJSON(data);
                $(parent).find('.city').empty();
                $(parent).find('.city').append("<option value ='0'>Select City </option>");
                for (var i = 0; i < json.length; i++) {
                    var isSelected = (json[i]["iCityId"] == cityId) ? "selected" : "";
                    $(parent).find('.city').append("<option value=" + json[i]["iCityId"] + " " + isSelected + " > " + json[i]["vCityName"] + "</option>");
                }
              //  $('.selectpicker').selectpicker();
            }
        });
    });
});