<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<footer class="mdui-typo mdui-m-y-5">
    <?php if (!empty($this->options->ButtomText)) echo $this->options->ButtomText . '<br />'; ?>
    <?php if ($this->options->mdrHitokoto) : ?>
        <span id="hitokoto"><?=_t('一言获取中……')?></span><br>
        <script src="https://v1.hitokoto.cn/?encode=js&c=<?php $this->options->mdrHitokotoc(); ?>&select=%23hitokoto" defer></script>
    <?php endif;  ?>
    <?php if ($this->options->SiteTime) : ?>
        <?=_t('博客已上线')?> <span id="runtime_span"></span><br />
        <script>
            const mdrSiteTime = '<?= $this->options->SiteTime ?>';
        </script>
    <?php endif; ?>
    <br />&copy; <?php echo date('Y'); ?>
    <a href="<?php $this->options->siteUrl(); ?>"><?php ($this->options->mdrCopytext) ? $this->options->mdrCopytext() : $this->options->title() ?></a>.
    Powered by <a href="http://www.typecho.org" target="_blank">Typecho</a>.
    Theme <a href="https://github.com/FlyingSky-CN/MDr/tree/petals-dev">MDr-Petals</a> by <a href="https://fsky7.com">FlyingSky</a>.<br>
</footer>
</main>
<?php if (!MDR_PJAX) : /** 如果是 PJAX 请求则可以跳过这部分 */ ?>
    <button class="mdui-fab mdui-color-theme-accent mdui-fab-fixed mdui-ripple mdui-fab-hide" id="top">
        <i class="mdui-icon material-icons">&#xe316;</i>
    </button>
    <script src="<?= staticUrl('mdui.min.js') ?>"></script>
    <script>
        const mdrVersion = '<?= MDR_VERSION ?>';
        const mdrSnackbar = '<?= $this->options->mdrSnackbar ?>';
        const mdrTab = new mdui.Tab('#mdrTab');
        const mdrTabDom = mdui.$('#mdrTab');
        const mdrAjaxLoadTimes = <?= $this->options->AjaxLoadTimes ?>;
    </script>
    <!-- mdr | jQuery -->
    <script src="<?= staticUrl('jquery.min.js') ?>"></script>
    <script src="<?= cjUrl('js/script.js?v=' . str_replace(' ', '-', strtolower(MDR_VERSION)) . (MDR_DEBUG ? '&ts=' . time() : '')) ?>"></script>
    <?php if ($this->options->ViewImg) : ?>
        <!-- mdr | FancyBox -->
        <script src="<?= staticUrl('jquery.fancybox.min.js') ?>"></script>
        <script>
            function mdrfa() {
                $('#post .mdui-card-content img').each(function() {
                    $(this).before('<div data-fancybox="gallery" href="' + $(this).attr('src') + '"><img src="' + $(this).attr('src') + '" alt="' + $(this).attr('alt') + '" title="' + $(this).attr('title') + '"></div>');
                    $(this).remove()
                });
                $.fancybox.defaults.buttons = ["zoom", "download", "thumbs", "close"]
            }
            mdrfa();
        </script>
    <?php endif; ?>
    <?php if ($this->options->PjaxOption) : ?>
        <!-- mdr | Pjax STR -->
        <script src="<?= staticUrl('jquery.pjax.min.js') ?>"></script>
        <script>
            $(document).pjax('a[target!=_blank]', {
                    container: '#main',
                    fragment: '#main',
                    timeout: 10000
                })
                .on('submit', 'form[id=search], form[id=comment-form]', function(event) {
                    $.pjax.submit(event, {
                        container: '#main',
                        fragment: '#main',
                        timeout: 10000
                    })
                })
                .on('pjax:send', function() {
                    $('#mdr-loading').fadeIn();
                })
                .on('pjax:beforeReplace', function() {
                    mdrCatalog(false);
                })
                .on('pjax:complete', function() {
                    setTimeout(function() {
                        $("#mdr-loading").fadeOut()
                    }, 300);
                    $('#header').removeClass("on");
                    $('#s').val("");
                    $("#top").addClass("mdui-fab-hide");
                })
                .on('pjax:end', function() {
                    mdui.mutation();
                    if (document.body.clientWidth < 1024) {
                        mdui.Drawer('#mdrDrawerL').close();
                    }
                    <?php if ($this->options->mdrQrCode) : ?>
                        genQrCode();
                    <?php endif; ?>
                    al();
                    ac();
                    ap();
                    <?php if ($this->options->CustomContent) : ?>
                        if (typeof _hmt !== 'undefined') {
                            _hmt.push(['_trackPageview', location.pathname + location.search])
                        };
                        if (typeof ga !== 'undefined') {
                            ga('send', 'pageview', location.pathname + location.search)
                        }
                        if (typeof gtag !== 'undefined') {
                            gtag('event', 'page_view', {
                                page_location: location.href,
                                page_path: location.pathname + location.search,
                                page_title: document.title
                            })
                        }
                    <?php endif;
                    if ($this->options->ViewImg) : ?>
                        mdrfa();
                    <?php endif; ?>
                    <?php if (null !== @$_GET['debug'] and $this->user->hasLogin() && $this->user->pass('administrator', true)) : ?>
                        mdrDebug();
                    <?php endif; ?>
                });
            ac();
            ap();
        </script>
        <!-- mdr | Pjax END -->
    <?php endif; ?>
    <?php if ($this->options->mdrQrCode) : ?>
        <!-- mdr | mdrQrCode -->
        <script src="<?= staticUrl('jquery.qrcode.min.js') ?>"></script>
        <script>
            new mdui.Menu('#switchQrCode', '#mdrQrCode', {
                position: "bottom",
                align: "right",
            });

            function genQrCode() {
                $('#mdrQrCode').html('');
                $('#mdrQrCode').qrcode({
                    width: 150,
                    height: 150,
                    text: window.location.href
                })
            }
            genQrCode();
        </script>
    <?php endif; ?>
    <?php if ($this->options->DarkMode) : ?>
        <!-- mdr | DarkMode -->
        <script>
            const mdrDarkModeFD = '<?= ($this->options->DarkModeFD && $this->options->DarkModeDomain) ? "domain=" . $this->options->DarkModeDomain : '' ?>';
            const mdrThemeColor = '<?= $this->options->mdrChrome ? $this->options->mdrChrome : "#FFFFFF" ?>';
        </script>
        <script src="<?php cjUrl('js/darkmode.js?v=' . str_replace(' ', '-', strtolower(MDR_VERSION)) . (MDR_DEBUG ? '&ts=' . time() : '')) ?>"></script>
    <?php endif; ?>
    <?php $this->footer(); ?>
    <?php if ($this->options->CustomContent) $this->options->CustomContent(); ?>
    <?php if (null !== @$_GET['debug'] and $this->user->hasLogin() && $this->user->pass('administrator', true)) : ?>
        <script>
            function mdrDebug() {
                mdui.$.each($$('a[href]'), function(i, item) {
                    if (item.href.indexOf("?debug=true") == -1) {
                        item.href = item.href + '?debug=true'
                    }
                })
            }
            mdrDebug();
        </script>
    <?php endif; ?>
<?php endif; ?>
</body>

</html>