<?php

if (!function_exists('lines_explode')) {
    /**
     * explode by \r\n, \n or \r
     * @param string $lines
     * @return array
     */
    function lines_explode($lines) {
        return explode("\n", str_replace("\n\n", "\n", str_replace("\r", "\n", $lines)));
    }
}