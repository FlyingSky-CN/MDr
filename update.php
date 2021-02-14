<?php

/**
 * MDr 主题更新程序
 * 
 * @author FlyingSky-CN
 * @author paizi
 * @package update
 */

/***** Set HTTP Header *****/

header("Content-Type: text/plain; charset=UTF-8");

/***** Load Typecho *****/

if (!defined('__DIR__')) {
    define('__DIR__', dirname(__FILE__));
}

if (!defined('__TYPECHO_ROOT_DIR__') && !@include_once __DIR__ . '/../../../config.inc.php') {
    file_exists(__DIR__ . '/../../../install.php') ? header('Location: ../../../install.php') : print('载入 Typecho 失败');
    exit;
}

/***** Register Widget *****/

Typecho_Widget::widget('Widget_Options')->to($options);
Typecho_Cookie::setPrefix($options->originalSiteUrl);
Typecho_Widget::widget('Widget_User')->to($user);

/***** Check Auth *****/

if (!$user->hasLogin()) {
    /* Unlogin */
    header('HTTP/1.1 403 Forbidden');
    header('Location: ../../../admin/login.php');
    print('没有权限访问');
    exit();
}

if (!$user->pass('administrator', true)) {
    /* Not an Administrator */
    header('HTTP/1.1 403 Forbidden');
    header('Location: ../../../admin/login.php');
    print('没有权限访问');
    exit();
}

/***** Update *****/

/* Download URL */

define('__MDR_RAW_DEV_URL__', 'https://raw.githubusercontent.com/FlyingSky-CN/MDr/master/');
define('__MDR_RAW_REL_URL__', 'https://cdn.jsdelivr.net/gh/FlyingSky-CN/MDr/');
define('__MDR_RAW_URL__', @$_GET['dev'] ? __MDR_RAW_DEV_URL__ : __MDR_RAW_REL_URL__);

echo "MDr主题更新程序";

if (!is_writable(__DIR__)) {
    echo "\n\n主题文件夹没有写入的权限，无法执行更新程序。";
    exit;
}

/**
 * curl
 * 简单封装
 * 
 * @param string $url
 */
function curl($url)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    curl_setopt($curl, CURLOPT_REFERER, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($curl);
    curl_close($curl);
    return $result;
}

echo "\n\n目标服务器 " . __MDR_RAW_URL__;

echo "\n\n获取文件 Hash 表...\n\n";

$hash = curl(__MDR_RAW_URL__ . 'hash.txt');

if (!$hash) {
    /* Hash 获取失败 */
    print('文件 Hash 表获取失败，请检查服务器与 ' . __MDR_RAW_URL__ . '的连通性。');
    exit();
}

echo $hash . "\n";

$hash = explode("\n", $hash);

echo "检查本地文件...\n\n";

$upnew = false;

foreach ($hash as $remote) {
    list($remote_sha256, $filename) = explode('  ', $remote);
    $trimname = str_replace('./', '', trim($filename));
    if (!file_exists(__DIR__ . '/' . $trimname) || !hash_equals(hash('sha256', file_get_contents(__DIR__ . '/' . $trimname)), $remote_sha256)) {
        echo "检测到 " . $trimname . " 有新版本";
        if (!is_dir(dirname(__DIR__ . '/' . $trimname)))
            mkdir(dirname(__DIR__ . '/' . $trimname), 0777, true);
        if (!is_writable(__DIR__ . '/' . $trimname) && file_exists(__DIR__ . '/' . $trimname)) {
            echo "，该文件没有写入的权限，无法更新。\n";
        } else {
            $url = __MDR_RAW_URL__ . $trimname;
            if (file_put_contents(__DIR__ . '/' . $trimname, curl($url))) {
                echo "，已更新\n";
                $upnew = true;
            } else {
                die("\n下载失败，错误位置: $url\n");
            }
        }
    } else {
        echo "Hash 相同，无需更新  " . $trimname . "\n";
    }
}

/* Update Stats */
if ($upnew) {

    $parseInfo = Typecho_Plugin::parseInfo(__DIR__ . '/index.php');

    if (function_exists('file_get_contents')) {
        $contexts = stream_context_create([
            'http' => [
                'method' => "GET",
                'header' => "User-Agent: ForInstallMatch\r\n",
                'timeout' => 5
            ]
        ]);
        file_get_contents('https://api.fsky7.com/InstallMatch/newUpdate' .
            '?class=' . urlencode('MDr ' . $parseInfo['version']) . '&hostname=' . urlencode($_SERVER['HTTP_HOST']), false, $contexts);
    }
}

echo "\n任务完成";
