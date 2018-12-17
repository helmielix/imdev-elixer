initComponent = function() {
	$('.ui-button').click(function(){
		if ($(this).hasClass('selected')) {
			$(this).removeClass('selected');
			if ($(this).hasClass('toolbarPanelController')) {
				var index = $(this).index('.toolbarPanelController');
				$('.toolbarPanel').eq(index).hide();
			}
		} else {
			$('.ui-button').removeClass('selected');
			
			if ($(this).hasClass('toggleButton')) {
				$(this).addClass('selected');
			}
			
			if ($(this).hasClass('toolbarPanelController')) {
				var index = $(this).index('.toolbarPanelController');
				$('.toolbarPanel').hide();
				$('.toolbarPanel').eq(index).show();
			}
		}
	});
	
	$('.toolbarPanelButton').click(function(){
		if ($(this).hasClass('selected')) {
			$(this).removeClass('selected');
			if($(this).hasClass('basemapButton')) {
				$('.toolbarPanelButtonText').removeClass('selected');
			} else {
				$(this).children('.toolbarPanelButtonText').removeClass('selected');
			}
		} else {
			if($(this).hasClass('basemapButton')) {
				$('.toolbarPanelButton').removeClass('selected');
				$('.toolbarPanelButtonText').removeClass('selected');
				$(this).addClass('selected');
				$(this).children('.toolbarPanelButtonText').addClass('selected');
			} else {
				$(this).addClass('selected');
				$(this).children('.toolbarPanelButtonText').addClass('selected');
			}
		}
	});
	
};
 
 $(window).ready(initComponent);