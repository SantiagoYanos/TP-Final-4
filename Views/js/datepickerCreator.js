function crearDatepicker(id, dates, startDate) {
  $("#" + id).datepicker({
    multidate: true,
    format: "yyyy-mm-dd",
    startDate: startDate,
  });

  if (dates && dates != "") {
    $("#" + id).datepicker("setDates", dates);
  }
}
