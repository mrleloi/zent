$.datetimepicker.setLocale("ja");

const adminDatepicker = function(name) {
  $(name).datetimepicker({
    timepicker: false,
    format: "Y-m-d"
  });
};
