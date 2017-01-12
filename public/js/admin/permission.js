$(document).ready(function(){ 
    if($('[id^=chisRead]').length == $('[id^=chisRead]:checked').length){
        $('#chAllIsRead').attr('checked','checked');
    }
    if($('[id^=chisWrite]').length == $('[id^=chisWrite]:checked').length){
        $('#chAllIsWrite').attr('checked','checked');
    }
    if($('[id^=chisDelete]').length == $('[id^=chisDelete]:checked').length){
        $('#chAllIsDelete').attr('checked','checked');
    }
    $('#chAllIsRead').click(function(){
        if(this.checked){
            $('[id^=chisRead]').attr('checked','checked');
        }else{
            $('[id^=chisRead]').removeAttr('checked');
        }
    });
    $('#chAllIsWrite').click(function(){
        if(this.checked){
            $('[id^=chisWrite]').attr('checked','checked');
        }else{
            $('[id^=chisWrite]').removeAttr('checked');
        }
    });
    $('#chAllIsDelete').click(function(){
        if(this.checked){
            $('[id^=chisDelete]').attr('checked','checked');
        }else{
            $('[id^=chisDelete]').removeAttr('checked');
        }
    });
    
    $("#vRole").keyup(function() {
        if (this.value != '') {
            $("#vRoleCode").val(this.value);
        } else {
            $("#vRoleCode").val('');
        }
    });
        
    $('#permission_form').validate({
       rules: {
            'vRole': {
                required: true
            },
            'vRoleCode': {
                required: true
            }
        },
        messages: {
            'vRole': {
                required: 'Please enter a Role Name'
            },
            'vRoleCode': {
                required: 'Please enter a Role Code'
            }
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "vRole") {
                error.appendTo("#vRoleErr");
            }
            if (element.attr("name") == "vRoleCode") {
                error.appendTo("#vRoleCodeErr");
            }           
        }, submitHandler: function(form) {           
                if ($('#mode').val() == 'add') {
                $.ajax({
                    type: 'POST',
                    url: admin_url+"roles/checkRoles",
                    data: {vRoleCode: $('#vRoleCode').val()},
                    success: function(data) { //alert(data);
                        if (data == false) { 
                            $("#vRoleCodeErr").addClass('error');
                             $("#vRoleCodeErr").html('<label class="error">Role code already exists.</label>');

                            //$("#vRoleCodeErr").text('Username already exists');
                        } else {
                            form.submit();
                        }
                    }
                });
            } else {
                form.submit();
            }
        }
    });
});
