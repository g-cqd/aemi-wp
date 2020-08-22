<?php

if (!function_exists('aemi_body_classes'))
{
	function aemi_body_classes($classes)
	{

		// Color Scheme Preferences
		$classes[] = 'color-scheme-' . get_theme_mod('aemi_color_scheme', 'auto');

		if (is_enabled('aemi_homepage_header',0))
		{
			$classes[] = 'homepage-custom-header';
		}

		$classes[] = is_singular() ? 'singular' : 'not-singular';

		if (has_post_thumbnail())
		{
			$classes[] = 'has-post-thumbnail';
		}

		$stickyness = get_theme_mod('aemi_header_stickyness', 'adaptative');

		if (in_array($stickyness,['top','adaptative']))
		{
			$classes[] = 'header-'.$stickyness;
			$auto_hide = is_enabled('aemi_header_autohiding', 1);
			if ($auto_hide)
			{
				$classes[] = 'header-auto-hide';
			}
		}
		else {
			$classes[] = 'header-absolute';
		}

		return $classes;
	}
}