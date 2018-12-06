/* global Ext, ol, map, geometry, geometries */

setListenerBtnModal = function() {
	$('#modal').on('hide.bs.modal', function (e) {
		window.location.href = "#";
		$.pjax.reload({container:'#pjax',timeout: false});
		
		if ($('#cancelButton').length){
			e.stopImmediatePropagation();
			$( '#submitButton' ).trigger( 'click' );
			$( '#submitButton' ).off( 'click' );
		}
	})
	$('#createModal').click(function(){
		$('#modal').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
		$('#modalHeader').html('<h3> '+ $(this).attr('header') +'</h3>');


	});

	$('#uploadModal').click(function(){
		$('#modal').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
		$('#modalHeader').html('<h3> '+ $(this).attr('header') +'</h3>');
	});
};

setListenerBtnModalPjax = function() {
	$('.viewButton').click(function(){
		$('#modal').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
		$('#modalHeader').html('<h3> '+ $(this).attr('header') +'</h3>');
	});
}

setListenerPageLoad = function() {
	arrUrl = window.location.href.split("#");
	if(arrUrl[1] !== undefined && arrUrl[1] != '') {
		$header = arrUrl[1].split("header=");
		$('#modal').modal('show')
			.find('#modalContent')
			.load(arrUrl[1], function () {
				$('#modalHeader').html('<h3> '+ $header[1].replace(/_/g,' ') +'</h3>');
			});
	}
}

modalOnLoad = function(){
	$('#modal').find('#modalContent')
	.html('<div class="text-center"><i id="spinRefreshLoad" class="fa fa-spin fa-refresh" style="font-size:  50px;"></i></div>');
}

$.ajaxSetup({
	timeout: 30000 //Time in milliseconds
});	


$(window).ready(setListenerBtnModal);

$(document).on('ready pjax:success', setListenerBtnModalPjax);

$(document).ready(setListenerPageLoad);

$(document).ready(function(){
	$('#modal').on('hidden.bs.modal', function () {
		modalOnLoad();
	});	
	
	$('#modal').removeAttr('tabindex');
});

$(function(){
    $(document).ajaxError(function(event, xhr, settings) {
        console.log('Ajax error '+ xhr.status +', please try again.');
		if (xhr == 'timeout'){
			// alert('There is no response from server, please try again.');
		}
		if (xhr.status == 0 && $('#spinRefresh').length) {
			// alert('Connection is lost, please try again.');
		}
		$('#spinRefresh').parent().delay( 800 ).prop('disabled', false);
		$('#spinRefresh').remove();
    });
});
