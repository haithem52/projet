<?php
if (!function_exists('transformName')) {
    /**
     * @return string
     */
    function transformName($name)
    {
        return ucfirst($name);
    }
}