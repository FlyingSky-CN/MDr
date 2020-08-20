<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;

/* MDr */
if (!defined('MDR_OUTREQUIER') && Helper::options()->GravatarUrl)
    define('__TYPECHO_GRAVATAR_PREFIX__', Helper::options()->GravatarUrl);
define('MDR_PJAX', isset($_GET['_pjax']) ? true : false);
define('MDR_VERSION', Typecho_Plugin::parseInfo(__DIR__ . '/index.php')['version']);

require_once __DIR__ . '/core/functions.php';

Typecho_Plugin::factory('Widget_Abstract_Contents')->contentEx = array('MDr', 'contentEx');

/* MDr Theme Config */
function themeConfig($form)
{
    $db = Typecho_Db::get();
    $nameQuery = $db->fetchRow($db->select()->from('table.options')->where('name = ?', 'theme'));
    $name = isset($nameQuery['value']) ? $nameQuery['value'] : false;
    $themeQuery = $db->fetchRow($db->select()->from('table.options')->where('name = ?', "theme:$name"));

    /**
     * MDr Install Match
     * 统计安装量
     * 
     * @author FlyingSky-CN
     * @link   https://mdr.docs.fsky7.com/privacy/
     */
    if (!isset($themeQuery['value']) && function_exists('file_get_contents')) {
        file_get_contents(
            'https://api.fsky7.com/InstallMatch/newInstall?class=' .
                urlencode('MDr ' . MDR_VERSION) . '&hostname=' . $_SERVER['HTTP_HOST'],
            false,
            stream_context_create(['http' => [
                'method' => "GET",
                'header' => "User-Agent: ForInstallMatch\r\n",
                'timeout' => 5
            ]])
        );
    }

    /**
     * MDr Options Backup
     * 主题设置备份
     * 
     * @link https://qqdie.com/archives/typecho-templates-backup-and-restore.html
     */
    if (isset($_GET['themeBackup']) && isset($_POST['type'])) :
        $theme = $themeQuery ? $themeQuery['value'] : false;
        $backupQuery = $db->fetchRow($db->select()->from('table.options')->where('name = ?', "theme:themeBackup-$name"));
        $backup = $backupQuery ? $backupQuery['value'] : false;

        if ($_POST["type"] == "备份主题设置") {
            if ($theme) {
                if ($backup) {
                    $update = $db->update('table.options')->rows(array('value' => $theme))->where('name = ?', "theme:themeBackup-$name");
                    $db->query($update);
                    Typecho_Widget::widget('Widget_Notice')->set(_t('主题设置备份已更新'), 'success');
                } else {
                    $insert = $db->insert('table.options')->rows(array('name' => "theme:themeBackup-$name", 'user' => '0', 'value' => $theme));
                    $db->query($insert);
                    Typecho_Widget::widget('Widget_Notice')->set(_t('主题设置备份已完成'), 'success');
                }
            } else Typecho_Widget::widget('Widget_Notice')->set(_t('主题设置备份错误: 无法找到主题设置数据'), 'error');
        } else if ($_POST["type"] == "还原主题设置") {
            if ($backup) {
                $update = $db->update('table.options')->rows(array('value' => $backup))->where('name = ?', "theme:$name");
                $db->query($update);
                Typecho_Widget::widget('Widget_Notice')->set(_t('主题设置已恢复，若浏览器没有自动刷新，请手动刷新页面'), 'success');
                echo '<script language="JavaScript">window.setTimeout("location=\'\'", 2000);</script>';
            } else Typecho_Widget::widget('Widget_Notice')->set(_t('没有找到主题设置备份'), 'notice');
        } else if ($_POST["type"] == "删除备份设置") {
            if ($backup) {
                $delete = $db->delete('table.options')->where('name = ?', "theme:themeBackup-$name");
                $db->query($delete);
                Typecho_Widget::widget('Widget_Notice')->set(_t('主题设置备份已删除'), 'success');
            } else Typecho_Widget::widget('Widget_Notice')->set(_t('没有找到主题设置备份'), 'notice');
        } else Typecho_Widget::widget('Widget_Notice')->set(_t('主题设置备份错误: 未知操作'), 'error');
    endif;

    echo <<<EOF
	<style> h2 {margin-bottom: 10px} h2 small {opacity: 0.5} .btn {margin: 2px 0} </style>
    <p>
        <span style="display: block;margin-bottom: 10px;margin-top: 10px;font-size: 16px;">MDr <small>书写你的篇章</small></span>
        <span style="display: block;margin-bottom: 10px;margin-top: 10px;font-size: 14px;opacity:0.5">版本 <code id="mdr-version"></code></span>
	</p>
	<p>
		<a href="https://blog.fsky7.com/archives/60/"><button class="btn primary">前往发布页</button></a>
		<a href="https://mdr.docs.fsky7.com/"><button class="btn primary">查看文档</button></a>
		<button class="btn" style="outline: 0" id="mdr-update-in" onclick="$(this).hide();$('#mdr-update-more').show()">检查并更新主题</button>
		<span id="mdr-update-more" style="display:none">
			<button class="btn success" style="outline: 0" id="mdr-update">更新正式版</button>
			<button class="btn" style="outline: 0" id="mdr-update-dev">更新开发版</button>
		</span>
	</p>
	<p>
		<form class="protected" action="?themeBackup" method="post" id="mdr-backup">
			<input type="submit" name="type" class="btn btn-s" value="备份主题设置" />
			<input type="submit" name="type" class="btn btn-s" value="还原主题设置" />
			<input type="submit" name="type" class="btn btn-s" value="删除备份设置" />
		</form>
	</p>
	<textarea id="mdr-update-pre" class="w-100 mono" style="display:none" readonly></textarea>
	<style>#mdr-update-pre{height:512px;}</style>
    <p>
        <a href="#mdr-color"><button class="btn btn-s">主题色</button></a>
        <a href="#mdr-cdn"><button class="btn btn-s">CDN</button></a>
        <a href="#mdr-nav"><button class="btn btn-s">边栏</button></a>
        <a href="#mdr-pjax"><button class="btn btn-s">Ajax</button></a>
        <a href="#mdr-dark"><button class="btn btn-s">黑暗模式</button></a>
        <a href="#mdr-music"><button class="btn btn-s">背景音乐</button></a>
        <a href="#mdr-func"><button class="btn btn-s">附加功能</button></a>
		<a href="#mdr-custom"><button class="btn btn-s">自定义</button></a>
		<a href="#mdr-end"><button class="btn btn-s">完成</button></a>
	</p>
	<script>
	window.onload = function(){
		$('form').last().find('[type="submit"]').first().parent().append('<button onclick="mdrInstantView();return false" class="btn primary">预览设置</button>')
	};
	function mdrInstantView() {
		$.ajax({
			url:'../?debug=start',
			type:"POST",
			data:$('form').last().serialize(),
			success:function(){
				window.open("../?debug=true","_blank")
			}
		})
	}
	</script>
EOF;
    echo "<script>document.getElementById('mdr-version').innerHTML = '" . MDR_VERSION . "'</script>" . '<script>document.getElementById("mdr-update").onclick = function(){if(confirm("你确认要执行吗？更新过程中站点可能无法正常访问")){$("#mdr-update-more").hide();$("#mdr-update-in").show();document.getElementById("mdr-update-in").innerHTML = "正在检查并更新";document.getElementById("mdr-update-in").setAttribute("disabled","true");var xmlhttp;if (window.XMLHttpRequest){xmlhttp=new XMLHttpRequest()}else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP")}xmlhttp.onreadystatechange=function(){if(xmlhttp.readyState==4){document.getElementById("mdr-update-pre").innerHTML=xmlhttp.responseText;$("#mdr-update-pre").slideDown();document.getElementById("mdr-update-in").innerHTML = "完成";}else{document.getElementById("mdr-update-in").innerHTML = "正在执行";}};xmlhttp.open("GET","';
    cjUrl('update.php');
    echo '",true);xmlhttp.send();}}</script>' . '<script>document.getElementById("mdr-update-dev").onclick = function(){if(confirm("你确认要执行吗？更新过程中站点可能无法正常访问\n更新开发版需要服务器能访问 githubusercontent 服务器")){$("#mdr-update-more").hide();$("#mdr-update-in").show();document.getElementById("mdr-update-in").innerHTML = "正在检查并更新";document.getElementById("mdr-update-in").setAttribute("disabled","true");var xmlhttp;if (window.XMLHttpRequest){xmlhttp=new XMLHttpRequest()}else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP")}xmlhttp.onreadystatechange=function(){if(xmlhttp.readyState==4){document.getElementById("mdr-update-pre").innerHTML=xmlhttp.responseText;$("#mdr-update-pre").slideDown();document.getElementById("mdr-update-in").innerHTML = "完成";}else{document.getElementById("mdr-update-in").innerHTML = "正在执行";}};xmlhttp.open("GET","';
    cjUrl('update.php?dev=true');
    echo '",true);xmlhttp.send();}}</script>';

    /* MDr Color 主题色设置 */
    $mdrNotice = new Typecho_Widget_Helper_Form_Element_Text('mdrNotice', NULL, NULL, _t('<h2 id="mdr-color">主题色设置 <small>Color</small></h2>'));
    $mdrNotice->input->setAttribute('style', 'display:none');
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

    /* MDr CDN 设置 */
    $mdrNotice = new Typecho_Widget_Helper_Form_Element_Text('mdrNotice', NULL, NULL, _t('<h2 id="mdr-cdn">CDN 设置 <small>CDN</small></h2>'));
    $mdrNotice->input->setAttribute('style', 'display:none');
    $form->addInput($mdrNotice);

    $mdrMDUICDN = new Typecho_Widget_Helper_Form_Element_Radio(
        'mdrMDUICDN',
        array(
            'bootcss' => _t('BootCDN'),
            'cdnjs' => _t('CDNJS'),
            'cssnet' => _t('CSSnet'),
            'custom' => _t('自建')
        ),
        'cssnet',
        _t('MDUI 静态资源来源'),
        _t('默认 CSSnet ，请根据需求选择合适来源')
    );
    $form->addInput($mdrMDUICDN);

    $mdrMDUICDNlink = new Typecho_Widget_Helper_Form_Element_Textarea(
        'mdrMDUICDNlink',
        null,
        null,
        _t('MDUI 静态资源自建地址'),
        _t('只在上面的选项选择自建时需要。')
    );
    $form->addInput($mdrMDUICDNlink);

    $cjCDN = new Typecho_Widget_Helper_Form_Element_Radio(
        'cjCDN',
        array(
            'bc' => _t('BootCDN'),
            'cf' => _t('CDNJS'),
            'jd' => _t('jsDelivr'),
            'custom' => _t('自建')
        ),
        'bc',
        _t('其他公共静态资源来源'),
        _t('默认BootCDN，请根据需求选择合适来源')
    );
    $form->addInput($cjCDN);

    $mdrcjCDNlink = new Typecho_Widget_Helper_Form_Element_Textarea(
        'mdrcjCDNlink',
        null,
        null,
        _t('其他公共静态资源自建地址'),
        _t('只在上面的选项选择自建时需要。')
    );
    $form->addInput($mdrcjCDNlink);

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
    $mdrNotice = new Typecho_Widget_Helper_Form_Element_Text('mdrNotice', NULL, NULL, _t('<h2 id="mdr-nav">边栏设置 <small>Nav</small></h2>'));
    $mdrNotice->input->setAttribute('style', 'display:none');
    $form->addInput($mdrNotice);

    $mdrNavDefOpen = new Typecho_Widget_Helper_Form_Element_Radio(
        'mdrNavDefOpen',
        array(
            true => _t('开'),
            false => _t('关')
        ),
        true,
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

    $mdrSidebar = new Typecho_Widget_Helper_Form_Element_Radio(
        'mdrSidebar',
        array(
            true => _t('开'),
            false => _t('关')
        ),
        true,
        _t('右侧边栏总开关'),
        _t('默认开启')
    );
    $form->addInput($mdrSidebar);

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
    $mdrNotice = new Typecho_Widget_Helper_Form_Element_Text('mdrNotice', NULL, NULL, _t('<h2 id="mdr-pjax">Ajax 设置 <small>Ajax</small></h2>'));
    $mdrNotice->input->setAttribute('style', 'display:none');
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
    $mdrNotice = new Typecho_Widget_Helper_Form_Element_Text('mdrNotice', NULL, NULL, _t('<h2 id="mdr-dark">黑暗模式设置 <small>Dark Mode</small></h2>'));
    $mdrNotice->input->setAttribute('style', 'display:none');
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
    $mdrNotice = new Typecho_Widget_Helper_Form_Element_Text('mdrNotice', NULL, NULL, _t('<h2 id="mdr-music">背景音乐设置 <small>Music</small></h2>'));
    $mdrNotice->input->setAttribute('style', 'display:none');
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
        _t('请输入一个0到1之间的小数（0为静音  0.5为50%音量  1为100%最大音量）输入错误内容或留空则使用默认音量100%')
    );
    $MusicVol->input->setAttribute('class', 'mini');
    $form->addInput($MusicVol->addRule('isInteger', _t('请填入一个0~1内的数字')));

    /* MDr Func 附加功能设置 */
    $mdrNotice = new Typecho_Widget_Helper_Form_Element_Text('mdrNotice', NULL, NULL, _t('<h2 id="mdr-func">附加功能设置 <small>Func</small></h2>'));
    $mdrNotice->input->setAttribute('style', 'display:none');
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
        _t('默认开启，采用的是 <a target="_blank" href="http://fancyapps.com/fancybox/3/">Fancybox</a>')
    );
    $form->addInput($ViewImg);

    $mdrQrCode = new Typecho_Widget_Helper_Form_Element_Radio(
        'mdrQrCode',
        array(
            1 => _t('启用'),
            0 => _t('关闭')
        ),
        1,
        _t('当前页面二维码'),
        _t('默认开启，开启后将显示当前页面二维码按钮')
    );
    $form->addInput($mdrQrCode);

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
    $mdrNotice = new Typecho_Widget_Helper_Form_Element_Text('mdrNotice', NULL, NULL, _t('<h2 id="mdr-custom">自定义内容 <small>Custom</small></h2>'));
    $mdrNotice->input->setAttribute('style', 'display:none');
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

    $mdrPostAuthor = new Typecho_Widget_Helper_Form_Element_Radio(
        'mdrPostAuthor',
        array(
            true => _t('显示'),
            false => _t('不显示')
        ),
        false,
        _t('文章内页显示作者'),
        _t('默认不显示')
    );
    $form->addInput($mdrPostAuthor);

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

    /* MDr 后台设置结束 */
    $mdrNotice = new Typecho_Widget_Helper_Form_Element_Text('mdrNotice', NULL, NULL, _t('<div id="mdr-end"></div>'));
    $mdrNotice->input->setAttribute('style', 'display:none');
    $form->addInput($mdrNotice);
}

/* MDr themeFields */
function themeFields($layout)
{

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

/* MDr Theme Init */
function themeInit($archive)
{
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
