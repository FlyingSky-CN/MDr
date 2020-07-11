/**Attention: Dark Mode 不使用 jQuery 库 */
function onDarkMode() {
    var body = mdui.JQ('body'),
        appbar = document.getElementsByClassName('mdui-appbar')[0];
    console.log('Dark mode on');
    document.cookie = "dark=1;path=/;" + mdrDarkModeFD;
    body.addClass('mdui-theme-layout-dark');
    body.removeClass(mdrAccent);
    body.addClass(mdrAccentD);
    appbar.style.backgroundColor = '#212121';
    var meta = document.getElementsByTagName('meta');
    meta["theme-color"].setAttribute('content', '#212121');
}

function offDarkMode() {
    var body = mdui.JQ('body'),
        appbar = document.getElementsByClassName('mdui-appbar')[0];
    console.log('Dark mode off');
    document.cookie = "dark=0;path=/;" + mdrDarkModeFD;
    body.removeClass('mdui-theme-layout-dark');
    body.removeClass(mdrAccentD);
    body.addClass(mdrAccent);
    appbar.style.backgroundColor = '#ffffff';
    var meta = document.getElementsByTagName('meta');
    meta["theme-color"].setAttribute('content', mdrThemeColor);
}
/* Dark Mode 对于 @print 的适配 */
window.addEventListener("beforeprint", function () {
    var body = mdui.JQ('body'),
        appbar = mdui.JQ('.mdui-appbar');
    appbar.hide();
    if (body.hasClass('mdui-theme-layout-dark')) {
        body.addClass('mdui-theme-layout-dark-print');
        body.removeClass('mdui-theme-layout-dark')
    }
});
window.addEventListener("afterprint", function () {
    var body = mdui.JQ('body'),
        appbar = mdui.JQ('.mdui-appbar');
    appbar.show();
    if (body.hasClass('mdui-theme-layout-dark-print')) {
        body.addClass('mdui-theme-layout-dark');
        body.removeClass('mdui-theme-layout-dark-print')
    }
});
/* Dark Mode 的控制（系统黑暗模式优先于 Cookie 中的黑暗模式） */
function switchDarkMode() {
    /* 手动触发 */
    var night = document.cookie.replace(/(?:(?:^|.*;\s*)dark\s*\=\s*([^;]*).*$)|^.*$/, "$1") || '0';
    if (night == '0') {
        onDarkMode();
        mdui.snackbar({
            message: '已开启 Dark Mode ，早 6 点之前保持开启。',
            position: mdrSnackbar,
            timeout: 1000
        });
    } else {
        offDarkMode();
        mdui.snackbar({
            message: '已关闭 Dark Mode ',
            position: mdrSnackbar,
            timeout: 1000
        });
    }
}
(function () {
    /* 加载完触发，判断时间段（当系统开启黑暗模式时不执行） */
    if (getComputedStyle(document.documentElement).getPropertyValue('content') != '"dark"') {
        if (document.cookie.replace(/(?:(?:^|.*;\s*)dark\s*\=\s*([^;]*).*$)|^.*$/, "$1") === '') {
            if (new Date().getHours() > 22 || new Date().getHours() < 6) {
                onDarkMode();
            } else {
                offDarkMode();
            }
        } else {
            var dark = document.cookie.replace(/(?:(?:^|.*;\s*)dark\s*\=\s*([^;]*).*$)|^.*$/, "$1") || '0';
            if (dark == '0') {
                offDarkMode();
            } else if (dark == '1') {
                onDarkMode();
            }
        }
    }
})();
document.addEventListener('visibilitychange', function () {
    /* 切换标签页时触发 */
    var dark = document.cookie.replace(/(?:(?:^|.*;\s*)dark\s*\=\s*([^;]*).*$)|^.*$/, "$1") || '0';
    if (dark == '0') {
        offDarkMode();
        if (getComputedStyle(document.documentElement).getPropertyValue('content') == '"dark"') {
            onDarkMode();
            mdui.snackbar({
                message: '已开启 Dark Mode ，跟随系统。',
                position: mdrSnackbar,
                timeout: 1000
            });
        };
    } else if (dark == '1') {
        onDarkMode();
    }
});
if (getComputedStyle(document.documentElement).getPropertyValue('content') == '"dark"') {
    var dark = document.cookie.replace(/(?:(?:^|.*;\s*)dark\s*\=\s*([^;]*).*$)|^.*$/, "$1") || '0';
    /* 加载完触发，判断系统黑暗模式是否开启 */
    if (dark == '0') {
        onDarkMode();
        mdui.snackbar({
            message: '已开启 Dark Mode ，跟随系统。',
            position: mdrSnackbar,
            timeout: 1000
        });
    }
};
window.matchMedia('(prefers-color-scheme: dark)').addEventListener("change", (e) => {
    /* 系统黑暗模式切换时触发 */
    if (e.matches) {
        onDarkMode();
        mdui.snackbar({
            message: '已开启 Dark Mode ，跟随系统。',
            position: mdrSnackbar,
            timeout: 1000
        });
    } else {
        var night = document.cookie.replace(/(?:(?:^|.*;\s*)dark\s*\=\s*([^;]*).*$)|^.*$/, "$1") || '0';
        if (night == '1') {
            offDarkMode();
            mdui.snackbar({
                message: '已关闭 Dark Mode ',
                position: mdrSnackbar,
                timeout: 1000
            });
        }
    }
});