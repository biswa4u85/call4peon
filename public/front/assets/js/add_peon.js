$(document).ready(function () {
    $("#userForm").validate({
        rules: {
            firstName: "required",
            lastName: "required",
            contactNo: {
                required: true,
                number: true
            },
            vehicleId: {
                min: 1
            },
            address: {
                required: true,
            },
            area: {
                required: true,
            },
            dlimg: "required",
        },
        messages: {
            firstName: "Please enter first name",
            lastName: "Please enter last name",
            contactNo: {
                required: "Please enter Contact No",
                number: "Please enter number only"
            },
            vehicleId: {
                min: "Please select vehicle"
            },
            address:"Please enter address",
            area:"Please enter area"
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
            $(e).closest('.form-group').removeClass('has-error').addClass('has-error');
            $(e).closest('.help-block').remove();
        },
        success: function (element) {
            element.text('').addClass('valid').closest('.control-group').removeClass('error').addClass('success');
            $(element).closest('.form-group').removeClass('has-error');
        }
    });
});