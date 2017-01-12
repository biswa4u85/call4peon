$(document).ready(function () {
    $("#shipmentForm").validate({
        rules: {
            title: "required",
            description: "required",
            contactNo: {
                required: true,
                number: true
            },
            prefferedDate: "required",
            vehicle: {
                min: 1
            },
            firstName: "required",
            lastname: "required",
            pickupAddress: "required",
            pickupCountry: {
                min: 1
            },
            pickupState: {
                min: 1
            },
            pickupCity: {
                min: 1
            },
            dropAddress: "required",
            dropCountry: {
                min: 1
            },
            dropState: {
                min: 1
            },
            dropCity: {
                min: 1
            },
        },
        messages: {
            user: {
                required: "Please select user",
                min: "Please select User"
            },
            pickupCountry: {
                min: "Please select Country"
            },
            dropCountry: {
                min: "Please select Country"
            },
            pickupState: {
                min: "Please select State"
            },
            dropState: {
                min: "Please select State"
            },
            pickupCity: {
                min: "Please select City"
            },
            dropCity: {
                min: "Please select City"
            },
            vehicle: {
                min: "Please select Vehicle"
            },
            type: "Please enter vehicle type",
            number: "Please enter vehicle number",
            standingPoint: "please enter vehicle standing point"
        },
        submitHandler: function (form) {
            $(':button[type="submit"]').html('<i class="fa fa-ban"></i> Please Wait...');
            $(':button[type="submit"]').attr('disabled', true);
                $.ajax({
                type: 'POST',
                url: site_url + "content/shipment_add",
                data: $("#shipmentForm").serialize(),
                success: function (data) {
                    //alert(data);
                    $('#shipmentForm').css({ display: "none" });
                    $('#SuccessMessage').html(data);
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
            }
        });
    });
    
    
    
});