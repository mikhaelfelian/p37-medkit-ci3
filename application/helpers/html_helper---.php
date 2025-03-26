<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * HTML Helper Functions
 */

if (!function_exists('br')) {
    /**
     * Generates HTML line break tag(s)
     *
     * @param int $count Number of times to repeat the tag
     * @return string
     */
    function br($count = 1) {
        return str_repeat("<br />", $count);
    }
}

if (!function_exists('img')) {
    /**
     * Image Tag
     *
     * @param string|array $src Image source URI or array of attributes
     * @param bool $index_page Add index page to URL
     * @return string
     */
    function img($src = '', $index_page = FALSE) {
        if (!is_array($src)) {
            $src = ['src' => $src];
        }

        // If there is no alt attribute set, add an empty one
        if (!isset($src['alt'])) {
            $src['alt'] = '';
        }

        $img = '<img';
        foreach ($src as $k => $v) {
            $img .= ' '.$k.'="'.$v.'"';
        }
        return $img.' />';
    }
}

if (!function_exists('heading')) {
    /**
     * Heading
     *
     * @param string $data Content
     * @param int $h Heading level (1-6)
     * @param string $attributes HTML attributes
     * @return string
     */
    function heading($data = '', $h = 1, $attributes = '') {
        $h = (int)$h;
        if ($h < 1 || $h > 6) {
            $h = 1;
        }
        return "<h{$h}" . ($attributes ? " {$attributes}" : '') . ">{$data}</h{$h}>";
    }
}

if (!function_exists('ul')) {
    /**
     * Unordered List
     *
     * @param array $list List items
     * @param string $attributes HTML attributes
     * @return string
     */
    function ul($list, $attributes = '') {
        return _list('ul', $list, $attributes);
    }
}

if (!function_exists('ol')) {
    /**
     * Ordered List
     *
     * @param array $list List items
     * @param string $attributes HTML attributes
     * @return string
     */
    function ol($list, $attributes = '') {
        return _list('ol', $list, $attributes);
    }
}

if (!function_exists('_list')) {
    /**
     * Generates HTML list tag (ordered/unordered)
     *
     * @param string $type List type (ul/ol)
     * @param array $list List items
     * @param string $attributes HTML attributes
     * @return string
     */
    function _list($type = 'ul', $list = [], $attributes = '') {
        if (empty($list)) {
            return '';
        }

        $out = "<{$type}" . ($attributes ? " {$attributes}" : '') . ">\n";
        foreach ($list as $item) {
            $out .= '<li>';
            if (!is_array($item)) {
                $out .= $item;
            } else {
                $out .= $item['content'];
                if (isset($item['children'])) {
                    $out .= _list($type, $item['children']);
                }
            }
            $out .= "</li>\n";
        }
        return $out . "</{$type}>\n";
    }
}

if (!function_exists('div')) {
    /**
     * Generate div tag
     *
     * @param string $content Content inside div
     * @param string|array $attributes HTML attributes
     * @return string
     */
    function div($content = '', $attributes = '') {
        if (is_array($attributes)) {
            $attrs = '';
            foreach ($attributes as $key => $val) {
                $attrs .= ' ' . $key . '="' . $val . '"';
            }
            $attributes = $attrs;
        }
        return "<div" . ($attributes ? " {$attributes}" : '') . ">{$content}</div>";
    }
}

if (!function_exists('p')) {
    /**
     * Paragraph tag
     *
     * @param string $content Content inside p tag
     * @param string|array $attributes HTML attributes
     * @return string
     */
    function p($content = '', $attributes = '') {
        if (is_array($attributes)) {
            $attrs = '';
            foreach ($attributes as $key => $val) {
                $attrs .= ' ' . $key . '="' . $val . '"';
            }
            $attributes = $attrs;
        }
        return "<p" . ($attributes ? " {$attributes}" : '') . ">{$content}</p>";
    }
}

if (!function_exists('span')) {
    /**
     * Span tag
     *
     * @param string $content Content inside span tag
     * @param string|array $attributes HTML attributes
     * @return string
     */
    function span($content = '', $attributes = '') {
        if (is_array($attributes)) {
            $attrs = '';
            foreach ($attributes as $key => $val) {
                $attrs .= ' ' . $key . '="' . $val . '"';
            }
            $attributes = $attrs;
        }
        return "<span" . ($attributes ? " {$attributes}" : '') . ">{$content}</span>";
    }
} 