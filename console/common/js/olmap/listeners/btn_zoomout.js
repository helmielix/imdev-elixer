setListenersBtnZoomout = function() {
	$('.icon_zoomout').click(function(){
		map.getView().setZoom(map.getView().getZoom() - 1)
	});
};

$(window).ready(setListenersBtnZoomout);
