<?php

define('MDR_CONFIG', [
    'DarkMode' => 1, // 黑暗模式总开关，1（开启）| 0（关闭）。
    'DarkModeFD' => 0, // 黑暗模式跨域使用开关，1（开启）| 0（关闭）。
    'DarkModeDomain' => null, // 黑暗模式跨域使用总域名。
    'mdrCornertool' => false, // 界面滚动条，true | false 。
    'mdrSnackbar' => 'right-bottom', // Snackbar 位置，即所谓的 “通知系统” 弹出的通知的位置，bottom | top | [left|right]-[bottom|top] 。
    'mdrLoading' => 'top', // Ajax 加载条位置，top | bottom 。
    'customTitle' => null, // 自定义头部站点标题，仅在页面头部标题位置显示，和 Typecho 后台设置的站点名称不冲突，留空则显示默认站点名称。
    'mdrCopytext' => null, // 自定义底部版权所属，默认为站点名称。
    'mdrMDUICDNlink' => null, // MDUI 静态资源自建地址，只在上面的选项选择自建时需要。
    'mdrcjCDNlink' => null, // 其他公共静态资源自建地址，只在上面的选项选择自建时需要。
    'mdrSponsor' => [
        //['爱发电', 'deep-purple-accent', 'https://afdian.net'],
    ], //参照上述格式
    'mdrSiteArchived' => false,
]);
