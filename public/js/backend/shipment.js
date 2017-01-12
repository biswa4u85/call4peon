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
//            pickupArea: "required",
//            pickupLandmark: "required",
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
//            dropupArea: "required",
//            dropupLandmark: "required",
//            'shipImages[]':{
//                accept:"image/*",
//                maxLength:5
//            }
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

    $('#prefferedDate').val($.datepicker.formatDate('dd-M-yy', new Date()))



});
function delete_file(obj)
{
    var file = $(obj).data('bind');
    if (confirm('Are you sure want to delete?')) {
        $.ajax({
            type: 'POST',
            url: rootPath + 'shipment/deleteImage',
            data: {file: file},
            success: function (data) {
                location.reload();
            }
        });
    }
}
