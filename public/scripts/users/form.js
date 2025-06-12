jQuery(function(){

      const body$ = jQuery("body.users-list");

    if(_.isEmpty(body$)){

        console.error("body class users-list not found");

        return;
    }
    const table$ = body$.find("table.users-dt");

    const form$ = body$.find("form.user");
     table$.on('click', '.btn-edit', function(){
        const row = JSON.parse(jQuery(this).closest('tr').attr('data-row'));
        form$.find("[name=id]").val(row.id);
        form$.find("[name=fullname]").val(row.fullname);
        form$.find("[name=email]").val(row.email);
        form$.find("[name=mobile]").val(row.mobile);
        form$.find("[name=password]").val(row.password);
        form$.find("[name=role_id]").val(row.role_id);
    })

   form$.validate({
        rules: {
            fullname: {
                required: true
            },
            email: {
                required: true
            },
            mobile: {
                required: true
            },
            password: {
                required: false
            },
            role_id: {
                required: true
            }
        },
        submitHandler: function(form, event){
            event.preventDefault();
            const data =  {
                id: form$.find("[name=id]").val(),
                fullname: form$.find("[name=fullname]").val(),
                email: form$.find("[name=email]").val(),
                mobile: form$.find("[name=mobile]").val(),
                password: form$.find("[name=password]").val(),
                role_id: form$.find("[name=role_id]").val(),
            }
            form$.find('fieldset').prop('disabled', true);
            jQuery.ajax({
                endpoint: "users",
                method:"POST",
                data:data,
                success: function(res){
                    table$.trigger('redraw');
                    form$.find("[name=id]").val('');
                    form$[0].reset();
                    
                },
                error: function(err){
                },
                complete: function(){
                    form$.find('fieldset').prop('disabled', false);
                    
                }
            })
        }
    })
})