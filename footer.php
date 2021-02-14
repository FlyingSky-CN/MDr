<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<footer class="mdui-typo" style="margin-top: 32px;margin-bottom: 32px;">
    <!-- mdr | Copyright & Powered by -->
    &copy; <?php echo date('Y'); ?>
    <a href="<?php $this->options->siteUrl(); ?>"><?php ($this->options->mdrCopytext) ? $this->options->mdrCopytext() : $this->options->title() ?></a>.
    Powered by <a href="http://www.typecho.org" target="_blank">Typecho</a> & <a href="https://blog.fsky7.com/archives/60/">MDr</a>.<br>
    <?php if (!empty($this->options->ButtomText)) : ?>
        <!-- mdr | BottomText -->
        <?= $this->options->ButtomText ?>
    <?php endif; ?>
    <?php if ($this->options->mdrHitokoto) : ?>
        <!-- mdr | Hitokoto -->
        <span id="hitokoto">一言获取中...</span><br>
        <script src="https://v1.hitokoto.cn/?encode=js&c=<?php $this->options->mdrHitokotoc(); ?>&select=%23hitokoto" defer></script>
    <?php endif;  ?>
    <?php if ($this->options->SiteTime) : ?>
        <!-- mdr | SiteTime -->
        博客已上线 <span id="runtime_span"></span> .<br />
        <script>
            function show_runtime() {
                window.setTimeout("show_runtime()", 1000);
                var X = new Date("<?= $this->options->SiteTime ?>"),
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
            show_runtime();
        </script>
    <?php endif; ?>
    <?php if ($this->options->ICPbeian) : ?>
        <!-- mdr | ICPbeian -->
        <a href="http://beian.miit.gov.cn" target="_blank"><?= $this->options->ICPbeian ?></a>
    <?php endif; ?>
    <?php if ($this->options->beianProvince && $this->options->beianNumber) : ?>
        <!-- mdr | GWAB -->
        <a href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=<?= $this->options->beianNumber ?>" target="_blank"><?= $this->options->beianProvince ?>公网安备<?= $this->options->beianNumber ?>号</a>
        <img src="<?= mdrGWABlogo() ?>" style="box-shadow:none" alt="公网安备案图标">
    <?php endif; ?>
</footer>
</main>
<?php if (!MDR_PJAX) : ?>
    <button class="mdui-fab mdui-color-theme-accent mdui-fab-fixed mdui-ripple mdui-fab-hide" id="top">
        <i class="mdui-icon material-icons">keyboard_arrow_up</i>
    </button>
    <script src="<?= staticUrl('mdui.min.js') ?>"></script>
    <script>
        /* MDr Global JavaScript */
        console.log(
            "\n %c MDr <?= MDR_VERSION ?> %c FlyingSky-CN/MDr %c \n",
            "color:#fff;background:#6cf;padding:5px 0;border: 1px solid #6cf;",
            "color:#6cf;background:none;padding:5px 0;border: 1px solid #6cf;",
            "");
        const mdrSnackbar = '<?= $this->options->mdrSnackbar ?>';
        const mdrTab = new mdui.Tab('#mdrTab');
        const mdrTabDom = mdui.JQ('#mdrTab');
    </script>
    <script>
        /* MDr Catalog */
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
            var list = mdui.JQ('#mdrDrawerLtoc .mdui-list');
            list.empty();
            data.forEach((value) => {
                var dom = mdui.JQ(document.createElement('a'));
                dom.addClass('mdui-list-item mdui-ripple');
                dom.addClass('mdui-p-l-' + Math.min(value.depth * 2, 5));
                dom.attr('href', '#cl-' + value.count);
                dom.html('<span>' + value.count + '</span><div class="mdui-text-truncate">' + value.text + '</div>');
                list.append(dom);
            })
            mdrTabDom.attr('style', 'margin-top: 0');
        }
    </script>
    <?php if ($this->options->mdrQrCode) : ?>
        <!-- mdr | pageQrCode -->
        <div id="pageQrCode" class="mdui-menu" onclick="$('#pageQrCode').removeClass('mdui-menu-open')"></div>
    <?php endif; ?>
    <?php if ($this->user->hasLogin() && $this->user->pass('administrator', true) and null !== @$_GET['debug']) : ?>
        <script>
            var $$ = mdui.JQ;

            function mdrDebug() {
                $$.each($$('a[href]'), function(i, item) {
                    if (item.href.indexOf("?debug=true") == -1) {
                        item.href = item.href + '?debug=true'
                    }
                })
            }
        </script>
    <?php endif; ?>
    <?php if ($this->options->PjaxOption || $this->options->AjaxLoad || $this->options->ViewImg || $this->options->mdrQrCode) : ?>
        <!-- mdr | jQuery -->
        <script src="<?= staticUrl('jquery.min.js') ?>"></script>
    <?php endif;
    if ($this->options->ViewImg) : ?>
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
    <?php endif;
    if ($this->options->PjaxOption) : ?>
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
                        mdui.Drawer('#mdrDrawerR').close();
                    }
                    <?php if ($this->options->mdrQrCode) : ?>
                        getQrCode();
                    <?php endif;
                    if ($this->options->AjaxLoad) : ?>
                        al();
                    <?php endif; ?>
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
    <?php endif;
    if ($this->options->AjaxLoad) : ?>
        <!-- mdr | Ajax STR -->
        <script>
            var isbool = true;
            var autoloadtimes = 0;
            <?php if ($this->options->AjaxLoad == 'auto') : ?>
                $(window).scroll(function() {
                    <?php
                    $autoloadtimes = $this->options->AjaxLoadTimes;
                    if ($autoloadtimes == '0') {
                        $leavrolzzzz = "";
                        /**我命名废！**/
                    } else {
                        $leavrolzzzz = "&& autoloadtimes<" . $autoloadtimes;
                    }
                    ?>
                    if (isbool<?= $leavrolzzzz ?> && $('.ajaxload .next a').attr("href") && ($(this).scrollTop() + $(window).height() + 20) >= $(document).height()) {
                        isbool = false;
                        autoloadtimes++;
                        console.log('Autoload ' + autoloadtimes + ' times');
                        aln()
                    }
                });
            <?php endif; ?>

            function al() {
                $('.ajaxload li[class!="next"]').remove();
                $('.ajaxload .next a').click(function() {
                    if (isbool) {
                        aln()
                    }
                    return false
                })
            }
            al();

            function aln() {
                var a = '.ajaxload .next a',
                    b = $(a).attr("href");
                $(a).addClass('loading').text("正在加载");
                if (b) {
                    $.ajax({
                        url: b,
                        error: function() {
                            mdui.snackbar({
                                message: '请求失败，请检查网络并重试或者联系管理员。',
                                position: mdrSnackbar,
                                timeout: 3000
                            });
                            $(a).removeAttr("class").text("查看更多");
                            return false
                        },
                        success: function(d) {
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
        </script>
        <!-- mdr | Ajax END -->
    <?php endif; ?>
    <?php $this->footer(); ?>
    <?php if ($this->options->scrollTop) : ?>
        <!-- mdr | scrollTop -->
        <script>
            window.onscroll = function() {
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
        </script>
    <?php endif; ?>
    <?php if ($this->options->CustomContent) $this->options->CustomContent(); ?>
    <?php if ($this->options->mdrQrCode) : ?>
        <!-- mdr | mdrQrCode -->
        <script src="<?= staticUrl('jquery.qrcode.min.js') ?>"></script>
        <script>
            function getQrCode() {
                $('#pageQrCode').html('');
                $('#pageQrCode').qrcode({
                    width: 150,
                    height: 150,
                    text: window.location.href
                })
            }
            getQrCode();

            function switchQrCode() {
                if ($('#pageQrCode').hasClass('mdui-menu-open')) {
                    $('#pageQrCode').removeClass('mdui-menu-open')
                } else {
                    $('#pageQrCode').addClass('mdui-menu-open')
                }
            }
        </script>
    <?php endif;
    if ($this->options->DarkMode) : ?>
        <!-- mdr | DarkMode -->
        <script>
            const mdrDarkModeFD = '<?= ($this->options->DarkModeFD && $this->options->DarkModeDomain) ? "domain=" . $this->options->DarkModeDomain : '' ?>';
            const mdrThemeColor = '<?= $this->options->mdrChrome ? $this->options->mdrChrome : "#FFFFFF" ?>';
        </script>
        <script src="<?php cjUrl('js/darkmode.js') ?>"></script>
    <?php endif; ?>
    <?php if ($this->user->hasLogin() && $this->user->pass('administrator', true) and null !== @$_GET['debug']) : ?>
        <script>
            mdrDebug()
        </script>
    <?php endif; ?>
<?php endif; ?>
</body>

</html>
<?php /* mdr | HTML 压缩 */
if ($this->options->compressHtml) {
    $html_source = ob_get_contents();
    ob_clean();
    print compressHtml($html_source);
    ob_end_flush();
}
?>