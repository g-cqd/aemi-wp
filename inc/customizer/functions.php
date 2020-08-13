<?php

if (!function_exists('aemi_header_script'))
{
	function aemi_header_script()
	{
		$header_script = get_theme_mod('aemi_header_js_code');
		if ($header_script)
		{
			?><script id="aemi-custom-header-script" type="text/javascript"><?= $header_script ?></script><?php
		}
	}
}
add_action('wp_head', 'aemi_header_script');


if (!function_exists('aemi_footer_script'))
{
	function aemi_footer_script()
	{
		$footer_script = get_theme_mod('aemi_footer_js_code');
		if ($footer_script)
		{
			?><script id="aemi-custom-footer-script" type="text/javascript"><?= $footer_script ?></script><?php
		}
	}
}
add_action('wp_footer', 'aemi_footer_script');


if (!function_exists('aemi_type_setting'))
{
	function aemi_setting($type,$tag)
	{
		return 'aemi_type_' . $type . '_' . $tag;
	}
}

if (!function_exists('aemi_add_setting_checkbox'))
{
	function aemi_add_setting_checkbox($wp_customize,$setting,$default,$critical = false)
	{
		if ($critical)
		{
			$wp_customize->add_setting($setting, [
				'default'			=> $default,
				'capability'		=> 'edit_theme_options',
				'sanitize_callback'	=> 'aemi_sanitize_checkbox',
				'transport'			=> 'refresh',
			]);
		}
		else
		{
			$wp_customize->add_setting($setting, [
				'default'			=> $default,
				'sanitize_callback'	=> 'aemi_sanitize_checkbox',
				'transport'			=> 'refresh',
			]);
		}
	}
}

if (!function_exists('aemi_add_setting_radio'))
{
	function aemi_add_setting_radio($wp_customize,$setting,$default,$critical = false)
	{
		if ($critical)
		{
			$wp_customize->add_setting($setting, [
				'default'			=> $default,
				'capability'		=> 'edit_theme_options',
				'sanitize_callback'	=> 'aemi_sanitize_radio',
				'transport'			=> 'refresh',
			]);
		}
		else
		{
			$wp_customize->add_setting($setting, [
				'default'			=> $default,
				'sanitize_callback'	=> 'aemi_sanitize_radio',
				'transport'			=> 'refresh',
			]);
		}
	}
}