
// When the browser is ready...

$(function() {

    // Setup form validation on the #register-form element
    $("#admin-form").validate({
        // Specify the validation rules
        rules: {
            vName: "required",
            vFirstname: "required",
            vLastname: "required",
            vFirstName: "required",
            vLastName: "required",
            vMiddleName: "required",
            vUserName: "required",
            vAddress1: "required",
            vAddress2: "required",
            vCity: "required",
            vState: "required",
            iCountryId: "required",
            vAlterAdd1: "required",
            vAlterAdd2: "required",
            vAlterCity: "required",
            vAlterState: "required",
            iAlterCountryId: "required",
            vZipcode: "required",
            dBirthday: "required",
            vContactHome: "required",
            vContactWork: "required",
            vContactMob: "required",
            vContactOther: "required",
            vContactPhone: "required",
            vFileName: "required",
            vTitle: "required",
            vDescription: "required",
            vSaluation: "required",
            vType: "required",
            vContactNo: {
                required: true,
                minlength: 10
            },
            vContactNo1: {
                required: true,
                minlength: 10
            },
            vContactNo2: {
                required: true,
                minlength: 10
            },
            vFaxNo:  "required",
            iRoleId: "required",
            iUtypeId: "required",
            eStatus: "required",
            vDateRange: "required",
            vEmail: {
                required: true,
                email: true
            },
             vContactEmail: {
                required: true,
                email: true
            },
            tUrl: {
                required: true,
                url: true
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
            vName: "Please enter Name",
            vFirstname: "Please enter First Name",
            vLastname: "Please enter Last Name",
            vFirstName: "Please enter First Name",
            vLastName: "Please enter Last Name",
            vMiddleName: "Please enter Middle Name",
            vUserName: "Please enter Username",
            vAddress1: "Please enter Address1",
            vAddress2: "Please enter Address2",
            vCity: "Please enter City",
            vState: "Please enter State",
            iCountryId: "Please select Country",
            vZipcode: "Please enter Zipcode",
            vAlterAdd1: "Please enter Alternate Address",
            vAlterAdd2: "Please enter Alternate Address",
            vAlterCity: "Please enter Alternate City",
            vAlterState: "Please enter Alternate State",
            iAlterCountryId: "Please select Alternate Country",
            dBirthday: "Please select Birthdate",
            vContactHome: "Please enter Contact Home No",
            vContactWork: "Please enter Contact Work No",
            vContactMob: "Please enter Contact Mobile No",
            vContactOther: "Please enter Contact Other No",
            vContactPhone: "Please enter Contact No",
            vFileName: "Please select Document to upload",
            vTitle: "Please enter Document Title",
            vDescription: "Please enter Document Description",
            vSaluation: "Please enter Saluation",
            vType:"Please enter Type",
            vContactNo: {
                required: "Please enter Contact No",
                minlength: "Please enter atleast 10 digits"
            },
            vContactNo1: {
                required: "Please enter contact no",
                minlength: "Please enter atleast 10 digits"
            },
            vContactNo2: {
                required: "Please enter contact no",
                minlength: "Please enter atleast 10 digits"
            },
            vFaxNo: "Please enter Fax no",
            iRoleId: "Please select Role",
            iUtypeId: "Please select User Type",
            eStatus: "Please select status",
            vDateRange: "Please Select daterange",
             vEmail: {
                required: "Please enter Email address",
                email: "Please enter a valid email address"
            },
            vContactEmail: {
                required: "Please enter Email address",
                email: "Please enter a valid email address"
            },
            tUrl: {
                 required: "Please enter website Url",
                url: "Please enter valid Website Url"
            },            
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




function alternatechk(obj) {
    if (obj.checked) {
        $('.alteradd').attr('disabled',true);
        $('.alteradd').attr('readonly',true);
        $('#vAlterAdd1').val($('#vAddress1').val());
        $('#vAlterAdd2').val($('#vAddress2').val());
         $('#vAlterCity').val($('#vCity').val());
        $('#vAlterState').val($('#vState').val());
        //$('#iAlterCountryId').val($('#iCountryId').val());
        var value1=$('#iCountryId').val();
        $("#iAlterCountryId").val(value1);
             
    }else{
         $('.alteradd').attr('disabled',false);
        $('.alteradd').attr('readonly',false);
         $('#vAlterAdd1').val('');
        $('#vAlterAdd2').val('');
         $('#vAlterCity').val('');
        $('#vAlterState').val('');
        $('#iAlterCountryId').val('');
        
    }

}

