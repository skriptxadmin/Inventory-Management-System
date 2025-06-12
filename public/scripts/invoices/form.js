jQuery(function () {
  const body$ = jQuery("body.invoices-form");

  if (_.isEmpty(body$)) {
    console.error("body class invoices-form not found");
    return;
  }

  const form$ = body$.find("form.invoice");
  if (_.isEmpty(form$)) {
    console.error("form.invoice not found");
  }
  const fieldset$ = form$.find("fieldset");

  const invoiceId = form$.data("invoice-id");
  const outletId$ = form$.find("select#outlet_id");
  const customerId$ = form$.find("select#customer_id");
  const invoiceNo$ = form$.find("input[name=invoiceNo]");
  const invoiceDate$ = form$.find("input[name=invoiceDate]");
  const description$ = form$.find("textarea[name=description]");
  const invoiceFormTbody$ = body$.find("#invoiceFormTbody").html();
  const table$ = body$.find("table.invoice");
  const tbodyLineItems$ = table$.find("tbody.line-items");
  const tbodySummary$ = table$.find("tbody.summary");
  let invoiceDateInstance;

  addRow(1);
  bindCustomerSelect2();
  initDatepicker();
  if (invoiceId) {
    jQuery.ajax({
      endpoint: "invoices/" + invoiceId,
      success: function (res) {
        if(res.outlet_id){
          outletId$.val(res.outlet_id);
        }
        if (res.customer_id && res.customer_name) {
          let option = new Option(res.customer_name, res.customer_id, true, true);
          customerId$.append(option).trigger("change");
        }
        if (res.invoice_no) {
          invoiceNo$.val(res.invoice_no);
        }
        if (invoiceDateInstance && res.invoice_date) {
          const date = moment(res.invoice_date, "YYYY-MM-DD").format(
            "DD-MM-YYYY"
          );
          invoiceDateInstance.setDate(date);
        }
        if (res.items.length) {
          tbodyLineItems$.empty();
          addRow(res.items.length);
          res.items.forEach(function (item, index) {
            const tr$ = tbodyLineItems$.find(`tr:eq(${index})`);
            tr$.find("input[name=quantity]").val(item.quantity);
            tr$.find("input[name=price]").val(item.price);
            tr$.find("td.unit").text(item.unit);
            const product$ = tr$.find("select[name=product]");
            let option = new Option(
              item.product_name,
              item.product_id,
              true,
              true
            );
            product$.append(option).trigger("change");
          });
        }
        tbodySummary$.find("input[name=taxes]").val(res.taxes);
        tbodySummary$.find("input[name=discount]").val(res.discount);
        tbodySummary$.find("input[name=paid]").val(res.paid);
        description$.val(res.description);
        calculateTotals();
      },
    });
  }

  tbodyLineItems$.on("blur", "input[name=price]", function () {
    const isLast = jQuery(this)
      .closest("tr")
      .is(tbodyLineItems$.find("tr").last());
    const select$ = jQuery(this).closest("tr").find("select[name=product]");
    if (isLast && select$.val()) {
      addRow(1);
    }
  });

  table$.on("blur", "input", function () {
    calculateTotals();
  });

  tbodyLineItems$.on("click", ".remove-row", function () {
    const tr$ = jQuery(this).closest("tr");
    Swal.fire({
      title: "Are you sure?",
      text: `Do you want to remove row? You won't be able to revert this!`,
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!",
    }).then((result) => {
      if (result.isConfirmed) {
        tr$.remove();
        numberRows();
      }
    });
  });

  function initDatepicker() {
    const options = {
      format: "dd-mm-yyyy",
      autohide: true,
    };
    invoiceDateInstance = new Datepicker(invoiceDate$[0], options);
  }

  function addRow(count) {
    for (let i = 0; i < count; i++) {
      tbodyLineItems$.append(_.template(invoiceFormTbody$));
    }
    checkProductSelect2();
    numberRows();
  }

  function checkProductSelect2() {
    tbodyLineItems$.find("tr").each(function () {
      const product$ = jQuery(this).find("select[name=product]");
      if (!product$.data("select2")) {
        bindProductSelect2(product$);
      }
    });
  }
  function numberRows() {
    tbodyLineItems$.find("tr").each(function (i) {
      jQuery(this)
        .find("td:eq(0)")
        .text(i + 1);
    });
  }

  function bindCustomerSelect2() {
    customerId$.select2({
      placeholder: "Select a customer",
      minimumInputLength: 3,
      theme: "bootstrap-5",
      ajax: {
        transport: function (params, success, failure) {
          jQuery.ajax({
            endpoint: "customers/select2",
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
              failure("Failed to fetch customers");
            },
          });
        },
      },
    });
  }

  function bindProductSelect2(element$) {
    element$.select2({
      placeholder: "Select a product",
      minimumInputLength: 3,
      theme: "bootstrap-5",
      allowClear: true,
      ajax: {
        transport: function (params, success, failure) {
          jQuery.ajax({
            endpoint: "products/select2",
            method: "POST",
            data: {
              q: params.data.term,
            },
            success: function (data) {
              const formatted = data.map((item) => ({
                id: item.id,
                text: item.product_name,
                uom: item.uom_name,
              }));
              success({ results: formatted });
            },
            error: function (xhr) {
              failure("Failed to fetch products");
            },
          });
        },
      },
    });
    element$.on("select2:select", function (e) {
      const { data } = e.params;
      element$.closest("tr").find("td.unit").text(data.uom);
      calculateTotals();
    });
  }

  function calculateTotals() {
    let subtotal = 0;
    tbodyLineItems$.find("tr").each(function (i, tr$) {
      const price = getCellValue(tr$, "price");
      const quantity = getCellValue(tr$, "quantity");
      const total$ = jQuery(this).find("td.row-total");
      const rowTotal = parseFloat(price * quantity);
      total$.text(rowTotal.toFixed(2));
      subtotal = subtotal + rowTotal;
    });
    const taxes = getCellValue(tbodySummary$, "taxes");
    const discount = getCellValue(tbodySummary$, "discount");
    const paid = getCellValue(tbodySummary$, "paid");
    const total = subtotal + taxes - discount;
    const balance = total - paid;
    tbodySummary$.find(".subtotal").text(subtotal.toFixed(2));
    tbodySummary$.find(".total").text(total.toFixed(2));
    tbodySummary$.find(".balance").text(balance.toFixed(2));
  }

  form$.validate({
    rules: {
       outlet_id: {
        required: true,
      },
      customer_id: {
        required: true,
      },
      invoiceNo: {
        required: true,
      },
      invoiceDate: {
        required: true,
      },
    },
    submitHandler: function (form, event) {
      event.preventDefault();
      let data = {
        id: invoiceId,
        outlet_id: outletId$.val(),
        customer_id: customerId$.val(),
        items: [],
        subtotal: 0,
        taxes: 0,
        discount: 0,
        total: 0,
        invoice_no: invoiceNo$.val(),
        invoice_date: moment(invoiceDate$.val(), "DD-MM-YYYY").format(
          "YYYY-MM-DD"
        ),
        description: description$.val(),
      };
      let subtotal = 0;
      tbodyLineItems$.find("tr").each(function (i, tr$) {
        const price = getCellValue(tr$, "price");
        const quantity = getCellValue(tr$, "quantity");
        const product = getCellValue(tr$, "product");
        const rowTotal = parseFloat(price * quantity);
        if (product) {
          data.items.push({
            product_id: product,
            price: price,
            quantity: quantity,
          });
          subtotal = subtotal + rowTotal;
        }
      });
      data.taxes = getCellValue(tbodySummary$, "taxes");
      data.discount = getCellValue(tbodySummary$, "discount");
      data.paid = getCellValue(tbodySummary$, "paid");
      data.subtotal = subtotal;
      data.total = data.subtotal + data.taxes - data.discount;
      data.balance = data.total - data.paid;
      if (_.isEmpty(data.items)) {
        Swal.fire({
          title: "Error!",
          text: "No items in line",
          icon: "error",
        });
        return;
      }
      fieldset$.prop("disabled", true);
      jQuery.ajax({
        endpoint: "invoices",
        method: "POST",
        data: data,
        success: function (res) {
          Swal.fire({
            title: "Success",
            text: "Stored in database",
            icon: "success",
          });
          window.location.href = window.app.baseurl + "invoices";
        },
        complete: function () {
          fieldset$.prop("disabled", false);
        },
      });
    },
  });

  function getCellValue(element$, identifier) {
    const val = jQuery(element$).find(`[name=${identifier}]`).val();
    return val && !isNaN(val) && parseFloat(val) ? parseFloat(val) : 0;
  }
});
