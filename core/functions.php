<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;

require_once __DIR__ . '/config.ini.php';
require_once __DIR__ . '/lib/Main.php';
require_once __DIR__ . '/lib/ShortCode.php';

define('MDR_DEBUG', file_exists(__DIR__ . '/.debugger'));
if (!defined('MDR_OUTREQUIER') && Helper::options()->GravatarUrl)
    define('__TYPECHO_GRAVATAR_PREFIX__', Helper::options()->GravatarUrl);
define('MDR_PJAX', isset($_GET['_pjax']) ? true : false);
define('MDR_COLOR', json_decode(file_get_contents(__DIR__ . '/lib/Color.json'), true));
define('MDR_VERSION', Typecho_Plugin::parseInfo(__DIR__ . '/../index.php')['version']);

function cjUrl($path)
{
    $options = Helper::options();
    $options->themeUrl('core/' . $path);
}

function hrefOpen($obj)
{
    return preg_replace('/<a\b([^>]+?)\bhref="((?!' . addcslashes(Helper::options()->index, '/._-+=#?&') . ').*?)"([^>]*?)>/i', '<a\1href="\2"\3 target="_blank">', $obj);
}

/* function 文章缩略图 */
function postThumb($obj)
{
    $thumb = $obj->fields->thumb;
    if (!$thumb) {
        return false;
    }
    if (is_numeric($thumb)) {
        preg_match_all('/<img.*?src="(.*?)".*?[\/]?>/i', $obj->content, $matches);
        if (isset($matches[1][$thumb - 1])) {
            $thumb = $matches[1][$thumb - 1];
        } else {
            return false;
        }
    }
    return '<img src="' . $thumb . '"  style="width: 100%"/>';
}

/**
 * [ 文章阅读数统计 ]
 * 更新（如果为文章）并返回阅读数
 * 
 * @return string
 */
function Postviews($archive)
{
    $db = Typecho_Db::get();
    $cid = $archive->cid;
    if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')))) {
        $db->query('ALTER TABLE `' . $db->getPrefix() . 'contents` ADD `views` INT(10) DEFAULT 0;');
    }
    $exist = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid))['views'];
    if ($archive->is('single')) {
        $cookie = Typecho_Cookie::get('contents_views');
        $cookie = $cookie ? explode(',', $cookie) : array();
        if (!in_array($cid, $cookie)) {
            $db->query($db->update('table.contents')
                ->rows(array('views' => (int) $exist + 1))
                ->where('cid = ?', $cid));
            $exist = (int) $exist + 1;
            array_push($cookie, $cid);
            $cookie = implode(',', $cookie);
            Typecho_Cookie::set('contents_views', $cookie);
        }
    }
    echo $exist == 0 ? '暂无阅读' : $exist . ' 次阅读';
}

/**
 * MDr Catalog
 * 创建目录
 */
function createCatalog($obj)
{
    global $catalog;
    global $catalog_count;
    $catalog = array();
    $catalog_count = 0;
    $obj = preg_replace_callback('/<h([1-6])(.*?)>(.*?)<\/h\1>/i', function ($obj) {
        global $catalog;
        global $catalog_count;
        $catalog_count++;
        $catalog[] = array('text' => trim(strip_tags($obj[3])), 'depth' => (int)$obj[1], 'count' => $catalog_count);
        $text = trim(strip_tags($obj[3]));
        return '<h' . $obj[1] . $obj[2] . '><a class="cl-offset" id="dl-' . $text . '" name="cl-' . $catalog_count . '"></a>' . $text . '</h' . $obj[1] . '>';
    }, $obj);
    return $obj;
}

/**
 * MDr Catalog
 * 获取目录
 * 
 * @author FlyingSky-CN
 * @return array
 */
function getCatalog()
{
    global $catalog;
    return $catalog;
}

function CommentAuthor($obj, $autoLink = NULL, $noFollow = NULL)
{
    $options = Helper::options();
    $autoLink = $autoLink ? $autoLink : $options->commentsShowUrl;
    $noFollow = $noFollow ? $noFollow : $options->commentsUrlNofollow;
    if ($obj->url && $autoLink) {
        echo '<a href="' . $obj->url . '"' . ($noFollow ? ' rel="external nofollow"' : NULL) . (strstr($obj->url, $options->index) == $obj->url ? NULL : ' target="_blank"') . '>' . $obj->author . '</a>';
    } else {
        echo $obj->author;
    }
}

function Contents_Post_Initial($limit = 10, $order = 'created')
{
    $db = Typecho_Db::get();
    $options = Helper::options();
    $posts = $db->fetchAll($db->select()->from('table.contents')
        ->where('type = ? AND status = ? AND created < ?', 'post', 'publish', $options->time)
        ->order($order, Typecho_Db::SORT_DESC)
        ->limit($limit), array(Typecho_Widget::widget('Widget_Abstract_Contents'), 'filter'));
    if ($posts) {
        foreach ($posts as $post) {
            echo '<li><a' . ($post['hidden'] && $options->PjaxOption ? '' : ' href="' . $post['permalink'] . '"') . '>' . htmlspecialchars($post['title']) . '</a></li>' . "\n";
        }
    } else {
        echo '<li>暂无文章</li>' . "\n";
    }
}

function Contents_Comments_Initial($limit = 10, $ignoreAuthor = 0)
{
    $db = Typecho_Db::get();
    $options = Helper::options();
    $select = $db->select()->from('table.comments')
        ->where('status = ? AND created < ?', 'approved', $options->time)
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
        foreach ($comments as $comment) {
            $parent = FindContent($comment['cid']);
            echo '<li><a' . ($parent['hidden'] && $options->PjaxOption ? '' : ' href="' . permaLink($comment) . '"') . ' title="来自: ' . $parent['title'] . '">' . $comment['author'] . '</a>: ' . ($parent['hidden'] && $options->PjaxOption ? '内容被隐藏' : Typecho_Common::subStr(strip_tags($comment['text']), 0, 35, '...')) . '</li>' . "\n";
        }
    } else {
        echo '<li>暂无回复</li>' . "\n";
    }
}

function permaLink($obj)
{
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
            ->where('coid ' . ('DESC' == $options->commentsOrder ? '>=' : '<=') . ' ?', $coid)
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
                $total++;
            }
        }
        $currentPage = ceil($total / $options->commentsPageSize);
        $pageRow = array('permalink' => $parentContent['pathinfo'], 'commentPage' => $currentPage);
        return Typecho_Router::url('comment_page', $pageRow, $options->index) . '#' . $obj['type'] . '-' . $obj['coid'];
    }
    return $parentContent['permalink'] . '#' . $obj['type'] . '-' . $obj['coid'];
}

function FindContent($cid)
{
    $db = Typecho_Db::get();
    return $db->fetchRow($db->select()->from('table.contents')
        ->where('cid = ?', $cid)
        ->limit(1), array(Typecho_Widget::widget('Widget_Abstract_Contents'), 'filter'));
}

function FindContents($val = NULL, $order = 'order', $sort = 'a', $publish = NULL)
{
    $db = Typecho_Db::get();
    $sort = ($sort == 'a') ? Typecho_Db::SORT_ASC : Typecho_Db::SORT_DESC;
    $select = $db->select()->from('table.contents')
        ->where('created < ?', Helper::options()->time)
        ->order($order, $sort);
    if ($val) {
        $select->where('template = ?', $val);
    }
    if ($publish) {
        $select->where('status = ?', 'publish');
    }
    return $db->fetchAll($select, array(Typecho_Widget::widget('Widget_Abstract_Contents'), 'filter'));
}

/* function 输出轻语 */
function Whisper()
{
    $db = Typecho_Db::get();
    $options = Helper::options();
    $page = FindContents('page-whisper.php', 'commentsNum', 'd');
    if (isset($page[0])) {
        $page = $page[0];
        $comment = $db->fetchAll($db->select()->from('table.comments')
            ->where('cid = ? AND status = ? AND parent = ?', $page['cid'], 'approved', '0')
            ->order('coid', Typecho_Db::SORT_DESC)
            ->limit(1));
        if ($comment) {
            $content = hrefOpen(Markdown::convert($comment[0]['text']));
            return array(
                strip_tags($content, '<p><br><strong><a><img><pre><code>' . $options->commentsHTMLTagAllowed),
                $page['permalink'],
                $page['title']
            );
        } else {
            return array(
                '<p>暂无内容</p>',
                $page['permalink'],
                $page['title']
            );
        }
    } else {
        return array(
            '<p>暂无内容</p>'
        );
    }
}

function Links_list()
{
    $db = Typecho_Db::get();
    $list = Helper::options()->Links ? Helper::options()->Links : '';
    $page_links = FindContents('page-links.php', 'order', 'a');
    if (isset($page_links[0])) {
        $exist = $db->fetchRow($db->select()->from('table.fields')
            ->where('cid = ? AND name = ?', $page_links[0]['cid'], 'links'));
        if (empty($exist)) {
            $db->query($db->insert('table.fields')
                ->rows(array(
                    'cid'           =>  $page_links[0]['cid'],
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
                ->where('cid = ? AND name = ?', $page_links[0]['cid'], 'links'));
            return $list;
        }
        $list = $exist['str_value'];
    }
    return $list;
}

function Links($short = false)
{
    $link = NULL;
    $list = Links_list();
    if ($list) {
        $list = explode("\r\n", $list);
        foreach ($list as $val) {
            list($name, $url, $description, $logo) = explode(',', $val);
            if ($short) {
                $link .= '<div class="mdui-chip"><a' . ($url ? ' href="' . $url . '"' : '') . ' title="' . $description . '" target="_blank">' . ($logo ? '<img class="mdui-chip-icon" src="' . $logo . '"/>' : '') . '<span class="mdui-chip-title">' . ($url ? $name : '<del>' . $name . '</del>') . '</span></a></div>' . "\n";
            } else {
                $link .= '
                <div class="mdui-col" style="padding-top: 16px;">
                    <a href="' . $url . '" target="_blank">
                        <div class="mdui-card mdui-card-media link-card" style="background-color: #bebebe!important;">
                            <img class="link-logo" style="background: #fff;" src="' . $logo . '"/>
                            <div class="helper"></div>
                            <div class="mdui-card-media-covered">
                                <div class="mdui-card-primary">
                                    <div class="mdui-card-primary-title">' . $name . '</div>
                                    <div class="mdui-card-primary-subtitle">' . $description . '</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>' . "\n";
            }
        }
    }
    echo $link ? $link : '<div class="mdui-chip"><span class="mdui-chip-icon"><i class="mdui-icon material-icons">label_outline</i></span><span class="mdui-chip-title">暂无链接</span></div>' . "\n";
}

function compressHtml($html_source)
{
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

/* function 总访问量 */
function theAllViews()
{
    $db = Typecho_Db::get();
    $prefix = $db->getPrefix();
    $row = $db->fetchAll('SELECT SUM(VIEWS) FROM `' . $prefix . 'contents`');
    return number_format($row[0]['SUM(VIEWS)']);
}

/* function 导航位内容 */
function MyLinks($links)
{
    $link = explode("\n", $links);
    $num = count($link);
    for ($i = 0; $i < $num; $i++) {
        $links = trim($link[$i]);
        if ($links) {
            $obj = explode("=", $links);
            echo '<a href="' . $obj['1'] . '" target="_blank"><li class="mdui-list-item mdui-ripple">' . $obj['0'] . '</li></a>';
        }
    }
}

/* function 许可协议 */
function license($license)
{
    $licenselist = array(
        'BY' => '署名 4.0 国际 (CC BY 4.0)',
        'BY-SA' => '署名-相同方式共享 4.0 国际 (CC BY-SA 4.0)',
        'BY-ND' => '署名-禁止演绎 4.0 国际 (CC BY-ND 4.0)',
        'BY-NC' => '署名-非商业性使用 4.0 国际 (CC BY-NC 4.0)',
        'BY-NC-SA' => '署名-非商业性使用-相同方式共享 4.0 国际 (CC BY-NC-SA 4.0)',
        'BY-NC-ND' => '署名-非商业性使用-禁止演绎 4.0 国际 (CC BY-NC-ND 4.0)'
    );
    if (isset($license) && $license != 'NONE') {
        echo '<div class="copyright">本篇文章采用 <a rel="noopener" href="https://creativecommons.org/licenses/' . strtolower($license) . '/4.0/deed.zh" target="_blank" class="external">' . $licenselist[$license] . '</a> 许可协议进行许可。</div>';
    } else {
        echo '<div class="copyright">本篇文章未指定许可协议。</div>';
    }
}

/* function 是否为状态 */
function is_status($post)
{
    $tags = $post->tags;
    $is = false;
    foreach ($tags as $tag) {
        if ($tag['name'] == '状态' || $tag['name'] == 'status' || $tag['name'] == 'Status') {
            $is = true;
            break;
        }
    }
    return $is;
}

/* function 输出文章标签 */
function mdrTags($post)
{
    if ($post->tags) {
        $result = '';
        foreach ($post->tags as $tag) {
            $result .= '<div class="mdui-chip"><a href="' . $tag['permalink'] . '"><span class="mdui-chip-title">'
                . $tag['name'] . '</span></a></div> ';
        }
        echo $result;
    } else {
        echo '<div class="mdui-chip"><span class="mdui-chip-title">None</span></div>';
    }
}

/* function 公网安备logo */
function mdrGWABlogo()
{
    return file_get_contents(__DIR__ . '/src/GWABlogo.txt');
}

/**
 * 获取静态资源 URL
 * 
 * @author FlyingSky-CN 
 * @param string $file 需要的文件
 */
function staticUrl($file = '')
{
    $lists = explode("\r\n", Helper::options()->mdrMDUICDNlink);
    $mdrMDUIlinks = [
        'mdui.min.css' => [
            'cssnet' => 'cdnjs.loli.net/ajax/libs/mdui/0.4.3/css/mdui.min.css',
            'bootcss' => 'cdn.bootcss.com/mdui/0.4.2/css/mdui.min.css',
            'cdnjs' => 'cdnjs.cloudflare.com/ajax/libs/mdui/0.4.3/css/mdui.min.css',
            'custom' => isset($lists[0]) ? $lists[0] : ''
        ],
        'mdui.min.js' => [
            'cssnet' => 'cdnjs.loli.net/ajax/libs/mdui/0.4.3/js/mdui.min.js',
            'bootcss' => 'cdn.bootcss.com/mdui/0.4.2/js/mdui.min.js',
            'cdnjs' => 'cdnjs.cloudflare.com/ajax/libs/mdui/0.4.3/js/mdui.min.js',
            'custom' => isset($lists[1]) ? $lists[1] : ''
        ]
    ];
    $lists = explode("\r\n", Helper::options()->mdrcjCDNlink);
    $cjCDNlinks = [
        'jquery.min.js' => [
            'bc' => 'cdn.bootcss.com/jquery/3.4.1/jquery.min.js',
            'cf' => 'cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js',
            'jd' => 'cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js',
            'custom' => isset($lists[0]) ? $lists[0] : ''
        ],
        'jquery.pjax.min.js' => [
            'bc' => 'cdn.bootcss.com/jquery.pjax/2.0.1/jquery.pjax.min.js',
            'cf' => 'cdnjs.cloudflare.com/ajax/libs/jquery.pjax/2.0.1/jquery.pjax.min.js',
            'jd' => 'cdn.jsdelivr.net/npm/jquery-pjax@2.0.1/jquery.pjax.min.js',
            'custom' => isset($lists[1]) ? $lists[1] : ''
        ],
        'jquery.qrcode.min.js' => [
            'bc' => 'cdn.bootcss.com/jquery.qrcode/1.0/jquery.qrcode.min.js',
            'cf' => 'cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js',
            'jd' => 'cdn.jsdelivr.net/npm/jquery.qrcode@1.0/jquery.qrcode.min.js',
            'custom' => isset($lists[2]) ? $lists[2] : ''
        ],
        'jquery.fancybox.min.css' => [
            'bc' => 'cdn.bootcss.com/fancybox/3.5.7/jquery.fancybox.min.css',
            'cf' => 'cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css',
            'jd' => 'cdn.jsdelivr.net/npm/fancybox@3.0.1/dist/css/jquery.fancybox.css',
            'custom' => isset($lists[3]) ? $lists[3] : ''
        ],
        'jquery.fancybox.min.js' => [
            'bc' => 'cdn.bootcss.com/fancybox/3.5.7/jquery.fancybox.min.js',
            'cf' => 'cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js',
            'jd' => 'cdn.jsdelivr.net/npm/fancybox@3.0.1/dist/js/jquery.fancybox.min.js',
            'custom' => isset($lists[4]) ? $lists[4] : ''
        ]
    ];
    if (isset($mdrMDUIlinks[$file])) {
        $links = $mdrMDUIlinks[$file];
        $which = Helper::options()->mdrMDUICDN;
    } else if (isset($cjCDNlinks[$file])) {
        $links = $cjCDNlinks[$file];
        $which = Helper::options()->cjCDN;
    } else return '';
    return isset($links[$which]) ? '//' . $links[$which] : '';
}
