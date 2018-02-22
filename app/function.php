<?php

if (!function_exists('msubstr')) {
    /**
     * 感谢简书博主金星show
     * @link https://www.jianshu.com/p/960672138e7e
     * @param        $str
     * @param int    $start
     * @param        $length
     * @param string $charset
     * @param bool   $suffix
     * @return string
     */
    function msubstr($str, $start = 0, $length, $charset = "utf-8", $suffix = true)
    {
        if (function_exists("mb_substr")) {
            if ($suffix)
                return mb_substr($str, $start, $length, $charset) . "..."; else
                return mb_substr($str, $start, $length, $charset);
        } elseif (function_exists('iconv_substr')) {
            if ($suffix)
                return iconv_substr($str, $start, $length, $charset) . "..."; else
                return iconv_substr($str, $start, $length, $charset);
        }
        $re['utf-8'] = "/[x01-x7f]|[xc2-xdf][x80-xbf]|[xe0-xef][x80-xbf]{2}|[xf0-xff][x80-xbf]{3}/";
        $re['gb2312'] = "/[x01-x7f]|[xb0-xf7][xa0-xfe]/";
        $re['gbk'] = "/[x01-x7f]|[x81-xfe][x40-xfe]/";
        $re['big5'] = "/[x01-x7f]|x81-xfe/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("", array_slice($match[0], $start, $length));
        if ($suffix)
            return $slice . "...";
        return $slice;
    }
}

if (!function_exists('bit')) {
    /**
     * 进制转换
     * @param string $str
     * @param bool   $flag
     * @return string
     */
    function bit($str = '', $flag = false)
    {
        $str = $flag ? base_convert(base64_decode($str), 2, 10) : base64_encode(base_convert($str, 10, 2));
        return $str;
    }
}
