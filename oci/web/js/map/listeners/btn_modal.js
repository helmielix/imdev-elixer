/* global Ext, ol, map, geometry, geometries */

setListenerBtnModal = function() {
	$('#createCAModal').click(function(){
		$('#CAModal').modal('show')
			.find('#CAModalContent')
			.load($(this).attr('value'));
		$('#CAModalHeader').html('<h3> Create Potential CA</h3>');
	});
	
	$('#uploadsurveyCAModal').click(function(){
		$('#CAModal').modal('show')
			.find('#CAModalContent')
			.load($(this).attr('value'));
		$('#CAModalHeader').html('<h3> Upload Batch Survey </h3>');
	});
};

setListenerBtnModalPjax = function() {
	$('.CAViewButton').click(function(){
		$('#CAModal').modal('show')
			.find('#CAModalContent')
			.load($(this).attr('value'));
		$('#CAModalHeader').html('<h3> Detail Potential CA</h3>');
	});
	$('.CAVerifikasiButton').click(function(){
		$('#CAModal').modal('show')
			.find('#CAModalContent')
			.load($(this).attr('value'));
		$('#CAModalHeader').html('<h3> Verifikasi Potential CA</h3>');
	});
	$('.CAApproveButton').click(function(){
		$('#CAModal').modal('show')
			.find('#CAModalContent')
			.load($(this).attr('value'));
		$('#CAModalHeader').html('<h3> Approve Potential CA</h3>');
	});
}

$(window).ready(setListenerBtnModal);

$(document).on('ready pjax:success', setListenerBtnModalPjax);