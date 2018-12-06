setListenersBtnZoomtoextent = function() {
	$('.icon_zoomtoextent').click(function(){
		map.getView().setZoom(9);
		map.getView().setCenter([11894377, -692885]);
	});
};

$(window).ready(setListenersBtnZoomtoextent);
