jQuery(function(){

      const body$ = jQuery("body.unit-of-measures-list");

    if(_.isEmpty(body$)){

        console.error("body class unit-of-measures-list not found");

        return;
    }
    const table$ = body$.find("table.unit-of-measures-dt");

    const form$ = body$.find("form.unit-of-measure");

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
                endpoint: "unit-of-measures",
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