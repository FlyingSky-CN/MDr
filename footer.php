<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
	<div class="mdui-typo" style="margin-top: 32px;margin-bottom: 32px;">
		<!-- mdr | Copyright & Powered by -->
		&copy; <?php echo date('Y'); ?> <a href="<?php $this->options->siteUrl(); ?>"><?php if ($this->options->mdrCopytext): $this->options->mdrCopytext(); else: $this->options->title(); endif; ?></a>. Powered by <a href="http://www.typecho.org" target="_blank">Typecho</a> & <a href="https://blog.fsky7.com/archives/60/">MDr</a>.<br>
		<?php if (!empty($this->options->ButtomText)): ?>
		<!-- mdr | BottomText -->
		<?=$this->options->ButtomText?>
		<?php endif; ?>
		<?php if ($this->options->mdrHitokoto): ?>
		<!-- mdr | Hitokoto -->
		<span id="hitokoto">一言获取中...</span><br>
		<script src="https://v1.hitokoto.cn/?encode=js&c=<?php $this->options->mdrHitokotoc(); ?>&select=%23hitokoto" defer></script>
		<?php endif;  ?>
		<?php if ($this->options->SiteTime): ?>
		<!-- mdr | SiteTime -->
		博客已上线 <span id="runtime_span"></span> .<br/>
		<script>
			function show_runtime() {
				window.setTimeout("show_runtime()",1000);
				var X = new Date("<?=$this->options->SiteTime?>"),
					Y = new Date(),
					T = (Y.getTime()-X.getTime()),
					M = 24*60*60*1000,
					a = T/M,
					A = Math.floor(a),
					b = (a-A)*24,
					B = Math.floor(b),
					c = (b-B)*60,
					C = Math.floor((b-B)*60),
					D = Math.floor((c-C)*60);
				runtime_span.innerHTML = A+" 天 "+B+" 时 "+C+" 分 "+D+" 秒";
			}
			show_runtime();
		</script>
		<?php endif; ?>
		<?php if ($this->options->ICPbeian): ?>
		<!-- mdr | ICPbeian -->
		<a href="http://beian.miit.gov.cn" target="_blank"><?php $this->options->ICPbeian(); ?></a> 
		<?php endif; ?>
		<?php if (($this->options->beianProvince) && ($this->options->beianNumber)): ?>
		<!-- mdr | GWAB -->
		<a href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=<?php $this->options->beianNumber(); ?>" target="_blank"><?php $this->options->beianProvince(); ?>公网安备<?php $this->options->beianNumber(); ?>号</a> 
		<img src="<?=mdrGWABlogo()?>" style="box-shadow:none" alt="公网安备案图标">
		<?php endif; ?>
	</div>
</div>
<div class="mdui-fab-wrapper" mdui-fab="{trigger: 'hover'}">
  	<button class="mdui-fab mdui-ripple mdui-color-theme-accent">
    	<i class="mdui-icon material-icons">apps</i>
    	<i class="mdui-icon mdui-fab-opened material-icons">close</i>
  	</button>
  	<div class="mdui-fab-dial" id="cornertool">
	  	<?php if ($this->options->scrollTop): ?>
		<button class="mdui-fab mdui-ripple mdui-fab-mini mdui-color-white mdui-fab-hide" id="top"><i class="mdui-icon material-icons"></i></button>
		<?php endif; ?>
		<?php if ($this->options->DarkMode): ?>
		<button class="mdui-fab mdui-ripple mdui-fab-mini mdui-color-white" onclick="switchDarkMode()"><i class="mdui-icon material-icons">brightness_4</i></button>
		<?php endif; ?>
		<?php if ($this->options->mdrQrCode): ?>
		<button class="mdui-fab mdui-ripple mdui-fab-mini mdui-color-white mdui-fab-hide" onclick="switchQrCode()"><i class="mdui-icon material-icons">phonelink</i></button>
		<?php endif; ?>
		<?php if ($this->options->MusicSet && $this->options->MusicUrl): ?>
		<button class="mdui-fab mdui-ripple mdui-fab-mini mdui-color-white"><div class="hidden" id="music"><span><i></i></span><div class="mdui-icon material-icons">music_note</div><audio id="audio" preload="none"></audio></div></button>
		<?php endif; ?>
  	</div>
</div>
<div id="pageQrCode" class="mdui-menu" style="padding:10px 0px 0px 10px;width:170px;height:170px;background:#fff;right: 16px;bottom: 16px" onclick="$('#pageQrCode').removeClass('mdui-menu-open')"></div>

<!-- MDUI STR -->
<script src="//<?php if ($this->options->mdrMDUICDN == 'bootcss'): ?>cdn.bootcss.com/mdui/0.4.2/js/mdui.min.js<?php elseif ($this->options->mdrMDUICDN == 'cdnjs'): ?>cdnjs.cloudflare.com/ajax/libs/mdui/0.4.3/js/mdui.min.js<?php else: ?>cdnjs.loli.net/ajax/libs/mdui/0.4.3/js/mdui.min.js<?php endif; ?>"></script>
<!-- MDUI END -->
<?php if ($this->options->PjaxOption || $this->options->AjaxLoad || $this->options->ViewImg || $this->options->mdrQrCode): ?>
<script src="//<?php if ($this->options->cjCDN == 'bc'): ?>cdn.bootcss.com/jquery/3.4.1/jquery.min.js<?php elseif ($this->options->cjCDN == 'cf'): ?>cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js<?php else: ?>cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js<?php endif; ?>"></script>
<?php endif; if ($this->options->PjaxOption): ?>
<script src="//<?php if ($this->options->cjCDN == 'bc'): ?>cdn.bootcss.com/jquery.pjax/2.0.1/jquery.pjax.min.js<?php elseif ($this->options->cjCDN == 'cf'): ?>cdnjs.cloudflare.com/ajax/libs/jquery.pjax/2.0.1/jquery.pjax.min.js<?php else: ?>cdn.jsdelivr.net/npm/jquery-pjax@2.0.1/jquery.pjax.min.js<?php endif; ?>"></script>
<?php if ($this->options->ViewImg): ?>
<script src="//<?php if ($this->options->cjCDN == 'bc'): ?>cdn.bootcss.com/fancybox/3.5.7/jquery.fancybox.min.js<?php elseif ($this->options->cjCDN == 'cf'): ?>cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js<?php else: ?>cdn.jsdelivr.net/npm/fancybox@3.0.1/dist/js/jquery.fancybox.min.js<?php endif; ?>"></script>
<?php endif; ?>
<script>
jQuery.fn.Shake = function(n, d) {
	this.each(function() {
		var jSelf = $(this);
		jSelf.css({
			position: 'relative'
		});
		for (var x = 1; x <= n; x++) {
			jSelf.animate({
				left: ( - d)
			},
			50).animate({
				left: d
			},
			50).animate({
				left: 0
			},
			50)
		}
	});
	return this
};
$(document).pjax('a[target!=_blank]', { 
	container: '#main',
	fragment: '#main',
	timeout: 10000
}).on('submit', 'form[id=search], form[id=comment-form]',
function(event) {
	$.pjax.submit(event, {
		container: '#main',
		fragment: '#main',
		timeout: 10000
	})
}).on('pjax:send',
function() {
	$('#loading').fadeIn();
}).on('pjax:complete',
function() {
	setTimeout(function() {
		$("#loading").fadeOut()
	},
	300);
	$('#header').removeClass("on");
	$('#s').val(""); <?php if ($this->options->SidebarFixed) : ?>$("#secondary").removeAttr("style"); <?php endif; ?>
}).on('pjax:end',
function() {
    mdrcd();
	<?php if ($this->options->mdrQrCode): ?>getQrCode();<?php endif; ?>
	<?php if ($this->options->AjaxLoad) : ?>al(); <?php endif; ?>cl();
	ac();
	ap(); 
	<?php if ($this->options->CustomContent) : ?>
	if (typeof _hmt !== 'undefined') {
		_hmt.push(['_trackPageview', location.pathname + location.search])
	};
	if (typeof ga !== 'undefined') {
		ga('send', 'pageview', location.pathname + location.search)
	} 
	<?php endif; ?>
	<?php if ($this->options->ViewImg): ?>mdrfa();<?php endif; ?>
});
<?php if ($this->options->ViewImg): ?>
function mdrfa() {
	$('#post .mdui-card-content img').each(function(){
		$(this).before('<div data-fancybox="gallery" href="'+$(this).attr('src')+'"><img src="'+$(this).attr('src')+'" alt="'+$(this).attr('alt')+'" title="'+$(this).attr('title')+'"></div>');
		$(this).remove();
	});
	$.fancybox.defaults.buttons = ["zoom", "download", "thumbs", "close"];
}
mdrfa();
<?php endif; ?>
function mdrcd() {
    if ( document.body.clientWidth < 1024 ) {
        mdui.Drawer('#mdrDrawerL').close();
        mdui.Drawer('#mdrDrawerR').close();
    }
}
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
            position: '<?=$this->options->mdrSnackbar?>',
            timeout: 5000
		});
		if (ar[1]['name'] == 'parent') {
			l = 'comment-'+ar[1]['value'];
		}
		$.ajax({
			url: $(this).attr('action'),
			type: 'post',
			data: ar,
			error: function() {
                mdui.snackbar({
                    message: '提交失败，请检查网络并重试或者联系管理员。',
                    position: '<?=$this->options->mdrSnackbar?>',
                    timeout: 5000
                });
				return false
			},
			success: function(d) {
				if (!$(g, d).length) {
					mdui.snackbar({
                        message: '您输入的内容不符合规则或者回复太频繁，请修改内容或者稍等片刻。',
                        position: '<?=$this->options->mdrSnackbar?>',
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
                        position: '<?=$this->options->mdrSnackbar?>',
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
		<?php else: ?>
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
                        position: '<?=$this->options->mdrSnackbar?>',
                        timeout: 3000
                    });
					ap_n.text("提交失败，请检查网络并重试或者联系管理员。").css('color', 'red').Shake(2, 10);
					return false
				}
			}
		})
	}
} <?php endif; ?>
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
                position: '<?=$this->options->mdrSnackbar?>',
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
                    position: '<?=$this->options->mdrSnackbar?>',
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
<?php endif; if ($this->options->AjaxLoad): ?>
<script>
var isbool=true;
var autoloadtimes=0;
<?php if ($this->options->AjaxLoad == 'auto'): ?>
$(window).scroll(function(){
    <?php
        $autoloadtimes = $this->options->AjaxLoadTimes;
        if ($autoloadtimes=='0') {
            $leavrolzzzz="";
            /**我命名废！**/
        } else {
            $leavrolzzzz="&& autoloadtimes<".$autoloadtimes;
        }
    ?>
    if(isbool<?=$leavrolzzzz?>&&$('.ajaxload .next a').attr("href")&&($(this).scrollTop()+$(window).height()+20)>=$(document).height()){
        isbool=false;
        autoloadtimes++;
        console.log('Autoload '+autoloadtimes+' times');
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
                    position: '<?=$this->options->mdrSnackbar?>',
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
<?php endif; ?>
<?php $this->footer(); ?>
<?php if ($this->options->scrollTop || $this->options->SidebarFixed): ?>
<script>
    window.onscroll = function() {
    var a = document.documentElement.scrollTop || document.body.scrollTop; 
    <?php if ($this->options->scrollTop): ?>
    var b = document.getElementById("top");
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
    <?php endif; if ($this->options->SidebarFixed): ?>
	if ($(window).width() >= 1024){
		var e = document.getElementById("main"),
			f = document.getElementById("mdrDrawerR");
			f.style.marginTop = "-" + a + "px"
	}
    <?php endif; ?>
}
</script>
<?php endif; if ($this->options->MusicSet && $this->options->MusicUrl): ?>
<script>(function(){var a=document.getElementById("audio");var b=document.getElementById("music");var c=<?php Playlist() ?>;<?php if ($this->options->MusicVol): ?>var d=<?php $this->options->MusicVol(); ?>;if(d>=0&&d<=1){a.volume=d}<?php endif; ?>a.src=c.shift();a.addEventListener('play',g);a.addEventListener('pause',h);a.addEventListener('ended',f);a.addEventListener('error',f);a.addEventListener('canplay',j);function f(){if(!c.length){a.removeEventListener('play',g);a.removeEventListener('pause',h);a.removeEventListener('ended',f);a.removeEventListener('error',f);a.removeEventListener('canplay',j);b.style.display="none";mdui.snackbar({message: '本站的背景音乐好像有问题了，希望您可以通过留言等方式通知管理员，谢谢您的帮助。',position: '<?=$this->options->mdrSnackbar?>',timeout: 5000});}else{a.src=c.shift();a.play()}}function g(){b.setAttribute("class","play");a.addEventListener('timeupdate',k)}function h(){b.removeAttribute("class");a.removeEventListener('timeupdate',k)}function j(){c.push(a.src)}function k(){b.getElementsByTagName("i")[0].style.height=(a.currentTime/a.duration*100).toFixed(1)+"%"}b.onclick=function(){if(a.canPlayType('audio/mpeg')!=""||a.canPlayType('audio/ogg;codes="vorbis"')!=""||a.canPlayType('audio/mp4;codes="mp4a.40.5"')!=""){if(a.paused){if(a.error){f()}else{a.play()}}else{a.pause()}}else{mdui.snackbar({message: '对不起，您的浏览器不支持HTML5音频播放，请升级您的浏览器。',position: '<?=$this->options->mdrSnackbar?>',timeout: 5000});}};b.removeAttribute("class")})();</script>
<?php endif; if ($this->options->CustomContent): $this->options->CustomContent(); ?>

<?php endif; ?>
<script>
var cornertool=true;
function cl(){
    var a=document.getElementById("catalog-col"),
        b=document.getElementById("catalog"),
        c=document.getElementById("cornertool"),
        d;
    if(a&&!b){
        d=document.createElement("button");
        d.setAttribute("id","catalog");
        d.setAttribute("onclick","Catalogswith()");
        d.setAttribute("class","mdui-fab mdui-ripple mdui-fab-mini mdui-color-white");
        d.innerHTML='<i class="mdui-icon material-icons">&#xe5d2;</i>';
        c.appendChild(d);
    }if(!a&&b){
        cornertool?c.removeChild(b):document.body.removeChild(c)
    }
}
cl();
console.log("\n %c MDr By FlyingSky %c https://fsky7.com/ %c \n","color:#fff;background:#6cf;padding:5px 0;border: 1px solid #6cf;","color:#fff;background:#fff;padding:5px 0;border: 1px solid #6cf;","");
</script>
<?php if ($this->options->mdrQrCode): ?>
<script src="//<?php if ($this->options->cjCDN == 'bc'): ?>cdn.bootcss.com/jquery.qrcode/1.0/jquery.qrcode.min.js<?php elseif ($this->options->cjCDN == 'cf'): ?>cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js<?php else: ?>cdn.jsdelivr.net/npm/jquery.qrcode@1.0/jquery.qrcode.min.js<?php endif; ?>"></script>
<script>
function getQrCode() {
	$('#pageQrCode').html('');
	$('#pageQrCode').qrcode({width:150,height:150,text:window.location.href});
}
getQrCode();
function switchQrCode() {
	if ($('#pageQrCode').hasClass('mdui-menu-open')) {
		$('#pageQrCode').removeClass('mdui-menu-open');
	} else {
		$('#pageQrCode').addClass('mdui-menu-open');
	}
}
</script>
<?php endif; ?>
<?php if ($this->options->DarkMode): ?>
<?php 
    if ($this->options->DarkModeFD && $this->options->DarkModeDomain) {
        $DarkModeFD="domain=".$this->options->DarkModeDomain;
    } else {
        $DarkModeFD="";
    }
?>
<script>
	function hasClass(elem, cls) {
		cls = cls || '';
		if (cls.replace(/\s/g, '').length == 0) return false;
		return new RegExp(' ' + cls + ' ').test(' ' + elem.className + ' ');
	}
	function addClass(ele, cls) {
		if (!hasClass(ele, cls)) {
			ele.className = ele.className == '' ? cls : ele.className + ' ' + cls;
		}
	}
	function removeClass(elem, cls) {
		if (hasClass(elem, cls)) {
			var newClass = ' ' + elem.className.replace(/[\t\r\n]/g, '') + ' ';
			while (newClass.indexOf(' ' + cls + ' ') >= 0) {
				newClass = newClass.replace(' ' + cls + ' ', ' ');
			}
			elem.className = newClass.replace(/^\s+|\s+$/g, '');
		}
	}
</script>
<script>
    function onDarkMode() {
		var body = document.getElementsByTagName('body')[0],
			appbar = document.getElementsByClassName('mdui-appbar')[0];
		console.log('Dark mode off');
		document.cookie = "dark=1;path=/;<?=$DarkModeFD?>";
		addClass(body,'mdui-theme-layout-dark');
		removeClass(body,'mdui-theme-accent-<?php $this->options->mdrAccent() ?>');
		addClass(body,'mdui-theme-accent-<?php $this->options->mdrAccentD() ?>');
		appbar.style.backgroundColor = '#212121';
		var meta = document.getElementsByTagName('meta');
		meta["theme-color"].setAttribute('content','#212121');
    }
    function offDarkMode() {
		var body = document.getElementsByTagName('body')[0],
			appbar = document.getElementsByClassName('mdui-appbar')[0];
		console.log('Dark mode on');
		document.cookie = "dark=0;path=/;<?=$DarkModeFD?>";
        removeClass(body,'mdui-theme-layout-dark');
		removeClass(body,'mdui-theme-accent-<?php $this->options->mdrAccentD() ?>');
        addClass(body,'mdui-theme-accent-<?php $this->options->mdrAccent() ?>');
        appbar.style.backgroundColor = '#ffffff';
		var meta = document.getElementsByTagName('meta');
		meta["theme-color"].setAttribute('content','<?php if($this->options->mdrChrome){echo $this->options->mdrChrome();} else {echo "#FFFFFF";} ?>');
    }
</script>
<script>
	/* Dark Mode 的控制（系统黑暗模式优先于 Cookie 中的黑暗模式） */
	function switchDarkMode(){
		/* 手动触发 */
		var night = document.cookie.replace(/(?:(?:^|.*;\s*)dark\s*\=\s*([^;]*).*$)|^.*$/, "$1") || '0';
		if (night == '0'){
			onDarkMode();
			mdui.snackbar({message: '已开启 Dark Mode ，早 6 点之前保持开启。',position: '<?=$this->options->mdrSnackbar?>',timeout: 1000});
		}else{
			offDarkMode();
			mdui.snackbar({message: '已关闭 Dark Mode ',position: '<?=$this->options->mdrSnackbar?>',timeout: 1000});
		}
	}
	(function(){
		/* 加载完触发，判断时间段（当系统开启黑暗模式时不执行） */
		if (getComputedStyle(document.documentElement).getPropertyValue('content') != '"dark"') {
			if(document.cookie.replace(/(?:(?:^|.*;\s*)dark\s*\=\s*([^;]*).*$)|^.*$/, "$1") === ''){
				if(new Date().getHours() > 22 || new Date().getHours() < 6){
					onDarkMode();
				}else{
					offDarkMode();
				}
			}else{
				var dark = document.cookie.replace(/(?:(?:^|.*;\s*)dark\s*\=\s*([^;]*).*$)|^.*$/, "$1") || '0';
				if(dark == '0'){
					offDarkMode();
				}else if(dark == '1'){
					onDarkMode();
				}
			}
		}
	})();
	document.addEventListener('visibilitychange', function () {
		/* 切换标签页时触发 */
		var dark = document.cookie.replace(/(?:(?:^|.*;\s*)dark\s*\=\s*([^;]*).*$)|^.*$/, "$1") || '0';
		if(dark == '0'){
			offDarkMode();
		}else if(dark == '1'){
			onDarkMode();
		}
		if (getComputedStyle(document.documentElement).getPropertyValue('content') == '"dark"') {
			onDarkMode();
		};
	});
	if (getComputedStyle(document.documentElement).getPropertyValue('content') == '"dark"') {
		/* 加载完触发，判断系统黑暗模式是否开启 */
		onDarkMode();
		mdui.snackbar({message: '已开启 Dark Mode ，跟随系统。',position: '<?=$this->options->mdrSnackbar?>',timeout: 1000});
	};
	window.matchMedia('(prefers-color-scheme: dark)').addEventListener("change",(e) => {
		/* 系统黑暗模式切换时触发 */
		if (e.matches) {
			onDarkMode();
			mdui.snackbar({message: '已开启 Dark Mode ，跟随系统。',position: '<?=$this->options->mdrSnackbar?>',timeout: 1000});
		} else {
			var night = document.cookie.replace(/(?:(?:^|.*;\s*)dark\s*\=\s*([^;]*).*$)|^.*$/, "$1") || '0';
			if (night == '1') {
				offDarkMode();
				mdui.snackbar({message: '已关闭 Dark Mode ',position: '<?=$this->options->mdrSnackbar?>',timeout: 1000});
			}
		}
	});
</script>
<?php endif; ?>
</body>
</html><?php if ($this->options->compressHtml): $html_source = ob_get_contents(); ob_clean(); print compressHtml($html_source); ob_end_flush(); endif; ?>