layui.use(["jquery", "element", "util","layer"], function () {
    var f = layui.jquery,
        e = layui.element,
        layer = layui.layer,
        d = layui.util;

    f("body").on("mouseenter", ".minihome-promote", function () {
        var msg =f(this).attr("data-tips");
        layer.tips(msg, f(this), {            tips: [3, '#803ED9'] //[3, '#9F17E9']
            ,maxWidth: 320
            ,time: 0
            ,anim: 5
            ,tipeMore: true, time: 20000});
    });

    if (f(".ew-header").length > 0) {
        var b = [];
        f("[nav-id]").each(function () {
            b.push(f(this).attr("nav-id"))
        });
        e.on("nav(ew-header-nav)", function (g) {
            var j = f(g).attr("lay-href");
            if (j) {
                if (b.length == 0) {
                    location.href = j
                } else {
                    if (j.indexOf("#") != -1) {
                        var i = j.substring(j.indexOf("#") + 1);
                        var h = f('[nav-id="' + i + '"]');
                        if (h.length > 0) {
                            f("html,body").animate({
                                scrollTop: h.offset().top - 70
                            }, 300)
                        }
                    } else {
                        f("html").animate({
                            scrollTop: 0
                        }, 300)
                    }
                }
            }
        });
        if (b.length > 0) {
            f(window).on("scroll", function () {
                a()
            });
            if (location.hash) {
                f('.ew-header a[lay-href$="' + location.hash.substring(1) + '"]').trigger("click")
            } else {
                a()
            }
            f(document).on("click", "[nav-scroll]", function () {
                var h = f(this).attr("nav-scroll");
                var g = f('[nav-id="' + h + '"]');
                if (g.length > 0) {
                    // f(".ew-header .layui-nav-item").removeClass("layui-this");
                    f('.ew-header a[lay-href$="#' + h + '"]').parent().addClass("layui-this");
                    f("html,body").animate({
                        scrollTop: g.offset().top - 70
                    }, 300)
                }
            })
        }
        d.fixbar({
            bgcolor: "#1aa094",
        })
    }

    function a() {
        var g = f(window).scrollTop();
        for (var h = b.length - 1; h >= 0; h--) {
            if (g >= (f('[nav-id="' + b[h] + '"]').offset().top - 75)) {
                // f(".ew-header .layui-nav-item").removeClass("layui-this");
                f('.ew-header a[lay-href$="#' + b[h] + '"]').parent().addClass("layui-this");
                return
            }
        }
        // f(".ew-header .layui-nav-item").removeClass("layui-this");
        f('.ew-header a[lay-href="index.html"]').parent().addClass("layui-this")
    }
});

function getProjectUrl() {
    var c = layui.cache.dir;
    if (!c) {
        var e = document.scripts, b = e.length - 1, f;
        for (var a = b; a > 0; a--) {
            if (e[a].readyState === "interactive") {
                f = e[a].src;
                break
            }
        }
        var d = f || e[b].src;
        c = d.substring(0, d.lastIndexOf("/") + 1)
    }
    return c.substring(0, c.indexOf("assets"))
};

//banner
var mySwiper = new Swiper('#bannerSwiper',{
    loop: true,
    speed:600,
    grabCursor : true,
    parallax:true,
    autoplay:{
        delay: 3000,
    },
    pagination: {
        el:'#bannerpagination',
        clickable :true,
    },
    navigation: {
        nextEl: '.arrow-right',
        prevEl: '.arrow-left',
    },
});

// 鼠标移入停止自动滚动
$('#bannerSwiper').mouseenter(function() {
    mySwiper.autoplay.stop();
})
// 鼠标移出开始自动滚动
$('#bannerSwiper').mouseleave(function() {
    mySwiper.autoplay.start();
})

//首页新闻
var swiper = new Swiper('.swiper-news', {
    slidesPerView: 4,
    spaceBetween: 30,
    slidesPerGroup: 4,
    loop: true,
    loopFillGroupWithBlank: true,
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
});

//首页新闻
var swiper = new Swiper('.swiper-news-wap', {
    slidesPerView: 1,
    spaceBetween: 30,
    slidesPerGroup: 1,
    loop: true,
    loopFillGroupWithBlank: true,
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
});

//store
var swiper = new Swiper('.store-img', {
    slidesPerView: 1,
    spaceBetween: 30,
    loop: true,
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
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

//合作客户翻页调用
$(".customer-buttons div").click(function() {
    var linum = $(this).index();
    var CaseList = $(".customer_items .item");
    $(this).addClass('disabled').siblings().removeClass('disabled');
    CaseList.eq(linum).show().siblings().hide();
});

