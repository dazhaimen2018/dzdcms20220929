var $window = $(window),           
	ww = $window.width(),
	wh = $window.height();
$(function(){

	/********手机菜单**********/
	$('.buttonset').click(function(){
		$('.neirong').toggleClass('neirong-show');
		$(this).toggleClass('on');
	})
	
	// 案例动画效果
    if($(window).width()>1024){
        $(".case_list ul li .case_img").hover(function(){
			$(this).parent().parent().siblings().find('.case_cover').stop().addClass('on');

			$('.cover-row').stop().addClass('on');
			// $(this).parent().parent().siblings().find('.cover-glass').stop().removeClass('on');
			$(this).parent().parent().find('.cover-glass').stop().addClass('on');
		},function(){
			$(this).parent().parent().siblings().find('.case_cover').stop().removeClass('on');
			
			$('.cover-row').stop().removeClass('on');
			// $(this).parent().parent().siblings().find('.cover-glass').stop().addClass('on');
			$(this).parent().parent().find('.cover-glass').stop().removeClass('on');
		});

    };





	// 返回顶部
    $('.m-totop').click(function(event) {
        $('body, html').animate({scrollTop:0}, 600); 
    });

    $('.back-top').click(function(event) {
        $('body, html').animate({scrollTop:0}, 600); 
    });

    // 显示qq信息
    $("#QQ_s").hover(
		function(){
			$(".QQ_y").hide();
			$(".QQ_x").show();
		},
		function(){
		    $(".QQ_y").show();
			$(".QQ_x").hide();
		}
	)
	
	//案例底部form
	$(window).on('load resize',function(event) {
		if($(window).width()>1199){
			var demandH = $('.demand_left').height();
			$('.demand_right').height(demandH);
		}	
	});
	
	$(window).on('scroll resize',function(event) {
		if ($('.demand').length == 0) {
			return ;
		}
		var h=$('.demand').offset().top;
		if ($(this).scrollTop() > h - 500 && $(this).scrollTop() < h + 500) {
			$('.demand').addClass('cur');
		}else{
			$('.demand').removeClass('cur');
		}
	});

	//鼠标向上滚动出现菜单	
	// scroll(function(x){

	//     var scorolltop = $(document).scrollTop(); 
	//     if(scorolltop < 100){
	// 	   $('.navbar-fixed').stop().removeClass('show');
	//     }else if(x == "up"){
	// 		$('.navbar-fixed').stop().addClass('show');
	// 		$('.fix-nav-btm').stop().addClass('show');
	// 	}else if(x == "down"){
	// 		$('.navbar-fixed').stop().removeClass('show');
	// 		$('.fix-nav-btm').stop().removeClass('show');
	// 	}
	// });
	
	
	
	/*案例继续了解动画*/
	
	function o() {
		r = !0, setTimeout(function() {
			if (r) {
				r = !0;
				var o;
				e.addClass("det_more_hover"), a.show().stop().fadeTo(800, .3), s.stop().animate({
					top: -f,
					height: i,
					opacity: 1
				}, {
					step: function(t, e) {
						o = e.pos, s.css({
							filter: "alpha(opacity=" + parseInt(1e4 * o) / 100 + ")"
						})
					}
				}, n)
			}
		}, 100)
	}
	function t() {
		r = !1;
		var o;
		e.removeClass("det_more_hover"), a.stop().fadeOut(800), s.stop().animate({
			top: 0,
			height: p,
			opacity: 0
		}, {
			step: function(t, e) {
				o = 1 - e.pos, s.css({
					filter: "alpha(opacity=" + parseInt(1e4 * o) / 100 + ")"
				})
			}
		}, n)
	}
	var e = $(".det_more"),
		a = $(".det_more_mask"),
		s = e.find(".det_more_bg"),
		i = 330,
		p = 200,
		f = (i - p) / 2,
		n = 800,
		r = !1;
	s.css("top", 0), e.hover(o, t)
	/*案例继续了解动画结束*/

	// .demand-logo控制
	// $('.demand-logo-one-desc').height($('.demand-logo-one-img').height());

	// 链接按钮点击效果.btn-circle-hover
	$('.btn-circle').click(function(e) {
        var parentOffset = $(this).offset(), relX = e.pageX - parentOffset.left, relY = e.pageY - parentOffset.top;
        var circleR = $(this).outerWidth(true);

        $(this).find('.btn-circle-click').css({
            top: relY,
            left: relX,
            width: 2.5*circleR,
            height: 2.5*circleR,
            opacity: 0,
		    transition: 'width 1s, height 1s, opacity 1.2s'
        });

        $(this).find('.btn-circle-click').get(0).addEventListener('transitionend', zeroCircleClick, false);

        function zeroCircleClick(e) {
        	if (e.propertyName == 'opacity') {
		        $(this).css({
		            width: 0,
		            height: 0,
		            opacity: 1,
				    transition: '0s'
		        });

		        $(this).get(0).removeEventListener('transitionend', zeroCircleClick, false);
        	}
        }

	});

	// 链接按钮hover效果.btn-circle-hover
    $('.btn-circle').on('mouseenter mouseover', function (e) {
        var parentOffset = $(this).offset(), relX = e.pageX - parentOffset.left, relY = e.pageY - parentOffset.top;
        var circleR = $(this).outerWidth(true);

        $(this).find('.btn-circle-hover').css({
            top: relY,
            left: relX,
            width: 2.5*circleR,
            height: 2.5*circleR,
            opacity: 1,
		    transition: 'width .8s, height .8s, opacity .8s'
        });
    }).on('mouseout', function (e) {
        var parentOffset = $(this).offset(), relX = e.pageX - parentOffset.left, relY = e.pageY - parentOffset.top;

        $(this).find('.btn-circle-hover').css({
            top: relY,
            left: relX,
            width: 0,
            height: 0,
            opacity: 0,
		    transition: 'width .6s, height .6s, opacity 1.3s'
        });
    });


	// .demand_right出场优化
	$('.demand_right').css('opacity', '1');

});

$(window).on('scroll', function(event) {
	divMove('.demand-logo-list');
});

// 页脚手机导航
$(window).on('resize ready', function(event) {
    // navClick();
});

function navClick() {
    var winW = $(window).width();

    if (winW <= 992) {

        $('.footer-l > ul > li').click(function() {
            var _this = $(this);

            $('.footer-sub-menu').hide();
            _this.find('.footer-sub-menu').show();
        });

        $('.footer-sub-menu').click(function(event) {
            event.stopPropagation();
        });
    }
}

// 动画效果
function divMove(sel, only) {
    winW = $(window).width(),
    winH = $(window).height(),//可视窗口高度
    scrollT = $(window).scrollTop(),//鼠标滚动的距离
    pu = $(window).width()/1920;

    $(sel).each(function(index, el) {
        var _this = $(this);

        if (_this.length && winH + scrollT - _this.offset().top > winH*(1/7) && scrollT < _this.height() + _this.offset().top) {

            if (_this.hasClass('letmove')) {
                _this.addClass('move');
            }
            
            if (!only) {
                _this.find('.letmove').addClass('move');
            }
        }
    });
}

// 点击触发
function onceClick(sel) {
    winW = $(window).width(),
    winH = $(window).height(),//可视窗口高度
    scrollT = $(window).scrollTop(),//鼠标滚动的距离
    pu = $(window).width()/1920;

    $(sel).each(function(index, el) {
        var _this = $(this);

        if (_this.length && winH + scrollT - _this.offset().top > -winH*(3/4) && scrollT < _this.height() + _this.offset().top + winH*(1/10)) {

            if (!$(sel).hasClass('on') && !$(sel).siblings().hasClass('on')) {
                _this.click();
            }

        }
    });
}

// function scroll( fn ) {
//     var beforeScrollTop = document.body.scrollTop,
//         fn = fn || function() {};
//     window.addEventListener("scroll", function() {
//         var afterScrollTop = document.body.scrollTop,
//             delta = afterScrollTop - beforeScrollTop;
//         if( delta === 0 ) return false;
//         fn( delta > 0 ? "down" : "up" );
//         beforeScrollTop = afterScrollTop;
//     }, false);
// } 

//鼠标向上滚动出现菜单	
var beforeScrollTop=$(window).scrollTop();
$(window).scroll(function(){

	var scrollTop=$(window).scrollTop();
	
	var delta = scrollTop - beforeScrollTop;
	
	if(delta > 0){

		$('.navbar-fixed').stop().removeClass('show');
		$('.fix-nav-btm').stop().addClass('hide');
	}else if(delta <= 0){
		$('.navbar-fixed').stop().addClass('show');
		$('.fix-nav-btm').stop().removeClass('hide');
	}
	if(scrollTop< 100){
		$('.navbar-fixed').stop().removeClass('show');
	}
	beforeScrollTop=scrollTop;
})