<?php

if (!function_exists('format_date')) {
    /**
     * 感谢sf.gg的萧逸先生
     * @link https://segmentfault.com/a/1190000008483869
     * @param $time
     * @return string
     */
    function format_date($time)
    {
        $t = time() - $time;
        $f = array(
            '31536000' => '年',
            '2592000'  => '个月',
            '604800'   => '星期',
            '86400'    => '天',
            '3600'     => '小时',
            '60'       => '分钟',
            '1'        => '秒',
        );

        foreach ($f as $k => $v) {
            if (0 != $c = floor($t / intval($k))) {
                return $c . $v . '前';
            }
        }
    }
}

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

if (!function_exists('floor_tree')) {
    /**
     * 层级评论树
     * @link https://stackoverflow.com/questions/4196157/create-array-tree-from-array-list
     * @param $list
     * @param $parent
     * @return array
     */
    function createTree(&$list, $parent)
    {
        $tree = [];
        foreach ($parent as $k => $l) {
            if (isset($list[$l['id']])) {
                $l['children'] = createTree($list, $list[$l['id']]);
            }
            $tree[] = $l;
        }
        return $tree;
    }
}
