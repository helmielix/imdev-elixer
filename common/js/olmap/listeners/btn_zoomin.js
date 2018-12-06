setListenersBtnZoomin = function() {
	$('.icon_zoomin').click(function(){
		map.getView().setZoom(map.getView().getZoom() + 1)
	});
};

$(window).ready(setListenersBtnZoomin);
