 $(document).ready(function(){ 		
    $('#modules-form').validate({
       rules: {
            'vModule': {
                required: true
            },
            'vURL': {
                required: true
            },
            'vMenuDisplay': {
                required: true
            }
        },
        messages: {
            'vModule': {
                required: 'Please enter a Feature name'
            },
            'vURL': {
                required: 'Please enter a URL'
            },
            'vMenuDisplay': {
                required: 'Please enter a Menu Display Title'
            }
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "vModule") {
                error.appendTo("#vModuleErr");
            }
            if (element.attr("name") == "vURL") {
                error.appendTo("#vURLErr");
            }  
			if (element.attr("name") == "vMenuDisplay") {
                error.appendTo("#vMenuDisplayErr");
            }
        }
    });
});