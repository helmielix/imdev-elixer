setListenersBtnFeaturesinfo = function() {
	var totalDivLength = 0;
	var container = document.getElementById('popup');
	var closer = document.getElementById('popup-closer');
	overlay = new ol.Overlay(/** @type {olx.OverlayOptions} */ ({
		element: container,
		autoPan: true,
		autoPanAnimation: {
			duration: 250
		}
	}));
	map.addOverlay(overlay);
	closer.onclick = function() {
        overlay.setPosition(undefined);
        closer.blur();
        return false;
	};
	
	function setFunctionFeaturesInfo(evt) {
		$.ajax({
			url: '/frontend/web/map/get-features-by-coordinates',
			method: 'GET',
			dataType: 'json',
			contentType: "application/json",
			data: { x: evt.coordinate[0], y:evt.coordinate[1], resolution:map.getView().getResolution()  },
			success: function(result) { 
				var datas = JSON.parse(result);
				$('#popup-content').html('');
				for (var i=0; i< datas.length; i++) {
					if(datas[i][0] == 'area') {
						$('#popup-content').append(
							'<div class="popup-content-div">' +
								'<table>' +
									'<tr><td>ID Area&nbsp;</td><td width="8"> : </td><td>'+datas[i][1].id_area+'</td></tr>' +
									'<tr><td>Region&nbsp;</td><td> : </td><td>'+datas[i][1].region+'</td></tr>' +
									'<tr><td>City&nbsp;</td><td> : </td><td>'+datas[i][1].city+'</td></tr>' +
									'<tr><td>District&nbsp;</td><td> : </td><td>'+datas[i][1].district+'</td></tr>' +
									'<tr><td>Subdistrict&nbsp;</td><td> : </td><td>'+datas[i][1].subdistrict+'</td></tr>' +
									'<tr><td>RW&nbsp;</td><td> : </td><td>'+datas[i][1].id_area.slice(-2)+'</td></tr>' +
									'<tr><td>Total HP Potential&nbsp;</td><td> : </td><td>'+datas[i][1].homepass+'</td></tr>' +
									'<tr><td>Status IOM Rollout&nbsp;</td><td> : </td><td>'+datas[i][1].status_iom+'</td></tr>' +
								'</table>' +
							'</div>'
						);
					} 
					else if(datas[i][0] == 'olt_built') {
						$('#popup-content').append(
							'<div class="popup-content-div">' +
								'<table>' +
									'<tr><td>ID OLT&nbsp;</td><td width="8"> : </td><td>'+datas[i][1].id_olt+'</td></tr>' +
								'</table>' +
							'</div>'
						);
					}
					else if(datas[i][0] == 'olt_plan') {
						$('#popup-content').append(
							'<div class="popup-content-div">' +
								'<table>' +
									'<tr><td>ID OLT&nbsp;</td><td width="8"> : </td><td>'+datas[i][1].id_olt+'</td></tr>' +
								'</table>' +
							'</div>'
						);
					}
					else if(datas[i][0] == 'odc_built') {
						$('#popup-content').append(
							'<div class="popup-content-div">' +
								'<table>' +
									'<tr><td>ID ODC&nbsp;</td><td width="8"> : </td><td>'+datas[i][1].id_odc+'</td></tr>' +
								'</table>' +
							'</div>'
						);
					}
					else if(datas[i][0] == 'odc_plan') {
						$('#popup-content').append(
							'<div class="popup-content-div">' +
								'<table>' +
									'<tr><td>ID ODC&nbsp;</td><td width="8"> : </td><td>'+datas[i][1].id_odc+'</td></tr>' +
								'</table>' +
							'</div>'
						);
					}
					else if(datas[i][0] == 'odp_built') {
						$('#popup-content').append(
							'<div class="popup-content-div">' +
								'<table>' +
									'<tr><td>ID ODP&nbsp;</td><td width="8"> : </td><td>'+datas[i][1].id_odp+'</td></tr>' +
								'</table>' +
							'</div>'
						);
					}
					else if(datas[i][0] == 'odp_plan') {
						$('#popup-content').append(
							'<div class="popup-content-div">' +
								'<table>' +
									'<tr><td>ID ODP&nbsp;</td><td width="8"> : </td><td>'+datas[i][1].id_odp+'</td></tr>' +
								'</table>' +
							'</div>'
						);
					}
					else if(datas[i][0] == 'pole_built') {
						$('#popup-content').append(
							'<div class="popup-content-div">' +
								'<table>' +
									'<tr><td>ID Pole&nbsp;</td><td width="8"> : </td><td>'+datas[i][1].id_pole+'</td></tr>' +
								'</table>' +
							'</div>'
						);
					}
					else if(datas[i][0] == 'pole_built') {
						$('#popup-content').append(
							'<div class="popup-content-div">' +
								'<table>' +
									'<tr><td>ID Pole&nbsp;</td><td width="8"> : </td><td>'+datas[i][1].id_pole+'</td></tr>' +
								'</table>' +
							'</div>'
						);
					}
					else if(datas[i][0] == 'pole_history') {
						$('#popup-content').append(
							'<div class="popup-content-div">' +
								'<table>' +
									'<tr><td>Name&nbsp;</td><td width="8"> : </td><td>'+datas[i][1].id+'</td></tr>' +
									'<tr><td>Area ID&nbsp;</td><td> : </td><td>'+datas[i][1].id_area+'</td></tr>' +
									'<tr><td>Map ID&nbsp;</td><td> : </td><td>'+datas[i][1].id_map+'</td></tr>' +
									/*
									'<tr><td>Owner Type&nbsp;</td><td> : </td><td>'+datas[i][1].owner_type+'</td></tr>' +
									'<tr><td>Location C&nbsp;</td><td> : </td><td>'+datas[i][1].location_c+'</td></tr>' +
									'<tr><td>Address&nbsp;</td><td> : </td><td>'+datas[i][1].address+'</td></tr>' +
									'<tr><td>Kelurahan&nbsp;</td><td> : </td><td>'+datas[i][1].kelurahan+'</td></tr>' +
									'<tr><td>Kecamatan&nbsp;</td><td> : </td><td>'+datas[i][1].kecamatan+'</td></tr>' +
									'<tr><td>Region&nbsp;</td><td> : </td><td>'+datas[i][1].region+'</td></tr>' +
									'<tr><td>Kota&nbsp;</td><td> : </td><td>'+datas[i][1].kota+'</td></tr>' +
									*/
									'<tr><td>Longitude&nbsp;</td><td> : </td><td>'+datas[i][1].longitude+'</td></tr>' +
									'<tr><td>Lattitude&nbsp;</td><td> : </td><td>'+datas[i][1].latitude+'</td></tr>' +
									'<tr><td>Quantity Pole&nbsp;</td><td> : </td><td>'+datas[i][1].qty_pole+'</td></tr>' +
									'<tr><td>Pole Type&nbsp;</td><td> : </td><td>'+datas[i][1].pole_type+'</td></tr>' +
									'<tr><td>Pole Status&nbsp;</td><td> : </td><td>'+datas[i][1].pole_status+'</td></tr>' +
									'<tr><td>Pole Owner&nbsp;</td><td> : </td><td>'+datas[i][1].pole_owner+'</td></tr>' +
									'<tr><td>Cable Status&nbsp;</td><td> : </td><td>'+datas[i][1].cable_status+'</td></tr>' +
									'<tr><td>Cable Type&nbsp;</td><td> : </td><td>'+datas[i][1].cable_type+'</td></tr>' +
									'<tr><td>Cable Length&nbsp;</td><td> : </td><td>'+datas[i][1].cable_length+'</td></tr>' +
									'<tr><td>ODC Status&nbsp;</td><td> : </td><td>'+datas[i][1].odc_status+'</td></tr>' +
									'<tr><td>ODC Quantity&nbsp;</td><td> : </td><td>'+datas[i][1].odc_qty+'</td></tr>' +
									'<tr><td>FAT Status&nbsp;</td><td> : </td><td>'+datas[i][1].fat_status+'</td></tr>' +
									'<tr><td>FAT Quantity&nbsp;</td><td> : </td><td>'+datas[i][1].fat_qty+'</td></tr>' +
									'<tr><td>IKR&nbsp;</td><td> : </td><td>'+datas[i][1].ikr+'</td></tr>' +
									'<tr><td>Klem Anchor&nbsp;</td><td> : </td><td>'+datas[i][1].clamp_anchor_bracket+'</td></tr>' +
									'<tr><td>Dead End&nbsp;</td><td> : </td><td>'+datas[i][1].dead_end_bracket+'</td></tr>' +
									'<tr><td>Sling Bracket&nbsp;</td><td> : </td><td>'+datas[i][1].sling_bracket+'</td></tr>' +
									'<tr><td>Suspension&nbsp;</td><td> : </td><td>'+datas[i][1].suspension+'</td></tr>' +
									'<tr><td>Slack Support&nbsp;</td><td> : </td><td>'+datas[i][1].slack_support+'</ttd></tr>' +
									'<tr><td>Steel Band&nbsp;</td><td> : </td><td>'+datas[i][1].steel_band+'</td></tr>' +
									'<tr><td>Bekel Stop&nbsp;</td><td> : </td><td>'+datas[i][1].buckle_stop_link+'</td></tr>' +
									'<tr><td>Pole Strap&nbsp;</td><td> : </td><td>'+datas[i][1].pole_strap+'</td></tr>' +
									'<tr><td>Klem Ring&nbsp;</td><td> : </td><td>'+datas[i][1].clamp_ring+'</td></tr>' +
									'<tr><td>Remark&nbsp;</td><td> : </td><td>'+datas[i][1].remark+'</td></tr>' +
									'<tr><td>Date Input&nbsp;</td><td> : </td><td>'+datas[i][1].date_input+'</td></tr>' +
								'</table>' +
							'</div>'
						);
					}
				}
				totalDivLength = $('#popup-content div').length;
				if($('#popup-content div').length > 0) {
					$('#popup-pagination').html('1 dari '+totalDivLength);
					$('.popup-content-div').eq(0).show();
					if($('#popup-content div').length > 1) {
						$('#popup-next').show();
						
					}
				} else {
					$('#popup-pagination').html('1 dari '+totalDivLength);
					$('#popup-content').append('<div> Tidak ada data pada area yang dipilih</div>');
				}
				overlay.setPosition(evt.coordinate);
			},
			error: function(result) { alert("Terjadi masalah pada request."); },
		});
		
	}
	
	$('.icon_info').click(function(){	
		if($(this).hasClass('selected')) {
			map.addOverlay(overlay);
			content = document.getElementById('popup-content');
			map.unByKey(btnListener);
			btnListener = map.on('singleclick', setFunctionFeaturesInfo);
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

$(window).ready(setListenersBtnFeaturesinfo);
