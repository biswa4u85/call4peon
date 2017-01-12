jQuery(document).ready(function($){
   $('#category-form').validate({
     rules:{
       vCategory:"required",
       eStatus:"required"
     },  
     messages:{
         vCategory:"This field is mandatory",
         eStatus:"Please select your status"
     },validClass: function(element) {
            $('#' + $(element).attr('id') + 'div').removeClass('has-error');
            $('#' + $(element).attr('id') + 'div').addClass('has-success');
        },
        errorPlacement: function(error, element) {
            //  $('#'+$(element).attr('id')+'div').addClass('has-error');
            error.appendTo("#" + $(element).attr('id') + "Err");

        },
     	submitHandler: function(form) {

            if ($('#iCategoryId').val() == '') {
                $.ajax({
                    type: 'POST',
                    url: site_url + 'category/category/checkCategory',
                    data: {vCategory: $('#vCategory').val(), tablename: $(form).data('form')},
                    success: function(data) {console.log(data)
                        if (data == true) {
                            $('#vCategory').closest('.control-group').removeClass('success').addClass('error');
                            $("#vCategoryErr").html('<label for="vCategory" generated="true" class="error">Category already exists</label>');
                        } else {
                            form.submit();
                        }
                    }
                });
            } else {
                form.submit();
            }

        },
            highlight: function(element) {
                $(element).closest('.control-group').removeClass('success').addClass('error');
            },
            success: function(element) {
                element
                    .text('OK!').addClass('valid')
                    .closest('.control-group').removeClass('error').addClass('success');
            }
   });
});
//  
//    $("#vCategory").change(function() {
//        $("#iParentId").empty();
//        var newOption ='<option value="'+$("#vCategory").val()+'">'+$("#vCategory").val()+'<option />';
//        $("#iParentId").append(newOption);
//    }); 

//        validClass: function(element){
//            $('#' + $(element).attr('id') + 'div').removeClass('has-error');
//            $('#' + $(element).attr('id') + 'div').addClass('has-success');
//        },
//        errorPlacement: function(error,element){
//            error.appendTo("#" + $(element).attr('id') + "Err");
//        },