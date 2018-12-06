// Create Function for add Listener to Zoom Out Button
setListenersBtnZoomout = function() {
	$(".icon_zoomout").click(function() {
		var level = map.getZoom();
		if(level > 0) {
			level--;
			map.setZoom(level);
		}
	});
}

$(window).ready(setListenersBtnZoomout);