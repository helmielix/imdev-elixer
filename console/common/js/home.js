$( ".homelinkcontainer" ).hover(
	function() {
		$( this ).addClass('selected');
	}, function() {
		$( this ).removeClass( 'selected');
	}
);

$( ".homelinkcontainer" ).click(
	function() {
		var index =  $('.homelinkcontainer').index($(this));
		$('.homeButtonContainer').not(':eq('+index+')').slideUp();
		$( this ).children('.homeButtonContainer').slideDown();
	}
);