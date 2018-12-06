// Create Function for add Listener to Zoom To Extent Button
setListenersBtnZoomtoextent = function() {
	$(".icon_zoomtoextent").click(function() {
		map.centerAndZoom([116,-0.7893], 5);
	});
}

$(window).ready(setListenersBtnZoomtoextent);