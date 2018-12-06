// Create Function for add Listener to Zoom In Button
function setListenersInputcoordinatesAppend() {
	$(".inputcoordinatesContainer .longitude:last").focusin(function(){
		$(".inputcoordinatesContainer")
			.append('<input class="tf_toolbar longitude" placeholder="longitude" > </input>' +
					'<input class="tf_toolbar latitude" placeholder="latitude" > </input>'
		);
		$(this).off();
		setListenersInputcoordinatesAppend();
		setListenersInputcoordinatesApprove();
	});
}

function setListenersInputcoordinatesApprove() {
	$(".inputcoordinatesContainer .latitude:last").focusout(function(){
		approveInputcoordinates();
	});
	$(".inputcoordinatesContainer .latitude:last").keypress(function (e) {
		var key = e.which;
		if(key == 13)  
		{
			approveInputcoordinates();
		}
	});
}

function approveInputcoordinates() {
	var polygonArray = []; 
	$(".inputcoordinatesContainer .longitude").each(function(index){
		var longitude = $(this).val()*1;
		var latitude = $(".inputcoordinatesContainer .latitude:eq("+index+")").val()*1;
		if (!isNaN(longitude) && !isNaN(latitude) && longitude != '' && latitude != '') {
			polygonArray.push([longitude,latitude]);
		}
	})
	polygonArray.push(polygonArray[0]);
	if(polygonArray.length > 3) {
		setInputcoordinatesPolygon(polygonArray);
	}
}

$(window).ready(setListenersInputcoordinatesAppend());
$(window).ready(setListenersInputcoordinatesApprove());