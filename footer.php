<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
            <div class="mdui-typo" style="margin-top: 32px;margin-bottom: 32px;">
                &copy; <?php echo date('Y'); ?> <a href="<?php $this->options->siteUrl(); ?>"><?php if ($this->options->mdrCopytext): $this->options->mdrCopytext(); else: $this->options->title(); endif; ?></a>. Powered by <a href="http://www.typecho.org" target="_blank">Typecho</a> & <a href="https://blog.fsky7.com/archives/60/">MDr</a>.<br>
                <?php if (!empty($this->options->ButtomText)): ?>
                <?=$this->options->ButtomText?>
                <?php endif; ?>
		  <?php if ($this->options->mdrHitokoto): ?>
                <script type="text/javascript" src="https://api.lwl12.com/hitokoto/v1?encode=js&charset=utf-8"></script><span id="lwlhitokoto"><script>lwlhitokoto()</script></span><br>
                <?php endif;  ?>
                <?php if ($this->options->SiteTime): ?>
                博客已上线 <span id="runtime_span"></span> .
                <script>function show_runtime(){window.setTimeout("show_runtime()",1000);X=new Date("<?=$this->options->SiteTime?>");Y=new Date();T=(Y.getTime()-X.getTime());M=24*60*60*1000;a=T/M;A=Math.floor(a);b=(a-A)*24;B=Math.floor(b);c=(b-B)*60;C=Math.floor((b-B)*60);D=Math.floor((c-C)*60);runtime_span.innerHTML=""+A+" 天 "+B+" 时 "+C+" 分 "+D+" 秒"}show_runtime();</script>
                <?php endif; ?>
                <?php if ($this->options->ICPbeian): ?>
                <br><a href="http://beian.miit.gov.cn" target="_blank"><?php $this->options->ICPbeian(); ?></a>
                <?php endif; ?>
            </div>
        </div>
<?php if ($this->options->scrollTop || ($this->options->MusicSet && $this->options->MusicUrl) || $this->options-DarkMode): ?>
<div id="cornertool">
<ul>
<?php if ($this->options->scrollTop): ?>
<li id="top" class="hidden"></li>
<?php endif; ?>
<?php if ($this->options->DarkMode): ?>
<li id="darkmode" onclick="switchDarkMode()"><?php if($_COOKIE['dark']=='1'){echo"亮";}else{echo"暗";} ?></li>
<?php endif; ?>
<?php if ($this->options->MusicSet && $this->options->MusicUrl): ?>
<li id="music" class="hidden">
<span><i></i></span>
<audio id="audio" preload="none"></audio>
</li>
<?php endif; ?>
</ul>
</div>
<?php endif; ?>
<!-- MDUI STR -->
<script src="//<?php if ($this->options->mdrMDUICDN == 'bootcss'): ?>cdn.bootcss.com/mdui/0.4.2/js/mdui.min.js<?php elseif ($this->options->mdrMDUICDN == 'cdnjs'): ?>cdnjs.cloudflare.com/ajax/libs/mdui/0.4.3/js/mdui.min.js<?php else: ?>cdnjs.loli.net/ajax/libs/mdui/0.4.3/js/mdui.min.js<?php endif; ?>"></script>
<!-- MDUI END -->
<?php if ($this->options->PjaxOption || $this->options->AjaxLoad || $this->options->ViewImg): ?>
<script src="//<?php if ($this->options->cjCDN == 'bc'): ?>cdn.bootcss.com/jquery/3.4.1/jquery.min.js<?php elseif ($this->options->cjCDN == 'cf'): ?>cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js<?php else: ?>cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js<?php endif; ?>"></script>
<?php endif; if ($this->options->PjaxOption): ?>
<script src="//<?php if ($this->options->cjCDN == 'bc'): ?>cdn.bootcss.com/jquery.pjax/2.0.1/jquery.pjax.min.js<?php elseif ($this->options->cjCDN == 'cf'): ?>cdnjs.cloudflare.com/ajax/libs/jquery.pjax/2.0.1/jquery.pjax.min.js<?php else: ?>cdn.jsdelivr.net/npm/jquery-pjax@2.0.1/jquery.pjax.min.js<?php endif; ?>"></script>
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
});
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
        mdui.snackbar({
            message: '评论正在发送中...',
            position: 'right-top',
            timeout: 5000
        });
		$.ajax({
			url: $(this).attr('action'),
			type: 'post',
			data: $(this).serializeArray(),
			error: function() {
                mdui.snackbar({
                    message: '提交失败，请检查网络并重试或者联系管理员。',
                    position: 'right-top',
                    timeout: 5000
                });
				return false
			},
			success: function(d) {
				if (!$(g, d).length) {
					mdui.snackbar({
                        message: '您输入的内容不符合规则或者回复太频繁，请修改内容或者稍等片刻。',
                        position: 'right-top',
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
							$('#' + l).append("<div class='comment-children'><ol class='comment-list'><\/ol><\/div>")
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
                        position: 'right-top',
                        timeout: 5000
                    });
					if (k) {
						$body.animate({
							scrollTop: $('#comment-' + k).offset().top - 50
						},
						300)
					} else {
						$body.animate({
							scrollTop: $('#comments').offset().top - 50
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
                        position: 'right-top',
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
                position: 'right-top',
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
                    position: 'right-top',
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
                    position: 'right-top',
                    timeout: 3000
                });
				$(a).removeAttr("class").text("查看更多");
				return false
			},
			success: function(d) {
				var c = $(d).find("#main .mdui-card"),
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
<?php if ($this->options->scrollTop || $this->options->HeadFixed || $this->options->SidebarFixed): ?>
<script>window.onscroll=function(){var a=document.documentElement.scrollTop||document.body.scrollTop;<?php if ($this->options->scrollTop): ?>var b=document.getElementById("top");if(a>=200){b.removeAttribute("class")}else{b.setAttribute("class","hidden")}b.onclick=function totop(){var a=document.documentElement.scrollTop||document.body.scrollTop;if(a>0){requestAnimationFrame(totop);window.scrollTo(0,a-(a/5))}else{cancelAnimationFrame(totop)}};<?php endif; if ($this->options->HeadFixed): ?>var d=document.getElementById("header");if(a>0&&a<30){d.style.padding=(15-a/2)+"px 0"}else if(a>=30){d.style.padding=0}else{d.removeAttribute("style")};<?php endif; if ($this->options->SidebarFixed): ?>var e=document.getElementById("main");var f=document.getElementById("secondary");var g=document.documentElement.clientHeight;var h=<?php echo $this->options->HeadFixed ? 0 : 41 ?>;if(e.offsetHeight>f.offsetHeight){if(f.offsetHeight>g-71&&a>f.offsetHeight+101-g){if(a<e.offsetHeight+101-g){f.style.marginTop=(a-f.offsetHeight-101+g)+"px"}else{f.style.marginTop=(e.offsetHeight-f.offsetHeight)+"px"}}else if(f.offsetHeight<=g-71&&a>30+h){if(a<e.offsetHeight-f.offsetHeight+h){f.style.marginTop=(a-30-h)+"px"}else{f.style.marginTop=(e.offsetHeight-f.offsetHeight-30)+"px"}}else{f.removeAttribute("style")}}<?php endif; ?>}</script>
<?php endif; if ($this->options->MusicSet && $this->options->MusicUrl): ?>
<script>(function(){var a=document.getElementById("audio");var b=document.getElementById("music");var c=<?php Playlist() ?>;<?php if ($this->options->MusicVol): ?>var d=<?php $this->options->MusicVol(); ?>;if(d>=0&&d<=1){a.volume=d}<?php endif; ?>a.src=c.shift();a.addEventListener('play',g);a.addEventListener('pause',h);a.addEventListener('ended',f);a.addEventListener('error',f);a.addEventListener('canplay',j);function f(){if(!c.length){a.removeEventListener('play',g);a.removeEventListener('pause',h);a.removeEventListener('ended',f);a.removeEventListener('error',f);a.removeEventListener('canplay',j);b.style.display="none";mdui.snackbar({message: '本站的背景音乐好像有问题了，希望您可以通过留言等方式通知管理员，谢谢您的帮助。',position: 'right-top',timeout: 5000});}else{a.src=c.shift();a.play()}}function g(){b.setAttribute("class","play");a.addEventListener('timeupdate',k)}function h(){b.removeAttribute("class");a.removeEventListener('timeupdate',k)}function j(){c.push(a.src)}function k(){b.getElementsByTagName("i")[0].style.width=(a.currentTime/a.duration*100).toFixed(1)+"%"}b.onclick=function(){if(a.canPlayType('audio/mpeg')!=""||a.canPlayType('audio/ogg;codes="vorbis"')!=""||a.canPlayType('audio/mp4;codes="mp4a.40.5"')!=""){if(a.paused){if(a.error){f()}else{a.play()}}else{a.pause()}}else{mdui.snackbar({message: '对不起，您的浏览器不支持HTML5音频播放，请升级您的浏览器。',position: 'right-top',timeout: 5000});}};b.removeAttribute("class")})();</script>
<?php endif; if ($this->options->CustomContent): $this->options->CustomContent(); ?>

<?php endif; ?>
<script>
var cornertool=true;
function cl(){
    var a=document.getElementById("catalog-col"),b=document.getElementById("catalog"),c=document.getElementById("cornertool"),d;
    if(a&&!b){
        if(c){
            c=c.getElementsByTagName("ul")[0];
            d=document.createElement("li");
            d.setAttribute("id","catalog");
            d.setAttribute("onclick","Catalogswith()");
            d.appendChild(document.createElement("span"));
            c.appendChild(d)
        }else{
            cornertool=false;
            c=document.createElement("div");
            c.setAttribute("id","cornertool");
            c.innerHTML='<ul><li id="catalog" onclick="Catalogswith()"><span></span></li></ul>';
            document.body.appendChild(c)
        }
    }if(!a&&b){
        cornertool?c.getElementsByTagName("ul")[0].removeChild(b):document.body.removeChild(c)
    }if(a&&b){
        b.className=a.className
    }
}
cl();
console.log("\n %c Initial By JIElive %c http://www.offodd.com %c \n","color:#fff;background:#000;padding:5px 0;border: 1px solid #000;","color:#fff;background:#fff;padding:5px 0;border: 1px solid #000;","")</script>
<script>
console.log("\n %c Fly By FlyingSky %c https://fsky7.com/ %c \n","color:#fff;background:#444;padding:5px 0;border: 1px solid #444;","color:#fff;background:#fff;padding:5px 0;border: 1px solid #444;","");</script>
<script>
console.log("\n %c MDr By FlyingSky %c https://fsky7.com/ %c \n","color:#fff;background:#6cf;padding:5px 0;border: 1px solid #6cf;","color:#fff;background:#fff;padding:5px 0;border: 1px solid #6cf;","");</script>
<?php if ($this->options->DarkMode): ?>
<?php 
    if ($this->options->DarkModeFD && $this->options->DarkModeDomain) {
        $DarkModeFD="domain=".$this->options->DarkModeDomain;
    } else {
        $DarkModeFD="";
    }
?>
<script>
    function onDarkMode() {
        $('body').addClass('mdui-theme-layout-dark');
        $('body').addClass('mdui-theme-accent-<?php $this->options->mdrAccentD() ?>');
        $('body').removeClass('mdui-theme-accent-<?php $this->options->mdrAccent() ?>');
        $('.mdui-appbar').css('background-color','#212121');
    }
    function offDarkMode() {
        $('body').removeClass('mdui-theme-layout-dark');
        $('body').addClass('mdui-theme-accent-<?php $this->options->mdrAccent() ?>');
        $('body').removeClass('mdui-theme-accent-<?php $this->options->mdrAccentD() ?>');
        $('.mdui-appbar').css('background-color','#ffffff');
    }
</script>
<script>
function switchDarkMode(){
    var night = document.cookie.replace(/(?:(?:^|.*;\s*)dark\s*\=\s*([^;]*).*$)|^.*$/, "$1") || '0';
    if (night == '0'){
        onDarkMode();
        document.cookie = "dark=1;path=/;<?=$DarkModeFD?>";
        console.log('Dark mode on');
        mdui.snackbar({message: '已开启 Dark Mode ，早 6 点之前保持开启。',position: 'right-top',timeout: 1000});
        document.getElementById("darkmode").innerHTML="亮";
    }else{
       offDarkMode();
        document.cookie = "dark=0;path=/;<?=$DarkModeFD?>";
        console.log('Dark mode off');
        mdui.snackbar({message: '已关闭 Dark Mode ',position: 'right-top',timeout: 1000});
        document.getElementById("darkmode").innerHTML="暗";
    }
}
(function(){
    if(document.cookie.replace(/(?:(?:^|.*;\s*)dark\s*\=\s*([^;]*).*$)|^.*$/, "$1") === ''){
        if(new Date().getHours() > 22 || new Date().getHours() < 6){
            onDarkMode();
            document.cookie = "dark=1;path=/;<?=$DarkModeFD?>";
            console.log('Dark mode on');
            mdui.snackbar({message: '已开启 Dark Mode ，早 6 点之前保持开启。',position: 'right-top',timeout: 1000});
            document.getElementById("darkmode").innerHTML="亮";
        }else{
            offDarkMode();
            document.cookie = "dark=0;path=/;<?=$DarkModeFD?>";
            console.log('Dark mode off');
            mdui.snackbar({message: '已关闭 Dark Mode ',position: 'right-top',timeout: 1000});
            document.getElementById("darkmode").innerHTML="暗";
        }
    }else{
        var dark = document.cookie.replace(/(?:(?:^|.*;\s*)dark\s*\=\s*([^;]*).*$)|^.*$/, "$1") || '0';
        if(dark == '0'){
            offDarkMode();
        }else if(dark == '1'){
            onDarkMode();
        }
    }
})();
document.addEventListener('visibilitychange', function () {
    var dark = document.cookie.replace(/(?:(?:^|.*;\s*)dark\s*\=\s*([^;]*).*$)|^.*$/, "$1") || '0';
    if(dark == '0'){
        offDarkMode();
        document.getElementById("darkmode").innerHTML="暗";
    }else if(dark == '1'){
        onDarkMode();
        document.getElementById("darkmode").innerHTML="亮";
    }
});
</script>
<?php endif; ?>
</body>
</html><?php if ($this->options->compressHtml): $html_source = ob_get_contents(); ob_clean(); print compressHtml($html_source); ob_end_flush(); endif; ?>