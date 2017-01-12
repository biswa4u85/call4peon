jQuery(document).ready(function ($) {
    $('#forgot_password').validate({
        rules: {
            'login_email': {
                required: true,
                email: true
            }
        },
        messages: {
            'login_email': {
                required: 'Please enter a email address'
            }
        },
        showErrors: function (map, list)
        {
            this.currentElements.parents('label:first, div:first').find('.has-error').remove();
            this.currentElements.parents('.form-group:first').removeClass('has-error');

            $.each(list, function (index, error)
            {
                var ee = $(error.element);
                var eep = ee.parents('label:first').length ? ee.parents('label:first') : ee.parents('div:first');

                ee.parents('.form-group:first').addClass('has-error');
                eep.find('.has-error').remove();
                eep.append('<p class="has-error help-block">' + error.message + '</p>');
            });
        }, submitHandler: function (form) {
            form.submit();
        }
    });
});