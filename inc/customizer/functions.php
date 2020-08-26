<?php

if (!function_exists('aemi_type_setting'))
{
	function aemi_setting($type,$tag)
	{
		return 'aemi_type_' . $type . '_' . $tag;
	}
}

if (!function_exists('aemi_add_setting_checkbox'))
{
	function aemi_add_setting_checkbox($wp_customize, $setting, $default, $critical = false)
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
	function aemi_add_setting_radio($wp_customize, $setting, $default, $critical = false)
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

if (!function_exists('aemi_add_settings'))
{
	function aemi_add_settings($settings,$wp_customize)
	{
		foreach ($settings as $setting) {

			switch ($setting['type']) {
				case 'radio':
					aemi_add_setting_radio(
						$wp_customize,
						$setting['name'],
						$setting['default']
					);
					break;
				case 'checkbox':
					aemi_add_setting_checkbox(
						$wp_customize,
						$setting['name'],
						$setting['default'],
						isset($setting['critical']) ? $setting['critical'] : false
					);
					break;
				default:
					break;
			}
		}
	}
}

if (!function_exists('aemi_load_customize_controls'))
{
	function aemi_load_customize_controls()
	{
		require_once( trailingslashit( get_template_directory() ) . 'inc/customizer/custom-controls/index.php' );
	}
}

if (!function_exists('aemi_sanitize_media'))
{
	function aemi_sanitize_media( $filename )
	{
		return in_array(mime_content_type($filename), wp_get_allowed_mime_types()) ? $filename : null;
	}
}