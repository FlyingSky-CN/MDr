/**
 * MDr 是一套基于 MDUI 开发的 Typecho 模板
 */

const mdrScroll = () => {
    if ($(document).scrollTop() > 0) {
        $('header').removeClass('mdui-shadow-0');
    } else {
        $('header').addClass('mdui-shadow-0');
    }
}

$(document).ready(mdrScroll);
$(document).scroll(mdrScroll);

const mdrSiteTimeUpdate = () => {
    window.setTimeout("mdrSiteTimeUpdate()", 1000);
    var X = new Date(mdrSiteTime),
        Y = new Date(),
        T = (Y.getTime() - X.getTime()),
        M = 24 * 60 * 60 * 1000,
        a = T / M,
        A = Math.floor(a),
        b = (a - A) * 24,
        B = Math.floor(b),
        c = (b - B) * 60,
        C = Math.floor((b - B) * 60),
        D = Math.floor((c - C) * 60);
    runtime_span.innerHTML = A + " 天 " + B + " 时 " + C + " 分 " + D + " 秒";
}
if (typeof mdrSiteTime !== "undefined") mdrSiteTimeUpdate();

/**
 * Ajax Loader
 */
var isbool = true;
var autoloadtimes = 0;

$(window).scroll(function () {
    if (isbool && $('.ajaxload .next a').attr("href") && ($(this).scrollTop() + $(window).height() + 20) >= $(document).height()) {
        if (mdrAjaxLoadTimes == '-1' || autoloadtimes < mdrAjaxLoadTimes) {
            isbool = false;
            autoloadtimes++;
            console.log('Autoload ' + autoloadtimes + ' times');
            aln();
        }
    }
});

function al() {
    $('.ajaxload li[class!="next"]').remove();
    $('.ajaxload .next').addClass('mdui-center mdui-hoverable mdui-btn mdui-m-x-0');
    $('.ajaxload .next').click(function () {
        if (isbool) {
            aln()
        }
        return false
    });
    $('.ajaxload').removeClass('hidden');
}
al();

function aln() {
    var a = '.ajaxload .next a',
        b = $(a).attr("href");
    $(a).addClass('loading').text("正在加载");
    if (b) {
        $.ajax({
            url: b + '?_pjax',
            error: function () {
                mdui.snackbar({
                    message: '请求失败，请检查网络并重试或者联系管理员。',
                    position: mdrSnackbar,
                    timeout: 3000
                });
                $(a).removeAttr("class").text("查看更多");
                return false
            },
            success: function (d) {
                var c = $(d).find("#main .mdui-card.post"),
                    e = $(d).find(a).attr("href");
                if (c) {
                    $('.ajaxload').before(c)
                };
                $(a).removeAttr("class");
                if (e) {
                    $(a).text("查看更多").attr("href", e)
                } else {
                    $(a).remove();
                    $('.ajaxload .next').text('没有更多文章了')
                }
                if ($('.protected', d).length) {
                    $('.protected *').unbind();
                }
                isbool = true;
                return false
            }
        })
    }
}