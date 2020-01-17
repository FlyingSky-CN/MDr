<?php if(!defined('__TYPECHO_ROOT_DIR__'))exit;
if(Helper::options()->GravatarUrl)define('__TYPECHO_GRAVATAR_PREFIX__', Helper::options()->GravatarUrl);

/* MDr Theme Version */
define('MDR_VERSION', '1.0.3 Dev');

/* MDr themeConfig */
function themeConfig($form) {

    echo <<<EOF
    <script type="text/javascript" src="https://npmcdn.com/headroom.js@0.9.3/dist/headroom.min.js"></script>
    <style>h2{margin-bottom:10px}h2 small{opacity:0.5}#mdr-botnav{position:fixed;right:0;left:0;bottom:0;min-height:36px;background-color:#292d33;display:flex;padding:0;margin:0 auto;overflow:hidden;white-space:nowrap;z-index:9999;padding:0 10px;transition:all 1s ease-in-out;}#mdr-botnav.slideDown{transform: translate3d(0,100%,0)!important}#mdr-botnav.slideUp{ransform: translate3d(0,0,0)!important;}</style>
    <p>
        <span style="display: block;margin-bottom: 10px;margin-top: 10px;font-size: 16px;">感谢您使用 MDr 主题</span>
        <span style="display: block;margin-bottom: 10px;margin-top: 10px;font-size: 14px;opacity:0.5">版本 <code id="mdr-version"></code></span>
        <a style="font-size:14px;" href="https://blog.fsky7.com/archives/60/">关于&帮助&反馈</a>
	</p>
	<button class="btn" style="outline: 0" id="mdr-update">检查并更新主题</button>
	<pre id="mdr-update-pre" style="word-wrap:break-word;white-space:pre-wrap;display:none"></pre>
    <div id="mdr-botnav" class="row">
        <nav id="typecho-nav-list">
            <ul class="root"><li class="parent"><a href="#mdr-color">主题色</a></li></ul>
            <ul class="root"><li class="parent"><a href="#mdr-cdn">CDN</a></li></ul>
            <ul class="root"><li class="parent"><a href="#mdr-nav">边栏</a></li></ul>
            <ul class="root"><li class="parent"><a href="#mdr-pjax">Ajax</a></li></ul>
            <ul class="root"><li class="parent"><a href="#mdr-dark">黑暗模式</a></li></ul>
            <ul class="root"><li class="parent"><a href="#mdr-music">背景音乐</a></li></ul>
            <ul class="root"><li class="parent"><a href="#mdr-func">附加功能</a></li></ul>
            <ul class="root"><li class="parent"><a href="#mdr-custom">自定义</a></li></ul>
        </nav>
    </div>
    <script>(function(){new Headroom(document.querySelector("#mdr-botnav"),{classes:{pinned:"slideDown",unpinned:"slideUp"}}).init();}());</script>
EOF;
	echo "<script>document.getElementById('mdr-version').innerHTML = '".MDR_VERSION."'</script>";
	echo '<script>
	document.getElementById("mdr-update").onclick = function(){
		if(confirm("你确认要执行吗？更新过程中站点可能无法正常访问")){
			document.getElementById("mdr-update").innerHTML = "正在检查并更新";
			document.getElementById("mdr-update").setAttribute("disabled","true");
			var xmlhttp;
			if (window.XMLHttpRequest){xmlhttp=new XMLHttpRequest()}else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP")}
			xmlhttp.onreadystatechange=function()
			{
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					document.getElementById("mdr-update-pre").innerHTML=xmlhttp.responseText;
					$("mdr-update-pre").slideDown();
					document.getElementById("mdr-update").innerHTML = "完成";
				} else {
					document.getElementById("mdr-update-pre").innerHTML=xmlhttp.responseText;
					$("mdr-update-pre").slideDown();
					document.getElementById("mdr-update").innerHTML = "错误";
				}
			}
			xmlhttp.open("GET","';cjUrl('update.php');echo '",true);
			xmlhttp.send();
		}
	}
	</script>';
	/* MDr Color 主题色设置 */
    $mdrNotice = new Typecho_Widget_Helper_Form_Element_Checkbox('mdrNotice', NULL, NULL, _t('<h2 id="mdr-color">主题色设置 <small>Color</small></h2>'));
	$form->addInput($mdrNotice);
    
    $mdrPrimary = new Typecho_Widget_Helper_Form_Element_Select(
        'mdrPrimary',
        array(
            'red' => _t('red'),
            'pink' => _t('pink'),  
            'purple' => _t('purple'),
            'deep-purple' => _t('deep-purple'),
            'indigo' => _t('indigo'), 
            'blue' => _t('blue'),  
            'light-blue' => _t('light-blue'), 
            'cyan' => _t('cyan'),
            'teal' => _t('teal'),
            'green' => _t('green'),  
            'light-green'  => _t('light-green'),
            'lime' => _t('lime'),
            'yellow' => _t('yellow'),
            'amber' => _t('amber'),
            'orange' => _t('orange'),
            'deep-orange' => _t('deep-orange'),
            'brown' => _t('brown'),
            'grey' => _t('grey'),
            'blue-grey' => _t('blue-grey')
        ),
        'indigo',
        _t('主题主色'),
        _t('默认为 indigo ，详情参见 <a href="https://www.mdui.org/docs/color" target="_blank">颜色和主题 - MDUI 文档</a>')
    );
    $form->addInput($mdrPrimary);
    
    $mdrAccent = new Typecho_Widget_Helper_Form_Element_Select(
        'mdrAccent',
        array(
            'red' => _t('red'),
            'pink' => _t('pink'),  
            'purple' => _t('purple'),
            'deep-purple' => _t('deep-purple'),
            'indigo' => _t('indigo'), 
            'blue' => _t('blue'),  
            'light-blue' => _t('light-blue'), 
            'cyan' => _t('cyan'),
            'teal' => _t('teal'),
            'green' => _t('green'),  
            'light-green'  => _t('light-green'),
            'lime' => _t('lime'),
            'yellow' => _t('yellow'),
            'amber' => _t('amber'),
            'orange' => _t('orange'),
            'deep-orange' => _t('deep-orange')
        ),
        'pink',
        _t('主题强调色'),
        _t('默认为 pink ，详情参见 <a href="https://www.mdui.org/docs/color" target="_blank">颜色和主题 - MDUI 文档</a>')
    );
    $form->addInput($mdrAccent);
    
    $mdrAccentD = new Typecho_Widget_Helper_Form_Element_Select(
        'mdrAccentD',
        array(
            'red' => _t('red'),
            'pink' => _t('pink'),  
            'purple' => _t('purple'),
            'deep-purple' => _t('deep-purple'),
            'indigo' => _t('indigo'), 
            'blue' => _t('blue'),  
            'light-blue' => _t('light-blue'), 
            'cyan' => _t('cyan'),
            'teal' => _t('teal'),
            'green' => _t('green'),  
            'light-green'  => _t('light-green'),
            'lime' => _t('lime'),
            'yellow' => _t('yellow'),
            'amber' => _t('amber'),
            'orange' => _t('orange'),
            'deep-orange' => _t('deep-orange')
        ),
        'pink',
        _t('主题强调色 ( Dark Mode )'),
        _t('默认为 pink ，详情参见 <a href="https://www.mdui.org/docs/color" target="_blank">颜色和主题 - MDUI 文档</a>')
    );
	$form->addInput($mdrAccentD);
	
	$mdrChrome = new Typecho_Widget_Helper_Form_Element_Text(
		'mdrChrome', 
		NULL, 
		'#ffffff', 
		_t('Chrome 顶栏颜色'),
		_t('即未开启 Dark Mode 时的 <code>meta["theme-color"]</code> 的值，为十六进制颜色码，默认为 <code>#ffffff</code>')
	);
	$mdrChrome->input->setAttribute('class', 'mini');
	$form->addInput($mdrChrome);

    $mdrNotice = new Typecho_Widget_Helper_Form_Element_Checkbox(
		'mdrNotice',
		NULL,
		NULL,
		_t('<h2 id="mdr-cdn">CDN 设置 <small>CDN</small></h2>')
	);
	$form->addInput($mdrNotice);
    
    $mdrMDUICDN = new Typecho_Widget_Helper_Form_Element_Radio(
        'mdrMDUICDN',
        array(
            'bootcss' => _t('BootCDN'),
            'cdnjs' => _t('CDNJS'),
            'cssnet' => _t('CSSnet')
        ),
        'cssnet',
        _t('MDUI 静态资源来源'),
        _t('默认 CSSnet ，请根据需求选择合适来源')
    );
    $form->addInput($mdrMDUICDN);
    
    $cjCDN = new Typecho_Widget_Helper_Form_Element_Radio(
		'cjCDN', 
		array(
			'bc' => _t('BootCDN'),
			'cf' => _t('CDNJS'),
			'jd' => _t('jsDelivr')
		),
		'bc',
		_t('其他公共静态资源来源'),
		_t('默认BootCDN，请根据需求选择合适来源')
	);
	$form->addInput($cjCDN);

	$GravatarUrl = new Typecho_Widget_Helper_Form_Element_Radio(
		'GravatarUrl', 
		array(
			false => _t('官方源'),
			'https://cn.gravatar.com/avatar/' => _t('国内源'),
			'https://cdn.v2ex.com/gravatar/' => _t('V2EX源')
		),
		false,
		_t('Gravatar 头像源'),
		_t('默认官方源，请根据需求选择合适来源')
	);
	$form->addInput($GravatarUrl);
	
	/* MDr Nav 边栏设置 */
	$mdrNotice = new Typecho_Widget_Helper_Form_Element_Checkbox('mdrNotice', NULL, NULL, _t('<h2 id="mdr-nav">边栏设置 <small>Nav</small></h2>'));
	$form->addInput($mdrNotice);
    
    $mdrNavDefOpen = new Typecho_Widget_Helper_Form_Element_Radio(
        'mdrNavDefOpen',
        array(
            true => _t('开'),
            false => _t('关')
        ),
        false,
        _t('默认打开抽屉导航栏'),
        _t('开启后默认打开抽屉导航栏，关闭后则不自动打开')
    );
    $form->addInput($mdrNavDefOpen);
    
    $mdrNavBackground = new Typecho_Widget_Helper_Form_Element_Radio(
        'mdrNavBackground',
        array(
            true => _t('开'),
            false => _t('关')
        ),
        false,
        _t('应用栏背景'),
        _t('开启时应用栏背景颜色为主题主色，关闭后则为白色')
    );
    $form->addInput($mdrNavBackground);
    
    $mdrNavColorBut = new Typecho_Widget_Helper_Form_Element_Radio(
        'mdrNavColorBut',
        array(
            true => _t('开'),
            false => _t('关')
        ),
        true,
        _t('抽屉导航栏彩色按钮'),
        _t('开启时抽屉导航栏图标为彩色，关闭后则为灰色')
    );
    $form->addInput($mdrNavColorBut);
    
    $SidebarFixed = new Typecho_Widget_Helper_Form_Element_Radio(
		'SidebarFixed', 
		array(
			1 => _t('启用'),
			0 => _t('关闭')
		),
		0,
		_t('动态显示侧边栏'),
		_t('默认关闭')
	);
	$form->addInput($SidebarFixed);
    
    $Navset = new Typecho_Widget_Helper_Form_Element_Checkbox(
	    'Navset', 
    	array(
            'ShowCategory' => _t('显示分类'),
            'OpenCategory' => _t('默认打开分类列表'),
            'ShowPage' => _t('显示页面'),
            'OpenPage' => _t('默认打开页面列表'),
            'ShowArchive' => _t('显示归档')
        ),
        array(
            'ShowCategory', 
            'ShowPage', 
            'OpenPage',
            'ShowArchive'
        ), 
        _t('抽屉导航栏显示')
    );
	$form->addInput($Navset->multiMode());
	
	$sidebarBlock = new Typecho_Widget_Helper_Form_Element_Checkbox(
		'sidebarBlock', 
		array(
			'ShowWaySit' => _t('显示导航位（下方自定义）'),
			'ShowEatFoodSit' => _t('显示广告位（下方自定义）'),
			'ShowHotPosts' => _t('显示热门文章（根据浏览量排序）'),
			'ShowRecentPosts' => _t('显示最新文章'),
			'ShowRecentComments' => _t('显示最近回复'),
			'IgnoreAuthor' => _t('不显示作者回复'),
			'ShowCategory' => _t('显示分类'),
			'ShowTag' => _t('显示标签'),
			'ShowArchive' => _t('显示归档'),
			'ShowStats' => _t('显示网站统计'),
			'ShowOther' => _t('显示其它杂项')
		),
		array(
			'ShowRecentPosts',
			'ShowRecentComments',
			'ShowCategory',
			'ShowTag',
			'ShowArchive',
			'ShowOther'
		),
		_t('侧边栏显示')
	);
	$form->addInput($sidebarBlock->multiMode());
	
	/* MDr Pjax Ajax 设置 */
	$mdrNotice = new Typecho_Widget_Helper_Form_Element_Checkbox('mdrNotice', NULL, NULL, _t('<h2 id="mdr-pjax">Ajax 设置 <small>Ajax</small></h2>'));
	$form->addInput($mdrNotice);
	
	$PjaxOption = new Typecho_Widget_Helper_Form_Element_Radio(
		'PjaxOption', 
		array(
			1 => _t('启用'),
			0 => _t('关闭')
		),
		0,
		_t('全站 Pjax'),
		_t('默认关闭，启用则会强制关闭“反垃圾保护”，强制“将较新的的评论显示在前面”')
	);
	$form->addInput($PjaxOption);

	$AjaxLoad = new Typecho_Widget_Helper_Form_Element_Radio(
		'AjaxLoad', 
		array(
			'auto' => _t('自动'),
			'click' => _t('点击'),
			0 => _t('关闭')
		),
		0,
		_t('Ajax 翻页'),
		_t('默认关闭，启用则会使用Ajax加载文章翻页')
	);
	$form->addInput($AjaxLoad);
	
	$AjaxLoadTimes = new Typecho_Widget_Helper_Form_Element_Text(
		'AjaxLoadTimes',
		NULL,
		'0',
		_t('Ajax 自动翻页限制'),
		_t('Ajax加载文章最多自动翻页~次，0则无限制')
	);
	$AjaxLoadTimes->input->setAttribute('class', 'mini');
	$form->addInput($AjaxLoadTimes);
	
	$mdrLoading = new Typecho_Widget_Helper_Form_Element_Radio(
        'mdrLoading',
        array(
            'top' => _t('顶部'),
            'bottom' => _t('底部')
        ),
        'top',
        _t('Ajax 加载条位置'),
        _t('默认为顶部，然后作者表示强迫症犯了')
    );
    $form->addInput($mdrLoading);
	
	/* MDr Dark 黑暗模式设置 */
    $mdrNotice = new Typecho_Widget_Helper_Form_Element_Checkbox('mdrNotice', NULL, NULL, _t('<h2 id="mdr-dark">黑暗模式设置 <small>Dark Mode</small></h2>'), _t('Dev | 该功能还在开发阶段，如遇问题欢迎反馈。'));
	$form->addInput($mdrNotice);
	
	$DarkMode = new Typecho_Widget_Helper_Form_Element_Radio(
		'DarkMode', 
		array(
			1 => _t('启用'),
			0 => _t('关闭')
		),
		1,
		_t('黑暗模式总开关'),
		_t('默认开启')
	);
	$form->addInput($DarkMode);
	
	$DarkModeFD = new Typecho_Widget_Helper_Form_Element_Radio(
		'DarkModeFD', 
		array(
			1 => _t('启用'),
			0 => _t('关闭')
		),
		0,
		_t('黑暗模式跨域使用开关'),
		_t('默认关闭')
	);
	$form->addInput($DarkModeFD);
	
	$DarkModeDomain = new Typecho_Widget_Helper_Form_Element_Text(
		'DarkModeDomain',
		NULL,
		NULL,
		_t('黑暗模式跨域使用总域名')
	);
	$DarkModeDomain->input->setAttribute('class', 'mini');
	$form->addInput($DarkModeDomain);
	
	/* MDr Music 背景音乐设置 */
	$mdrNotice = new Typecho_Widget_Helper_Form_Element_Checkbox('mdrNotice', NULL, NULL, _t('<h2 id="mdr-music">背景音乐设置 <small>Music</small></h2>'));
	$form->addInput($mdrNotice);
	
	$MusicSet = new Typecho_Widget_Helper_Form_Element_Radio(
		'MusicSet', 
		array(
			'order' => _t('顺序播放'),
			'shuffle' => _t('随机播放'),
			0 => _t('关闭')
		),
		0,
		_t('背景音乐'),
		_t('默认关闭，启用后请填写音乐地址,否则开启无效')
	);
	$form->addInput($MusicSet);

	$MusicUrl = new Typecho_Widget_Helper_Form_Element_Textarea(
		'MusicUrl',
		NULL,
		NULL,
		_t('背景音乐地址（建议使用mp3格式）'),
		_t('请输入完整的音频文件路径，例如：https://music.163.com/song/media/outer/url?id={MusicID}.mp3（好东西 QwQ），可设置多个音频，一行一个，留空则关闭背景音乐')
	);
	$form->addInput($MusicUrl);

	$MusicVol = new Typecho_Widget_Helper_Form_Element_Text(
		'MusicVol',
		NULL,
		NULL,
		_t('背景音乐播放音量（输入范围：0~1）'),
		_t('请输入一个0到1之间的小数（0为静音  0.5为50%音量  1为100%最大音量）输入错误内容或留空则使用默认音量100%'))
	;
	$MusicVol->input->setAttribute('class', 'mini');
	$form->addInput($MusicVol->addRule('isInteger', _t('请填入一个0~1内的数字')));
	
	/* MDr Func 附加功能设置 */
    $mdrNotice = new Typecho_Widget_Helper_Form_Element_Checkbox('mdrNotice', NULL, NULL, _t('<h2 id="mdr-func">附加功能设置 <small>Func</small></h2>'));
	$form->addInput($mdrNotice);
	
	$mdrSnackbar = new Typecho_Widget_Helper_Form_Element_Select(
        'mdrSnackbar',
        array(
            'bottom' => _t('下方'),
            'top' => _t('上方'),  
            'left-bottom' => _t('左下角'),
            'left-top' => _t('左上角'),
            'right-bottom' => _t('右下角'), 
            'right-top' => _t('右上角')
        ),
        'right-bottom',
        _t('Snackbar 位置'),
        _t('默认为右下角，即所谓的 “通知系统” 弹出的通知的位置')
    );
    $form->addInput($mdrSnackbar);

    $mdrCornertool = new Typecho_Widget_Helper_Form_Element_Radio(
        'mdrCornertool',
        array(
            true => _t('开'),
            false => _t('关')
        ),
        true,
        _t('界面滚动条'),
        _t('强迫症犯了')
    );
    $form->addInput($mdrCornertool);
	
	$RandomLinks = new Typecho_Widget_Helper_Form_Element_Radio(
        'RandomLinks',
        array(
            true => _t('开'),
            false => _t('关')
        ),
        true,
        _t('友情链接随机排序'),
        _t('开启后友情链接将按照随机顺序排列')
    );
	$form->addInput($RandomLinks);
	
    $mdrPray = new Typecho_Widget_Helper_Form_Element_Radio(
        'mdrPray',
        array(
            true => _t('开'),
            false => _t('关')
        ),
        false,
        _t('全站暗淡'),
        _t('开启后全站变黑白色调')
    );
    $form->addInput($mdrPray);

    $mdrHitokoto = new Typecho_Widget_Helper_Form_Element_Radio(
        'mdrHitokoto',
        array(
            true => _t('开'),
            false => _t('关')
        ),
        true,
        _t('一言 API 开关'),
        _t('显示在网站底部，API by <a href="https://hitokoto.cn" target="_blank">hitokoto.cn</a>')
    );
	$form->addInput($mdrHitokoto);

	$mdrHitokotoc = new Typecho_Widget_Helper_Form_Element_Radio(
		'mdrHitokotoc', 
		array(
			'' => _t('随机'),
			'a' => _t('动画'),
			'b' => _t('漫画'),
			'c' => _t('游戏'), 
			'd' => _t('小说'), 
			'e' => _t('原创'), 
			'f' => _t('来自网络'), 
			'g' => _t('其他')
		),
		'',
        _t('一言 API 分类'),
        _t('默认随机显示')
	);
	$form->addInput($mdrHitokotoc);

	$Breadcrumbs = new Typecho_Widget_Helper_Form_Element_Checkbox(
		'Breadcrumbs', 
		array(
			'Postshow' => _t('文章内显示'),
			'Text' => _t('↪文章标题替换为“正文”'),
			'Pageshow' => _t('页面内显示')
		),
		array(
			'Postshow',
			'Text',
			'Pageshow'
		),
		_t('面包屑导航显示'),
		_t('默认在文章与页面内显示，并将文章标题替换为“正文”')
	);
	$form->addInput($Breadcrumbs->multiMode());
	
	$TimeNotice = new Typecho_Widget_Helper_Form_Element_Radio(
		'TimeNotice', 
		array(
			1 => _t('启用'),
			0 => _t('关闭')
		),
		0,
		_t('久远文章提醒'),
		_t('默认关闭')
	);
	$form->addInput($TimeNotice);
	
	$TimeNoticeLock = new Typecho_Widget_Helper_Form_Element_Text(
		'TimeNoticeLock',
		NULL,
		'30',
		_t('久远文章提醒阈值'),
		_t('单位：天，默认30天')
	);
	$TimeNoticeLock->input->setAttribute('class', 'mini');
	$form->addInput($TimeNoticeLock);
	
	$SiteTime = new Typecho_Widget_Helper_Form_Element_Text(
		'SiteTime',
		NULL,
		NULL,
		_t('建站时间'),
		_t('格式：月/日/年 时:分:秒（示例：08/19/2018 10:00:00 为 2018年8月19日10点整），显示在网站底部，留空不显示')
	);
	$SiteTime->input->setAttribute('class', 'mini');
	$form->addInput($SiteTime);

    $WordCount = new Typecho_Widget_Helper_Form_Element_Radio(
		'WordCount', 
		array(
			1 => _t('启用'),
			0 => _t('关闭')
		),
		1,
		_t('文章字数统计'),
		_t('默认开启')
	);
	$form->addInput($WordCount);
	
	$ViewImg = new Typecho_Widget_Helper_Form_Element_Radio(
		'ViewImg', 
		array(
			1 => _t('启用'),
			0 => _t('关闭')
		),
		1,
		_t('图片灯箱'),
		_t('<b>当前版本不可用</b>')
	);
	$form->addInput($ViewImg);

	$compressHtml = new Typecho_Widget_Helper_Form_Element_Radio(
		'compressHtml', 
		array(
			1 => _t('启用'),
			0 => _t('关闭')
		),
		0,
		_t('HTML压缩'),
		_t('默认关闭，启用则会对HTML代码进行压缩，可能与部分插件存在兼容问题，请酌情选择开启或者关闭')
	);
	$form->addInput($compressHtml);

	$scrollTop = new Typecho_Widget_Helper_Form_Element_Radio(
		'scrollTop', 
		array(
			1 => _t('启用'),
			0 => _t('关闭')
		),
		1,
		_t('返回顶部'),
		_t('默认开启，启用将在右下角显示“返回顶部”按钮')
	);
	$form->addInput($scrollTop);
	
	/* MDr Custom 自定义设置 */
	$mdrNotice = new Typecho_Widget_Helper_Form_Element_Checkbox('mdrNotice', NULL, NULL, _t('<h2 id="mdr-custom">自定义内容 <small>Custom</small></h2>'));
	$form->addInput($mdrNotice);

	$ShowLinks = new Typecho_Widget_Helper_Form_Element_Checkbox(
		'ShowLinks',
		array(
			'sidebar' => _t('侧边栏')
		),
		NULL,
		_t('首页显示链接')
	);
	$form->addInput($ShowLinks->multiMode());

	$ShowWhisper = new Typecho_Widget_Helper_Form_Element_Checkbox(
		'ShowWhisper',
		array(
			'index' => _t('首页'),
			'sidebar' => _t('侧边栏')
		),
		NULL,
		_t('显示最新的“轻语”')
	);
	$form->addInput($ShowWhisper->multiMode());
	
	$mdrPostInfo = new Typecho_Widget_Helper_Form_Element_Radio(
		'mdrPostInfo', 
		array(
			'menu' => _t('作为弹出菜单'),
			'subtitle' => _t('作为副标题')
		),
		'menu',
		_t('文章信息显示方式'),
		_t('默认为弹出菜单，为文章列表中文章的信息显示方式')
	);
	$form->addInput($mdrPostInfo);
	
	$mdrPostTitle = new Typecho_Widget_Helper_Form_Element_Radio(
		'mdrPostTitle', 
		array(
			'normal' => _t('在图片下方'),
			'button' => _t('覆盖在图片底部(如果有)'),
			'top' => _t('覆盖在图片顶部(如果有)')
		),
		'normal',
		_t('文章标题显示方式'),
		_t('默认在图片下方')
	);
	$form->addInput($mdrPostTitle);

	$mdrPostThumb = new Typecho_Widget_Helper_Form_Element_Radio(
		'mdrPostThumb', 
		array(
			true => _t('显示'),
			false => _t('不显示')
		),
		true,
		_t('文章内页缩略图显示'),
		_t('默认显示')
	);
	$form->addInput($mdrPostThumb);

	$subTitle = new Typecho_Widget_Helper_Form_Element_Text(
		'subTitle',
		NULL,
		NULL,
		_t('自定义站点副标题'),
		_t('浏览器副标题，仅在当前页面为首页时显示，显示格式为：<b>标题 - 副标题</b>，留空则不显示副标题')
	);
	$form->addInput($subTitle);

	$favicon = new Typecho_Widget_Helper_Form_Element_Text(
		'favicon',
		NULL,
		NULL,
		_t('Favicon 地址'),
		_t('在这里填入一个图片 URL 地址, 以添加一个Favicon，留空则不单独设置Favicon')
	);
	$form->addInput($favicon);
	
	$customTitle = new Typecho_Widget_Helper_Form_Element_Text(
        'customTitle',
        NULL,
        NULL,
        _t('自定义头部站点标题'),
        _t('仅在页面头部标题位置显示，和 Typecho 后台设置的站点名称不冲突，留空则显示默认站点名称')
    );
	$form->addInput($customTitle);
	
	$mdrCopytext = new Typecho_Widget_Helper_Form_Element_Text(
        'mdrCopytext',
        NULL,
        NULL,
        _t('自定义底部版权所属'),
        _t('默认为站点名称')
    );
    $form->addInput($mdrCopytext);
	
	$MyLinks = new Typecho_Widget_Helper_Form_Element_Textarea(
        'MyLinks',
        NULL,
        NULL,
        _t('自定义导航栏链接'), 
        _t('格式为 <b class="notice">文字=链接</b>，一行一个，留空则没有')
	);
	$form->addInput($MyLinks);
	
	$AttUrlReplace = new Typecho_Widget_Helper_Form_Element_Textarea(
		'AttUrlReplace',
		NULL,
		NULL,
		_t('文章内的链接地址替换'),
		_t('按照格式输入你的CDN链接以替换原链接，格式 <b class="notice">原地址=替换地址</b><br>建议用在图片等静态资源的链接上，可设置多个规则，换行即可，一行一个')
	);
	$form->addInput($AttUrlReplace);

    $WaySit = new Typecho_Widget_Helper_Form_Element_Textarea(
		'WaySit',
		NULL,
		NULL,
		_t('导航位内容'),
		_t('位于侧边栏')
	);
	$form->addInput($WaySit);
    
    $EatFoodSit = new Typecho_Widget_Helper_Form_Element_Textarea(
		'EatFoodSit',
		NULL,
		NULL,
		_t('广告位内容'),
		_t('位于侧边栏')
	);
	$form->addInput($EatFoodSit);

	$ICPbeian = new Typecho_Widget_Helper_Form_Element_Text(
		'ICPbeian',
		NULL,
		NULL,
		_t('ICP备案号'),
		_t('在这里输入ICP备案号，留空则不显示')
	);
	$form->addInput($ICPbeian);

	$beianProvince = new Typecho_Widget_Helper_Form_Element_Text(
		'beianProvince',
		NULL,
		NULL,
		_t('公网安备案所在省份'),
		_t('在这里输入公网安备案所在省份缩写，如北京=京，山东=鲁，留空则不显示')
	);
	$form->addInput($beianProvince);

	$beianNumber = new Typecho_Widget_Helper_Form_Element_Text(
		'beianNumber',
		NULL,
		NULL,
		_t('公网安备案号'),
		_t('在这里输入公网安备案号，留空则不显示')
	);
	$form->addInput($beianNumber);

	$ButtomText = new Typecho_Widget_Helper_Form_Element_Textarea(
		'ButtomText',
		NULL,
		NULL,
		_t('底部自定义内容'),
		_t('位于底部版权下方建站时间上方')
	);
	$form->addInput($ButtomText);

	$CustomContent = new Typecho_Widget_Helper_Form_Element_Textarea(
		'CustomContent',
		NULL,
		NULL,
		_t('底部自定义内容'),
		_t('位于底部，footer之后body之前，适合放置一些JS内容，如网站统计代码等（若开启全站Pjax，目前支持Google和百度统计的回调，其余统计代码可能会不准确）')
	);
	$form->addInput($CustomContent);

}

/* MDr themeFields */
function themeFields($layout) {

	$thumb = new Typecho_Widget_Helper_Form_Element_Text(
		'thumb',
		NULL,
		NULL,
		_t('自定义缩略图'),
		_t('在这里填入一个图片 URL 地址, 以添加本文的缩略图，若填入纯数字，例如 <b>3</b> ，则使用文章第三张图片作为缩略图（对应位置无图则不显示缩略图），留空则默认不显示缩略图')
	);
	$thumb->input->setAttribute('class', 'w-100');
	$layout->addItem($thumb);

	$catalog = new Typecho_Widget_Helper_Form_Element_Radio(
		'catalog', 
		array(
			true => _t('启用'),
			false => _t('关闭')
		),
		false,
		_t('文章目录'),
		_t('默认关闭，启用则会在文章内显示“文章目录”（若文章内无任何标题，则不显示目录）')
	);
	$layout->addItem($catalog);
	
    $licenses = new Typecho_Widget_Helper_Form_Element_Radio(
		'linceses', 
    	array(
			'BY' => _t('CC BY'),
    		'BY-SA' => _t('CC BY-SA'),
    		'BY-ND' => _t('CC BY-ND'),
    		'BY-NC' => _t('CC BY-NC'),
    		'BY-NC-SA' => _t('CC BY-NC-SA'),
    		'BY-NC-ND' => _t('CC BY-NC-ND'),
			'NONE' => _t('没有')
		),
		'NONE',
		_t('许可协议'),
		_t('默认没有协议，请前往 <a href="https://creativecommons.org/licenses/" target="_blank">CreativeCommons</a> 查看更多关于协议的内容，仅支持 4.0 ( 国际 ) 协议')
	);
	$layout->addItem($licenses);
	
}

/* MDr themeInit */
function themeInit($archive) {
	$options = Helper::options();
	$options->commentsAntiSpam = false;
	if ($options->PjaxOption || FindContents('page-whisper.php', 'commentsNum', 'd')) {
		$options->commentsOrder = 'DESC';
		$options->commentsPageDisplay = 'first';
	}
	if ($archive->is('single')) {
		$archive->content = hrefOpen($archive->content);
		if ($options->AttUrlReplace) {
			$archive->content = UrlReplace($archive->content);
		}
		if ($archive->fields->catalog) {
			$archive->content = createCatalog($archive->content);
		}
	}
}

function cjUrl($path) {
	$options = Helper::options();
	$options->themeUrl($path);
}

function hrefOpen($obj) {
	return preg_replace('/<a\b([^>]+?)\bhref="((?!'.addcslashes(Helper::options()->index, '/._-+=#?&').').*?)"([^>]*?)>/i', '<a\1href="\2"\3 target="_blank">', $obj);
}

/* function URL替换 */
function UrlReplace($obj) {
	$list = explode("\r\n", Helper::options()->AttUrlReplace);
	foreach ($list as $tmp) {
		list($old, $new) = explode('=', $tmp);
		$obj = str_replace($old, $new, $obj);
	}
	return $obj;
}

/* function 文章缩略图 */
function postThumb($obj) {
	$thumb = $obj->fields->thumb;
	if (!$thumb) {
		return false;
	}
	if (is_numeric($thumb)) {
		preg_match_all('/<img.*?src="(.*?)".*?[\/]?>/i', $obj->content, $matches);
		if (isset($matches[1][$thumb-1])) {
			$thumb = $matches[1][$thumb-1];
		} else {
			return false;
		}
	}
	if (Helper::options()->AttUrlReplace) {
		$thumb = UrlReplace($thumb);
	}
	return '<img src="'.$thumb.'"  style="width: 100%"/>';
}

/* function 文章阅读数 */
function Postviews($archive) {
	$db = Typecho_Db::get();
	$cid = $archive->cid;
	if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')))) {
		$db->query('ALTER TABLE `'.$db->getPrefix().'contents` ADD `views` INT(10) DEFAULT 0;');
	}
	$exist = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid))['views'];
	if ($archive->is('single')) {
		$cookie = Typecho_Cookie::get('contents_views');
		$cookie = $cookie ? explode(',', $cookie) : array();
		if (!in_array($cid, $cookie)) {
			$db->query($db->update('table.contents')
				->rows(array('views' => (int)$exist+1))
				->where('cid = ?', $cid));
			$exist = (int)$exist+1;
			array_push($cookie, $cid);
			$cookie = implode(',', $cookie);
			Typecho_Cookie::set('contents_views', $cookie);
		}
	}
	echo $exist == 0 ? '暂无阅读' : $exist.' 次阅读';
}

function createCatalog($obj) {
	global $catalog;
	global $catalog_count;
	$catalog = array();
	$catalog_count = 0;
	$obj = preg_replace_callback('/<h([1-6])(.*?)>(.*?)<\/h\1>/i', function($obj) {
		global $catalog;
		global $catalog_count;
		$catalog_count ++;
		$catalog[] = array('text' => trim(strip_tags($obj[3])), 'depth' => $obj[1], 'count' => $catalog_count);
		$text = trim(strip_tags($obj[3]));
		return '<h'.$obj[1].$obj[2].'><a class="cl-offset" id="dl-'.$text.'" name="cl-'.$catalog_count.'"></a>'.$text.'</h'.$obj[1].'>';
	}, $obj);
	return $obj."\n".getCatalog();
}

function getCatalog() {
	global $catalog;
	$index = '';
	if ($catalog) {
		$index = '<ul>'."\n";
		$prev_depth = '';
		$to_depth = 0;
		foreach($catalog as $catalog_item) {
			$catalog_depth = $catalog_item['depth'];
			if ($prev_depth) {
				if ($catalog_depth == $prev_depth) {
					$index .= '</li>'."\n";
				} elseif ($catalog_depth > $prev_depth) {
					$to_depth++;
					$index .= "\n".'<ul>'."\n";
				} else {
					$to_depth2 = ($to_depth > ($prev_depth - $catalog_depth)) ? ($prev_depth - $catalog_depth) : $to_depth;
					if ($to_depth2) {
						for ($i=0; $i<$to_depth2; $i++) {
							$index .= '</li>'."\n".'</ul>'."\n";
							$to_depth--;
						}
					}
					$index .= '</li>'."\n";
				}
			}
			$index .= '<li><a href="#cl-'.$catalog_item['count'].'" onclick="Catalogswith()">'.$catalog_item['text'].'</a>';
			$prev_depth = $catalog_item['depth'];
		}
		for ($i=0; $i<=$to_depth; $i++) {
			$index .= '</li>'."\n".'</ul>'."\n";
		}
	$index = '<div id="catalog-col" class="mdui-card">'."\n".'<b>文章目录</b>'."\n".$index.'<script>function Catalogswith(){document.getElementById("catalog-col").classList.toggle("catalog");document.getElementById("catalog").classList.toggle("catalog")}</script>'."\n".'</div>'."\n";
	}
	return $index;
}

function CommentAuthor($obj, $autoLink = NULL, $noFollow = NULL) {
	$options = Helper::options();
	$autoLink = $autoLink ? $autoLink : $options->commentsShowUrl;
	$noFollow = $noFollow ? $noFollow : $options->commentsUrlNofollow;
	if ($obj->url && $autoLink) {
		echo '<a href="'.$obj->url.'"'.($noFollow ? ' rel="external nofollow"' : NULL).(strstr($obj->url, $options->index) == $obj->url ? NULL : ' target="_blank"').'>'.$obj->author.'</a>';
	} else {
		echo $obj->author;
	}
}

function Contents_Post_Initial($limit = 10, $order = 'created') {
	$db = Typecho_Db::get();
	$options = Helper::options();
	$posts = $db->fetchAll($db->select()->from('table.contents')
		->where('type = ? AND status = ? AND created < ?', 'post', 'publish', $options->time)
		->order($order, Typecho_Db::SORT_DESC)
		->limit($limit), array(Typecho_Widget::widget('Widget_Abstract_Contents'), 'filter'));
	if ($posts) {
		foreach($posts as $post) {
			echo '<li><a'.($post['hidden'] && $options->PjaxOption ? '' : ' href="'.$post['permalink'].'"').'>'.htmlspecialchars($post['title']).'</a></li>'."\n";
		}
	} else {
		echo '<li>暂无文章</li>'."\n";
	}
}

function Contents_Comments_Initial($limit = 10, $ignoreAuthor = 0) {
	$db = Typecho_Db::get();
	$options = Helper::options();
	$select = $db->select()->from('table.comments')
		->where('status = ? AND created < ?','approved', $options->time)
		->order('coid', Typecho_Db::SORT_DESC)
		->limit($limit);
	if ($options->commentsShowCommentOnly) {
		$select->where('type = ?', 'comment');
	}
	if ($ignoreAuthor == 1) {
		$select->where('ownerId <> authorId');
	}
	$page_whisper = FindContents('page-whisper.php', 'commentsNum', 'd');
	if (!empty($page_whisper)) {
		$select->where('cid <> ? OR (cid = ? AND parent <> ?)', $page_whisper[0]['cid'], $page_whisper[0]['cid'], '0');
	}
	$comments = $db->fetchAll($select);
	if ($comments) {
		foreach($comments as $comment) {
			$parent = FindContent($comment['cid']);
			echo '<li><a'.($parent['hidden'] && $options->PjaxOption ? '' : ' href="'.permaLink($comment).'"').' title="来自: '.$parent['title'].'">'.$comment['author'].'</a>: '.($parent['hidden'] && $options->PjaxOption ? '内容被隐藏' : Typecho_Common::subStr(strip_tags($comment['text']), 0, 35, '...')).'</li>'."\n";
		}
	} else {
		echo '<li>暂无回复</li>'."\n";
	}
}

function permaLink($obj) {
	$db = Typecho_Db::get();
	$options = Helper::options();
	$parentContent = FindContent($obj['cid']);
	if ($options->commentsPageBreak && 'approved' == $obj['status']) {
		$coid = $obj['coid'];
		$parent = $obj['parent'];
		while ($parent > 0 && $options->commentsThreaded) {
			$parentRows = $db->fetchRow($db->select('parent')->from('table.comments')
			->where('coid = ? AND status = ?', $parent, 'approved')->limit(1));
			if (!empty($parentRows)) {
				$coid = $parent;
				$parent = $parentRows['parent'];
			} else {
				break;
			}
		}
		$select  = $db->select('coid', 'parent')->from('table.comments')
			->where('cid = ? AND status = ?', $parentContent['cid'], 'approved')
			->where('coid '.('DESC' == $options->commentsOrder ? '>=' : '<=').' ?', $coid)
			->order('coid', Typecho_Db::SORT_ASC);
		if ($options->commentsShowCommentOnly) {
			$select->where('type = ?', 'comment');
		}
		$comments = $db->fetchAll($select);
		$commentsMap = array();
		$total = 0;
		foreach ($comments as $comment) {
			$commentsMap[$comment['coid']] = $comment['parent'];
			if (0 == $comment['parent'] || !isset($commentsMap[$comment['parent']])) {
				$total ++;
			}
		}
		$currentPage = ceil($total / $options->commentsPageSize);
		$pageRow = array('permalink' => $parentContent['pathinfo'], 'commentPage' => $currentPage);
		return Typecho_Router::url('comment_page', $pageRow, $options->index).'#'.$obj['type'].'-'.$obj['coid'];
	}
	return $parentContent['permalink'].'#'.$obj['type'].'-'.$obj['coid'];
}

function FindContent($cid) {
	$db = Typecho_Db::get();
	return $db->fetchRow($db->select()->from('table.contents')
	->where('cid = ?', $cid)
	->limit(1), array(Typecho_Widget::widget('Widget_Abstract_Contents'), 'filter'));
}

function FindContents($val = NULL, $order = 'order', $sort = 'a', $publish = NULL) {
	$db = Typecho_Db::get();
	$sort = ($sort == 'a') ? Typecho_Db::SORT_ASC : Typecho_Db::SORT_DESC;
	$select = $db->select()->from('table.contents')
		->where('created < ?', Helper::options()->time)
		->order($order, $sort);
	if ($val) {
		$select->where('template = ?', $val);
	}
	if ($publish) {
		$select->where('status = ?','publish');
	}
	return $db->fetchAll($select, array(Typecho_Widget::widget('Widget_Abstract_Contents'), 'filter'));
}

/* function 输出轻语 */
function Whisper($sidebar = NULL) {
	$db = Typecho_Db::get();
	$options = Helper::options();
	$page = FindContents('page-whisper.php', 'commentsNum', 'd');
	$p = $sidebar ? 'li' : 'p';
	if (isset($page)) {
		$page = $page[0];
		$title = $sidebar ? '' : '<h2 class="post-title"><a href="'.$page['permalink'].'">'.$page['title'].'<span class="more">···</span></a></h2>'."\n";
		$comment = $db->fetchAll($db->select()->from('table.comments')
			->where('cid = ? AND status = ? AND parent = ?', $page['cid'], 'approved', '0')
			->order('coid', Typecho_Db::SORT_DESC)
			->limit(1));
		if ($comment) {
			$content = hrefOpen(Markdown::convert($comment[0]['text']));
			if ($options->AttUrlReplace) {
				$content = UrlReplace($content);
			}
			echo $title.strip_tags($content, '<p><br><strong><a><img><pre><code>'.$options->commentsHTMLTagAllowed)."\n".($sidebar ? '<li class="more"><a href="'.$page['permalink'].'">查看更多...</a></li>'."\n" : '');
		} else {
			echo $title.'<'.$p.'>暂无内容</'.$p.'>'."\n";
		}
	} else {
		echo ($sidebar ? '' : '<h2 class="post-title"><a>轻语</a></h2>'."\n").'<'.$p.'>暂无内容</'.$p.'>'."\n";
	}
}

function Links_list() {
	$db = Typecho_Db::get();
	$list = Helper::options()->Links ? Helper::options()->Links : '';
	$page_links = FindContents('page-links.php', 'order', 'a')[0];
	if (isset($page_links)) {
		$exist = $db->fetchRow($db->select()->from('table.fields')
			->where('cid = ? AND name = ?', $page_links['cid'], 'links'));
		if (empty($exist)) {
			$db->query($db->insert('table.fields')
				->rows(array(
					'cid'           =>  $page_links['cid'],
					'name'          =>  'links',
					'type'          =>  'str',
					'str_value'     =>  $list,
					'int_value'     =>  0,
					'float_value'   =>  0
				)));
			return $list;
		}
		if (empty($exist['str_value'])) {
			$db->query($db->update('table.fields')
				->rows(array('str_value' => $list))
				->where('cid = ? AND name = ?', $page_links['cid'], 'links'));
			return $list;
		}
		$list = $exist['str_value'];
	}
	return $list;
}

function Links($short = false) {
	$link = NULL;
	$list = Links_list();
	if ($list) {
		$list = explode("\r\n", $list);
		foreach ($list as $val) {
			list($name, $url, $description, $logo) = explode(',', $val);
            if ($short) {
                $link .= '<a'.($url ? ' href="'.$url.'"' : '').($icon==1&&$url ? ' class="l_logo"' : '').' title="'.$description.'" target="_blank"><span>'.($url ? $name : '<del>'.$name.'</del>').'</span></a>'."\n";
            } else {
                $link .= '
                <div class="mdui-col" style="padding-top: 16px;">
                    <a href="'.$url.'" target="_blank">
                        <div class="mdui-card mdui-card-media">
                            <img class="link-logo" style="min-height: 100px;background: #fff" src="'.$logo.'"/>
                            <div class="mdui-card-media-covered">
                                <div class="mdui-card-primary">
                                    <div class="mdui-card-primary-title">'.$name.'</div>
                                    <div class="mdui-card-primary-subtitle">'.$description.'</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>'."\n";
            }
        }
	}
	echo $link ? $link : '<div class="mdui-chip"><span class="mdui-chip-icon"><i class="mdui-icon material-icons">label_outline</i></span><span class="mdui-chip-title">暂无链接</span></div>'."\n";
}	


function Playlist() {
	$options = Helper::options();
	$arr = explode("\r\n", $options->MusicUrl);
	if ($options->MusicSet == 'shuffle') {
		shuffle($arr);
	}
	echo '["'.implode('","', $arr).'"]';
}

function compressHtml($html_source) {
	$chunks = preg_split('/(<!--<nocompress>-->.*?<!--<\/nocompress>-->|<nocompress>.*?<\/nocompress>|<pre.*?\/pre>|<textarea.*?\/textarea>|<script.*?\/script>)/msi', $html_source, -1, PREG_SPLIT_DELIM_CAPTURE);
	$compress = '';
	foreach ($chunks as $c) {
		if (strtolower(substr($c, 0, 19)) == '<!--<nocompress>-->') {
			$c = substr($c, 19, strlen($c) - 19 - 20);
			$compress .= $c;
			continue;
		} else if (strtolower(substr($c, 0, 12)) == '<nocompress>') {
			$c = substr($c, 12, strlen($c) - 12 - 13);
			$compress .= $c;
			continue;
		} else if (strtolower(substr($c, 0, 4)) == '<pre' || strtolower(substr($c, 0, 9)) == '<textarea') {
			$compress .= $c;
			continue;
		} else if (strtolower(substr($c, 0, 7)) == '<script' && strpos($c, '//') != false && (strpos($c, "\r") !== false || strpos($c, "\n") !== false)) {
			$tmps = preg_split('/(\r|\n)/ms', $c, -1, PREG_SPLIT_NO_EMPTY);
			$c = '';
			foreach ($tmps as $tmp) {
				if (strpos($tmp, '//') !== false) {
					if (substr(trim($tmp), 0, 2) == '//') {
						continue;
					}
					$chars = preg_split('//', $tmp, -1, PREG_SPLIT_NO_EMPTY);
					$is_quot = $is_apos = false;
					foreach ($chars as $key => $char) {
						if ($char == '"' && $chars[$key - 1] != '\\' && !$is_apos) {
							$is_quot = !$is_quot;
						} else if ($char == '\'' && $chars[$key - 1] != '\\' && !$is_quot) {
							$is_apos = !$is_apos;
						} else if ($char == '/' && $chars[$key + 1] == '/' && !$is_quot && !$is_apos) {
							$tmp = substr($tmp, 0, $key);
							break;
						}
					}
				}
				$c .= $tmp;
			}
		}
		$c = preg_replace('/[\\n\\r\\t]+/', ' ', $c);
		$c = preg_replace('/\\s{2,}/', ' ', $c);
		$c = preg_replace('/>\\s</', '> <', $c);
		$c = preg_replace('/\\/\\*.*?\\*\\//i', '', $c);
		$c = preg_replace('/<!--[^!]*-->/', '', $c);
		$compress .= $c;
	}
	return $compress;
}

/* function 加载时间 */
function timer_start() {
	global $timestart;
	$mtime = explode( ' ', microtime() );
	$timestart = $mtime[1] + $mtime[0];
	return true;
}

timer_start();

function timer_stop( $display = 0, $precision = 3 ) {
	global $timestart, $timeend;
	$mtime = explode( ' ', microtime() );
	$timeend = $mtime[1] + $mtime[0];
	$timetotal = number_format( $timeend - $timestart, $precision );
	$loadtime = $timetotal < 1 ? $timetotal * 1000 . ' ms' : $timetotal . ' s';
	if ( $display ) {
		echo $loadtime;
	}
	return $loadtime;
}

/* function 总访问量 */
function theAllViews() {
	$db = Typecho_Db::get();
	$prefix = $db->getPrefix();
	$row = $db->fetchAll('SELECT SUM(VIEWS) FROM `'.$prefix.'contents`');
	return number_format($row[0]['SUM(VIEWS)']);
}

/* function 导航位内容 */
function MyLinks($links) {
    $link = explode("\n",$links);
    $num = count($link);
    for ($i=0; $i<$num; $i++) {
        $links = trim($link[$i]);
        if ($links) {
            $obj = explode("=",$links);
            echo '<a href="'.$obj['1'].'" target="_blank"><li class="mdui-list-item mdui-ripple">'.$obj['0'].'</li></a>';
        }
    }
}

/* function 文章字数统计 */
function WordCount($cid) {
    $db=Typecho_Db::get();
    $rs=$db->fetchRow($db->select ('table.contents.text')->from('table.contents')->where('table.contents.cid=?',$cid)->order('table.contents.cid',Typecho_Db::SORT_ASC)->limit(1));
    $text = preg_replace("/[^\x{4e00}-\x{9fa5}]/u","",$rs['text']);
    echo mb_strlen($text,'UTF-8').'字';
}

/* function 许可协议 */
function license($license) {
	$licenselist = array(
        'BY' => '署名 4.0 国际 (CC BY 4.0)',
        'BY-SA' => '署名-相同方式共享 4.0 国际 (CC BY-SA 4.0)',
        'BY-ND' => '署名-禁止演绎 4.0 国际 (CC BY-ND 4.0)',
        'BY-NC' => '署名-非商业性使用 4.0 国际 (CC BY-NC 4.0)',
        'BY-NC-SA' => '署名-非商业性使用-相同方式共享 4.0 国际 (CC BY-NC-SA 4.0)',
		'BY-NC-ND' => '署名-非商业性使用-禁止演绎 4.0 国际 (CC BY-NC-ND 4.0)'
	);
	if (isset($license) && $license != 'NONE') {
		echo '<div class="copyright">本篇文章采用 <a rel="noopener" href="https://creativecommons.org/licenses/'.strtolower($license).'/4.0/deed.zh" target="_blank" class="external">'.$licenselist[$license].'</a> 许可协议进行许可。</div>';
	} else {
		echo '<div class="copyright">本篇文章未指定许可协议。</div>';
	}
}