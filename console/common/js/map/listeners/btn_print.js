// Create Function for add Listener to Zoom Print
setListenersBtnPrint = function() {
	$(".icon_print").click(function() {
		params.map = map;
		printTask.execute(params, function(url){
			$('#btnFormPrint').html('Print');
			$('#btnFormPrint').removeAttr('disabled');
			window.open(url['url'], '_blank');
		});
	});
	
	$('#btnFormPrint').click(function () {
		 var form = $('#printForm');
		 // return false if form still have some validation errors
		 if (form.find('.has-error').length) {
			  return false;
		 }
		 $('#btnFormPrint').attr('disabled','disabled');
		 $('#btnFormPrint').html('Submitting...');
		 // submit form
		 $.ajax({
			url: '../logprint/print',
			type: 'post',
			data: form.serialize(),
			success: function (response) {
				$('#btnFormPrint').html('Rendering...');
				params.map = map;
				if(response == 'success') {
					printTask.execute(params, function(url){
						$('#btnFormPrint').html('Print');
						$('#btnFormPrint').removeAttr('disabled');
						window.open(url['url'], '_blank');
					});
				}
			}
		 });
		 return false;
	});
}

$(window).ready(setListenersBtnPrint);