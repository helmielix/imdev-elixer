// Create Function for add Listener to Zoom To Extent Button
setListenersBtnZoomtoxy = function() {
	function gotoXy() {
		var longitude = $('#tf_longitude').val();
		var latitude = $('#tf_latitude').val()
		if (longitude <= 180 && longitude >= -180 && latitude <= 180 && latitude >= -180 && longitude != "" && latitude != "") {
			map.centerAndZoom([longitude,latitude], 9); 
		} else {
			alert ('mohon masukan angka koordinat geografis yang sesuai');
		}
	}
	$(".icon_gotoxy").click(function() {
		gotoXy();
	});
	
	$("#tf_latitude").keypress(function (e) {
		var key = e.which;
		if(key == 13)  
		{
			gotoXy();
		}
	});
}

$(window).ready(setListenersBtnZoomtoxy);