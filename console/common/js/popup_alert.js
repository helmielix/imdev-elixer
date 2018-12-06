
setPopupAlert = function(message) {
	$('.content-wrapper').append(
		'<div class="alert alert-success alert-dismissable" style="position:absolute; z-index:2000; top:0; width: 400px">'+
			'<button type="button" class="close" ' + 
					'data-dismiss="alert" aria-hidden="true">' + 
				'&times;' + 
			'</button>' + 
				message + 
		 '</div>'
	);
	var viewportWidth = $(window).width();
	var viewportHeight = $(window).height();
	var adjustLeft = $('.sidebar').width();
	$('.alert').css('left', ((viewportWidth-400)/2));
	$('.alert').css('top', ((viewportHeight-30)/2));
	setTimeout(function(){
		$('.alert').fadeOut( 200, function(){
			$('.alert').remove();
		})
	},2000);
};
