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

// header btn
	document.getElementById('OpenClick').addEventListener("click", function() {
		this.classList.toggle("open")
	});


// функция для прокрутки в самый низ, когда нажимаешь на кнопку "подробнее"
function scrollToInfo(){
	window.scrollTo(0, 2200);
};



