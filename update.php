<?php
/**
 * MDr 主题更新程序
 */

/* CLI 自动生成 Hash */

if (isset($argv[1])) {
    if ($argv[1] == 'hash') {
        $files = array(
            '404.php',
            'archive.php',
            'comments.php',
            'footer.php',
            'functions.php',
            'header.php',
            'index.php',
            'LICENSE',
            'page.php',
            'page-archives.php',
            'page-links.php',
            'page-whisper.php',
            'post.php',
            'README.md',
            'screenshot.png',
            'sidebar.php',
            'style.css'
        );
        $hash = '';
        foreach ($files as $file) {
            $hash .= hash('sha256', file_get_contents($file)).'  '.$file."\n";
        }
        file_put_contents("hash.txt",$hash);
        exit();
    }
}

/* Header */

header("Content-Type: text/plain; charset=UTF-8");

/* 载入 Typecho */

if (!defined('__DIR__')) {
    define('__DIR__', dirname(__FILE__));
}

if (!defined('__TYPECHO_ROOT_DIR__') && !@include_once __DIR__ . '/../../../config.inc.php') {
    file_exists(__DIR__ . '/../../../install.php') ? header('Location: ../../../install.php') : print('载入 Typecho 失败');
    exit;
}

/* 注册 Widget */

Typecho_Widget::widget('Widget_Options')->to($options);
Typecho_Cookie::setPrefix($options->originalSiteUrl);
Typecho_Widget::widget('Widget_User')->to($user);

/* 验证 Administrator 权限 */

if (!$user->hasLogin()) {
    /* 未登录 */
    header('HTTP/1.1 403 Forbidden');
    header('Location: ../../../admin/login.php');
    print('没有权限访问');
    exit();
}

if (!$user->pass('administrator',true)) {
    /* 不是 Administrator */
    header('HTTP/1.1 403 Forbidden');
    header('Location: ../../../admin/login.php');
    print('没有权限访问');
    exit();
}

/* 更新程序 */

define('__MDR_RAW_URL__', 'https://raw.githubusercontent.com/FlyingSky-CN/MDr/master/');

echo "MDr主题更新程序";

if(!is_writable(__DIR__)){
    echo "\n\n主题文件夹没有写入的权限，无法执行更新程序。";
    exit;
}

function curl($url){
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

$hash = curl(__MDR_RAW_URL__ . 'hash.txt');

echo "\n\n获取文件 Hash 表...\n\n";

if (!$hash) {
    /* Hash 获取失败 */
    print('文件 Hash 表获取失败，请检查服务器与 ' . __MDR_RAW_URL__ . '的连通性。');
    exit();
}

echo $hash . "\n";

$hash = explode("\n", $hash);
array_pop($hash);

echo "检查本地文件...\n\n";

foreach ($hash as $remote) {
    list($remote_sha256, $filename) = explode('  ', $remote);
    $trimname = trim($filename);
    if (!file_exists(__DIR__.'/'.$trimname) || !hash_equals(hash('sha256', file_get_contents(__DIR__.'/'.$trimname)), $remote_sha256)) {
        echo "检测到 ".$trimname." 有新版本";
        if(!is_writable(__DIR__.'/'.$trimname)){
            echo "，该文件没有写入的权限，无法更新。\n";
        } else {
            $url = __MDR_RAW_URL__ . $trimname;
            if (file_put_contents(__DIR__.'/'.$trimname,curl($url))) {
                echo "，已更新\n";
            } else {
                die("\n下载失败，错误位置: $url\n");
            }
        }
    } else {
        echo "Hash 相同，无需更新  ".$trimname."\n";
    }
}

echo "\n任务完成";

exit();?>