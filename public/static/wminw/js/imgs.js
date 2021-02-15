$(function() {
	newsSwiper();

	// 展示用的虚拟加载更多功能
	// $('.co-news-more a.a-1').click(function() {
	// 	$(this).hide();
	// 	$('.co-news-list').find('.hide').fadeIn();
	// });
});

$(window).resize(function() {
	newsSwiper();
});

function newsSwiper() {
	var $winW = $(window).width();

	// 业绩新闻轮播图
	var slidesPerView = 6;
	var spaceBetween = 50;

	if ($winW <= 1450) {
		spaceBetween = 10;
	}
	if ($winW <= 1000) {
		slidesPerView = 2;
		spaceBetween = 10;
	}
	if ($winW <= 768) {
		slidesPerView = 1;
		spaceBetween = 0;
	}
	if ($winW <= 544) {
		spaceBetween = 0;
	}

	var imgsListM = new Swiper('.imgs-list-m', {
		autoplay: false,//可选选项，自动滑动
		slidesPerView: slidesPerView,
		spaceBetween: spaceBetween,
		lazy: true,
		onInit: function(swiper){
			$('.imgs-list-m .swiper-slide').eq(swiper.activeIndex).find('img.swiper-lazy').each(function(index, el) {
				_srcNeed = $(this).data('src');

				$(this).attr('src', _srcNeed);
			});
		},
		onSlideChangeStart: function(swiper){
			$('.imgs-list-m .swiper-slide').eq(swiper.activeIndex).find('img.swiper-lazy').each(function(index, el) {
				_srcNeed = $(this).data('src');

				$(this).attr('src', _srcNeed);
			});
		}
	});

	$('.imgs-prev-m').click(function() {
		imgsListM.slidePrev();
	});
	$('.imgs-next-m').click(function() {
		imgsListM.slideNext();
	});

	var imgsListPC = new Swiper('.imgs-list-pc', {
		autoplay: false,//可选选项，自动滑动
		speed: 600,
		slidesPerView: 1,
		spaceBetween: 0,
		pagination: '.swiper-pagination',
		paginationClickable: true,
		lazy: true,
		onInit: function(swiper){
			$('.imgs-list-pc .swiper-slide').eq(swiper.activeIndex).find('img.swiper-lazy').each(function(index, el) {
				_srcNeed = $(this).data('src');

				$(this).attr('src', _srcNeed);
			});
		},
		onSlideChangeStart: function(swiper){
			$('.imgs-list-pc .swiper-slide').eq(swiper.activeIndex).find('img.swiper-lazy').each(function(index, el) {
				_srcNeed = $(this).data('src');

				$(this).attr('src', _srcNeed);
			});
		}
	});

	$('.imgs-prev-pc').click(function() {
		imgsListPC.slidePrev();
	});
	$('.imgs-next-pc').click(function() {
		imgsListPC.slideNext();
	});
}