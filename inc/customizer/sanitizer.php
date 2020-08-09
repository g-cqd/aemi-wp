<?php

if (!function_exists('aemi_sanitize_checkbox'))
{
    function aemi_sanitize_checkbox($input)
    {
        if ($input === true)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
}

if (!function_exists('aemi_raw_js_code'))
{
    function aemi_raw_js_code($input)
    {
        return $input;
    }
}