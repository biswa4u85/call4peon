$(document).ready(function () {
    $("#pageForm").validate({
        rules: {
            pagetitle: "required",
            pagecode: "required",
            tContent: "required",
            eType: "required"
        },
        messages: {
            pagetitle: "Please enter Page Title",
            pagecode: "Please enter Page Code",
            tContent: "Please enter Content",
            eType: "Please select Page Type"
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
    
    if ($('input[name=eType]:checked').val() == 'Page') {
        $(".show-guide").hide();
    } else {
        $(".show-page").hide();
    }
    
    $( "input[name=eType]" ).click(function() {
        $( ".show-guide" ).toggle( "hide");
        $( ".show-page" ).toggle( "show");
  });

});