jQuery(function($){   

    $('#menu-form').validate({
        rules:{
            vTitle:"required",
            eStatus:"required"
        },
        messages:{
            vTitle : "Please enter valid value.",
            eStatus : "Please select the Status"
        },
        validClass: function(element) {
            $('#' + $(element).attr('id') + 'div').removeClass('has-error');
            $('#' + $(element).attr('id') + 'div').addClass('has-success');
        },
        errorPlacement: function(error, element) {
            error.appendTo("#" + $(element).attr('id') + "Err");
        },
       submitHandler: function(form) {
            form.submit();
        }
  });

});
