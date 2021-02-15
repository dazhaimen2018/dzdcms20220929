// 出场动画
$(document).on('ready scroll', function(event) {
	divMove('.about-desc');
	divMove('.about-title');
	divMove('.good-one');
	divMove('.about-partner');
	divMove('.about-client');
	divMove('.about-idea');
});

paceOptions = {
	elements: true
};

function load(time){
	var x = new XMLHttpRequest()
	x.open('GET', "" + time, true);
	x.send();
};

setTimeout(function(){
	Pace.ignore(function(){
		load(3100);
	});
}, 4000);

Pace.on('hide', function(){
	console.log('done');
});

$(function () {
	if ($('html').hasClass('desktop')) {
		new WOW().init();
	}

	$(".case_list ul li a img").lazyload({
		placeholder : "../images/loading.gif",
		effect: "fadeIn"
	});
});

//设置计数
$.fn.countTo = function (options) {
	options = options || {};
	return $(this).each(function () {
		//当前元素的选项
		var settings = $.extend({}, $.fn.countTo.defaults, {
			from:            $(this).data('from'),
			to:              $(this).data('to'),
			speed:           $(this).data('speed'),
			refreshInterval: $(this).data('refresh-interval'),
			decimals:        $(this).data('decimals')
		}, options);
		//更新值
		var loops = Math.ceil(settings.speed / settings.refreshInterval),
			increment = (settings.to - settings.from) / loops;
		//更改应用和变量
		var self = this,
			$self = $(this),
			loopCount = 0,
			value = settings.from,
			data = $self.data('countTo') || {};
		$self.data('countTo', data);
		//如果有间断，找到并清除
		if (data.interval) {
			clearInterval(data.interval);
		};
		data.interval = setInterval(updateTimer, settings.refreshInterval);
		//初始化起始值
		render(value);
		function updateTimer() {
			value += increment;
			loopCount++;
			render(value);
			if (typeof(settings.onUpdate) == 'function') {
				settings.onUpdate.call(self, value);
			}
			if (loopCount >= loops) {
				//移出间隔
				$self.removeData('countTo');
				clearInterval(data.interval);
				value = settings.to;
				if (typeof(settings.onComplete) == 'function') {
					settings.onComplete.call(self, value);
				}
			}
		}
		function render(value) {
			var formattedValue = settings.formatter.call(self, value, settings);
			$self.html(formattedValue);
		}
	});
};
$.fn.countTo.defaults={
	from:0,               //数字开始的值
	to:0,                 //数字结束的值
	speed:1000,           //设置步长的时间
	refreshInterval:50,  //隔间值
	decimals:0,           //显示小位数
	formatter: formatter, //渲染之前格式化
	onUpdate:null,        //每次更新前的回调方法
	onComplete:null       //完成更新的回调方法
};
function formatter(value, settings){
	return value.toFixed(settings.decimals);
}
//自定义格式
$('#count-number').data('countToOptions',{
	formmatter:function(value, options){
		return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
	}
});

$(function(){
	var beok = true;
	$('.counter').each(function(){
		m = $(this).offset().top-wh;
		return $(this).attr('ori-pos',m);
	})

	$(window).on("scroll",function() {
		var s = $(window).scrollTop();
		$('.counter').each(function(){
			var that = $(this);
			breakpoint = that.attr('ori-pos');
			breakpoint_max = parseInt(breakpoint)+parseInt(wh)+parseInt(that.height());
			if((Math.abs(s)>=breakpoint) && (Math.abs(s) < breakpoint_max) && beok){
				beok = !beok;
				$('.about-client-line').addClass('move');
				for(var i=0;i < $('.counter').length;i++){
					var j = -1;
					var num = 250*i;
					setTimeout(function(){
						j++;
						$('.counter').eq(j).countTo()
					},num)
				}
			}
		})
	});


	function count(a) {
		var b = $(this);
		a = $.extend({},
			a || {},
			b.data("countToOptions") || {});
		b.countTo(a)
	};
})