jQuery(function(){

      const body$ = jQuery("body.outlets-list");

    if(_.isEmpty(body$)){

        console.error("body class outlets-list not found");

        return;
    }
    const table$ = body$.find("table.outlets-dt");

    const form$ = body$.find("form.outlet");

     table$.on('click', '.btn-edit', function(){
        const row = JSON.parse(jQuery(this).closest('tr').attr('data-row'));
        form$.find("[name=id]").val(row.id);
        form$.find("[name=name]").val(row.name);
        form$.find("[name=description]").val(row.description);
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
                description: form$.find("[name=description]").val(),
            }
            form$.find('fieldset').prop('disabled', true);
            jQuery.ajax({
                endpoint: "outlets",
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