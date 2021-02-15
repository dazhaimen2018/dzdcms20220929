// 出场动画
$(document).on('ready scroll', function(event) {
	divMove('.about-desc');
	divMove('.contact-sol');
	divMove('.contact-site');
});

// 计算最大高度
$(function() {
    var maxH = 0;
    var array = [];
    $('.need').each(function(){
        array.push(parseInt($(this).height()));
    })
    $('.need').height(Math.max.apply(null, array)) 
})


// winW = $(window).width();

// if (winW >= 1200) {
// 	// solution的高度
// 	var contactSolH = $('.contact-sol').height();
// 	var cSolRrightBtmH = $('.c-sol-r-b').height();
// 	var cSolRrightTopH = contactSolH - cSolRrightBtmH;

// 	$('.c-sol-r-t').height(cSolRrightTopH);
// }


