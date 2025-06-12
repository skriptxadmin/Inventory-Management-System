jQuery(function(){

    const form$ = jQuery("form.login");

    if(_.isEmpty(form$)){

        return;
    }

    form$.validate({
        rules: {
            username: {
                required: true
            },
            password: {
                required: true,
            }
        },
        submitHandler: function(form, event){
            event.preventDefault();
            const data =  {
                username: form$.find("[name=username]").val(),
                password: form$.find("[name=password]").val(),
            }
            form$.find('fieldset').prop('disabled', true);
            jQuery.ajax({
                endpoint: "login",
                method:"POST",
                data:data,
                success: function(res){
                    
                },
                error: function(err){
                    form$.find('fieldset').prop('disabled', false);
                },
                complete: function(){
                    
                }
            })
        }
    })

})