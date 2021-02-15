
/**
 * JS仿QQ空间鼠标停在长图片时候图片自动上下滚动效果
 * @date 2014-1-1 
 * @author tugenhua
 * @email 879083421@qq.com
 */

 function LongPicShow(options) {
 
	this.config = {
		targetImg     :  '.targetImg',   // 当前图片的元素
		speed         :  150             // 默认为150 值越小 执行的越慢 time = 图片height/speed
	};

	this.cache = {
		
	};
	this.init(options);
 }

 LongPicShow.prototype = {
	
	init: function(options) {
		var self = this,
			_config = self.config,
			_cache = self.cache;
		
		// 插入div
		self._insertDiv();
		
		// 设置css样式
		self._setCss();

		// 鼠标移上去的事件
		self._hover();
	},
	// 页面初始化 插入div
	_insertDiv: function(){
		var self = this,
			_config = self.config;

		$(_config.targetImg).each(function(index,item){
			var tagParent = $(item).parent();
			$(tagParent).append('<div class="topDiv"></div><div class="bottomDiv"></div>');
		});
	},
	// 设定css样式
	_setCss: function(){
		var self = this,
			_config = self.config,
			_cache = self.cache;
		$(_config.targetImg).each(function(index,item){
			var tagParent = $(item).parent(),
				parentWidth = $(tagParent).width(),
				parentHeight = $(tagParent).height();
			$(tagParent).css({
				'position':'relative'
			});
			$('.topDiv',tagParent).css({
				'height':parentHeight/2 + 'px',
				'width':parentWidth + 'px',
				'cursor':'pointer',
				'background':'#fff',
				'position':'absolute',
				'filter':'alpha(opacity=0)',
				'top': 0,
				'opacity':0
			});
			$('.bottomDiv',tagParent).css({
				'height':parentHeight/2 + 'px',
				'width':parentWidth + 'px',
				'cursor':'pointer',
				'background':'#fff',
				'position':'absolute',
				'filter':'alpha(opacity=0)',
				'opacity':0,
				'top':parentHeight/2 + 'px'
			});

		});
	},
	/*
	 * 鼠标移上触发的事件
	 */
	_hover: function(){
		var self = this,
			_config = self.config,
			_cache = self.cache;
		
		
		$(_config.targetImg).each(function(index,item){
			
			var tagParent = $(item).parent();
			// 向上移动 鼠标移到第二个div上
			$($(tagParent).find('div')[1]).hover(function(){

				var $imgHeight = $(item).height(),
					topStr= $(item).css("top").split("px")[0],
					$top,
					$time;
				if(topStr.split("-")[1]) {
					$top = parseFloat(topStr.split("-")[1]);
					$time = ($imgHeight-$top)/_config.speed;
				}else {
					$time = $imgHeight/_config.speed;
				}
				$(item).css('position','absolute');
				$(item).animate({top:-$imgHeight + $(tagParent).height()},$time * 1000,"linear");
			},function(){
				$(item).stop();
			});

			// 向下移动 鼠标移到第一个div上
			$($(tagParent).find('div')[0]).hover(function(){

				var $imgHeight = $(item).height(),
					topStr= $(item).css("top").split("px")[0],
					$top,
					$time;

				$top = parseFloat(topStr.split("-")[1]);
				$time = $top/_config.speed;
				$(item).css('position','absolute');
				$(item).animate({top:0},$time * 1000,"linear");
			},function(){
				$(item).stop();
			});
		});
	}
 };