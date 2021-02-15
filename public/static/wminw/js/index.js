// 出场动画
$(document).on('ready scroll', function(event) {
	divMove('.index-news');
});

$(function(){

	// 控制新闻最大高度
	var array = [];
	$('.index-news-list').each(function(){
	  var maxH = $(this).find('.index-news-one').eq(0).outerHeight() + $(this).find('.index-news-one').eq(1).outerHeight() + $(this).find('.index-news-one').eq(2).outerHeight();

          array.push(maxH);
	})

	if(ww>992){
		$('.index-news-list-all').height(Math.max.apply(null, array) + 45) 
	}else{
		$('.index-news-list').height(Math.max.apply(null, array) + 50) 
	}

	/********案例详情页图片hover效果**********/
	// var native_width = 0;
	// var native_height = 0;
	// var $wh=$(window).height();
	
 //   $(".big_img").mousemove(function(e){
	//    index=$(this).index();
	   
 //     if(!native_width && !native_height)
	// {
 //        var image_object = new Image();
	//     image_object.src = $(".zoomed").eq(index-1).data("src");
	//     native_width = image_object.width;  //图片的宽度
	//     native_height = image_object.height; //图片的高度
 //    }
 //     else
 //    {
	// 	var magnify_offset = $(this).offset();
	// 	var my = e.pageY - magnify_offset.top;//鼠标当前位置距离图片顶部的距离
	// 	var h =  $(this).width() * (native_height/native_width)//图片的实际高度
	// 	var grad = (h - ($(this).height())) / ($(this).height());
	// 	var bgp0 = 0 + "px " + 0 + "px";
	// 	var bgp1 = 0 + "px " + -(my-100)*grad + "px";
	// 	var bgp2 = 0 + "px " + -(my+100)*grad + "px";
		
	// 	if(h<$wh){
	// 		$(this).find('.zoomed.open').css({backgroundPosition: bgp0,"height":h,"top":"50%","transform":"translateY(-50%)"}); 
			
	// 	}else{
	// 		if(my>=100&& my<$wh/2){
	// 			$(this).find('.zoomed.open').css({backgroundPosition: bgp1,"height":$wh-100}); 
	// 		}else if(my<$wh-100 && my>=$wh/2){
	// 			$(this).find('.zoomed.open').css({backgroundPosition: bgp2,"height":$wh-100}); 
	// 		}
			
	// 	}
	//    }	
	//  }); 
	//  $(".big_img").hover(function(){
		 
	//  },function(){
	// 	$('.ProductPhoto').removeClass('open');
	// 	$('.big_img').fadeOut("slow");   
	// 	  $('.big_img .zoomed').removeClass('open'); 
	// 	  $('.bg-shadow').removeClass('open')
	//  });
	//   var index;
	//   $(".ProductPhoto").hover(function(e){
			
	// 		index=$(this).index();
	// 		var image_object = new Image();
	// 		image_object.src = $(".zoomed").eq(index-1).data("src");
	   
	// 	   native_width = image_object.width;  //图片的宽度
	// 	   native_height = image_object.height; //图片的高度
	// 		if($(window).width() > 768){
	// 		  var magnify_offset = $(this).offset();
	// 		  var my = e.pageY - magnify_offset.top;
	// 		  var h =   $(this).width() * (native_height/native_width); //图片自适应高度
	// 		  var grad = (h -  $(this).height()) /  $(this).height(); 
	// 		  var bgp = 0 + "px " + -my*grad + "px";
	// 		  var bgp2 = 0 + "px " + 0 + "px";
	// 		 $(this).addClass('open');
	// 		 $('.big_img').fadeIn("slow");  
	// 		 $('.big_img .zoomed').eq(index-1).addClass('open'); 
	// 		 if(h<$wh){
	// 			$('.big_img .zoomed.open').css({backgroundPosition: bgp2,"height":h}); 
	// 		 }else{
	// 			$('.big_img .zoomed.open').css({backgroundPosition: bgp,"height":$wh-100}); 
	// 		 }		 
	// 		 $('.bg-shadow').addClass('open');
	// 	}
	//   });
 /********案例详情页图片hover效果结束**********/
});

function getmaxH(Class){
    var maxH = 0;
      var array = [];
      $(Class).each(function(){
          array.push(parseInt($(this).height()));
      })
      $(Class).height(Math.max.apply(null, array)) 
}