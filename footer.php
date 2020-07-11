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
    <div class="mdui-fab-wrapper" mdui-fab="{trigger: 'hover'}">
        <button class="mdui-fab mdui-ripple mdui-color-theme-accent">
            <i class="mdui-icon material-icons">apps</i>
            <i class="mdui-icon mdui-fab-opened material-icons">close</i>
        </button>
        <div class="mdui-fab-dial" id="cornertool">
            <?php if ($this->options->scrollTop) : ?>
                <button class="mdui-fab mdui-ripple mdui-fab-mini mdui-color-white mdui-fab-hide" id="top"><i class="mdui-icon material-icons"></i></button>
            <?php endif;
            if ($this->options->DarkMode) : ?>
                <button class="mdui-fab mdui-ripple mdui-fab-mini mdui-color-white" onclick="switchDarkMode()"><i class="mdui-icon material-icons">brightness_4</i></button>
            <?php endif;
            if ($this->options->mdrQrCode) : ?>
                <button class="mdui-fab mdui-ripple mdui-fab-mini mdui-color-white mdui-fab-hide" onclick="switchQrCode()"><i class="mdui-icon material-icons">phonelink</i></button>
            <?php endif;
            if ($this->options->MusicSet && $this->options->MusicUrl) : ?>
                <button class="mdui-fab mdui-ripple mdui-fab-mini mdui-color-white">
                    <div class="hidden" id="music"><span><i></i></span>
                        <div class="mdui-icon material-icons">music_note</div><audio id="audio" preload="none"></audio>
                    </div>
                </button>
            <?php endif; ?>
        </div>
    </div>
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
        mdrTabDom.attr('style', 'margin-top: -48px');
        mdrTab.show(0);
        const mdrCatalog = (data) => {
            if (data === false) {
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
                dom.addClass('mdui-p-l-' + ((value.depth * 2 < 5) ? (value.depth * 2) : 5));
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
                    cl();
                    ac();
                    ap();
                    <?php if ($this->options->CustomContent) : ?>
                        if (typeof _hmt !== 'undefined') {
                            _hmt.push(['_trackPageview', location.pathname + location.search])
                        };
                        if (typeof ga !== 'undefined') {
                            ga('send', 'pageview', location.pathname + location.search)
                        }
                        /**TODO gtag.js 的回调 #28 */
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
            var protoken = '<?php echo Typecho_Widget::widget('Widget_Security')->getTokenUrl('Token'); ?>'.replace('Token', "");

            function ap() {
                $('.protected .post-title a, .protected .more a').click(function() {
                    var a = $(this).parent().parent();
                    a.find('.word').text("请输入密码访问").css('color', 'red').Shake(2, 10);
                    a.find(':password').focus();
                    return false
                });
                $('.protected form').submit(function() {
                    ap_btn = $(this);
                    ap_m = ap_btn.parent().find('.more a');
                    ap_n = ap_btn.find('.word');
                    $(ap_m).addClass('loading').text("请稍等");
                    <?php if (!$this->options->AjaxLoad) : ?>
                        apt();
                    <?php else : ?>
                        aps();
                    <?php endif; ?>
                    return false
                })
            }
            ap();
            <?php if (!$this->options->AjaxLoad) : ?>

                function apt() {
                    var b = $('.protected .post-title a').attr("href");
                    if ($('h1.post-title').length) {
                        aps()
                    } else {
                        $.ajax({
                            url: window.location.href,
                            success: function(d) {
                                protoken = $('.protected form[action^="' + b + '"]', d).attr("action").replace(b, "");
                                if (protoken) {
                                    aps()
                                } else {
                                    $(ap_m).removeAttr("class").text("- 阅读全文 -");
                                    mdui.snackbar({
                                        message: '提交失败，请检查网络并重试或者联系管理员。',
                                        position: mdrSnackbar,
                                        timeout: 3000
                                    });
                                    ap_n.text("提交失败，请检查网络并重试或者联系管理员。").css('color', 'red').Shake(2, 10);
                                    return false
                                }
                            }
                        })
                    }
                }
            <?php endif; ?>

            function aps() {
                var c = ap_btn.parent().parent().find('.post-title a').attr("href");
                $.ajax({
                    url: c + protoken,
                    type: 'post',
                    data: ap_btn.serializeArray(),
                    error: function() {
                        $(ap_m).removeAttr("class").text("- 阅读全文 -");
                        mdui.snackbar({
                            message: '提交失败，请检查网络并重试或者联系管理员。',
                            position: mdrSnackbar,
                            timeout: 3000
                        });
                        ap_n.text("提交失败，请检查网络并重试或者联系管理员。").css('color', 'red').Shake(2, 10);
                        return false
                    },
                    success: function(d) {
                        if (!$('h1.post-title', d).length) {
                            $(ap_m).removeAttr("class").text("- 阅读全文 -");
                            mdui.snackbar({
                                message: '对不起,您输入的密码错误。',
                                position: mdrSnackbar,
                                timeout: 3000
                            });
                            ap_n.text("对不起,您输入的密码错误。").css('color', 'red').Shake(2, 10);
                            $(":password").val("");
                            return false
                        } else {
                            $(ap_m).removeAttr("class").text("- 阅读全文 -");
                            $('h1.post-title').length ? $.pjax.reload({
                                container: '#main',
                                fragment: '#main',
                                timeout: 10000
                            }) : $.pjax({
                                url: c,
                                container: '#main',
                                fragment: '#main',
                                timeout: 10000
                            })
                        }
                    }
                })
            }
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
                                ap()
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
    <?php endif;
    if ($this->options->MusicSet && $this->options->MusicUrl) : ?>
        <script>
            (function() {
                var a = document.getElementById("audio");
                var b = document.getElementById("music");
                var c = <?php Playlist() ?>;
                <?php if ($this->options->MusicVol) : ?>
                    var d = <?php $this->options->MusicVol(); ?>;
                    if (d >= 0 && d <= 1) {
                        a.volume = d
                    }
                <?php endif; ?>
                a.src = c.shift();
                a.addEventListener('play', g);
                a.addEventListener('pause', h);
                a.addEventListener('ended', f);
                a.addEventListener('error', f);
                a.addEventListener('canplay', j);

                function f() {
                    if (!c.length) {
                        a.removeEventListener('play', g);
                        a.removeEventListener('pause', h);
                        a.removeEventListener('ended', f);
                        a.removeEventListener('error', f);
                        a.removeEventListener('canplay', j);
                        b.style.display = "none";
                        mdui.snackbar({
                            message: '本站的背景音乐好像有问题了，希望您可以通过留言等方式通知管理员，谢谢您的帮助。',
                            position: mdrSnackbar,
                            timeout: 5000
                        });
                    } else {
                        a.src = c.shift();
                        a.play()
                    }
                }

                function g() {
                    b.setAttribute("class", "play");
                    a.addEventListener('timeupdate', k)
                }

                function h() {
                    b.removeAttribute("class");
                    a.removeEventListener('timeupdate', k)
                }

                function j() {
                    c.push(a.src)
                }

                function k() {
                    b.getElementsByTagName("i")[0].style.height = (a.currentTime / a.duration * 100).toFixed(1) + "%"
                }
                b.onclick = function() {
                    if (a.canPlayType('audio/mpeg') != "" || a.canPlayType('audio/ogg;codes="vorbis"') != "" || a.canPlayType('audio/mp4;codes="mp4a.40.5"') != "") {
                        if (a.paused) {
                            if (a.error) {
                                f()
                            } else {
                                a.play()
                            }
                        } else {
                            a.pause()
                        }
                    } else {
                        mdui.snackbar({
                            message: '对不起，您的浏览器不支持HTML5音频播放，请升级您的浏览器。',
                            position: mdrSnackbar,
                            timeout: 5000
                        });
                    }
                };
                b.removeAttribute("class")
            })();
        </script>
    <?php endif; ?>
    <?php if ($this->options->CustomContent) $this->options->CustomContent(); ?>
    <script>
        var cornertool = true;

        function cl() {
            var a = document.getElementById("catalog-col"),
                b = document.getElementById("catalog"),
                c = document.getElementById("cornertool"),
                d;
            if (a && !b) {
                d = document.createElement("button");
                d.setAttribute("id", "catalog");
                d.setAttribute("onclick", "Catalogswith()");
                d.setAttribute("class", "mdui-fab mdui-ripple mdui-fab-mini mdui-color-white");
                d.innerHTML = '<i class="mdui-icon material-icons">&#xe5d2;</i>';
                c.appendChild(d);
            }
            if (!a && b) {
                cornertool ? c.removeChild(b) : document.body.removeChild(c)
            }
        }
        cl();
    </script>
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
            const mdrAccent = 'mdui-theme-accent-<?= $this->options->mdrAccent ?>';
            const mdrAccentD = 'mdui-theme-accent-<?= $this->options->mdrAccentD ?>';
        </script>
        <script src="<?php cjUrl('darkmode.js') ?>"></script>
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