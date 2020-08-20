<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;

class MDr
{
    public static function contentEx($data, $widget, $last)
    {
        $text = empty($last) ? $data : $last;
        if ($widget instanceof Widget_Archive) {
            $text = MDr_ShortCode::parseAll($text, $widget->parameter->__get('type') == 'feed');
        }

        return $text;
    }
}
