jQuery(function () {
  const body$ = jQuery("body.stocks-list");

  if (_.isEmpty(body$)) {
    console.error("body class stocks-list not found");

    return;
  }

  const table$ = body$.find("table.stocks-dt");
  const btnStockCalculate$ = body$.find("button.btn-stock-calculate");

  btnStockCalculate$.on('click', function(){
    btnStockCalculate$.prop('disabled', true);
    jQuery.ajax({
      endpoint:"stocks/calculate",
      success:function(){

    // table$.trigger('redraw');

      },
      complete:function(){
    btnStockCalculate$.prop('disabled', false);

      }
    })
  })

  const dtInstance = table$.DataTable({
    processing: true,
    serverSide: true,
    order: [],
    ajax: function (data, callback, settings) {
      jQuery.ajax({
        endpoint: "stocks/list", // Your CI4 controller endpoint
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
      { data: "id", title: "ID", width: "80px", orderable: false },
      { data: "name", title: "Name"      },
      { data:"uom_name",title:"Unit"},
      { data:"purchased", title:"Purchased"},
      { data:"invoiced", title:"Invoiced"},
      { data:"balance", title:"Balance"}
      
    ],
    rowCallback: function (row, data, index) {
      // Assuming your data object has an 'id' property
      jQuery(row).attr("data-row", JSON.stringify(data));
    },
  });

  table$.on("redraw", function () {
    dtInstance.draw();
  });
});
