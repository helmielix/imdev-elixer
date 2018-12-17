/* global Ext, ol, map, geometry, geometries */

isConstructedCAModal = false;

setListenersBtnInfo = function() {
	$('#btn_info').click(function(){
		if (!isConstructedCAModal) {
			console.log($("#createCAModal"));
			$("#createCAModal").modal('show')
				.find('#createCAModalContent')
				.load($(this).attr('value'))
				.on('hide', function() {
					$('#createCAModal').modal('hide');
				});
			//isConstructedCAModal = true;
		} else {
			if ($(this).hasClass('selected')) {
				$("#createCAModal").show();
			} else {
				$("#createCAModal").hide();
			}
		};
	});
	
};

$(window).ready(setListenersBtnInfo);