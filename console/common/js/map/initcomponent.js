initComponent = function() {
	$('.ui-button').click(function(){
		if ($(this).hasClass('selected')) {
			$(this).removeClass('selected');
			
			if ($(this).hasClass('toolbarPanelController')) {
				var index = $(this).index('.toolbarPanelController');
				$('.toolbarPanel').eq(index).hide();
			}
			
			$('#drawingHelp').hide();
			if(!hasMapIdentifyListener) {
				mapIdentifyListener = map.on("click", executeIdentifyTask);
				hasMapIdentifyListener = true;
			}
		} else {
			if ($(this).hasClass('subToggleButton') || $(this).hasClass('icon_draw_clear')) {
				$('.subToggleButton').removeClass('selected');
			} else {
				$('.ui-button').removeClass('selected');
				$('#drawingHelp').hide();
			}
			if ($(this).hasClass('toggleButton')) {
				$(this).addClass('selected');
			}
			
			if($(this).hasClass('icon_measurement') || $(this).hasClass('icon_draw')) {
				if(hasMapIdentifyListener) {
					mapIdentifyListener.remove();
					hasMapIdentifyListener = false;
				}
			} 
			
			if ($(this).hasClass('toolbarPanelController')) {
				var index = $(this).index('.toolbarPanelController');
				$('.toolbarPanel').hide();
				$('.toolbarPanel').eq(index).show();
			}
		}
	});
	
	$('#collapseButton').click(function() {
		if($('#collapseButton:visible').length) {
			$('#collapseButton').hide();
			$('#southPanel').animate({
				bottom: "-259px"
			}, 400, function() {
				$('#expandButton').removeClass('hidden');
				$('#expandButton').show();
			});
			$('#map').animate({
				height: "+=259px"
			}, 400);
		}
	});
	$('#expandButton, #w0 a').click(function() {
		if($('#expandButton:visible').length) {
			$('#expandButton').hide();
			$('#southPanel').animate({
				bottom: "0px"
			}, 400, function() {
				$('#collapseButton').removeClass('hidden');
				$('#collapseButton').show();
			});
			$('#map').animate({
				height: "-=259px"
			}, 400);
		}
	});
	
};

resetMapPanel = function() {
	if($('#collapseButton').is(":visible")) {
		$('#collapseButton').hide();
		$('#southPanel').animate({
			bottom: "-259px"
		}, 400, function() {
			$('#expandButton').removeClass('hidden');
			$('#expandButton').show();
		});
		$('#map').animate({
			height: "+=259px"
		}, 400);
	}
	
	console.log('b');
	$('.ui-button').removeClass('selected');
	$('.toolbarPanel').hide();
	console.log('a');
	$('#drawingHelp').hide();
	if(!hasMapIdentifyListener) {
		mapIdentifyListener = map.on("click", executeIdentifyTask);
		hasMapIdentifyListener = true;
	}
	
}

$(window).ready(initComponent);