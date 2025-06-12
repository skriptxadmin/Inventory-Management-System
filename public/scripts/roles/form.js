jQuery(function(){

      const body$ = jQuery("body.roles-list");

    if(_.isEmpty(body$)){

        console.error("body class roles-list not found");

        return;
    }
    const table$ = body$.find("table.roles-dt");

    const form$ = body$.find("form.role");

     table$.on('click', '.btn-edit', function(){
        const row = JSON.parse(jQuery(this).closest('tr').attr('data-row'));
        form$.find("[name=id]").val(row.id);
        form$.find("[name=name]").val(row.name);
    })

   form$.validate({
        rules: {
            name: {
                required: true
            }
        },
        submitHandler: function(form, event){
            event.preventDefault();
            const data =  {
                id: form$.find("[name=id]").val(),
                name: form$.find("[name=name]").val(),
            }
            form$.find('fieldset').prop('disabled', true);
            jQuery.ajax({
                endpoint: "roles",
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