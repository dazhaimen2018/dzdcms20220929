// 出场动画
$(document).on('ready scroll', function(event) {
	divMove('.biz-show-one');
	divMove('.bizstep-list', 1);
	divMove('.bstep-one');
});

paceOptions = {
	elements: true
};

function load(time){
	var x = new XMLHttpRequest()
	x.open('GET', "" + time, true);
	// x.send();
};

setTimeout(function(){
	Pace.ignore(function(){
		load(3100);
	});
}, 4000);

Pace.on('hide', function(){

});

$(function () {
	// 激活点击按钮，提交表单
	$('.send').click(function(e) {
		$(this).parent('form').submit();
	});

	if ($('html').hasClass('desktop')) {
		new WOW().init();
	}

	$(".case_list ul li a img").lazyload({
		placeholder : "../images/loading.gif",
		effect: "fadeIn"
	});
});

jQuery(document).ready(function($) {
	$('.smoothscroll').on('click',function (e) {
		e.preventDefault();
		var target = this.hash,
			$target = $(target);
		$('html, body').stop().animate({
			'scrollTop': $target.offset().top
		},600,'swing',function () {
			window.location.hash = target;
		});
	});
})