$(document).ready(function () {
    $('#chAllIsRead').click(function () {
        if (this.checked) {
            $('[id^=chisRead]').prop('checked', true);
        } else {
            $('[id^=chisRead]').prop('checked', false);
        }
    });
    $('#chAllIsWrite').click(function () {
        if (this.checked) {
            $('[id^=chisWrite]').prop('checked', true);
            $('[id^=chisRead]').prop('checked', true);
            $('#chAllIsRead').prop('checked', true);
        } else {
            $('[id^=chisWrite]').prop('checked', false);
            $('[id^=chisDelete]').prop('checked', false);
            $('#chAllIsDelete').prop('checked', false);
        }
    });
    $('#chAllIsDelete').click(function () {
        if (this.checked) {
            $('[id^=chisDelete]').prop('checked', true);
            $('[id^=chisRead]').prop('checked', true);
            $('[id^=chisWrite]').prop('checked', true);
            $('#chAllIsWrite').prop('checked', true);
            $('#chAllIsRead').prop('checked', true);
        } else {
            $('[id^=chisDelete]').prop('checked', false);
        }
    });

    $('.chkallread').click(function () {

        if (this.checked == true) {
            this.checked = true;
        } else {
            $(this).parents("tr").find(".chkallwrite").prop('checked', false);
            $(this).parents("tr").find(".chkalldelete").prop('checked', false);
        }
    });
    $('.chkallwrite').click(function () {

        if (this.checked == true) {
            this.checked = true;
            $(this).parents("tr").find(".chkallread").prop('checked', true);
        } else {
            $(this).parents("tr").find(".chkallread").prop('checked', true);
            $(this).parents("tr").find(".chkalldelete").prop('checked', false);
        }
    });
    $('.chkalldelete').click(function () {

        if (this.checked == true) {
            this.checked = true;
            $(this).parents("tr").find(".chkallread").prop('checked', true);
            $(this).parents("tr").find(".chkallwrite").prop('checked', true);
        } else {
            $(this).parents("tr").find(".chkallread").prop('checked', true);
            $(this).parents("tr").find(".chkallwrite").prop('checked', true);
        }
    });

    $("#vRole").keyup(function () {
        if (this.value != '') {
            $("#vRoleCode").val(this.value);
        } else {
            $("#vRoleCode").val('');
        }
    });

    var id = $("#iUserRoleId").val().trim();

    $("#permission_form").validate({
        rules: {
            vRole: "required",
            vRoleCode: {
                required: true,
                remote: {
                    url: admin_url + "roles/checkRoles?id=" + id,
                    type: "post"
                }
            }
        },
        messages: {
            vRole: "Please enter role",
            vRoleCode: {
                required: 'Please enter role code',
                remote: 'Role code already exists'
            }
        },
        submitHandler: function (form) {
            //ajaxformsubmit(form);
            $(':button[type="submit"]').html('<i class="fa fa-ban"></i> Please Wait...');
            $(':button[type="submit"]').attr('disabled', true);
            form.submit();
        },
        showErrors: function (map, list)
        {
            this.currentElements.parents('label:first, div:first').find('.require_field').remove();
            this.currentElements.parents('.form-group:first').removeClass('require_field');

            $.each(list, function (index, error)
            {
                var ee = $(error.element);
                var eep = ee.parents('label:first').length ? ee.parents('label:first') : ee.parents('div:first');
                console.log(ee)
                ee.parents('.form-group:first').addClass('require_field');
                eep.find('.require_field').remove();
                //eep.append('<p class="has-error help-block">' + error.message + '</p>');
                eep.append('<span class="require_field">' + error.message + '</span>');
            });
            //refreshScrollers();
        }
    });

});
