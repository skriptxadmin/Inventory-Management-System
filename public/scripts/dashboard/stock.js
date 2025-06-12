jQuery(function () {
  const body$ = jQuery("body.dashboard");

  if (_.isEmpty(body$)) {
    console.error("body class dashboard not found");

    return;
  }

  const getStocksBtn$ = jQuery("button.get-stocks");
  const stockQtyForm$ = jQuery("form.stock-qty");
  const stockQty$ = stockQtyForm$.find('input');
  const table$ = body$.find("table.dashboard-stock-dt");

  const dtInstance = table$.DataTable({
    processing: true,
    serverSide: true,
    order: [],
    ajax: function (data, callback, settings) {
      const val = stockQty$.val();
      const value =
        val && !isNaN(val) && parseFloat(val) ? parseFloat(val) : 10;
      stockQty$.val(value);
      data.balance = value;
      jQuery.ajax({
        endpoint: "dashboard/stock", // Your CI4 controller endpoint
        method: "POST",
        data: data, // DataTables will send `draw`, `start`, `length`, etc.
        dataType: "json",
        success: function (response) {
          callback(response); // Pass the server response to DataTables
        },
        error: function (xhr, status, error) {
          console.error("DataTables AJAX error:", error);
        },
      });
    },
    columns: [
      {
        data: "name",
        title: "Name",
      },
      {
        data: "unit",
        title: "Unit",
      },
      {
        data: "balance",
        title: "Balance",
      },
    ],
   
  });
  stockQtyForm$.on("submit", function (event) {
    event.preventDefault();
    dtInstance.draw();
  });
});
