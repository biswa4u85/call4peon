$(document).ready(function () {
    $("#ModuleForm").validate({
        rules: {
            vModule: "required",
            iSequenceOrder: "required",
            vMenuDisplay: "required",
            vImage: "required",            
            vURL:{ 
                required:true
            },
            DisplayAsMenu: "required",
            DisplayAsSubMenu: "required",
            vMainMenuCode: "required"
        },
        messages: {
            vModule: "Please enter Module Name",
            iSequenceOrder: "Please enter SequenceOrder",
            vMenuDisplay: "Please enter MenuDisplay",
            vImage: "Please Please enter Image Name",            
            vURL: {
                required:"Please select account owner"
            },
            DisplayAsMenu: "Please select account owner",
            DisplayAsSubMenu: "Please select account owner",
            vMainMenuCode: "Please enter MenuCode"
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

});
