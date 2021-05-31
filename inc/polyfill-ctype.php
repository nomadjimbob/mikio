<?php
/**
 * Polyfill-CType
 *
 * @link    https://github.com/nomadjimbob/polyfill-ctype
 * @author  James Collins <james.collins@outlook.com.au>
 * @license GPLv2 (http://www.gnu.org/licenses/gpl-2.0.html)
 */

if(!function_exists('ctype_alnum')) {
    function ctype_alnum($var) {
        return preg_match('/^[a-zA-Z0-9]+$/', $var);
    }
}

if(!function_exists('ctype_alpha')) {
    function ctype_alpha($var) {
        return preg_match('/^[a-zA-Z]+$/', $var);
    }
}

if(!function_exists('ctype_cntrl')) {
    function ctype_cntrl($var) {
        return preg_match('/^[\x00-\x1F\x7F]+$/', $var);
    }
}

if(!function_exists('ctype_digit')) {
    function ctype_digit($var) {
        return preg_match('/^[0-9]+$/', $var);
    }
}

if(!function_exists('ctype_graph')) {
    function ctype_graph($var) {
        return preg_match('/^[\x20-\x7E\x80-\xFF]+$/', $var);
    }
}

if(!function_exists('ctype_lower')) {
    function ctype_lower($var) {
        return preg_match('/^[a-z]+$/', $var);
    }
}

if(!function_exists('ctype_print')) {
    function ctype_print($var) {
        return preg_match('/^[\x20-\x7E\x80-\xFF]+$/', $var);
    }
}

if(!function_exists('ctype_punct')) {
    function ctype_punct($var) {
        return preg_match('/^[^\w\s]+$/', $var);
    }
}

if(!function_exists('ctype_space')) {
    function ctype_space($var) {
        return preg_match('/^[\r\t\n]+$/', $var);
    }
}

if(!function_exists('ctype_upper')) {
    function ctype_upper($var) {
        return preg_match('/^[A-Z]+$/', $var);
    }
}

if(!function_exists('ctype_xdigit')) {
    function ctype_upper($var) {
        return preg_match('/^[0-9A-Fa-f]+$/', $var);
    }
}

?>