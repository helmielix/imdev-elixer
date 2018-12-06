// Create Function for add Listener to Zoom In Button
setListenersBtnZoomin = function() {
	$(".icon_zoomin").click(function() {
		var level = map.getZoom();
		if(level < 19) {
			level++;
			map.setZoom(level);
		}
	});
}

$(window).ready(setListenersBtnZoomin);