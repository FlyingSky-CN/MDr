/**
 * MDr 是一套基于 MDUI 开发的 Typecho 模板
 */

console.log(
    "\n %c MDr " + mdrVersion + " %c FlyingSky-CN/MDr %c \n",
    "color:#fff;background:#6cf;padding:5px 0;border: 1px solid #6cf;",
    "color:#6cf;background:none;padding:5px 0;border: 1px solid #6cf;",
    "");

const mdrScroll = () => {
    let header = $('header');
    if ($(document).scrollTop() > 0) {
        header.removeClass('mdui-shadow-0');
        header.css('background', getDarkModeFromDom() ? '#212121' : '#ffffff');
    } else {
        header.addClass('mdui-shadow-0');
        header.css('background', getDarkModeFromDom() ? '#121212' : '#ffffff');
    }
}

$(document).ready(mdrScroll);
$(document).scroll(mdrScroll);

window.onscroll = function () {
    var a = document.documentElement.scrollTop || document.body.scrollTop,
        b = document.getElementById("top");
    if (a >= 200) {
        b.classList.remove("mdui-fab-hide")
    } else {
        b.classList.add("mdui-fab-hide")
    }
    b.onclick = function totop() {
        var a = document.documentElement.scrollTop || document.body.scrollTop;
        if (a > 0) {
            requestAnimationFrame(totop);
            window.scrollTo(0, a - (a / 5))
        } else {
            cancelAnimationFrame(totop)
        }
    };
}


/**
 * Site Time
 */
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
 * MDr Catalog 
 */
window.onresize = () => {
    setTimeout('mdrTab.handleUpdate()', 500)
}
mdrTabDom.attr('style', 'margin-top: -48px');
mdrTab.show(0);
const mdrCatalog = (data) => {
    if (data === false || data === null) {
        mdrTab.show(0);
        mdrTabDom.attr('style', 'margin-top: -48px');
        return;
    }
    mdrTab.show(0);
    var list = mdui.$('#mdrDrawerLtoc .mdui-list');
    list.empty();
    data.forEach((value) => {
        var dom = mdui.$(document.createElement('a'));
        dom.addClass('mdui-list-item mdui-ripple');
        dom.addClass('mdui-p-l-' + Math.min(value.depth * 2, 5));
        dom.attr('href', '#cl-' + value.count);
        dom.html('<span>' + value.count + '</span><div class="mdui-text-truncate">' + value.text + '</div>');
        list.append(dom);
    })
    mdrTabDom.attr('style', 'margin-top: 0');
}

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