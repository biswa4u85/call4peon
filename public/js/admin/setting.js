
// When the browser is ready...

$(function() {

    // Setup form validation on the #register-form element
    $("#admin-form").validate({
        // Specify the validation rules
        rules: {
           
            vName: "required",
            vCountry: "required",
            vCountryCode: "required",
            eStatus: "required",
            vDescription: "required"
           
        },
        // Specify the validation error messages
        messages: {
            
            vName: "Please enter Name",
            vCountry: "Please enter Country name",
             vCountryCode: "Please enter country code",
            eStatus: "Please select Status",
            vDescription: "Please enter Description"
        },
        validClass: function(element){
                            $('#'+$(element).attr('id')+'div').removeClass('has-error');
                            $('#'+$(element).attr('id')+'div').addClass('has-success');
        },
        errorPlacement: function(error, element) {
          //  $('#'+$(element).attr('id')+'div').addClass('has-error');
            error.appendTo("#" + $(element).attr('id') + "Err");
        },
     
        submitHandler: function(form) {
            form.submit();
        }
    });
    
 });




function changerole(obj) {

    $.ajax({
        type: "POST",
        url: "admin/chnge_role_admin",
        data: {
            iAdminId: $("#" + obj.id).data('admin'),
            iRoleId: obj.value
        },
        success: function(result) {
            location.reload(true);
        }
    });

}

