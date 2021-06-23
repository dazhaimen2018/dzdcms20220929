var clipboard = new ClipboardJS('.item');

clipboard.on('success', function (e) {
    console.info('Action:', e.action);
    console.info('Text:', e.text);
    console.info('Trigger:', e.trigger);
    //alert('成功！');
    $("#share-tip").text('复制成功！');
    setTimeout(function () {
        $("#share-tip").text('复制链接');
    }, 2000);
    e.clearSelection();
});

clipboard.on('error', function (e) {
    console.error('Action:', e.action);
    console.error('Trigger:', e.trigger);
    alert('失败！');
});
$(document).ready(function () {

    if (document.body.clientWidth <= 900) {
        $(".window-body").removeClass('with-sidebar');

    }

    $('li').hover(function () {
        $('li').removeClass('hover');
        $(this).addClass('hover');
        $(this).find('.wholerow').html('<div class="actions"></div>');
    })
    $("li").click(function (event) {
        event.stopPropagation();//阻止事件冒泡即可
        if ($(this).find('.icon.caret')) {
            if ($(this).find('.icon.caret').eq(0).hasClass('right')) {
                $(this).find('.icon.caret').eq(0).removeClass('right').addClass('down');
            } else {
                $(this).find('.icon.caret').eq(0).removeClass('down').addClass('right');
            }

        }

        $(this).toggleClass('open');
    })
    $(".wholerow").click(function () {
        var href = $(this).parent().find('a').attr('href');
        window.location.href = href;
    })

    $(".so").bind('input propertychange', function () {
        //var t = $(this).val().length*1000;
        //console.log($(this).val());
        if ($(this).val() != '') {

            $.post('/index/search', {w: $(this).val()}, function (r) {
                console.log(r);

                if (r.code == 0) {
                    var l = r.data.length;
                    $(".search-body").remove();
                    $(".catalog-body").hide();
                    var html = '<div class="search-body"><ul>';

                    $.each(r.data, function (k, item) {
                        html += '<li><a  href="' + item['url'] + '">' + (k + 1) + '.' + item['classname'] + '</a>';
                    });
                    html += '</ul></div>';

                    $(".sidebar-body").append(html);

                    if ($("#so").val() == '') {
                        $(".search-body").remove();
                        $(".catalog-body").show();
                    }
                }

            }, 'json');

        } else {
            $(".search-body").remove();
            $(".catalog-body").show();
        }
    });


})

function showshare() {
    $(".window-body .workspace .article .article-head .tools>.item").toggleClass('active visible');
    $(".ui.top.right.pointing.dropdown>.menu").toggleClass('visible');
}

function leftside() {
    $(".window-body").toggleClass('with-sidebar');
}

