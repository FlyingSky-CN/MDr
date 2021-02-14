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