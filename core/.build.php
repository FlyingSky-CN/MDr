<?php

/**
 * MDr theme build script.
 * 
 * @author FlyingSky
 * @package MDr
 * @since petals
 */

/**
 * 只允许在 CLI 下运行 
 */
if (php_sapi_name() !== 'cli') exit();

/**
 * 定义版权信息
 * 
 * @var string
 */
define('Copyright', 'https://github.com/FlyingSky-CN/MDr');

/**
 * 压缩 CSS 文件
 * 
 * @param string $buffer CSS 内容
 * @return string
 */
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
    return '/* ' . Copyright . ' @time ' . date('Y-m-d H:i:s') . ' */' . PHP_EOL . $buffer;
}

/**
 * 处理 CSS 文件
 */
file_put_contents(
    __DIR__ . '/css/style.min.css',
    compressCSS(
        file_get_contents(__DIR__ . '/css/style.css') .
            file_get_contents(__DIR__ . '/css/style-petals.css')
    )
);
