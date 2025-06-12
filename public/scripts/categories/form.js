jQuery(function () {
  const body$ = jQuery("body.categories-list");

  if (_.isEmpty(body$)) {
    console.error("body class categories-list not found");

    return;
  }
  const table$ = body$.find("table.categories-dt");

  const form$ = body$.find("form.category");

  const parent$ = form$.find("select#parent");

  table$.on("click", ".btn-edit", function () {
    const row = JSON.parse(jQuery(this).closest("tr").attr("data-row"));
    form$.find("[name=id]").val(row.id);
    form$.find("[name=name]").val(row.name);
    if (row.parent) {
      let option = new Option(row.parent.name, row.parent.id, true, true);
      parent$.append(option).trigger("change");
    }
  });

  parent$.select2({
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
    },
    submitHandler: function (form, event) {
      event.preventDefault();
      const data = {
        id: form$.find("[name=id]").val(),
        parent_id: parent$.val(),
        name: form$.find("[name=name]").val(),
      };
      form$.find("fieldset").prop("disabled", true);
      jQuery.ajax({
        endpoint: "categories",
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
