/**
 * MDr Dark Mode
 * 
 * @author FlyingSky-CN
 * @link https://blog.skk.moe/post/hello-darkmode-my-old-friend
 * @link https://blog.fsky7.com/archives/46
 */

/**
 * 从 CSS 媒体查询获取
 * 是否为 Dark Mode
 */
const getDarkModeFromCSSMediaQuery = () => {
    return window.matchMedia('(prefers-color-scheme: dark)').matches ? true : false
}

/**
 * 从 Cookie 获取
 * 是否为 Dark Mode
 */
const getDarkModeFromCookie = () => {
    var cookie = document.cookie.replace(/(?:(?:^|.*;\s*)dark\s*\=\s*([^;]*).*$)|^.*$/, "$1");
    if (cookie === "0") {
        return false
    } else if (cookie === "1") {
        return true
    } else return null
}

/**
 * 从当前页面 Dom 获取
 * 是否为 Dark Mode
 */
const getDarkModeFromDom = () => {
    return mdui.$('body').hasClass('mdui-theme-layout-dark')
}

/**MDr On DarkMode */
const onDarkMode = () => {
    var body = mdui.$('body'),
        appbar = document.getElementsByClassName('mdui-appbar')[0];
    console.log('Dark mode on');
    document.cookie = "dark=1;path=/;" + mdrDarkModeFD;
    body.addClass('mdui-theme-layout-dark');
    appbar.style.backgroundColor = '#212121';
    var meta = document.getElementsByTagName('meta');
    meta["theme-color"].setAttribute('content', '#212121');
}

/**MDr Off Darkmode */
const offDarkMode = () => {
    var body = mdui.$('body'),
        appbar = document.getElementsByClassName('mdui-appbar')[0];
    console.log('Dark mode off');
    document.cookie = "dark=0;path=/;" + mdrDarkModeFD;
    body.removeClass('mdui-theme-layout-dark');
    appbar.style.backgroundColor = '#ffffff';
    var meta = document.getElementsByTagName('meta');
    meta["theme-color"].setAttribute('content', mdrThemeColor);
}

/* Dark Mode 对于 @print 的适配 */
window.addEventListener("beforeprint", function () {
    var body = mdui.$('body'),
        appbar = mdui.$('.mdui-appbar');
    appbar.hide();
    if (body.hasClass('mdui-theme-layout-dark')) {
        body.addClass('mdui-theme-layout-dark-print');
        body.removeClass('mdui-theme-layout-dark')
    }
});
window.addEventListener("afterprint", function () {
    var body = mdui.$('body'),
        appbar = mdui.$('.mdui-appbar');
    appbar.show();
    if (body.hasClass('mdui-theme-layout-dark-print')) {
        body.addClass('mdui-theme-layout-dark');
        body.removeClass('mdui-theme-layout-dark-print')
    }
});

/**初始化 DarkMode */
const initDarkMode = () => {
    var css = getDarkModeFromCSSMediaQuery(),
        coo = getDarkModeFromCookie();
    if (css === coo) {
        applyDarkMode(css)
    } else if (coo === null) {
        applyDarkMode(css)
    } else {
        applyDarkMode(coo)
    }
}

/**应用模式 */
const applyDarkMode = (mode) => {
    if (mode === true) {
        onDarkMode();
    } else if (mode === false) {
        offDarkMode();
    } else return;
}

/**切换 Dark Mode */
const toggleDarkMode = () => {
    var dom = getDarkModeFromDom(),
        mode = dom ? false : true;
    applyDarkMode(mode)
}

/**切换标签页 */
document.addEventListener('visibilitychange', function () {
    initDarkMode();
});

/**当用户点击按钮时切换显示模式 */
document.getElementById('mdrDarkMode').addEventListener('click', () => {
    toggleDarkMode()
})

initDarkMode()
