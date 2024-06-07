jQuery(document).ready(function($){
    // console.log("ready")
    $('#post-form').submit(function(e){
        // console.log("submit")
        e.preventDefault();
        // console.log("first")

        let form = $(this);
        let formData = form.serialize();

        $.ajax({
            type: 'POST',
            url: dashboardToDevAjax.ajaxurl,
            data: formData + '&action=dashboard_submit',
            dataType: 'json',
            success: function(response){
                if(response.success){
                    alert("form submitted successfully");
                    form.trigger("reset");

                } else {
                    alert("error " + response.errors.join(', '));
                }
            },
            error: function(xhr, status, error){
                console.log("ajax request failed: " + status + ', ' + error);
            }
        });

    });
    
});

