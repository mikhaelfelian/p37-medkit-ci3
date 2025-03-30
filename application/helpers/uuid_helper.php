<?php defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('generate_uuid')) {
    function generate_uuid() {
        $CI =& get_instance();
        return $CI->uuid->v4();
    }
}

if (!function_exists('generate_short_uuid')) {
    function generate_short_uuid() {
        $CI =& get_instance();
        return $CI->uuid->short();
    }
} 