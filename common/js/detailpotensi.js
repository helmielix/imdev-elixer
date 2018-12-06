setFlipbook = function() {
	setTimeout(function(){
		var currentHeight = 0;
		var currentPage = 1;
		for(var i = 0; i < $('table').length;i++) {
			currentHeight += $('table:eq('+i+')').outerHeight(true);
			currentHeight += 20;
			if(currentHeight > 880) {
				if(currentPage%2 == 0) {page = ' even';} else {page = ' odd';};
				var boundary = $('table:eq('+(i+0)+')');
				$('<div class="pageContainer">').insertAfter(boundary.parent()).append(boundary.nextAll().andSelf());
				var boundary2 = $('.pageContainer:last');
				$('<div class="pageWrapper'+page+'">').insertAfter(boundary2.parent()).append(boundary2.nextAll().andSelf());
				currentPage++;
				currentHeight = $('table:eq('+(i+0)+')').outerHeight(true);
			} 
		}
	},400);
	
}

$(window).ready(setFlipbook);