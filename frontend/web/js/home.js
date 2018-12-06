initHome = function() {
	var viewportWidth = $(window).width();
	var viewportHeight = $(window).height();
	var xcenter = (viewportWidth/2) - 50;
	var ycenter = (viewportHeight/2) - 30;
	t=0.5;
	$('.homeButtonContainer').css('left',((viewportWidth/2)-60)+'px');
	$('.homeButtonContainer').css('top',((viewportHeight/2)-60)+'px');
	var maxDiv = $('.homeButtonContainer').length ;
	console.log(maxDiv);
	setTimeout(function(){
		$('.homeLogo').animate({
			top: ycenter - 67,
			left: xcenter - 70,
		},0).animate({
			opacity: 1
		},400);
	},800);
	
	function moveit() {
		var r = 53;
		var index;
		$( ".homeButtonContainer" ).each(function() {
			index = $(this).index('.homeButtonContainer');
			$( this ).animate({
				top: Math.floor(ycenter + ((r*(t)) * Math.sin(t+maxDiv+(Math.PI/maxDiv*2*index)))),
				left: Math.floor(xcenter + ((r*(t)) * Math.cos(t+maxDiv+(Math.PI/maxDiv*2*index)))),
				opacity: t/maxDiv
			}, 1, function() {
				if(t <=maxDiv+0.3) {
					if ($(this).index('.homeButtonContainer') == 0) {
						t = t + (t*0.05);
						moveit();
					}
				} else {
					index = $(this).index('.homeButtonContainer');
					$( this ).animate({
						top: Math.floor(ycenter - ((r*(t)) * Math.cos((Math.PI/maxDiv*2*index)))),
						left: Math.floor(xcenter + ((r*(t)) * Math.sin((Math.PI/maxDiv*2*index)))),
						opacity: 1
					},1,function(){
					})
				}
			});
		});
	} 
	moveit();
	isOut = false;
	setTimeout(function(){
		$('.homeButtonContainer').hover(function(){
			isOut = true;
			$(this).animate({
				width: '140px',
				height: '140px',
				left: '-=20px',
				top: '-=20px'},
				200,function(){
					$(this).children('span').css('display','block');
				});
		},function(){
			if(isOut){
				$(this).animate({
					width: '100px',
					height: '100px',
					left: '+=20px',
					top: '+=20px'},
					200,function(){
						$(this).children('span').css('display','none');
					});
			}
				
		});
	},1400);
	
}

resizeHome = function() {
	var viewportWidth = $(window).width();
	var viewportHeight = $(window).height();
	var xcenter = (viewportWidth/2);
	var ycenter = (viewportHeight/2);
	// t=0.2;
	// $('.homeButtonContainer').css('left',((viewportWidth/2)-60)+'px');
	// $('.homeButtonContainer').css('top',((viewportHeight/2)-60)+'px');
	// var maxDiv = $('.homeButtonContainer').length;
	// function moveit() {
		// var r = 13;
		// var index;
		// $( ".homeButtonContainer" ).each(function() {
			// index = $(this).index('.homeButtonContainer');
			// $( this ).animate({
				// top: Math.floor(ycenter + ((r*(t)) * Math.sin(t+maxDiv+(Math.PI/maxDiv*2*index)))),
				// left: Math.floor(xcenter + ((r*(t)) * Math.cos(t+maxDiv+(Math.PI/maxDiv*2*index)))),
				// opacity: t/maxDiv
			// }, 1, function() {
				// if(t <=maxDiv+0.3) {
					// if ($(this).index('.homeButtonContainer') == 0) {
						// t = t + (t*0.05);
						// moveit();
					// }
				// } else {
					// index = $(this).index('.homeButtonContainer');
					// $( this ).animate({
						// top: Math.floor(ycenter - ((r*(t)) * Math.cos((Math.PI/maxDiv*2*index)))),
						// left: Math.floor(xcenter + ((r*(t)) * Math.sin((Math.PI/maxDiv*2*index)))),
						// opacity: 1
					// },1,function(){
						// $(this).addClass('staticPos');
					// })
				// }
			// });
		// });
	// } 
	// moveit();
	// $('.homeButtonContainer').hover(function(){
		// $(this).animate({
			// width: '140px',
			// height: '140px',
			// left: '-=20px',
			// top: '-=20px'},
			// 200)
	// },function(){
		// $(this).animate({
			// width: '100px',
			// height: '100px',
			// left: '+=20px',
			// top: '+=20px'},
			// 200)
	// });
}

$(document).ready(initHome);
$(window).resize(resizeHome);