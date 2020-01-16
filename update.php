<?php
header("Content-Type: text/plain; charset=UTF-8");
echo "MDr主题更新程序";
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
$hash = curl('https://raw.githubusercontent.com/FlyingSky-CN/MDr/1.0.3/hash.txt');
echo "\n\n获取文件Hash...\n\n";
echo $hash."\n\n";
$hash = explode("\n", $hash);
array_pop($hash);
echo "检查本地文件...\n\n";
foreach ($hash as $remote) {
    list($remote_sha256, $filename) = explode('  ', $remote);
    $trimname = trim($filename);
    if (!file_exists(__DIR__.'/'.$trimname) || !hash_equals(hash('sha256', file_get_contents(__DIR__.'/'.$trimname)), $remote_sha256)) {
        echo "检测到 ".$trimname." 有新版本";
        $url = 'https://raw.githubusercontent.com/FlyingSky-CN/MDr/1.0.3/'.$trimname;
        if (file_put_contents(__DIR__.'/'.$trimname,curl($url))) {
            echo "，已更新\n";
        } else {
            die("\n下载失败，错误位置: $url\n");
        }
    } else {
        echo "Hash相同，无需更新  ".$trimname."\n";
    }
}
echo "\n\n任务完成";
die();
?>