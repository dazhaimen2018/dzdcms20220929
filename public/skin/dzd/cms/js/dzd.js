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
function setLang(lang,sid){
    $.cookie('think_site_id', sid);
    $.cookie('think_var', lang);
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

// 下拉搜索框
$(function() {
    $(".search-box .butn").on('click', function() {
        if ($(this).hasClass('hov')) {
            $(this).removeClass('hov');
            $(this).siblings('.share-sub').stop().animate({
                width: 288
            }, 500);

        } else {
            $(this).addClass('hov');
            $(this).siblings('.share-sub').stop().animate({
                width: 0
            }, 500);

        }
    });

    $('.case_list').on('mouseenter','li',function(){
        $(this).addClass('hover');
    }).on('mouseleave','li',function(){
        $(this).removeClass('hover');
    });

    $(".select_showbox").click(function() {
        $(".select_option").show();
        $(this).addClass("active");
    });

    if ($('.select_option li').is('.selected')) {
        $(".select_showbox").html($('.select_option li.selected').html());
        $("#modelid").val($('.select_option li.selected').data('id'));
    }

    $(".select_option li").click(function() {
        $("#modelid").val($(this).data('id'));
        $(".select_showbox").html($(this).html());
        $(".select_option").hide();
        $(".select_showbox").removeClass("active");
    });

    $(".select_option li").hover(function() {
        $(this).addClass("selected");
    }, function() {
        $(this).removeClass("selected");
    });

})