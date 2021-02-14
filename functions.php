<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;

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
        MDR_COLOR['primary'],
        'indigo',
        _t('主题主色'),
        _t('默认为 indigo ，详情参见 <a href="https://www.mdui.org/docs/color" target="_blank">颜色和主题 - MDUI 文档</a>')
    );
    $form->addInput($mdrPrimary);

    $mdrAccent = new Typecho_Widget_Helper_Form_Element_Select(
        'mdrAccent',
        MDR_COLOR['accent'],
        'pink',
        _t('主题强调色'),
        _t('默认为 pink ，详情参见 <a href="https://www.mdui.org/docs/color" target="_blank">颜色和主题 - MDUI 文档</a>')
    );
    $form->addInput($mdrAccent);

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

    /* MDr Func 附加功能设置 */
    $mdrNotice = new Typecho_Widget_Helper_Form_Element_Text('mdrNotice', NULL, NULL, _t('<h2 id="mdr-func">附加功能设置 <small>Func</small></h2>'));
    $mdrNotice->input->setAttribute('style', 'display:none');
    $form->addInput($mdrNotice);

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

    /* MDr Custom 自定义设置 */
    $mdrNotice = new Typecho_Widget_Helper_Form_Element_Text('mdrNotice', NULL, NULL, _t('<h2 id="mdr-custom">自定义内容 <small>Custom</small></h2>'));
    $mdrNotice->input->setAttribute('style', 'display:none');
    $form->addInput($mdrNotice);

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

    $MyLinks = new Typecho_Widget_Helper_Form_Element_Textarea(
        'MyLinks',
        NULL,
        NULL,
        _t('自定义导航栏链接'),
        _t('格式为 <b class="notice">文字=链接</b>，一行一个，留空则没有')
    );
    $form->addInput($MyLinks);

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
    $options->commentsOrder = 'DESC';
    $options->commentsPageDisplay = 'first';
    if ($archive->is('single')) {
        $archive->content = hrefOpen($archive->content);
        if ($archive->fields->catalog) {
            $archive->content = createCatalog($archive->content);
        }
    }
}
