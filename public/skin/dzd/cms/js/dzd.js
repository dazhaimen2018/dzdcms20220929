// banner
layui.use('carousel', function(){
    var carousel = layui.carousel;
    //建造实例
    carousel.render({
        elem: '#slide'
        ,width: '100%' //设置容器宽度
        ,arrow: 'always' //始终显示箭头
        //,anim: 'updown' //切换动画方式
    });
});

//加载更多
$(function() {
    $(document).on("click", ".btn-loadmore", function() {
        var that = this;
        var page = parseInt($(this).data("page"));
        page++;
        $(that).prop("disabled", true);
        $.ajax({
            url: $(that).attr("href"),
            type: "post",
            success: function(res) {
                $('.listAjax').append(res.data);
                $(that).remove();
                $(".imgBg").each(function(){$(this).css("background-image", "url(" + $(this).find("img").attr("src") + ")");});
                return false;
            },
        });
        return false;
    })
});

//站点切换 必须要有 jquery.cookie.min.js
function setLang(lang){
    $.cookie('lang', lang);
    window.location.reload();
}

//视频播放
$('.videolist').each(function(){ //遍历视频列表
    $(this).hover(function(){ //鼠标移上来后显示播放按钮
        $(this).find('.videoed').show();
    },function(){
        $(this).find('.videoed').hide();
    });
    $(this).click(function(){ //这个视频被点击后执行
        var img = $(this).attr('vpath');//获取视频预览图
        var video = $(this).attr('ipath');//获取视频路径
        $('.videos').html("<video id=\"video\" poster='"+img+"' src='"+video+"' preload=\"auto\" controls=\"controls\" autoplay=\"autoplay\"></video> <i onclick=\"closes()\"  class=\"layui-icon layui-icon-close vclose\"></i>");
        $('.videos').show();
    });
});

function closes(){
    var v = document.getElementById('video');//获取视频节点
    $('.videos').hide();//点击关闭按钮关闭暂停视频
    v.pause();
    $('.videos').html();
}

// 搜索框
jQuery(function () {
    $(".header-search-icon").click(function (e) {
        $(".header-search").toggleClass("active");
        e.preventDefault();
    });
})
