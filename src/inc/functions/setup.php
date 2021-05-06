<?php

global $aemi_version;

$theme = wp_get_theme('aemi');
$aemi_version = $theme['Version'];


if (!function_exists('aemi_content_width'))
{
	function aemi_content_width()
	{
		$GLOBALS['content_width'] = apply_filters('aemi_content_width', 1024);
	}
}


if (!function_exists('aemi_setup'))
{
	function aemi_setup()
	{
		add_theme_support('automatic-feed-links');
		add_theme_support('title-tag');
		add_theme_support('post-thumbnails');
		// add_image_size('aemi-4k', 4096, 2160, false);
		// add_image_size('aemi-uhd', 3840, 2160, false);
		add_image_size('aemi-large', 1920, 1200, false);
		add_image_size('aemi-fhd', 1920, 1080, false);
		add_image_size('aemi-hd', 1280, 720, false);
		add_image_size('aemi-mid', 720, 480, false);
		add_image_size('aemi-small', 640, 360, false);
		add_image_size('aemi-tiny', 320, 240, false);
		add_image_size('aemi-thumb', 300, 300, false);
		add_image_size('aemi-logo', 92, 276, false);

		register_nav_menus(
			[
				'header-menu'	=> __('Header Menu', 'aemi'),
				'overlay-menu'	=> __('Overlay Menu', 'aemi'),
				'social-menu'	=> __('Social Menu', 'aemi'),
				'footer-menu'	=> __('Footer Menu', 'aemi'),
			]
		);

		add_theme_support( 'html5' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'site-logo' );
		// add_theme_support( 'wp-block-styles' );
		add_theme_support( 'custom-line-height' );
		add_theme_support( 'custom-units' );
		//add_theme_support( 'custom-units', 'rem', 'em' );

		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'experimental-link-color' );
		add_theme_support( 'experimental-custom-spacing' );

		add_theme_support( 'editor-styles' );
		// add_theme_support( 'dark-editor-style' );
		add_editor_style([ 'assets/editor-style.css' ]);

		// add_theme_support( 'disable-custom-font-sizes' );
		// add_theme_support( 'disable-custom-colors' );
		// add_theme_support( 'disable-custom-gradients' );
		// remove_theme_support( 'core-block-patterns' );

		add_theme_support(
			'custom-background',
			[
				'default-color' => '',
			]
		);

		add_theme_support('custom-header', [
			'default-image'          => '',
			'width'                  => 2880,
			'height'                 => 172,
			'flex-height'            => true,
			'flex-width'             => true,
			'uploads'                => true,
			'random-default'         => false,
			'header-text'            => false,
			'default-text-color'     => '',
			'wp-head-callback'       => '',
			'admin-head-callback'    => '',
			'admin-preview-callback' => '',
		]);

		add_theme_support('custom-logo', [
			'height'      => 92,
			'width'		  => 276,
			'flex-height' => true,
			'flex-width'  => true,
			'header-text' => [],
		]);

		$starter_content = apply_filters('aemi_starter_content', [
			'widgets' => [
				'header-widget-area' => [ 'search' ],
				'footer-widget-area' => [ '' ]
			]
		]);
		add_theme_support('starter-content', $starter_content);
	}
}

if (!function_exists('aemi_header_menu_filter'))
{
	function aemi_header_menu_filter($items, $args)
	{
    	if ($args->theme_location == 'header-menu')
    	{
    	    $top_level_links = 0;
    	    foreach ($items as $key => $item)
    	    {
    	        if ($item->menu_item_parent == 0)
    	        {
    	            $top_level_links++;
    	        }
    	        if ($top_level_links > 3)
    	        {
    	            unset($items[$key]);
    	        }
    	    }
    	}
    	return $items;
	}
}

if (!function_exists('aemi_tagcount_filter'))
{
	function aemi_tagcount_filter($variable)
	{
		$variable = str_replace('<span class="tag-link-count"> (', '<span class="tag-link-count">&bull;', $variable);
		$variable = str_replace(')</span>', '</span>', $variable);
		return $variable;
	}
}


if ( ! function_exists( 'aemi_pingback_header' ) )
{
	function aemi_pingback_header()
	{
		if ( is_singular() && pings_open() )
		{
			echo '<link rel="pingback" href="', bloginfo( 'pingback_url' ), '">';
		}
	}
}

if (!function_exists('aemi_widgets_init'))
{
	function aemi_widgets_init()
	{
		register_sidebar([
			'name'			=>	__('Overlay Widget Area', 'aemi'),
			'id'			=>	'overlay-widget-area',
			'description'	=>	__('Add widgets in this area to display them on overlay area.', 'aemi'),
			'before_widget'	=>	'<div class="header-block"><div id="widget-%1$s" class="widget-container %2$s">',
			'after_widget'	=>	'</div></div>',
			'before_title'	=>	'<strong class="widget-title h4">',
			'after_title'	=>	'</strong>',
		]);
		register_sidebar([
			'name'			=>	__('Footer Widget Area', 'aemi'),
			'id'			=>	'footer-widget-area',
			'description'	=>	__('Add widgets in this area to display them on footer area.', 'aemi'),
			'before_widget'	=>	'<div id="widget-%1$s" class="widget-container %2$s">',
			'after_widget'	=>	'</div>',
			'before_title'	=>	'<strong class="widget-title h4">',
			'after_title'	=>	'</strong>',
		]);
	}
}

if (!function_exists('aemi_custom_comment_fields_order'))
{
	function aemi_custom_comment_fields_order($fields)
	{

		$new_fields = [];

		$types = ['author','email','url','comment'];

		foreach ($types as $type) {
			$new_fields[$type] = $fields[$type];
			unset($fields[$type]);
		}

		foreach ($types as $type) {
			$fields[$type] = $new_fields[$type];
		}
		
		return $fields;
	}
}

if (!function_exists('is_enabled'))
{
	function is_enabled($mod,$default)
	{
		return get_theme_mod($mod,$default) === 1;
	}
}
if (!function_exists('is_disabled'))
{
	function is_disabled($mod,$default)
	{
		return get_theme_mod($mod,$default) === 0;
	}
}
