
// When the browser is ready...

$(function() {

    // Setup form validation on the #register-form element
    $("#admin-form").validate({
        // Specify the validation rules
        rules: {
            vLocation:"required",
            vTitle: "required",
            vPageTitle: "required",
            vFile: "required",
            vSEOTitle: "required",
            vSEOKeyword: "required",
            vSEODescription: "required",
            vPageContent: "required",
            vPageName: "required",
            vBLocation: "required",
            vBannerFile: "required",
            vBannerTitle: "required",
            vBannerDescription: "required",
            vBannerSubtitle: "required",
            vBannerLink: "required",
            vFeatureURL: "required",
            vFeatureName: "required",
            iBannerOrderId:"required",
            vContactNo: {
                required: true,
                minlength: 5
            },
            iRoleId: "required",
            iUtypeId: "required",
            eStatus: "required",
            
            vEmail: {
                required: true,
                email: true
            },
            vPassword: {
                required: true,
                minlength: 5
            },
            vPassword2: {
                required: true,
                minlength: 5,
                equalTo: "#vPassword"
            }
        },
        // Specify the validation error messages
        messages: {
            vLocation:"Please enter Location",
             vTitle: "Please enter Title",
            vPageTitle: "Please enter Page Title",
            vFile: "Please Select a file",
            vSEOTitle: "Please enter SEO Title",
            vSEOKeyword: "Please enter SEO Keyword",
            vSEODescription: "Please enter Description",
            vPageContent: "Please enter Page Content",
            vPageName: "Please enter Page Name",
            vBLocation: "Please enter Location",
            vBannerFile: "Please Select File",
            vBannerTitle: "Please enter Title",
            vBannerSubtitle: "Please enter SubTitle",
            vBannerDescription: "Please enter Description",
            vBannerLink: "Please enter Link",
            iBannerOrderId: "Please Enter Order Id",
            vFeatureURL: "Please enter URL",
            vFeatureName: "Please enter Feature Name",
           
            vContactNo: {
                required: "Please enter contact no",
                minlength: "Please enter atleast 10 numbers"
            },
            iRoleId: "Please select Role",
            iUtypeId: "Please select User Type",
            eStatus: "Please select status",
            vEmail: "Please enter a valid email address",
            vPassword: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long"
            },
             vPassword2: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long",
                equalTo: "Please enter same password to confirm"
            }
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

