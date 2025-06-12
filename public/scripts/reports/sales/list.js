jQuery(function () {
  const body$ = jQuery("body.reports-sales-list");

  if (_.isEmpty(body$)) {
    console.error("body class sales-report-list not found");

    return;
  }

  const outletId$ = body$.find("select[name=outletId]");
  const customerId$ = body$.find("select[name=customerId]");
  const productId$ = body$.find("select[name=productId]");
  const duration$ = body$.find("#duration");
  const btnGetReport$ = body$.find("button.btn-get-report");
  const table$ = body$.find("table.sales-report-dt");
  let dateRangeInstance;

  initDateRangePicker();
  bindProductSelect2();
  bindCustomerSelect2();

  btnGetReport$.on("click", function () {
    dtInstance.draw();
  });

  const dtInstance = table$.DataTable({
    processing: true,
    serverSide: true,
    order: [],
    ajax: function (data, callback, settings) {
      const selectedDates = dateRangeInstance.getDates();
      const formattedDates = selectedDates.map((date) =>
        moment(date).format("YYYY-MM-DD")
      );
      data.outletId = outletId$.val();
      data.customerId = customerId$.val();
      data.productId = productId$.val();
      data.duration = formattedDates;
      jQuery.ajax({
        endpoint: "reports/sales/list", // Your CI4 controller endpoint
        method: "POST",
        data: data, // DataTables will send `draw`, `start`, `length`, etc.
        dataType: "json",
        success: function (response) {
          console.log(response)
          callback(response); // Pass the server response to DataTables
        },
        error: function (xhr, status, error) {
          console.error("DataTables AJAX error:", error);
        },
      });
    },
    columns: [
      {data:"invoice_no", title:"Invoice", orderable:false},
      {data:"invoice_date", title:"Date", orderable:false},
      {data:"product_name", title:"Product", orderable:false},
      {data:"unit", title:"Unit", orderable:false},
      {data:"quantity", title:"Quantity", orderable:false},
      {data:"price", title:"Price", orderable:false},
    ],
  
  });

  function initDateRangePicker() {
    const options = {
      format: "dd-mm-yyyy",
      autohide: true,
      multidate: true,
    };
    dateRangeInstance = new DateRangePicker(duration$[0], options);
    dateRangeInstance.setDates(new Date(), new Date());
  }

  function bindProductSelect2() {
    productId$.select2({
      placeholder: "Select a product",
      minimumInputLength: 3,
      theme: "bootstrap-5",
      allowClear: true,
      multiple: true,
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
  }

  function bindCustomerSelect2() {
    customerId$.select2({
      placeholder: "Select a customer",
      minimumInputLength: 3,
      theme: "bootstrap-5",
      allowClear: true,
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
              failure("Failed to fetch products");
            },
          });
        },
      },
    });
  }
});
