/* global Ext, ol, map, geometry, geometries */

setListenerBtnModal = function() {
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
		
		$('#modal').on('hide.bs.modal', function () {
			$.pjax.reload({container:'#pjax',timeout: false});
		})
		$('#modal').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
		$('#modalHeader').html('<h3> '+ $(this).attr('header') +'</h3>');
	});
}

setListenerPageLoad = function() {
	arrUrl = window.location.href.split("#");
	if(arrUrl[1] !== undefined && arrUrl[1] != '') {
		$('#modal').modal('show')
			.find('#modalContent')
			.load(arrUrl[1], function () {
				$('#modalHeader').html('<h3> '+ arrUrl[2] +'</h3>');
			});
	}
}

$(window).ready(setListenerBtnModal);

$(document).on('ready pjax:success', setListenerBtnModalPjax);

$(document).ready(setListenerPageLoad);