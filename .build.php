<?php if (php_sapi_name() !== 'cli') exit();

define('Copyright', 'https://github.com/FlyingSky-CN/MDr');

function compressCSS($buffer)
{
    $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
    $buffer = str_replace(
        ["\r", "\n", "\t", '  ', '    ', '    '],
        '',
        $buffer
    );
    $buffer = str_replace(
        [' {', ': ', ', ', ';}', ' !'],
        ['{', ':', ',', '}', '!'],
        $buffer
    );
    return '/* ' . Copyright . ' */' . PHP_EOL . $buffer;
}

file_put_contents(
    __DIR__ . '/core/css/style.min.css',
    compressCSS(
        file_get_contents(__DIR__ . '/core/css/style.css') .
            file_get_contents(__DIR__ . '/core/css/style-petals.css')
    )
);

/**
 * exceptFiles
 * 排除的文件
 * 
 * @var array
 */
define('exceptFiles', ['.git', '.github', '.build.php', 'style.css', 'hash.txt', '.gitignore']);

/**
 * fetchFiles
 * 扫描目录下所有文件
 * 包含子目录
 * 排除 exceptFiles
 * 
 * @param string $subdir
 * @return array
 */
function fetchFiles(string $subdir)
{
    $items = array_reverse(array_diff(scandir($subdir), ['.', '..']));
    $files = [];

    foreach ($items as $item) {
        if (is_file($subdir . $item))
            if (!in_array($item, exceptFiles))
                $files[] = $subdir . $item;
        if (is_dir($subdir . $item))
            if (!in_array($item, exceptFiles))
                foreach (fetchFiles($subdir . $item . '/') as $file)
                    $files[] = $file;
    }

    return $files;
}

/**
 * GitHub Action 
 * 自动更新 Hash 文件
 */

$files = fetchFiles('./');
$hash = [];

foreach ($files as $file)
    $hash[] = hash('sha256', file_get_contents($file)) . '  ' . $file;

file_put_contents(__DIR__ . "/hash.txt", implode("\n", $hash));
