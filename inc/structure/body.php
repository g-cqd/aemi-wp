<?php

if (!function_exists('aemi_body_classes'))
{
	function aemi_body_classes($classes)
	{

		// Color Scheme Preferences
		$scheme = get_theme_mod('aemi_color_scheme', 'auto');
		$user_pref_scheme = is_disabled('aemi_color_scheme_user', 0);
		$scheme_class = 'color-scheme';
		if ($user_pref_scheme && $scheme != 'auto') {
			$classes[] = $scheme_class . '-' . $scheme;
			$classes[] = 'force-color-scheme';
		}
		else if ($scheme == 'auto')
		{
			$classes[] = 'auto-color-scheme';
		}

		$classes[] = is_singular() ? 'singular' : 'not-singular';

		if (has_post_thumbnail())
		{
			$classes[] = 'has-post-thumbnail';
		}
		if (is_active_sidebar('sidebar-widget-area'))
		{
			$classes[] = 'sidebar';
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