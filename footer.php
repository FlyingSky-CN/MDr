<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<footer class="mdui-typo mdui-m-y-5">
    <?php if (!empty($this->options->ButtomText)) echo $this->options->ButtomText . '<br />'; ?>
    <?php if ($this->options->mdrHitokoto) : ?>
        <span id="hitokoto">一言获取中...</span><br>
        <script src="https://v1.hitokoto.cn/?encode=js&c=<?php $this->options->mdrHitokotoc(); ?>&select=%23hitokoto" defer></script>
    <?php endif;  ?>
    <?php if ($this->options->SiteTime) : ?>
        博客已上线 <span id="runtime_span"></span><br />
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
<?php if (!MDR_PJAX) : ?>
    <button class="mdui-fab mdui-color-theme-accent mdui-fab-fixed mdui-ripple mdui-fab-hide" id="top">
        <i class="mdui-icon material-icons">keyboard_arrow_up</i>
    </button>
    <script src="<?= staticUrl('mdui.min.js') ?>"></script>
    <script>
        const mdrVersion = '<?= MDR_VERSION ?>';
        const mdrSnackbar = '<?= $this->options->mdrSnackbar ?>';
        const mdrTab = new mdui.Tab('#mdrTab');
        const mdrTabDom = mdui.$('#mdrTab');
        const mdrAjaxLoadTimes = <?= $this->options->AjaxLoadTimes ?>;
    </script>
    <?php if ($this->user->hasLogin() && $this->user->pass('administrator', true) and null !== @$_GET['debug']) : ?>
        <script>
            var $$ = mdui.$;

            function mdrDebug() {
                $$.each($$('a[href]'), function(i, item) {
                    if (item.href.indexOf("?debug=true") == -1) {
                        item.href = item.href + '?debug=true'
                    }
                })
            }
        </script>
    <?php endif; ?>
    <!-- mdr | jQuery -->
    <script src="<?= staticUrl('jquery.min.js') ?>"></script>
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
            jQuery.fn.Shake = function(n, d) {
                this.each(function() {
                    $(this).css({
                        position: 'relative'
                    });
                    for (var x = 1; x <= n; x++) {
                        $(this)
                            .animate({
                                left: (-d)
                            }, 50)
                            .animate({
                                left: d
                            }, 50)
                            .animate({
                                left: 0
                            }, 50)
                    }
                });
                return this
            };
        </script>
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
                    $('#loading').fadeIn();
                })
                .on('pjax:beforeReplace', function() {
                    mdrCatalog(false);
                })
                .on('pjax:complete', function() {
                    setTimeout(function() {
                        $("#loading").fadeOut()
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
                    <?php if ($this->user->hasLogin() && $this->user->pass('administrator', true) and null !== @$_GET['debug']) : ?>
                        mdrDebug();
                    <?php endif; ?>
                });

            function ac() {
                $body = $('html,body');
                var g = '.comment-list',
                    h = '.comment-num',
                    i = '.comment-reply a',
                    j = '#textarea',
                    k = '',
                    l = '';
                c();
                $('#comment-form').submit(function() {
                    var ar = $(this).serializeArray();
                    console.log(ar);
                    mdui.snackbar({
                        message: '评论正在发送中...',
                        position: mdrSnackbar,
                        timeout: 5000
                    });
                    if (ar[1]) {
                        if (ar[1]['name'] == 'parent') {
                            l = 'comment-' + ar[1]['value'];
                        }
                    }
                    $.ajax({
                        url: $(this).attr('action'),
                        type: 'post',
                        data: ar,
                        error: function() {
                            mdui.snackbar({
                                message: '提交失败，请检查网络并重试或者联系管理员。',
                                position: mdrSnackbar,
                                timeout: 5000
                            });
                            return false
                        },
                        success: function(d) {
                            if (!$(g, d).length) {
                                mdui.snackbar({
                                    message: '您输入的内容不符合规则或者回复太频繁，请修改内容或者稍等片刻。',
                                    position: mdrSnackbar,
                                    timeout: 5000
                                });
                                return false
                            } else {
                                k = $(g, d).html().match(/id=\"?comment-\d+/g).join().match(/\d+/g).sort(function(a, b) {
                                    return a - b
                                }).pop();
                                if ($('.page-navigator .prev').length && l == "") {
                                    k = ''
                                }
                                if (l) {
                                    d = $('#comment-' + k, d).hide();
                                    if ($('#' + l).find(".comment-children").length <= 0) {
                                        $('#' + l).append("<div class='comment-children' style='padding: 0px 8px;'><ol class='comment-list'><\/ol><\/div>")
                                    }
                                    if (k) $('#' + l + " .comment-children .comment-list").prepend(d);
                                    l = ''
                                } else {
                                    d = $('#comment-' + k, d).hide();
                                    if (!$(g).length) $('#comments').prepend("<h3>已有 <span class='comment-num'>0<\/span> 条评论<\/h3><ol class='comment-list'><\/ol>");
                                    $(g).prepend(d)
                                }
                                $('#comment-' + k).fadeIn();
                                var f;
                                $(h).length ? (f = parseInt($(h).text().match(/\d+/)), $(h).html($(h).html().replace(f, f + 1))) : 0;
                                TypechoComment.cancelReply();
                                $(j).val('');
                                $(i + ', #cancel-comment-reply-link').unbind('click');
                                c();
                                mdui.snackbar({
                                    message: '评论已发送。',
                                    position: mdrSnackbar,
                                    timeout: 5000
                                });
                                if (k) {
                                    $body.animate({
                                            scrollTop: $('#comment-' + k).offset().top - 72
                                        },
                                        300)
                                } else {
                                    $body.animate({
                                            scrollTop: $('#comments').offset().top - 72
                                        },
                                        300)
                                }
                            }
                        }
                    });
                    return false
                });

                function c() {
                    $(i).click(function() {
                        l = $(this).parent().parent().parent().attr("id");
                        $(j).focus()
                    });
                    $('#cancel-comment-reply-link').click(function() {
                        l = ''
                    })
                }
            }
            ac();

            function ap() {
                $('form.protected').submit(() => {
                    token = $('form.protected').attr('action');
                    ap_n = $('form.protected  .word');
                    $.ajax({
                        url: token,
                        type: 'post',
                        data: $('form.protected').serializeArray(),
                        error: function() {
                            mdui.snackbar({
                                message: '提交失败，请检查网络并重试或者联系管理员。',
                                position: mdrSnackbar,
                                timeout: 3000
                            });
                            ap_n.text("提交失败，请检查网络并重试或者联系管理员。").css('color', 'red').Shake(2, 10);
                            return false
                        },
                        success: function(d) {
                            if (!$('#post', d).length) {
                                mdui.snackbar({
                                    message: '对不起,您输入的密码错误。',
                                    position: mdrSnackbar,
                                    timeout: 3000
                                });
                                ap_n.text("对不起,您输入的密码错误。").css('color', 'red').Shake(2, 5);
                                $(":password").val("");
                                return false
                            } else $.pjax.reload({
                                container: '#main',
                                fragment: '#main',
                                timeout: 10000
                            })
                        }
                    })
                    return false
                })
            }
            ap();
        </script>
        <!-- mdr | Pjax END -->
    <?php endif; ?>
    <?php $this->footer(); ?>
    <?php if ($this->options->CustomContent) $this->options->CustomContent(); ?>
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
        <script src="<?php cjUrl('js/darkmode.js?v=petals-dev-2') ?>"></script>
    <?php endif; ?>
    <?php if ($this->user->hasLogin() && $this->user->pass('administrator', true) and null !== @$_GET['debug']) : ?>
        <script>
            mdrDebug();
        </script>
    <?php endif; ?>
    <script src="<?= cjUrl('js/script.js?v=petals-dev-2' . (MDR_DEBUG ? '&ts=' . time() : '')) ?>"></script>
<?php endif; ?>
</body>

</html>
<?php /* mdr | HTML 压缩 */
if ($this->options->compressHtml) {
    return;
    /**
     * 请注意，该功能与 JavaScript 冲突，待修复。
     */
    $html_source = ob_get_contents();
    ob_clean();
    print compressHtml($html_source);
    ob_end_flush();
}
?>