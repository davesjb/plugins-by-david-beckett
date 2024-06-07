jQuery(document).ready(function($){
    $('#shortcode-form-plugin').submit(function(e){
        e.preventDefault();
        let emailElement = $("#email");
        let email = emailElement.val();
        let pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if(!pattern.test(email)){
            alert('please enter valid email');
            return;
        }
        
        let phoneElement = $("#phone");
        let phone = phoneElement.val();
        if (phone.length !== 10) {
            alert("phone no must be under 10 digits");
            return;
        }

        



        // $('#phone').on('input', function(){
        //     let phone = $(this).val();
 
        // });

        // alert("form submit");
        let form = $(this);
        let formData = form.serialize();

        $.ajax({
            type: 'POST',
            url: shortcodeFormPluginAjax.ajaxurl,
            data: formData + '&action=shortcode_form_plugin_submit',
            dataType: 'json',
            success: function(response){
                // console.log(response);
                if(response.success){
                    alert("form submitted successfully");
                    form.trigger("reset");
                } else {
                    alert("error: " + response.errors.join(', '))
                }
            },
            error: function(xhr, status, error){
                console.error("ajax request failed: " + status + ', ' + error);
            }
        });
    });
});