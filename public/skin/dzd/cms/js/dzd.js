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