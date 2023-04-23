// функционал бургер-меню
// $(function(){
// 	let check = false;
// 	$('.shell_sticky').click(function(){
// 		if (!check) {
// 			$('#sticky_2').css({
// 				'transform' : 'rotate(405deg)'
// 			});
// 			$('#sticky_2').fadeOut(10);

// 			$('#sticky_1').css({
// 				'transform' : 'rotate(405deg)',
// 				'margin-top' : '10px'
// 			});
// 			$('#sticky_3').css({
// 				'transform' : 'rotate(495deg)',
// 				'margin-top' : '10px'
// 			});
// 			check = true;
// 		}
// 		else{
// 			$('#sticky_2').fadeIn(10);
// 			$('#sticky_2').css({
// 				'transform' : 'rotate(0deg)'
// 			});
// 			$('#sticky_1').css({
// 				'transform' : 'rotate(0deg)',
// 				'margin-top' : '0px'
// 			});
// 			$('#sticky_3').css({
// 				'transform' : 'rotate(0deg)',
// 				'margin-top' : '20px'
// 			});
// 			check = false;
// 		}

// 	});
// });

$(function(){
	$('.text-center').click(function(){
		alert("иди нахуй максим");
	});
});

// карусель
$(document).ready(function(){
	$(".owl-carousel").owlCarousel({
		items: 2,
		loop: true,
		autoplay : true,
		autoplayTimeout: 5000,
		autoplayHoverPause: true,
		responsive : {
			100: {
				items: 1
			},
			500: {
				items: 2
			},
			800: {
				items: 3
			},
			1000: {
				items: 4
			}
		}
	});
	
});