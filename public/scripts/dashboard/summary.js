jQuery(function () {
  const body$ = jQuery("body.dashboard");

  if (_.isEmpty(body$)) {
    console.error("body class dashboard not found");

    return;
  }


  const duration$ = body$.find("#duration");
  let dateRangeInstance;
  initDateRangePicker();


  function getDashboardSummary(){
    const [start, end] = dateRangeInstance.getDates();
    const data = {
      start: moment(start).format("YYYY-MM-DD"),
      end: moment(end).format("YYYY-MM-DD"),
    };
    jQuery.ajax({
        endpoint:"dashboard/summary",
        method:"POST",
        data:data,
        success:function(res){
            body$.find("[data-field]").each(function(){
              jQuery(this).text(_.get(res, jQuery(this).attr('data-field')));
            })
        }
    })
  }

  duration$.on("changeDate", function (event) {
    getDashboardSummary();
  });

  function initDateRangePicker() {
    const options = {
      format: "dd-mm-yyyy",
      autohide: true,
      multidate: true,
    };
    dateRangeInstance = new DateRangePicker(duration$[0], options);
    dateRangeInstance.setDates(
      moment().subtract(1, "week").toDate(),
      moment().toDate()
    );
    getDashboardSummary();
  }

});
