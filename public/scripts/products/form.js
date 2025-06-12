jQuery(function () {
  const body$ = jQuery("body.products-list");

  if (_.isEmpty(body$)) {
    console.error("body class products-list not found");

    return;
  }
  const table$ = body$.find("table.products-dt");

  const form$ = body$.find("form.product");

  const category$ = form$.find("select#category");
  const uom$ = form$.find("select#uom");

  table$.on("click", ".btn-edit", function () {
    const row = JSON.parse(jQuery(this).closest("tr").attr("data-row"));
    form$.find("[name=id]").val(row.id);
    form$.find("[name=name]").val(row.name);
    if (row.category) {
      let option = new Option(row.category.name, row.category.id, true, true);
      category$.append(option).trigger("change");
    }
    if (row.uom) {
      uom$.val(row.uom.id);
    }
    form$.find("[name=description]").val(row.description);
  });

  category$.select2({
    placeholder: "Select a category",
    minimumInputLength: 3,
    theme: "bootstrap-5",
    ajax: {
      transport: function (params, success, failure) {
        jQuery.ajax({
          endpoint: "categories/select2",
          method: "POST",
          data: {
            q: params.data.term,
          },
          success: function (data) {
            const formatted = data.map((item) => ({
              id: item.id,
              text: item.name,
            }));
            success({ results: formatted });
          },
          error: function (xhr) {
            failure("Failed to fetch categories");
          },
        });
      },
    },
  });

  form$.validate({
    rules: {
      name: {
        required: true,
      },
      description:{
        required: true
      },
      category:{
        required: true,
      },
      uom:{
        required:true
      }
    },
    submitHandler: function (form, event) {
      event.preventDefault();
      const data = {
        id: form$.find("[name=id]").val(),
        category_id: category$.val(),
        uom_id: uom$.val(),
        name: form$.find("[name=name]").val(),
        description: form$.find("[name=description]").val(),
      };
      form$.find("fieldset").prop("disabled", true);
      jQuery.ajax({
        endpoint: "products",
        method: "POST",
        data: data,
        success: function (res) {
          table$.trigger("redraw");
          form$.find("[name=id]").val("");
          form$[0].reset();
        },
        error: function (err) {},
        complete: function () {
          form$.find("fieldset").prop("disabled", false);
        },
      });
    },
  });
});
