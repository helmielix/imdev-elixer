constructDatePicker = function() {
	$( "#datepicker" ).datepicker({autoclose: true});
    $( "#datepicker2" ).datepicker({autoclose: true});
    $( "#datepicker3" ).datepicker({autoclose: true});
	$( "#datepicker4" ).datepicker({autoclose: true});
};

setTimeout(constructDatePicker,100);