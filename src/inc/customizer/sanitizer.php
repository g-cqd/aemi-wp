<?php

if (!function_exists('aemi_sanitize_checkbox'))
{
    function aemi_sanitize_checkbox($input, $setting)
    {
        if ($input === true || $input === false)
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
        else
        {
            return $setting->default;
        }
    }
}

if (!function_exists('aemi_sanitize_checkbox_multiple'))
{
    function aemi_sanitize_checkbox_multiple( $values )
    {

        $multi_values = !is_array( $values ) ? explode( ',', $values ) : $values;

        return !empty( $multi_values ) ? array_map( 'sanitize_text_field', $multi_values ) : array();
    }
}

if (!function_exists('aemi_sanitize_dropdown_options'))
{
    function aemi_sanitize_dropdown_options( $value )
    {
        return sanitize_text_field($value);
    }
}

if (!function_exists('aemi_sanitize_radio'))
{
    function aemi_sanitize_radio($input, $setting)
    {
        $input = sanitize_key($input);
        $choices = $setting->manager->get_control( $setting->id )->choices;

        return (array_key_exists($input, $choices) ? $input : $setting->default);
    }
}

if (!function_exists('aemi_sanitize_dropdown_pages'))
{
    function aemi_sanitize_dropdown_pages($id,$setting)
    {
        $id = absint( $id );
        return ( 'publish' == get_post_status( $id ) ? $id : $setting->default );
    }
}

if (!function_exists('aemi_raw_js_code'))
{
    function aemi_raw_js_code($input)
    {
        return $input;
    }
}

if (!function_exists('aemi_sanitize_media'))
{
    function aemi_sanitize_media($filename)
    {
        return in_array(mime_content_type($filename),wp_get_allowed_mime_types()) ? $filename : null;
    }
}