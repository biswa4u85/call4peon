$(document).ready(function () {
    $("#locationForm").validate({
        rules: {
            address: "required",
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
                min: 1
            },
            landmark: "required",
            pincode: {
//                required: true,
                number: true,
                maxlength: 6,
            },
        },
        messages: {
            country: {
                min: "Please select country"
            },
            state: {
                min: "Please select state"
            },
            city: {
                min: "Please select city"
            },
            area: {
                min: "Please select area"
            },
            landmark: {
                required: "Please enter landmark"
            },
            address: {
                required: "Please enter address"
            },
            pincode: {
                required: "Please select pincode"
            },
        },
        submitHandler: function (form) {
            $(':button[type="submit"]').html('<i class="fa fa-ban"></i> Please Wait...');
            $(':button[type="submit"]').attr('disabled', true);
            form.submit();
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
        }
    });

    $('#country').on('change', function () {
        var country = $('#country').val();
        $.ajax({
            type: 'POST',
            url: site_url + "area/getStateData",
            data: {Id: country, tablename: "states"},
            success: function (data) {
                var json = jQuery.parseJSON(data);
                $('#state').empty();
                $('#city').empty();
                $('#state').append("<option value='0'>Select State</option>");
                $('#city').append("<option value='0'>Select City</option>");
                for (var i = 0; i < json.length; i++) {
                    var isSelected = (json[i]["iStateId"] == iStateId) ? "selected" : "";
                    $('#state').append("<option value=" + json[i]["iStateId"] + " " + isSelected + "> " + json[i]["vStateName"] + "</option>");
                }
                if (iStateId > 0) {
                    iStateId = 0;
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
                $('#area').empty();
                $('#city').append("<option value='0'>Select City</option>");
                $('#area').append("<option value='0'>Select Area</option>");
                for (var i = 0; i < json.length; i++) {
                    var isSelected = (json[i]["iCityId"] == iCityId) ? "selected" : "";
                    $('#city').append("<option value=" + json[i]["iCityId"] + " " + isSelected + " > " + json[i]["vCityName"] + "</option>");
                }

                if (iCityId > 0) {
                    iCityId = 0;
                    $('#city').trigger('change');
                }

                $('.selectpicker').selectpicker();
            }
        });
    });
    $('#city').on('change', function () {
        var country = $('#country').val();
        var state = $('#state').val();
        var city = $('#city').val();
        $.ajax({
            type: 'POST',
            url: site_url + "area/getAreaData",
            data: {Id: country, state_id: state, city_id: city, tablename: "area"},
            success: function (data) {
                var json = jQuery.parseJSON(data);console.log(iAreaId);
                $('#area').empty();
                $('#area').append("<option value='0'>Select Area</option>");
                for (var i = 0; i < json.length; i++) {
                    var isSelected = (json[i]["iAreaId"] == iAreaId) ? "selected" : "";
                    $('#area').append("<option value=" + json[i]["iAreaId"] + " " + isSelected + " > " + json[i]["vAreaName"] + "</option>");
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
        $("#area").select2({
            placeholder: "Select City",
            allowClear: true,
            width: '100%'
        });
    }
});
