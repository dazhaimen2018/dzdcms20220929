$(function() {
    $("#close_im").bind("click", function() {
        $("#main-im").css("height", "0");
        $("#im_main").hide();
        $("#open_im").show()
    });
    $("#open_im").bind("click", function(a) {
        $("#main-im").css("height", "272");
        $("#im_main").show();
        $(this).hide()
    });
    $(".go-top").bind("click", function() { $(window).scrollTop(0) });
    $(".weixing-container").bind("mouseenter", function() { $(".weixing-show").show() });
    $(".weixing-container").bind("mouseleave", function() { $(".weixing-show").hide() });
});