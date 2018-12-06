setListenersBtnFeaturessummary = function() {
	var totalDivLength = 0;
	var container = document.getElementById('popup');
	var closer = document.getElementById('popup-closer');
	closer.onclick = function() {
        overlay.setPosition(undefined);
        closer.blur();
        return false;
	};
	
	function setFunctionFeaturesSummary(evt) {
		$.ajax({
			url: '/foro/frontend/web/map/get-summary-by-coordinates',
			method: 'GET',
			dataType: 'json',
			contentType: "application/json",
			data: { x: evt.coordinate[0], y:evt.coordinate[1], resolution:map.getView().getResolution()  },
			success: function(result) { 
				var datas = JSON.parse(result);
				$('#popup-content').html('');
				$('#popup-content').append(
					'<div class="popup-content-div">' +
						'<table>' +
							'<tr><td>Jumlah Tiang&nbsp;</td><td width="8"> : </td><td>'+datas[0][1]+'</td></tr>' +
							'<tr><td>Jumlah ODP&nbsp;</td><td> : </td><td>'+datas[1][1]+'</td></tr>' +
							'<tr><td>Jumlah ODC&nbsp;</td><td> : </td><td>'+datas[2][1]+'</td></tr>' +
							'<tr><td>Jumlah Pelanggan&nbsp;</td><td> : </td><td></td></tr>' +
						'</table>' +
					'</div>'
				);
				
				totalDivLength = $('#popup-content div').length;
				$('#popup-pagination').html('1 dari '+totalDivLength);
				if($('#popup-content div').length > 0) {
					$('.popup-content-div').eq(0).show();
					if($('#popup-content div').length > 1) {
						$('#popup-next').show();
						
					}
				} else {
					$('#popup-content').append('<div> Tidak ada data pada area yang dipilih</div>');
				}
				overlay.setPosition(evt.coordinate);
			},
			error: function(result) { alert("Terjadi masalah pada request."); },
		});
		
	}
	
	$('.icon_summary').click(function(){	
		if($(this).hasClass('selected')) {
			map.addOverlay(overlay);
			content = document.getElementById('popup-content');
			map.unByKey(btnListener);
			btnListener = map.on('singleclick', setFunctionFeaturesSummary);
		} 
	});
	
	$('#popup-next').click(function(){
		var currentIndex = $('.popup-content-div:visible').index('.popup-content-div');
		$('#popup-content div').hide();
		$('#popup-content div').eq(currentIndex + 1).show();
		if(currentIndex + 2 == totalDivLength)
			$(this).hide();
		$('#popup-prev').show();
		$('#popup-pagination').html((currentIndex+2)+' dari '+totalDivLength);
	});
	$('#popup-prev').click(function(){
		var currentIndex = $('.popup-content-div:visible').index('.popup-content-div');
		$('#popup-content div').hide();
		$('#popup-content div').eq(currentIndex - 1).show();
		if(currentIndex == 1)
			$(this).hide();
		$('#popup-next').show();
		$('#popup-pagination').html((currentIndex)+' dari '+totalDivLength);
	});
};

$(window).ready(setListenersBtnFeaturessummary);
