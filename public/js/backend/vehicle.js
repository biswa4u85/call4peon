$(document).ready(function () {
    $("#vehicleForm").validate({
        rules: {
            user: {
                required: true,
                min: 1
            },
            type: "required",
            number: "required",
            standingPoint: "required"
        },
        messages: {
            user: {
                required: "Please select user",
                min: "Please select User"
            },
            type: "Please enter vehicle type",
            number: "Please enter vehicle number",
            standingPoint: "please enter vehicle standing point"
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
            $(e).closest('.help-block').remove();
        },
        success: function (element) {
            element.text('').addClass('valid').closest('.control-group').removeClass('error').addClass('success');
        }
    });
});
function delete_file(obj)
{
    var file = $(obj).data('bind');
    if (confirm('Are you sure want to delete?')) {
        $.ajax({
            type: 'POST',
            url: rootPath + 'vehicle/deleteImage',
            data: {file: file},
            success: function (data) {
                location.reload();
            }
        });
    }
}
