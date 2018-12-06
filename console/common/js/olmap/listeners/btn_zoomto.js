setListenersBtnZoomto = function() {
	$('.zoomtoButton').click(function(){
		$.ajax({
			url: '../map/getareaextent',
			type: 'post',
			data: {'id':$(this).attr('value')},
			success: function (response) {
				var coordinates = response.replace('BOX(','').replace(')','');
				var arrXY = coordinates.split(',');
				var arrX = arrXY[0].split(' ');
				var arrY= arrXY[1].split(' ');
				var ext = ol.extent.boundingExtent([[arrX[0]*1,arrX[1]*1],[arrY[0]*1,arrY[1]*1]]);
				ext = ol.proj.transformExtent(ext, ol.proj.get('EPSG:4326'), ol.proj.get('EPSG:3857'));
				console.log(map.getSize());
				if(map.getSize()[1] != 0) {
					map.getView().fit(ext,map.getSize());
				} else {
					map.getView().fit(ext,[1119, 155]);
				}
			}
		});
	});
};

$(window).ready(setListenersBtnZoomto);
$(document).on('ready pjax:success', setListenersBtnZoomto);
