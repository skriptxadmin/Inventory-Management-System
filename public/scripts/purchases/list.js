jQuery(function () {
  const body$ = jQuery("body.purchases-list");

  if (_.isEmpty(body$)) {
    console.error("body class purchases-list not found");

    return;
  }

  const table$ = body$.find("table.purchases-dt");

  const dtInstance = table$.DataTable({
    processing: true,
    serverSide: true,
    order: [],
    ajax: function (data, callback, settings) {
      jQuery.ajax({
        endpoint: "purchases/list", // Your CI4 controller endpoint
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
      { data: "purchase_no", title: "Num" },
      { data: "purchase_date", title: "Date" },
      { data: "vendor_name", title: "Vendor" },
      { data: "subtotal", title: "Sub Total" },
      { data: "taxes", title: "Taxes" },
      { data: "discount", title: "Discount" },
      { data: "total", title: "Total" },
           { data: "paid", title: "Paid" },
      { data: "balance", title: "Balance" },
      {
        data: "",
        title: "Action",
        width: "120px",
        orderable: false,
        render: function (data, type, row) {
          let html = `<a class="btn btn-sm btn-edit text-warning" href="${window.app.baseurl}purchases/form/${row.id}">${window.app.svgs.edit}</a>`;
          html += `<button class="btn btn-sm btn-delete text-danger">${window.app.svgs.trash}</button>`;
          return html;
        },
      },
    ],
    rowCallback: function (row, data, index) {
      // Assuming your data object has an 'id' property
      jQuery(row).attr("data-row", JSON.stringify(data));
    },
  });

  table$.on("redraw", function () {
    dtInstance.draw();
  });

  table$.on("click", ".btn-delete", function () {
    const row = JSON.parse(jQuery(this).closest("tr").attr("data-row"));
    Swal.fire({
      title: "Are you sure?",
      text: `Do you want to remove ${row.purchase_no} purchase? You won't be able to revert this!`,
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!",
    }).then((result) => {
      if (result.isConfirmed) {
        removePurchase(row);
      }
    });
  });

  function removePurchase(role) {
    jQuery.ajax({
      endpoint: "purchases/" + role.id,
      method: "DELETE",
      success: function (res) {
        Swal.fire({
          title: "Deleted!",
          text: "Purchase has been deleted.",
          icon: "success",
        });
        table$.trigger("redraw");
      },
      error: function (err) {},
      complete: function () {},
    });
  }
});
