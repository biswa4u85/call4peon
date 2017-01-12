$(document).ready(function () {

    $("#AreaForm").validate({
        rules: {
            country_id:{required:true},
            area_name: "required"
        },
        messages: {
            country_id: {required :"Please select country"},
            area_name: "Please enter area name"
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
            $(e).closest('.help-block').remove();
        },
        success: function (element) {
            element.text('').addClass('valid').closest('.control-group').removeClass('error').addClass('success');
        }
    });

    $('#country_id').on('change', function () {
        var country = $('#country_id').val();
        //alert(site_url);
        $.ajax({
            type: 'POST',
            url: site_url + "area/getStateData",
            data: {Id: country, tablename: "states"},
            success: function (data) {
                //alert(data);
                var json = jQuery.parseJSON(data);
                // console.log(json);
                $('#state_id').empty();
                for (var i = 0; i < json.length; i++) {
                    $('#state_id').append("<option value=" + json[i]["iStateId"] + " > " + json[i]["vStateName"] + "</option>");
                }
                $('.selectpicker').selectpicker();
            }
        });
    });
    
    $('#state_id').on('change', function () {
        var country = $('#country_id').val();
        var state = $('#state_id').val();
        //alert(site_url);
        $.ajax({
            type: 'POST',
            url: site_url + "area/getCityData",
            data: {Id: country,state_id: state, tablename: "city"},
            success: function (data) {
                //alert(data);
                var json = jQuery.parseJSON(data);
                // console.log(json);
                $('#city_id').empty();
                for (var i = 0; i < json.length; i++) {
                    $('#city_id').append("<option value=" + json[i]["iCityId"] + " > " + json[i]["vCityName"] + "</option>");
                }
                $('.selectpicker').selectpicker();
            }
        });
    });

    if (typeof $.fn.select2 != 'undefined')
    {
        // Placeholders                
        $("#country_id").select2({
            placeholder: "Select Country",
            allowClear: true,
            width: '100%'
        });
        $("#state_id").select2({
            placeholder: "Select State",
            allowClear: true,
            width: '100%'
        });
        $("#city_id").select2({
            placeholder: "Select City",
            allowClear: true,
            width: '100%'
        });
    }
});
