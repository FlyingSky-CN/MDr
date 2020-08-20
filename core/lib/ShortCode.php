<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;

/**
 * @link https://github.com/bakaomg/castle-Typecho-Theme/blob/master/core/libs/ShortCode.php
 */

/**
 * Castle Short Code Class
 * Last Update: 2020/04/20
 */

class MDr_ShortCode
{
    private static $isFeed;

    /**
     * 短代码解析入口
     *
     * @access public
     * @param  $content  需解析的内容
     * @param  $isFeed   请求的类型
     * @return $content  解析后的内容
     */
    public static function parseAll($content, $isFeed = false)
    {
        $content = self::parseAbbr($content, $isFeed);
        $content = self::parseMark($content, $isFeed);
        $content = self::parseKbd($content, $isFeed);

        return $content;
    }

    /**
     * 高亮文字
     */
    public static function parseMark($content)
    {
        $reg = self::get_shortcode_regex(['mark']);
        $rp = '<mark>${5}</mark>';
        $new = preg_replace("/$reg/s", $rp, $content);
        return $new;
    }

    /**
     * Keyboard
     */
    public static function parseKbd($content)
    {
        $reg = self::get_shortcode_regex(['kbd']);
        $rp = '<kbd>${5}</kbd>';
        $new = preg_replace("/$reg/s", $rp, $content);
        return $new;
    }

    /**
     * Abbr
     */
    public static function parseAbbr($content)
    {
        $pattern = self::get_shortcode_regex(array('abbr'));
        $new = preg_replace_callback("/$pattern/", ['MDr_ShortCode', 'parseAbbrCallback'], $content);
        return $new;
    }

    /**
     * Abbr 回调函数
     */
    private static function parseAbbrCallback($matches)
    {
        static $data = [];
        $data = self::shortcode_parse_atts($matches[3]);

        $title   = (!empty($data['title'])) ? $data['title'] : '';
        $content = (!empty($matches[5])) ? $matches[5] : '';

        return "<abbr title=\"$title\">$content</abbr>";
    }

    /**
     * 短代码参数解析
     *
     * @link https://github.com/WordPress/WordPress/blob/master/wp-includes/shortcodes.php#L508
     */
    private static function shortcode_parse_atts($text)
    {
        $atts = array();
        $pattern = '/([\w-]+)\s*=\s*"([^"]*)"(?:\s|$)|([\w-]+)\s*=\s*\'([^\']*)\'(?:\s|$)|([\w-]+)\s*=\s*([^\s\'"]+)(?:\s|$)|"([^"]*)"(?:\s|$)|(\S+)(?:\s|$)/';
        $text = preg_replace("/[\x{00a0}\x{200b}]+/u", " ", $text);
        if (preg_match_all($pattern, $text, $match, PREG_SET_ORDER)) {
            foreach ($match as $m) {
                if (!empty($m[1])) {
                    $atts[strtolower($m[1])] = stripcslashes($m[2]);
                } elseif (!empty($m[3])) {
                    $atts[strtolower($m[3])] = stripcslashes($m[4]);
                } elseif (!empty($m[5])) {
                    $atts[strtolower($m[5])] = stripcslashes($m[6]);
                } elseif (isset($m[7]) && strlen($m[7])) {
                    $atts[] = stripcslashes($m[7]);
                } elseif (isset($m[8])) {
                    $atts[] = stripcslashes($m[8]);
                }
            }

            foreach ($atts as &$value) {
                if (false !== strpos($value, '<')) {
                    if (1 !== preg_match('/^[^<]*+(?:<[^>]*+>[^<]*+)*+$/', $value)) {
                        $value = '';
                    }
                }
            }
        } else {
            $atts = ltrim($text);
        }
        return $atts;
    }

    /**
     * 短代码参数解析
     *
     * @access private
     * https://github.com/WordPress/WordPress/blob/master/wp-includes/shortcodes.php#L254
     */
    private static function get_shortcode_regex($tagnames = null)
    {
        $tagregexp = join('|', array_map('preg_quote', $tagnames));
        return '\[(\[?)(' . $tagregexp . ')(?![\w-])([^\]\/]*(?:\/(?!\])[^\]\/]*)*?)(?:(\/)\]|\](?:([^\[]*+(?:\[(?!\/\2\])[^\[]*+)*+)\[\/\2\])?)(\]?)';
    }
}
