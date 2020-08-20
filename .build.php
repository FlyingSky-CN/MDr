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
    'style.min.css',
    compressCSS(
        file_get_contents('style.css')
    )
);
